<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AssignClassGroupRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'class_type_id' => 'required|exists:class_types,id',
            'teacher_id' => 'required|exists:teachers,id',
            'courses' => 'required|array',
            'courses.*' => 'exists:courses,id',
        ];
    }

    public function messages()
    {
        return [
            'class_type_id.required' => 'يجب اختيار نوع الحلقة',
            'class_type_id.exists' => 'نوع الحلقة غير موجود',

            'teacher_id.required' => 'يجب اختيار المعلم',
            'teacher_id.exists' => 'المعلم غير موجود',

            'courses.required' => 'يجب اختيار كورس واحد على الأقل',
            'courses.array' => 'صيغة الكورسات غير صحيحة',
            'courses.*.exists' => 'أحد الكورسات غير موجود',
        ];
    }
}