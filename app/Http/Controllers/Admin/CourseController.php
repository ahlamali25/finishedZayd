<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\ClassType;
use App\Http\Requests\StoreCourseRequest;
use App\Http\Requests\UpdateCourseRequest;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    return view('admin.courses.index', [
        'courses' => Course::with('teacher')->get()
    ]);
}

public function store(StoreCourseRequest $request)
{
    Course::create($request->validated());

    return redirect()
        ->back()
        ->with('success', 'تم إنشاء الكورس بنجاح');
}



public function create()
{
    return view('admin.courses.create', [
        'teachers' => Teacher::with('user')->get(),
        'classTypes' => ClassType::all(),
    ]);
}

public function edit(Course $course)
{
    return view('admin.courses.edit', [
        'course' => $course,
        'teachers' => Teacher::with('user')->get(),
    ]);
}



public function update(UpdateCourseRequest $request, Course $course)
{
    $course->update($request->validated());

    return back()->with('success', 'تم تعديل الكورس');
}

public function destroy(Course $course)
{
    $course->delete();
    return back()->with('success', 'تم حذف الكورس');
}

public function show(Course $course)
{
    return view('admin.courses.show', compact('course'));
}
}