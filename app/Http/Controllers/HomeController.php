<?php

namespace App\Http\Controllers;
use App\Models\Course;
use App\Models\Teacher;
use App\Models\ClassType;
use App\Models\ClassGroup;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\ClassAcceptanceMail;

class HomeController extends Controller
{
   

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
    
    

public function joinClass($class_type_id)
{
    $user = auth()->user();
    if (! $user) {
        return redirect()->route('login');
    }

    $classType = ClassType::findOrFail($class_type_id);

    // تحقق العمر
    if ($user->age < $classType->age_from ||
        ($classType->age_to && $user->age > $classType->age_to)) {
        return back()->with('error', 'عمرك لا يتناسب مع متطلبات الحلقة.');
    }

    // منع التكرار
    $alreadyJoined = ClassGroup::where('class_type_id', $class_type_id)
        ->whereHas('users', fn ($q) => $q->where('users.id', $user->id))
        ->exists();

    if ($alreadyJoined) {
        return back()->with('error', 'أنت مسجل مسبقًا في هذه الحلقة');
    }

    // إيجاد أو إنشاء حلقة فرعية
    $group = ClassGroup::where('class_type_id', $class_type_id)
        ->where('current_count', '<', DB::raw('capacity'))
        ->orderBy('group_number')
        ->first();

    if (! $group) {
        $lastGroup = ClassGroup::where('class_type_id', $class_type_id)
            ->orderBy('group_number', 'desc')
            ->first();

        $group = ClassGroup::create([
            'group_number' => $lastGroup ? $lastGroup->group_number + 1 : 1,
            'capacity' => 30,
            'current_count' => 0,
            'teacher_id' => 1,
            'class_type_id' => $class_type_id,
        ]);
    }

    // ربط الطالب
    $group->users()->attach($user->id);
    $group->increment('current_count');

    // إرسال الإيميل
    Mail::to($user->email)->send(
        new ClassAcceptanceMail($user->name, $classType->name)
    );

    return back()->with('success', 'تم قبولك في الحلقة بنجاح!');
}






}
