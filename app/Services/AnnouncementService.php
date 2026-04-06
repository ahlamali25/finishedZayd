<?php

namespace App\Services;

use App\Models\Announcement;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;
use App\Notifications\AnnouncementCreatedNotification;
use Illuminate\Support\Facades\Notification;

class AnnouncementService
{
    /**
     * جلب جميع الإعلانات
     */
    public function getAllAnnouncements()
    {
        return Announcement::latest()->get();
    }

    /**
     * جلب الكورسات للقائمة المنسدلة
     */
    public function getAllCoursesForDropdown()
    {
        return Course::all();
    }

    /**
     * إنشاء إعلان جديد
     */
    public function createAnnouncement(array $data)
    {
        $data['user_id'] = Auth::id();

        $announcement = Announcement::create($data);

        // إرسال إشعارات
        $this->sendNotification($announcement);

        return $announcement;
    }

    /**
     * تحديث إعلان
     */
    public function updateAnnouncement(Announcement $announcement, array $data)
    {
        $announcement->update($data);

        return $announcement;
    }

    /**
     * حذف إعلان
     */
    public function deleteAnnouncement(Announcement $announcement)
    {
        return $announcement->delete();
    }

    /**
     * إرسال إشعار عند إنشاء إعلان
     */
    private function sendNotification(Announcement $announcement)
    {
        // إذا الإعلان مرتبط بكورس
        if ($announcement->course_id) {

            $course = $announcement->course;

            // الطلاب
            $students = $course->users;

            Notification::send(
                $students,
                new AnnouncementCreatedNotification($announcement)
            );

            // المعلم
            $teacherUser = $course->teacher->user ?? null;

            if ($teacherUser) {
                $teacherUser->notify(
                    new AnnouncementCreatedNotification($announcement)
                );
            }

        } else {
            // إعلان عام → إرسال لجميع المستخدمين
            $users = \App\Models\User::all();

            Notification::send(
                $users,
                new AnnouncementCreatedNotification($announcement)
            );
        }
    }
}