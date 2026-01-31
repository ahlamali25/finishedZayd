<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\ClassGroup;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'coursesCount' => Course::count(),
            'teachersCount' => Teacher::count(),
            'studentsCount' => User::where('role_id', 3)->count(),
            'classGroupsCount' => ClassGroup::count(),
            'courses' => Course::get(),
        ]);
    }
}

