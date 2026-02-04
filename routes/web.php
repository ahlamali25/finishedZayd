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


Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', [AdminDashboardController::class, 'index'])
            ->name('dashboard');

        Route::resource('courses', CourseController::class);

         Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');
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





Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



require __DIR__.'/auth.php';
