<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Teacher;
use App\Models\ClassType;
use App\Models\ClassGroup;
use Illuminate\Http\Request;
use App\Http\Requests\JoinClassRequest;
use App\Services\ClassService;

class HomeController extends Controller
{
    protected $classService;

    public function __construct(ClassService $classService)
    {
        $this->classService = $classService;
    }

    public function index()
    {
        $classTypes = ClassType::all();

        return view('welcome', [
            'class_types' => $classTypes,
            'courses' => Course::all(),
            'teachers' => Teacher::with('user')->get(),
        ]);
    }

    public function getGroupsCount($id)
    {
        $count = ClassType::find($id)->classGroups()->count();

        return response()->json(['count' => $count]);
    }

    public function joinClass(JoinClassRequest $request, $class_type_id)
    {
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        try {
            $this->classService->joinClass($user, $class_type_id);

            return back()->with('success', 'تم قبولك في الحلقة بنجاح!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}