<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLessonRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'video_link' => 'nullable|url',
            'date' => 'required|date',
            'time' => 'nullable|date_format:H:i'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'عنوان الدرس مطلوب',
            'title.string' => 'عنوان الدرس يجب أن يكون نص',
            'title.max' => 'عنوان الدرس لا يجب أن يتجاوز 255 حرف',

            'video_link.url' => 'رابط الفيديو غير صالح',

            'date.required' => 'تاريخ الدرس مطلوب',
            'date.date' => 'صيغة التاريخ غير صحيحة',

            'time.date_format' => 'الوقت يجب أن يكون بصيغة HH:MM',
        ];
    }
}