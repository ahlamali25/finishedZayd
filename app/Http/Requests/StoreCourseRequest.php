<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourseRequest extends FormRequest
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
            'name.max' => 'اسم الكورس طويل جدًا',

            'description.required' => 'وصف الكورس مطلوب',

            'total_sessions.required' => 'عدد الحصص مطلوب',
            'total_sessions.integer' => 'عدد الحصص يجب أن يكون رقم',
            'total_sessions.min' => 'عدد الحصص يجب أن يكون على الأقل 1',

            'teacher_id.required' => 'يجب اختيار المعلم',
            'teacher_id.exists' => 'المعلم غير موجود',
        ];
    }
}