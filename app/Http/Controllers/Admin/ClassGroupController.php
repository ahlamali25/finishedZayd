<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassGroup;
use App\Models\ClassType;
use App\Models\Teacher;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;
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

        // إضافة المتغيرات المطلوبة للإحصائيات
        $courses = Course::with('teacher.user', 'lessons', 'classGroups')->get();
        $totalLessons = Lesson::count();
        $totalStudents = User::where('role_id', 3)->count(); // role_id = 3 للطلاب
        $totalTeachers = User::where('role_id', 2)->count(); // role_id = 2 للمعلمين
        $activeCourses = Course::has('lessons')->count();

        // كورس مع أكبر عدد من الطلاب (الأكثر شعبية)
        $popularCourse = Course::withCount('users')
            ->orderBy('users_count', 'desc')
            ->first();
        $popularCourseName = $popularCourse ? $popularCourse->name : '-';

        // متوسط التقييم (إذا كان لديك نظام تقييم)
        $avgRating = 4.5; // يمكنك تغيير هذا حسب نظامك

        // دروس اليوم
        $todaysLessons = Lesson::whereDate('date', now()->toDateString())->count();

        return view('admin.class_groups.index', compact(
            'classTypes',
            'courses',
            'totalLessons',
            'totalStudents',
            'totalTeachers',
            'activeCourses',
            'popularCourseName',
            'avgRating',
            'todaysLessons'
        ));
    }

    /**
     * Show form to assign courses to class groups
     */
    public function classgroup()
    {
        return view('admin.class_groups.index', compact(
    'classTypes',
    'totalSubGroups',
    'totalStudents',
    'totalTeachers',
    'assignedCourses',
    'activeTeachers',
    'completedGroups',
    'avgAttendance'
));
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

        // إذا كانت هناك حلقة موجودة من نفس النوع ولم تمتلئ بعد، استخدمها
        $classGroup = ClassGroup::where('class_type_id', $validated['class_type_id'])
            ->whereColumn('current_count', '<', 'capacity')
            ->orderBy('group_number')
            ->first();

        if (! $classGroup) {
            $lastGroup = ClassGroup::where('class_type_id', $validated['class_type_id'])
                ->orderByDesc('group_number')
                ->first();

            $nextGroupNumber = $lastGroup ? $lastGroup->group_number + 1 : 1;

            $classGroup = ClassGroup::create([
                'class_type_id' => $validated['class_type_id'],
                'teacher_id' => $validated['teacher_id'],
                'group_number' => $nextGroupNumber,
                'capacity' => 30,
                'current_count' => 0,
            ]);
        } elseif ($classGroup->teacher_id !== $validated['teacher_id']) {
            $classGroup->teacher_id = $validated['teacher_id'];
            $classGroup->save();
        }

        // ربط الكورسات
        $classGroup->courses()->sync($validated['courses']);

        return redirect()
            ->route('admin.dashboard')
            ->with('success', 'تم تعيين الكورسات للحلقة بنجاح');
    }

public function assignForm()
{
    $classTypes = ClassType::all();
    $teachers = Teacher::with('user')->get();
    $courses = Course::all();

    return view('admin.courses.classgroup', compact(
        'classTypes',
        'teachers',
        'courses'
    ));
}

    /**
     * Show the form for editing class groups for a specific class type
     */
    public function edit(ClassType $classType)
    {
        $classType->load(['classGroups.users', 'classGroups.teacher.user', 'classGroups.courses']);
        $teachers = Teacher::with('user')->get();
        $courses = Course::all();
        $classGroup = $classType->classGroups->first();

        return view('admin.class_groups.edit', compact('classType', 'teachers', 'courses', 'classGroup'));
    }

    /**
     * Update the class groups for a specific class type
     */
    public function update(Request $request, ClassType $classType)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:teachers,id',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ]);

        // Find or create a class group for this type
        $classGroup = ClassGroup::firstOrCreate(
            ['class_type_id' => $classType->id],
            ['capacity' => 30, 'current_count' => 0]
        );

        // Update teacher and courses
        $classGroup->teacher_id = $validated['teacher_id'];
        $classGroup->courses()->sync($validated['courses']);
        $classGroup->save();

        return redirect()->route('admin.class-groups.index')->with('success', 'تم تحديث الحلقة بنجاح');
    }

}