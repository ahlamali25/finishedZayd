<?php

namespace App\Http\Controllers;
use App\Models\Announcement;
use App\Models\Course;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
       public function index()
    {
        $announcements = Announcement::orderBy('created_at', 'desc')->get();
        return view('center', compact('announcements'));
    }

     public function create()
    {
        // جلب جميع الكورسات لعرضها في القائمة المنسدلة
        $courses = Course::orderBy('name')->get();

        return view('announcement.create', compact('courses'));
    }

    /**
     * حفظ الإعلان الجديد
     */
    public function store(Request $request)
    {
        // التحقق من البيانات المدخلة
        $request->validate([
            'course_id' => 'nullable|exists:courses,id',
            'title' => 'required|string|max:255|min:3',
            'content' => 'required|string|min:10',
        ], [
            'title.required' => 'عنوان الإعلان مطلوب',
            'title.min' => 'عنوان الإعلان يجب أن يكون على الأقل 3 أحرف',
            'content.required' => 'محتوى الإعلان مطلوب',
            'content.min' => 'محتوى الإعلان يجب أن يكون على الأقل 10 أحرف',
        ]);

        // إنشاء الإعلان الجديد
        Announcement::create([
            'user_id' => Auth::id(), // المدير الحالي
            'course_id' => $request->course_id ?: null,
            'title' => $request->title,
            'content' => $request->content,
        ]);

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('center.page')
            ->with('success', 'تم إضافة الإعلان بنجاح!');
    }

    // تعديل الاعلان
    public function edit(Announcement $announcement)
    {
        // التحقق من الصلاحيات
        if (auth()->id() !== $announcement->user_id) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان');
        }
    
    // جلب الكورسات لعرضها في القائمة المنسدلة
        $courses = Course::all(); 
    
        return view('announcement.edit', compact('announcement', 'courses'));
    }

    // تحديث الاعلان
    public function update(Request $request, Announcement $announcement)
    {
        // التحقق من الصلاحيات
        if (auth()->id() !== $announcement->user_id) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان');
        }
    
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'nullable|exists:courses,id'
        ]);
    
        $announcement->update([
            'title' => $request->title,
            'content' => $request->content,
            'course_id' => $request->course_id ?: null,
            'updated_at' => now(),
        ]);
    
        return redirect()->route('center.page')
            ->with('success', 'تم تحديث الإعلان بنجاح');
    }

    // حذف الاعلان
    public function destroy(Announcement $announcement)
    {
        if (auth()->id() !== $announcement->user_id) {
            abort(403, 'ليس لديك صلاحية لحذف هذا الإعلان');
        }
    
        $announcement->delete();
    
        return redirect()->route('center.page')
          ->with('success', 'تم حذف الإعلان بنجاح');
    }

}
