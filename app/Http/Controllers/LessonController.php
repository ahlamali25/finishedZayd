<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Lesson;
use App\Notifications\LessonStartedNotification;
use App\Notifications\LessonCreatedNotification;
use Illuminate\Support\Facades\Notification;
use Illuminate\Http\Request;
use App\Services\LessonService;
use App\Http\Requests\StoreLessonRequest;

class LessonController extends Controller
{
    protected $lessonService;

    public function __construct(LessonService $lessonService)
    {
        $this->lessonService = $lessonService;
    }

    public function learn($courseId)
    {
        $data = $this->lessonService->getCourseWithLessons($courseId);

        return view('lessons.learn', $data);
    }

    public function create($courseId)
    {
        $course = Course::findOrFail($courseId);
        return view('lessons.create', compact('course'));
    }

    public function store(StoreLessonRequest $request, Course $course)
    {
        try {
            $validated = $request->validated();

            $this->lessonService->createLesson($validated, $course);

            return redirect()->route('lessons.learn', $course->id)
                ->with('success', 'تم إضافة الدرس بنجاح');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['general' => 'حدث خطأ أثناء إضافة الدرس: ' . $e->getMessage()]);
        }
    }

    public function edit($id)
    {
        $lesson = Lesson::findOrFail($id);
        return view('lessons.edit', compact('lesson'));
    }

    public function update(Request $request, $id)
    {
        $lesson = Lesson::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_link' => 'nullable|url',
            'date' => 'required|date'
        ]);

        $this->lessonService->updateLesson($lesson, $validated);

        return redirect()->route('lessons.learn', $lesson->course_id)
            ->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy($id)
    {
        $lesson = Lesson::findOrFail($id);

        $courseId = $this->lessonService->deleteLesson($lesson);

        return redirect()->route('lessons.learn', $courseId)
            ->with('success', 'تم حذف الدرس بنجاح');
    }

    public function startLesson($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        $this->lessonService->startLesson($lesson);

        return back()->with('success', 'تم بدء الدرس وإرسال الإشعارات');
    }

    public function show($id)
    {
        $lesson = Lesson::with('course')->findOrFail($id);
        return view('lessons.show', compact('lesson'));
    }
}

