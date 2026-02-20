<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    // صفحة لوحة التحكم
    public function index()
    {
        $teacher = auth()->user()->teacher;

        return view('teacher.dashboard', [
            'courses' => $teacher->courses->take(2),       // أول كورسين فقط
            'classGroups' => $teacher->classGroups->take(2), // أول حلقتين فقط
        ]);
    }

    // صفحة كل الحلقات "حلقاتي"
    public function myClasses()
    {
        $teacher = auth()->user()->teacher;

        return view('teacher.my-classes', [
            'classGroups' => $teacher->classGroups, 
        ]);
    }
    public function myCourses()
{
    $teacher = auth()->user()->teacher;

    // جلب كل الكورسات التي يدرسها المعلم
    return view('teacher.my-courses', [
        'courses' => $teacher->courses,
    ]);
}

}