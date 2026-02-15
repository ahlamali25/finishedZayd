<?php

namespace App\Http\Controllers;
use App\Models\ClassGroup;
use App\Models\Course;
use App\Models\ClassType;
use Illuminate\Http\Request;

class ClassGroupController extends Controller
{
    public function show(ClassGroup $classGroup)
{
    return view('classes.show', compact('classGroup'));
}

  /**
     * عرض كورسات حلقة معينة (الواجهة الوحيدة التي تحتاجها)
     */
    public function showCourses($id)
    {
       $classGroup = ClassGroup::with([
    'classType.courses' => function($query) {
        $query->withCount('lessons')->with('teacher');
    },
    'teacher',
    'classType'
])->findOrFail($id);


        return view('class_groups.courses', compact('classGroup'));
    }
}
