<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    protected $fillable = [
        'specialization',
        'status',
        'user_id',
    ];

    public function social()
    {
        return $this->hasOne(TeacherSocial::class);
    }

    public function classGroups()
    {
        return $this->hasMany(ClassGroup::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
