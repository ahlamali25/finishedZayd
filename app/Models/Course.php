<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'name',
        'description',
        'total_sessions',
        'teacher_id',
    ];

    public function assigments()
    {
        return $this->hasMany(Assigment::class);
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    public function classGroups()
    {
        return $this->belongsToMany(Class_group::class, 'class_group_courses', 'course_id', 'class_group_id');
    }

    public function classTypes()
{
    return $this->belongsToMany(
        ClassType::class,
        'class_type_courses'
    );
}


    
}
