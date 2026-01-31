<?php

namespace App\Http\Controllers\Teacher;
use App\Models\Course;
use App\Models\ClassGroup;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TeacherDashboardController extends Controller
{
public function index()
{
    $teacher = auth()->user()->teacher;

    return view('teacher.dashboard', [
        'courses' => $teacher->courses,
        'classGroups' => $teacher->classGroups,
    ]);
}
    

}
