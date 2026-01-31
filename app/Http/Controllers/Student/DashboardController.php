<?php

namespace App\Http\Controllers\Student;
use App\Models\Course;
use App\Models\ClassGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
  public function index()
{
    $user = auth()->user();
    $courses = $user->courses ?? collect(); // Assuming a User has many Courses relationship
    $classes = $user->classGroup()->with('classType')->get(); // Assuming a User has many Classes relationship

    return view('student.dashboard', compact('courses', 'classes'));

}

}
