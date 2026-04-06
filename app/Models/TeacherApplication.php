<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherApplication extends Model
{
   protected $fillable = [
    'user_id',
    'specialization',
    'experience',
    'motivation',
    'certificate_path',
    'cv',
    'status',
    'processed_by',
    'processed_at',
    'review_notes'
];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function processedBy()
    {
        return $this->belongsTo(User::class, 'processed_by');
    }

}