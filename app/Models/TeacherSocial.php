<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherSocial extends Model
{
    protected $fillable = [
        'teacher_id',
        'facebook_link',
        'instagram_link',
    ];

    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }
}
