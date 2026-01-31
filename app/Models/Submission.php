<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Submission extends Model
{
    protected $fillable = [
        'assigment_id',
        'user_id',
        'file_path',
        'grade',
        'submitted_at',
    ];

    public function assigment()
    {
        return $this->belongsTo(Assigment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
