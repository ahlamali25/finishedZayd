<?php

namespace App\Http\Controllers\Admin;
use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index(Request $request)
{
    $courseName = $request->course;

    // ===== الطلاب =====
    $students = User::where('role_id', 3)
        ->with(['courses', 'classGroup.classType'])
        ->when($courseName, function ($q) use ($courseName) {
            $q->where(function ($qq) use ($courseName) {
                $qq->whereHas('courses', function ($c) use ($courseName) {
                    $c->where('name', 'like', "%$courseName%");
                })
                ->orDoesntHave('courses'); // ⭐ يعرض غير المسجلين
            });
        })
        ->get();

    // ===== المعلمين =====
    $teachers = User::where('role_id', 2)
        ->with(['teacher.courses'])
        ->when($courseName, function ($q) use ($courseName) {
            $q->where(function ($qq) use ($courseName) {
                $qq->whereHas('teacher.courses', function ($c) use ($courseName) {
                    $c->where('name', 'like', "%$courseName%");
                })
                ->orDoesntHave('teacher.courses'); // ⭐ يعرض المعلم بدون كورسات
            });
        })
        ->get();

    return view('admin.users.index', compact('students', 'teachers'));
}

}
