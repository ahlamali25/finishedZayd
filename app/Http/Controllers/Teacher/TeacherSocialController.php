<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Models\TeacherSocial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherSocialController extends Controller
{
    // عرض صفحة الإضافة
    public function create(Teacher $teacher)
    {
        if (Auth::user()->teacher->id !== $teacher->id) {
            abort(403);
        }

        return view('teacher_social.create', compact('teacher'));
    }

    // تخزين الروابط أو تحديثها (updateOrCreate)
    public function store(Request $request, $teacher_id)
    {
        $request->validate([
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ]);

        TeacherSocial::updateOrCreate(
            ['teacher_id' => $teacher_id],
            [
                'facebook_link' => $request->facebook_link,
                'instagram_link' => $request->instagram_link,
            ]
        );

        return redirect()->route('home')->with('success', 'تم حفظ الروابط بنجاح');
    }

    public function edit(Teacher $teacher)
    {
        if (Auth::user()->teacher->id !== $teacher->id) {
            abort(403);
        }

        return view('teacher_social.edit', compact('teacher'));
    }

    public function update(Request $request, $teacher_id)
    {
        $request->validate([
            'facebook_link' => 'nullable|url',
            'instagram_link' => 'nullable|url',
        ]);

        TeacherSocial::updateOrCreate(
            ['teacher_id' => $teacher_id],
            [
                'facebook_link' => $request->facebook_link,
                'instagram_link' => $request->instagram_link,
            ]
        );

        return redirect()->route('home')->with('success', 'تم تحديث الروابط بنجاح');
    }

    public function destroy(Teacher $teacher)
    {
        if (Auth::user()->teacher->id !== $teacher->id) {
            abort(403);
        }

        if ($teacher->social) {
            $teacher->social->delete();
        }

        return redirect()->back()->with('success', 'تم حذف الروابط بنجاح');
    }
}