<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAnnouncementRequest extends FormRequest
{
    public function authorize()
    {
        return true; // لاحقًا ممكن نربطها بـ policy
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'course_id' => 'nullable|exists:courses,id'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان الإعلان مطلوب',
            'title.max' => 'عنوان الإعلان لا يجب أن يتجاوز 255 حرف',

            'content.required' => 'محتوى الإعلان مطلوب',

            'course_id.exists' => 'الكورس غير موجود',
        ];
    }
}