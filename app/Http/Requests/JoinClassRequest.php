<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class JoinClassRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // أو ضع صلاحيات لاحقاً
    }

    public function rules(): array
    {
        return [
            'class_type_id' => 'required|exists:class_types,id',
        ];
    }
}