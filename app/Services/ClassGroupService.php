<?php

namespace App\Services;

use App\Models\ClassGroup;
use App\Models\ClassType;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\User;

class ClassGroupService
{
    /**
     * بيانات صفحة index
     */
    public function getDashboardData()
    {
        $classTypes = ClassType::with([
            'classGroups.users',
            'classGroups.teacher.user',
            'classGroups.courses'
        ])->get();

        $courses = Course::with('teacher.user', 'lessons', 'classGroups')->get();

        return [
            'classTypes' => $classTypes,
            'courses' => $courses,
            'totalLessons' => Lesson::count(),
            'totalStudents' => User::where('role_id', 3)->count(),
            'totalTeachers' => User::where('role_id', 2)->count(),
            'activeCourses' => Course::has('lessons')->count(),
            'popularCourseName' => $this->getPopularCourse(),
            'avgRating' => 4.5,
            'todaysLessons' => Lesson::whereDate('date', now()->toDateString())->count(),
        ];
    }

    /**
     * إنشاء وربط class group
     */
    public function assignCourses(array $data)
    {
        // استخدم حلقة موجودة من نفس النوع إذا لم تمتلئ بعد
        $classGroup = ClassGroup::where('class_type_id', $data['class_type_id'])
            ->whereColumn('current_count', '<', 'capacity')
            ->orderBy('group_number')
            ->first();

        if (! $classGroup) {
            $lastGroup = ClassGroup::where('class_type_id', $data['class_type_id'])
                ->orderByDesc('group_number')
                ->first();

            $nextGroupNumber = $lastGroup ? $lastGroup->group_number + 1 : 1;

            $classGroup = ClassGroup::create([
                'class_type_id' => $data['class_type_id'],
                'teacher_id' => $data['teacher_id'],
                'group_number' => $nextGroupNumber,
                'capacity' => 30,
                'current_count' => 0,
            ]);
        } elseif ($classGroup->teacher_id !== $data['teacher_id']) {
            $classGroup->teacher_id = $data['teacher_id'];
            $classGroup->save();
        }

        // ربط الكورسات
        $classGroup->courses()->sync($data['courses']);

        return $classGroup;
    }

    private function getPopularCourse()
    {
        $course = Course::withCount('users')
            ->orderBy('users_count', 'desc')
            ->first();

        return $course ? $course->name : '-';
    }
}