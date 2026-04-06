<?php
// app/Http/Controllers/Admin/TeacherApplicationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TeacherApplicationStatusChanged;
use App\Mail\TeacherApplicationSubmitted;
use App\Models\TeacherApplication;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TeacherApplicationController extends Controller
{
    /**
     * عرض جميع الطلبات
     */
    public function index()
    {
        $applications = TeacherApplication::with('user')
                        ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
                        ->latest()
                        ->get();

        return view('admin.teacher-applications.index', compact('applications'));
    }

    /**
     * عرض تفاصيل طلب
     */
    public function show($id)
    {
        $application = TeacherApplication::with('user')->findOrFail($id);
        return view('admin.teacher-applications.show', compact('application'));
    }

    /**
     * الموافقة على الطلب
     */
    public function approve(Request $request, $id)
    {
        try {
            $application = TeacherApplication::findOrFail($id);

            if ($application->status != 'pending') {
                return redirect()->back()->with('error', 'تم معالجة هذا الطلب مسبقاً');
            }

            // تحديث حالة الطلب
            $application->update([
                'status' => 'approved',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'review_notes' => $request->input('review_notes'),
            ]);

            // تحديث role_id للمستخدم (2 = معلم)
            $user = $application->user;
            if ($user) {
                $user->update(['role_id' => 2]);
            }

            // إنشاء سجل في جدول teachers إذا لم يكن موجوداً
            $existingTeacher = Teacher::where('user_id', $user->id)->first();
            if (!$existingTeacher) {
                Teacher::create([
                    'user_id' => $user->id,
                    'specialization' => $application->specialization,
                    'status' => 'full_time',
                    'hired_at' => now(),
                ]);
            }

            // إخطار المتقدم عبر البريد
            try {
                Mail::to($application->user->email)->send(new TeacherApplicationStatusChanged($application, 'approved'));
            } catch (\Exception $e) {
                Log::error('Failed to send application approved email: ' . $e->getMessage());
            }

            return redirect()->route('admin.teacher-applications.index')
                            ->with('success', 'تم الموافقة على الطلب وأصبح المستخدم معلم');

        } catch (\Exception $e) {
            Log::error('Error in approve method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء معالجة الطلب: ' . $e->getMessage());
        }
    }

    /**
     * رفض الطلب
     */
    public function reject(Request $request, $id)
    {
        try {
            $request->validate([
                'review_notes' => 'required|string|min:5|max:1000',
            ]);

            $application = TeacherApplication::findOrFail($id);

            if ($application->status != 'pending') {
                return redirect()->back()->with('error', 'تم معالجة هذا الطلب مسبقاً');
            }

            $application->update([
                'status' => 'rejected',
                'processed_by' => auth()->id(),
                'processed_at' => now(),
                'review_notes' => $request->input('review_notes'),
            ]);

            // إخطار المتقدم عبر البريد
            try {
                Mail::to($application->user->email)->send(new TeacherApplicationStatusChanged($application, 'rejected'));
            } catch (\Exception $e) {
                Log::error('Failed to send application rejected email: ' . $e->getMessage());
            }

            return redirect()->route('admin.teacher-applications.index')
                            ->with('success', 'تم رفض الطلب');

        } catch (\Exception $e) {
            Log::error('Error in reject method: ' . $e->getMessage());
            return redirect()->back()->with('error', 'حدث خطأ أثناء رفض الطلب: ' . $e->getMessage());
        }
    }

    /**
     * عرض نموذج تقديم طلب التدريس
     */
    public function create()
    {
        // التحقق من وجود طلب سابق قيد المراجعة أو مقبول
        $existingApplication = TeacherApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingApplication) {
            $message = $existingApplication->status == 'pending'
                ? 'لديك طلب تدريس قيد المراجعة حالياً'
                : 'تم قبول طلب التدريس الخاص بك مسبقاً';

            return redirect()->route('dashboard')->with('info', $message);
        }

        return view('teacher.apply');
    }

    /**
     * حفظ طلب التدريس
     */
    public function store(Request $request)
    {
        try {
            // التحقق مرة أخرى من وجود طلب سابق
            $existingApplication = TeacherApplication::where('user_id', auth()->id())
                ->whereIn('status', ['pending', 'approved'])
                ->first();

            if ($existingApplication) {
                return redirect()->route('dashboard')
                    ->with('error', 'لديك طلب تدريس قيد المراجعة أو تم قبوله بالفعل.');
            }

            // التحقق من صحة البيانات
            $validated = $request->validate([
                'specialization' => 'required|string|max:255',
                'experience' => 'required|string|min:50|max:5000',
                'motivation' => 'required|string|min:50|max:5000',
                'certificate' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120', // 5MB كحد أقصى
            ]);

            // رفع الشهادة إذا وجدت
            $certificatePath = null;
            if ($request->hasFile('certificate') && $request->file('certificate')->isValid()) {
                $certificatePath = $request->file('certificate')->store('certificates/' . auth()->id(), 'public');
            }

            // إنشاء الطلب
            $application = TeacherApplication::create([
                'user_id' => auth()->id(),
                'specialization' => $request->specialization,
                'experience' => $request->experience,
                'motivation' => $request->motivation,
                'certificate_path' => $certificatePath,
                'status' => 'pending',
            ]);

            // إخطار المشرف عبر البريد
            try {
                $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL'));
                if ($adminEmail) {
                    Mail::to($adminEmail)->send(new TeacherApplicationSubmitted($application));
                }
            } catch (\Exception $e) {
                Log::error('Failed to send teacher application email to admin: ' . $e->getMessage());
            }

            return redirect()->route('dashboard')
                ->with('success', 'تم إرسال طلبك بنجاح، سيتم مراجعته من قبل الإدارة قريباً');

        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->validator)
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error in store method: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء إرسال الطلب: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * حذف طلب (اختياري - للإدارة فقط)
     */
    public function destroy($id)
    {
        try {
            $application = TeacherApplication::findOrFail($id);

            // حذف ملف الشهادة إذا وجد
            if ($application->certificate_path) {
                Storage::disk('public')->delete($application->certificate_path);
            }

            $application->delete();

            return redirect()->route('admin.teacher-applications.index')
                ->with('success', 'تم حذف الطلب بنجاح');

        } catch (\Exception $e) {
            Log::error('Error in destroy method: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'حدث خطأ أثناء حذف الطلب');
        }
    }
}