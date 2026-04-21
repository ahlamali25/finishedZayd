<?php

namespace App\Models;
use App\Models\Course;
use App\Models\ClassType;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    protected $fillable = [
        'group_number',
        'capacity',
        'current_count',
        'teacher_id',
        'class_type_id',
    ];

 public function users()
{
    return $this->hasMany(User::class);
}

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
    
    public function courses()
    {
        return $this->belongsToMany(Course::class, 'class_group_courses', 'class_group_id', 'course_id');
    }

    public function classType()
{
    return $this->belongsTo(ClassType::class);
}
}