<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClassGroupController as AdminClassGroupController;
use App\Http\Controllers\ClassGroupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\Admin\TeacherApplicationController;
use App\Http\Controllers\Teacher\TeacherSocialController;

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('courses/classgroup', [AdminClassGroupController::class, 'assignForm'])
            ->name('courses.classgroup');

        Route::prefix('class-groups')
            ->name('class-groups.')
            ->group(function () {
                Route::get('/', [AdminClassGroupController::class, 'index'])->name('index');
                Route::post('assign', [AdminClassGroupController::class, 'assignStore'])->name('assign.store');
            });

        Route::resource('courses', CourseController::class);

        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        Route::prefix('announcements')->name('announcements.')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('/create', [AnnouncementController::class, 'create'])->name('create'); 
            Route::post('/', [AnnouncementController::class, 'store'])->name('store'); 
            Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');    
            Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
        });

        Route::get('/teacher-applications', [TeacherApplicationController::class, 'index'])
            ->name('teacher-applications.index');

        Route::get('/teacher-applications/{id}', [TeacherApplicationController::class, 'show'])
            ->name('teacher-applications.show');

        Route::post('/teacher-applications/{id}/approve', [TeacherApplicationController::class, 'approve'])
            ->name('teacher-applications.approve');

        Route::post('/teacher-applications/{id}/reject', [TeacherApplicationController::class, 'reject'])
            ->name('teacher-applications.reject');

    });

/*
|--------------------------------------------------------------------------
| CLASS GROUP ADMIN EDIT
|--------------------------------------------------------------------------
*/
Route::get('admin/class-groups/{classType}/edit', [AdminClassGroupController::class, 'edit'])
    ->name('admin.class-groups.edit');

Route::put('admin/class-groups/{classType}', [AdminClassGroupController::class, 'update'])
    ->name('admin.class-groups.update');

/*
|--------------------------------------------------------------------------
| TEACHER
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'teacher'])->group(function () {

    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])
        ->name('teacher.dashboard');

    Route::get('/teacher/my-courses', [TeacherDashboardController::class, 'myCourses'])
        ->name('teacher.my-courses');

    Route::get('/teacher/my-classes', [TeacherDashboardController::class, 'myClasses'])
        ->name('teacher.my-classes');

    // إدارة حلقة فرعية معينة
    Route::get('/teacher/class-groups/{classGroup}', [TeacherDashboardController::class, 'manageClassGroup'])
        ->name('teacher.class-group.manage');

    Route::post('/lessons/{lesson}/start', [LessonController::class, 'startLesson'])
        ->name('lessons.start');


});

Route::get('/teacher/social/create/{teacher}', [TeacherSocialController::class, 'create'])
    ->middleware(['auth', 'teacher'])
    ->name('teacher.social.create');

Route::post('/teacher/social/store/{teacher_id}', [TeacherSocialController::class, 'store'])
    ->middleware(['auth', 'teacher'])
    ->name('teacher.social.store');

Route::get('/teacher/social/edit/{teacher}', [TeacherSocialController::class, 'edit'])
    ->middleware(['auth', 'teacher'])
    ->name('teacher.social.edit');

Route::put('/teacher/social/update/{teacher_id}', [TeacherSocialController::class, 'update'])
    ->middleware(['auth', 'teacher'])
    ->name('teacher.social.update');

Route::delete('/teacher/social/{teacher}', [TeacherSocialController::class, 'destroy'])
    ->middleware(['auth', 'teacher'])
    ->name('teacher.social.destroy');

/*
|--------------------------------------------------------------------------
| STUDENT
|--------------------------------------------------------------------------
*/
Route::get('/student/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified', 'student'])
    ->name('dashboard');

Route::middleware(['auth', 'student'])
    ->get('/student/my-courses', [DashboardController::class, 'myCourses'])
    ->name('student.courses');

/*
|--------------------------------------------------------------------------
| COURSES & CLASSES
|--------------------------------------------------------------------------
*/
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');
Route::get('/classes/{classGroup}', [ClassGroupController::class, 'show'])->name('classes.show');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/groups-count/{id}', [HomeController::class, 'getGroupsCount']);

Route::post('/join-class/{class_type_id}', [HomeController::class, 'joinClass'])
    ->middleware('auth')
    ->name('join.class');

Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');

Route::post('/enroll', [App\Http\Controllers\EnrollmentController::class, 'store'])
    ->name('enrollments.store');

/*
|--------------------------------------------------------------------------
| LESSONS (CLEANED - NO DUPLICATES)
|--------------------------------------------------------------------------
*/

// داخل الكورس (المعتمد)
Route::prefix('courses/{course}')->group(function () {
    Route::get('/lessons', [LessonController::class, 'learn'])->name('lessons.learn');
    Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
});

// نسخة مستقلة (اختياري - أسماء مختلفة)
Route::get('lessons/learn/{courseId}', [LessonController::class, 'learn'])
    ->name('lessons.learn.course');

Route::get('lessons/create/{courseId}', [LessonController::class, 'create'])
    ->name('lessons.create.course');

Route::get('lessons/{id}/edit', [LessonController::class, 'edit'])->name('lessons.edit');
Route::put('lessons/{id}', [LessonController::class, 'update'])->name('lessons.update');
Route::delete('lessons/{id}', [LessonController::class, 'destroy'])->name('lessons.destroy');
Route::get('/lessons/{id}', [LessonController::class, 'show'])->name('lessons.show');

/*
|--------------------------------------------------------------------------
| OTHER
|--------------------------------------------------------------------------
*/
Route::get('/courses/create', [CourseController::class, 'create'])->name('courses.create');

Route::get('/center', [AnnouncementController::class, 'index'])->name('center.page');

Route::get('/class-groups/{classGroup}/courses', [ClassGroupController::class, 'showCourses'])
    ->name('class_groups.courses');

/*
|--------------------------------------------------------------------------
| PROFILE
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| NOTIFICATIONS
|--------------------------------------------------------------------------
*/
Route::post('/notifications/mark-read', function () {
    $user = auth()->user();
    if ($user) {
        $user->unreadNotifications->markAsRead();
    }
    return response()->json(['ok' => true]);
})->middleware('auth')->name('notifications.markRead');

/*
|--------------------------------------------------------------------------
| TEACHER APPLY
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/teacher/apply', [TeacherApplicationController::class, 'create'])->name('teacher.apply.form');
    Route::post('/teacher/apply', [TeacherApplicationController::class, 'store'])->name('teacher.apply.store');
});

/*
|--------------------------------------------------------------------------
| CLASS GROUP LEAVE
|--------------------------------------------------------------------------
*/
Route::delete('/class-group/{classGroup}/leave', [ClassGroupController::class, 'leave'])
    ->middleware('auth')
    ->name('class-group.leave');

require __DIR__.'/auth.php';