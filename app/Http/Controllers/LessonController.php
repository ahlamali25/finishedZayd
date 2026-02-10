<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Lesson;
use App\Notifications\LessonStartedNotification;
use Illuminate\Http\Request;

class LessonController extends Controller
{

    /**
     * عرض صفحة تعلم الدروس
     */
    public function learn($courseId)
    {
        $course = Course::findOrFail($courseId);
        $lessons = Lesson::where('course_id', $courseId)
                        ->orderBy('date', 'asc')
                        ->get();

        return view('lessons.learn', compact('course', 'lessons'));
    }

  
    /**
     * عرض صفحة إنشاء درس جديد
     */
    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('lessons.create', compact('course'));
    }

    /**
     * حفظ درس جديد
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_link' => 'nullable|url',
            'date' => 'required|date',
            'course_id' => 'required|exists:courses,id'
        ]);

        Lesson::create($validated);

        return redirect()->route('lessons.learn', $validated['course_id'])
                        ->with('success', 'تم إضافة الدرس بنجاح');
    }

    /**
     * عرض صفحة تعديل درس
     */
    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('lessons.edit', compact('lesson'));
    }

    /**
     * تحديث درس
     */
    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_link' => 'nullable|url',
            'date' => 'required|date'
        ]);

        $lesson->update($validated);

        return redirect()->route('lessons.learn', $lesson->course_id)
                        ->with('success', 'تم تحديث الدرس بنجاح');
    }

    /**
     * حذف درس
     */
    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);
        $courseId = $lesson->course_id;
        $lesson->delete();

        return redirect()->route('lessons.learn', $courseId)
                        ->with('success', 'تم حذف الدرس بنجاح');
    }

    /**
     * إضافة مهمة فرعية للدرس
     */
    public function addSubTask(Request $request, $lessonId)
    {
        // كود إضافة مهمة فرعية
        // ستقوم بتنفيذ هذا لاحقاً عندما تنشئ نموذج SubTask

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة المهمة الفرعية',
            'data' => $request->all()
        ]);
    }

    /**
     * إضافة بند عمل للدرس
     */
    public function addWorkItem(Request $request, $lessonId)
    {
        // كود إضافة بند عمل
        // ستقوم بتنفيذ هذا لاحقاً عندما تنشئ نموذج WorkItem

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة بند العمل',
            'data' => $request->all()
        ]);
    }

    /**
     * إضافة تعليق للدرس
     */
    public function addComment(Request $request, $lessonId)
    {
        // كود إضافة تعليق
        // ستقوم بتنفيذ هذا لاحقاً عندما تنشئ نموذج Comment

        return response()->json([
            'success' => true,
            'message' => 'تم إضافة التعليق',
            'data' => $request->all()
        ]);
    }

    /**
     * تحديث حالة الدرس
     */
    public function updateStatus(Request $request, $lessonId)
    {
        // كود تحديث الحالة
        // ستقوم بتنفيذ هذا لاحقاً عندما تنشئ نموذج LessonStatus

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث الحالة',
            'data' => $request->all()
        ]);
    }

    /**
     * عرض الدرس بشكل منفرد
     */
    public function show($id)
    {
        $lesson = Lesson::with('course')->findOrFail($id);
        return view('lessons.show', compact('lesson'));
    }


    public function startLesson($lessonId)
{
    $lesson = Lesson::findOrFail($lessonId);

    // 1️⃣ الطلاب المسجلين بالكورس
    $students = $lesson->course->users;

    // إرسال إشعار جماعي
    Notification::send(
        $students,
        new LessonStartedNotification($lesson)
    );

    // 2️⃣ المعلم
    // عندك teacher_id داخل course
    $teacherUser = $lesson->course->teacher->user ?? null;

    if ($teacherUser) {
        $teacherUser->notify(
            new LessonStartedNotification($lesson)
        );
    }

    return back()->with('success', 'تم بدء الدرس وإرسال الإشعارات');
}
}

