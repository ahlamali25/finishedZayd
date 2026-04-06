<?php

namespace App\Services;

use App\Models\Lesson;
use App\Models\Course;
use App\Notifications\LessonCreatedNotification;
use App\Notifications\LessonStartedNotification;
use Illuminate\Support\Facades\Notification;

class LessonService
{
    public function getCourseWithLessons($courseId)
    {
        $course = Course::findOrFail($courseId);

        $lessons = Lesson::where('course_id', $courseId)
            ->orderBy('date', 'asc')
            ->get();

        return compact('course', 'lessons');
    }

    public function createLesson(array $data, Course $course)
    {
        $data['course_id'] = $course->id;

        $lesson = Lesson::create($data);

        $this->notifyLessonCreated($lesson);

        return $lesson;
    }

    public function updateLesson(Lesson $lesson, array $data)
    {
        $lesson->update($data);
        return $lesson;
    }

    public function deleteLesson(Lesson $lesson)
    {
        $courseId = $lesson->course_id;
        $lesson->delete();

        return $courseId;
    }

    public function startLesson(Lesson $lesson)
    {
        $this->notifyLessonStarted($lesson);
    }

    private function notifyLessonCreated(Lesson $lesson)
    {
        $students = $lesson->course->users;

        Notification::send($students, new LessonCreatedNotification($lesson));

        $teacherUser = $lesson->course->teacher->user ?? null;

        if ($teacherUser) {
            $teacherUser->notify(new LessonCreatedNotification($lesson));
        }
    }

    private function notifyLessonStarted(Lesson $lesson)
    {
        $students = $lesson->course->users;

        Notification::send($students, new LessonStartedNotification($lesson));

        $teacherUser = $lesson->course->teacher->user ?? null;

        if ($teacherUser) {
            $teacherUser->notify(new LessonStartedNotification($lesson));
        }
    }
}