<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\ClassType;

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

public function store(Request $request)
{
    $request->validate([
        'name' => 'required',
        'description' => 'required',
        'total_sessions' => 'required|integer',
        'teacher_id' => 'required|exists:teachers,id',
        'class_type_id' => 'required|exists:class_types,id',
    ]);

    // إنشاء الكورس
    $course = Course::create([
        'name' => $request->name,
        'description' => $request->description,
        'total_sessions' => $request->total_sessions,
        'teacher_id' => $request->teacher_id,
    ]);

    // ربطه بنوع الحلقة (Pivot)
    $course->classTypes()->attach($request->class_type_id);

    return redirect()
        ->back()
        ->with('success', 'تم إنشاء الكورس وربطه بنوع الحلقة');
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
    return view('admin.courses.edit', compact('course'));
}


public function update(Request $request, Course $course)
{
    $course->update($request->all());
    return back()->with('success', 'تم تعديل الكورس');
}

public function destroy(Course $course)
{
    $course->delete();
    return back()->with('success', 'تم حذف الكورس');
}
}