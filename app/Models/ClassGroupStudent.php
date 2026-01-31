<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassGroupStudent extends Model
{
    protected $fillable = [
        'class_group_id',
        'user_id',
    ];
}
