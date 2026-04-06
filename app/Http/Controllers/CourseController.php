<?php

namespace App\Http\Controllers;
use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $courses = Course::all();
    return view('courses.index', compact('courses'));
}

    /**
     * Display the specified resource.
     */
     public function show($id)
    {
      $course = Course::findOrFail($id);
      return view('courses.show', compact('course'));
    }

}
