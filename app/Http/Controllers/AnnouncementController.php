<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Http\Requests\UpdateAnnouncementRequest;

class AnnouncementController extends Controller
{
    protected $announcementService;

    public function __construct(AnnouncementService $announcementService)
    {
        $this->announcementService = $announcementService;
    }

    /**
     * عرض جميع الإعلانات
     */
    public function index()
    {
        $announcements = $this->announcementService->getAllAnnouncements();

        return view('center', compact('announcements'));
    }

    /**
     * عرض صفحة إنشاء إعلان
     */
    public function create()
    {
        $courses = $this->announcementService->getAllCoursesForDropdown();

        return view('announcement.create', compact('courses'));
    }

    /**
     * حفظ إعلان جديد
     */
    public function store(StoreAnnouncementRequest $request)
    {
        $this->announcementService->createAnnouncement(
            $request->validated()
        );

        return redirect()->route('center.page')
            ->with('success', 'تم إضافة الإعلان بنجاح!');
    }

    /**
     * عرض صفحة تعديل إعلان
     */
    public function edit(Announcement $announcement)
    {
        // التحقق من الصلاحية
        if (auth()->id() !== $announcement->user_id) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان');
        }

        $courses = $this->announcementService->getAllCoursesForDropdown();

        return view('announcement.edit', compact('announcement', 'courses'));
    }

    /**
     * تحديث إعلان
     */
    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        // التحقق من الصلاحية
        if (auth()->id() !== $announcement->user_id) {
            abort(403, 'ليس لديك صلاحية لتعديل هذا الإعلان');
        }

        $this->announcementService->updateAnnouncement(
            $announcement,
            $request->validated()
        );

        return redirect()->route('center.page')
            ->with('success', 'تم تحديث الإعلان بنجاح');
    }

    /**
     * حذف إعلان
     */
    public function destroy(Announcement $announcement)
    {
        // التحقق من الصلاحية
        if (auth()->id() !== $announcement->user_id) {
            abort(403, 'ليس لديك صلاحية لحذف هذا الإعلان');
        }

        $this->announcementService->deleteAnnouncement($announcement);

        return redirect()->route('center.page')
            ->with('success', 'تم حذف الإعلان بنجاح');
    }
}