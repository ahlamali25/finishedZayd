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

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // المسارات المحددة قبل resource (لها أولوية)
        Route::get('courses/classgroup', [AdminClassGroupController::class, 'classgroup'])
            ->name('courses.classgroup');

        Route::prefix('class-groups')
            ->name('class-groups.')
            ->group(function () {
                Route::get('/', [AdminClassGroupController::class, 'index'])
                    ->name('index');
                Route::post('assign', [AdminClassGroupController::class, 'assignStore'])
                    ->name('assign.store');
            });

        Route::resource('courses', CourseController::class);

         Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

        Route::prefix('announcements')->name('announcements.')->group(function () {
            Route::get('/', [AnnouncementController::class, 'index'])->name('index');
            Route::get('/create', [AnnouncementController::class, 'create'])->name('create'); 
            Route::post('/', [AnnouncementController::class, 'store'])->name('store'); 
            Route::get('/{announcement}/edit', [AnnouncementController::class, 'edit'])->name('edit');    
            Route::put('/{announcement}', [AnnouncementController::class, 'update'])->name('update');
            Route::delete('/{announcement}', [AnnouncementController::class, 'destroy'])->name('destroy');
        });

                  Route::get('/teacher-applications', [App\Http\Controllers\Admin\TeacherApplicationController::class, 'index'])
         ->name('teacher-applications.index');

    Route::get('/teacher-applications/{id}', [App\Http\Controllers\Admin\TeacherApplicationController::class, 'show'])
         ->name('teacher-applications.show');

    Route::post('/teacher-applications/{id}/approve', [App\Http\Controllers\Admin\TeacherApplicationController::class, 'approve'])
         ->name('teacher-applications.approve');

    Route::post('/teacher-applications/{id}/reject', [App\Http\Controllers\Admin\TeacherApplicationController::class, 'reject'])
         ->name('teacher-applications.reject');
});








// المعلم
Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])
        ->name('teacher.dashboard');

   // كورساتي
    Route::get('/teacher/my-courses', [TeacherDashboardController::class, 'myCourses'])
        ->name('teacher.my-courses');
    //حلقاتي
    Route::get('/teacher/my-classes', [TeacherDashboardController::class, 'myClasses'])
        ->name('teacher.my-classes');
    
    // start lesson route
    Route::post('/lessons/{lesson}/start', [App\Http\Controllers\LessonController::class, 'startLesson'])
        ->name('lessons.start');
  
});


Route::get('/student/dashboard', 
    [DashboardController::class, 'index']
)->middleware(['auth', 'verified', 'student'])->name('dashboard');

Route::middleware(['auth', 'student'])
    ->get('/student/my-courses', [DashboardController::class, 'myCourses'])
    ->name('student.courses');



Route::get('/courses/{course}', [CourseController::class, 'show'])
    ->name('courses.show');

Route::get('/classes/{classGroup}', [ClassGroupController::class, 'show'])
    ->name('classes.show');

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/groups-count/{id}', [App\Http\Controllers\HomeController::class, 'getGroupsCount']);
Route::post('/join-class/{class_type_id}',
    [HomeController::class, 'joinClass']
)->middleware('auth')->name('join.class');

Route::get('/courses', [App\Http\Controllers\CourseController::class, 'index'])->name('courses.index');
Route::post('/enroll', [App\Http\Controllers\EnrollmentController::class, 'store'])->name('enrollments.store');


Route::prefix('courses/{course}')->group(function () {
   Route::get('/lessons', [LessonController::class, 'learn'])->name('lessons.learn');
    Route::get('/lessons/create', [LessonController::class, 'create'])->name('lessons.create');
    Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
});

// عرض صفحة تعلم الدروس
Route::get('lessons/learn/{courseId}', [LessonController::class, 'learn'])
    ->name('lessons.learn');

// عرض نموذج إنشاء درس
Route::get('lessons/create/{courseId}', [LessonController::class, 'create'])
    ->name('lessons.create');

// حفظ درس جديد
Route::post('lessons', [LessonController::class, 'store'])
    ->name('lessons.store');

// عرض نموذج تعديل درس
Route::get('lessons/{id}/edit', [LessonController::class, 'edit'])
    ->name('lessons.edit');

// تحديث درس
Route::put('lessons/{id}', [LessonController::class, 'update'])
    ->name('lessons.update');

// حذف درس
Route::delete('lessons/{id}', [LessonController::class, 'destroy'])
    ->name('lessons.destroy');
//
Route::get('/lessons/{id}', [LessonController::class, 'show'])->name('lessons.show');

// يمكنك الاحتفاظ بـ CourseController للوظائف الأخرى المتعلقة بالكورسات
Route::controller(CourseController::class)->group(function () {
    Route::get('/courses', 'index')->name('courses.index');
    Route::get('/courses/create', 'create')->name('courses.create');

    });

    Route::get('/center', [AnnouncementController::class, 'index'])->name('center.page');

    Route::get('/class-groups/{classGroup}/courses', [ClassGroupController::class, 'showCourses'])
     ->name('class_groups.courses');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Mark notifications as read
Route::post('/notifications/mark-read', function () {
    $user = auth()->user();
    if ($user) {
        $user->unreadNotifications->markAsRead();
    }
    return response()->json(['ok' => true]);
})->middleware('auth')->name('notifications.markRead');


Route::middleware('auth')->group(function () {
    Route::get('/teacher/apply', [TeacherApplicationController::class, 'create'])->name('teacher.apply.form');
    Route::post('/teacher/apply', [TeacherApplicationController::class, 'store'])->name('teacher.apply.store');
});

require __DIR__.'/auth.php';
