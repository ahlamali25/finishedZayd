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

    // احسب رقم الحلقة الفرعية التالي
    $lastGroup = ClassGroup::where('class_type_id', $validated['class_type_id'])
        ->orderByDesc('group_number')
        ->first();

    $nextGroupNumber = $lastGroup ? $lastGroup->group_number + 1 : 1;

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