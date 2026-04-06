<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'course_id' => 'nullable|exists:courses,id',
            'title' => 'required|string|max:255|min:3',
            'content' => 'required|string|min:10',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان الإعلان مطلوب',
            'title.min' => 'عنوان الإعلان يجب أن يكون على الأقل 3 أحرف',
            'title.max' => 'عنوان الإعلان لا يجب أن يتجاوز 255 حرف',

            'content.required' => 'محتوى الإعلان مطلوب',
            'content.min' => 'محتوى الإعلان يجب أن يكون على الأقل 10 أحرف',

            'course_id.exists' => 'الكورس المختار غير موجود',
        ];
    }
}