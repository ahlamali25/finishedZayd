<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\ClassType;
use App\Models\Teacher;
use App\Models\Course;
use Illuminate\Http\Request;

class ClassGroupController extends Controller
{
    /**
     * Display class groups index
     */
    public function index()
    {
        $classTypes = ClassType::with(['classGroups.users', 'classGroups.teacher.user', 'classGroups.courses'])
            ->get();

        return view('admin.class_groups.index', compact('classTypes'));
    }

    /**
     * Show form to assign courses to class groups
     */
    public function classgroup()
    {
        return view('admin.courses.classgroup', [
            'classTypes' => ClassType::all(),
            'teachers' => Teacher::with('user')->get(),
            'courses' => Course::all(),
        ]);
    }

    /**
     * Store course assignment to class groups
     */
   public function assignStore(Request $request)
{
    $validated = $request->validate([
        'class_type_id' => 'required|exists:class_types,id',
        'teacher_id' => 'required|exists:teachers,id',
        'courses' => 'required|array',
        'courses.*' => 'exists:courses,id',
    ]);

    // احسب رقم الحلقة الفرعية التالي
    $lastGroup = ClassGroup::where('class_type_id', $validated['class_type_id'])
        ->orderByDesc('group_number')
        ->first();

    $nextGroupNumber = $lastGroup ? $lastGroup->group_number : 1;

    // أنشئ الحلقة الفرعية أو احصل عليها
    $classGroup = ClassGroup::firstOrCreate(
        [
            'class_type_id' => $validated['class_type_id'],
            'teacher_id' => $validated['teacher_id'],
            'group_number' => $nextGroupNumber,
        ],
        [
            'capacity' => 30, // العدد الأقصى لكل حلقة
            'current_count' => 0,
        ]
    );

    // ربط الكورسات
    $classGroup->courses()->sync($validated['courses']);

    return redirect()
        ->route('admin.dashboard')
        ->with('success', 'تم تعيين الكورسات للحلقة بنجاح');
}

}
