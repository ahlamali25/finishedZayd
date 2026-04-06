<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourseRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'total_sessions' => 'required|integer|min:1',
            'teacher_id' => 'required|exists:teachers,id',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'اسم الكورس مطلوب',
            'description.required' => 'الوصف مطلوب',
            'total_sessions.required' => 'عدد الحصص مطلوب',
            'teacher_id.required' => 'يجب اختيار المعلم',
        ];
    }
}