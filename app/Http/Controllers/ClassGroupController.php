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
        $classTypes = ClassType::all();
        $totalStudents = ClassGroup::sum('current_count');
        $totalTeachers = ClassGroup::whereNotNull('teacher_id')->count();

        return view('class_groups.show', compact('classGroup', 'classTypes', 'totalStudents', 'totalTeachers'));
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

    public function leave(ClassGroup $classGroup)
    {
        $user = auth()->user();

        if (! $user->classGroup->contains($classGroup)) {
            return redirect()->back()->with('error', 'أنت غير مسجل في هذه الحلقة');
        }

        $user->classGroup()->detach($classGroup);
        // مسح class_group_id من جدول المستخدمين
        $user->update(['class_group_id' => null]);
        $classGroup->decrement('current_count');

        return redirect()->back()->with('success', 'تم الانسحاب من الحلقة بنجاح');
    }
}
