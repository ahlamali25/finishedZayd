<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Student\DashboardController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ClassGroupController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\AnnouncementController;

Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

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


});


Route::middleware(['auth', 'teacher'])->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])
        ->name('teacher.dashboard');
});


Route::get('/student/dashboard', 
    [DashboardController::class, 'index']
)->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')
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

require __DIR__.'/auth.php';
