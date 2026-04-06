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
    $search = $request->search;

    $students = User::where('role_id', 3)
        ->with(['courses', 'classGroup.classType'])
        ->when($search, function ($q) use ($search) {
            $q->where(function ($query) use ($search) {

                // البحث بالكورس
                $query->whereHas('courses', function ($c) use ($search) {
                    $c->where('name', 'like', "%$search%");
                })

                // أو البحث بالحلقة
                ->orWhereHas('classGroup', function ($g) use ($search) {
                    $g->where('group_number', 'like', "%$search%")
                      ->orWhereHas('classType', function ($t) use ($search) {
                          $t->where('name', 'like', "%$search%");
                      });
                });
            });
        })
        ->get();

    $teachers = User::where('role_id', 2)
        ->with(['teacher.courses'])
        ->when($search, function ($q) use ($search) {
            $q->whereHas('teacher.courses', function ($c) use ($search) {
                $c->where('name', 'like', "%$search%");
            });
        })
        ->get();

    return view('admin.users.index', compact('students', 'teachers'));
}

}
