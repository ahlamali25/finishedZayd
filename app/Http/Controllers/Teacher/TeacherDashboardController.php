<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

class TeacherDashboardController extends Controller
{
    // صفحة لوحة التحكم
    public function index()
    {
        $user = auth()->user();
        
        // التحقق من وجود معلم مرتبط بالمستخدم
        if (!$user->teacher) {
            return view('teacher.dashboard', [
                'courses' => collect(),
                'classGroups' => collect(),
                'error' => 'لا يوجد حساب معلم مرتبط بحسابك'
            ]);
        }

        $teacher = $user->teacher;
        
        // جلب الكورسات مع eager loading
        $courses = $teacher->courses()
            ->with(['lessons', 'teacher.user'])
            ->take(2)
            ->get();
            
        $classGroups = $teacher->classGroups()
            ->with(['classType', 'users'])
            ->take(2)
            ->get();

        return view('teacher.dashboard', [
            'courses' => $courses,
            'classGroups' => $classGroups,
            'totalCourses' => $teacher->courses()->count(),
            'totalClassGroups' => $teacher->classGroups()->count(),
        ]);
    }

    // صفحة كل الحلقات "حلقاتي"
    public function myClasses()
    {
        $user = auth()->user();
        
        if (!$user->teacher) {
            return view('teacher.my-classes', [
                'classGroups' => collect(),
                'error' => 'لا يوجد حساب معلم مرتبط بحسابك'
            ]);
        }

        $teacher = $user->teacher;

        return view('teacher.my-classes', [
            'classGroups' => $teacher->classGroups()->with('classType', 'users')->get(), 
        ]);
    }
    public function myCourses()
    {
        $user = auth()->user();
        
        if (!$user->teacher) {
            return view('teacher.my-courses', [
                'courses' => collect(),
                'error' => 'لا يوجد حساب معلم مرتبط بحسابك'
            ]);
        }

        $teacher = $user->teacher;

        // جلب كل الكورسات التي يدرسها المعلم
        return view('teacher.my-courses', [
            'courses' => $teacher->courses()->with('lessons')->get(),
        ]);
    }

    // صفحة إدارة حلقة فرعية معينة
    public function manageClassGroup($classGroupId)
    {
        $teacher = auth()->user()->teacher;
        
        // التحقق من أن المعلم هو مالك هذه الحلقة
        $classGroup = $teacher->classGroups()->findOrFail($classGroupId);
        
        // جلب البيانات المطلوبة
        $students = $classGroup->users()->get(); // الطلاب المسجلين
        $courses = $classGroup->courses()->get(); // الكورسات المرتبطة
        $totalStudents = $students->count();
        $totalCourses = $courses->count();
        
        return view('teacher.class-group.manage', [
            'classGroup' => $classGroup,
            'students' => $students,
            'courses' => $courses,
            'totalStudents' => $totalStudents,
            'totalCourses' => $totalCourses,
        ]);
    }
}