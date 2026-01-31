<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
        ]);

        Enrollment::firstOrCreate([
            'user_id' => auth()->id(),

            'course_id' => $request->course_id,
        ]);

        return redirect()->back()->with('success', 'تم التسجيل في الدورة بنجاح!');
    
    }
}