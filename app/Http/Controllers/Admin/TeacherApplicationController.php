<?php
// app/Http/Controllers/Admin/TeacherApplicationController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\TeacherApplicationStatusChanged;
use App\Mail\TeacherApplicationSubmitted;
use App\Models\TeacherApplication;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

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
        $application = TeacherApplication::findOrFail($id);

        if ($application->status != 'pending') {
            return redirect()->back()->with('error', 'تم معالجة هذا الطلب مسبقاً');
        }

        // 1. تحديث حالة الطلب
        $application->update([
            'status' => 'approved',
            'processed_by' => auth()->id(),
            'processed_at' => now(),
            'review_notes' => $request->input('review_notes'),
        ]);

        // 2. تحديث role_id للمستخدم
        $user = $application->user;
        $user->update(['role_id' => 2]);

        // 3. إنشاء سجل في جدول teachers
        Teacher::create([
            'user_id' => $user->id,
            'specialization' => $application->specialization,
            'status' => 'full_time',
        ]);

        // 4. إخطار المتقدم عبر البريد
        try {
            Mail::to($application->user->email)->send(new TeacherApplicationStatusChanged($application, 'approved'));
        } catch (\Exception $e) {
            // log but don't fail
            logger()->error('Failed to send application approved email: '.$e->getMessage());
        }

        return redirect()->route('admin.teacher-applications.index')
                        ->with('success', 'تم الموافقة على الطلب وأصبح المستخدم معلم');
    }

    /**
     * رفض الطلب
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'review_notes' => 'required|string|min:10|max:500',
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

        // notify applicant
        try {
            Mail::to($application->user->email)->send(new TeacherApplicationStatusChanged($application, 'rejected'));
        } catch (\Exception $e) {
            logger()->error('Failed to send application rejected email: '.$e->getMessage());
        }

        return redirect()->route('admin.teacher-applications.index')
                        ->with('success', 'تم رفض الطلب');
    }

    /**
     * عرض نموذج تقديم طلب التدريس
     */
    public function create()
    {
        // Check if user already has a pending or approved application
        $existingApplication = TeacherApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingApplication) {
            return redirect()->route('dashboard')->with('error', 'لديك طلب تدريس قيد المراجعة أو تم قبوله بالفعل.');
        }

        return view('teacher.apply');
    }

    /**
     * حفظ طلب التدريس
     */
    public function store(Request $request)
    {
        // Check again for existing application
        $existingApplication = TeacherApplication::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved'])
            ->first();

        if ($existingApplication) {
            return redirect()->route('dashboard')->with('error', 'لديك طلب تدريس قيد المراجعة أو تم قبوله بالفعل.');
        }

        $request->validate([
            'specialization' => 'required|string|max:255',
            'experience' => 'required|string|min:50|max:2000',
            'motivation' => 'required|string|min:50|max:2000',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $certificatePath = null;
        if ($request->hasFile('certificate')) {
            $certificatePath = $request->file('certificate')->store('certificates', 'public');
        }

        $application = TeacherApplication::create([
            'user_id' => auth()->id(),
            'specialization' => $request->specialization,
            'experience' => $request->experience,
            'motivation' => $request->motivation,
            'certificate_path' => $certificatePath,
            'status' => 'pending',
        ]);

        // notify admin via mail
        try {
            $adminEmail = config('mail.admin_email', env('ADMIN_EMAIL'));
            if ($adminEmail) {
                Mail::to($adminEmail)->send(new TeacherApplicationSubmitted($application));
            }
        } catch (\Exception $e) {
            logger()->error('Failed to send teacher application email to admin: '.$e->getMessage());
        }

        return redirect()->route('dashboard')->with('success', 'تم إرسال طلبك بنجاح، سيتم مراجعته قريباً');
    }
}