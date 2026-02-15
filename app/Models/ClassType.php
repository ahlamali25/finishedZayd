<?php

namespace App\Models;
use App\Models\ClassGroup;
use Illuminate\Database\Eloquent\Model;

class ClassType extends Model
{
    protected $fillable = [
        'name',
        'description',
        'age_from',
        'age_to',
        'start_time',
        'end_time',
        'image',
    ];
    
    public function classGroups()
{
    return $this->hasMany(ClassGroup::class);
}

public function courses()
{
    return $this->belongsToMany(
        Course::class,
        'class_type_courses'
    );
}


}
