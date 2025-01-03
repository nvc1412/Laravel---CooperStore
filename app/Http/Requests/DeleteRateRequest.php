<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DeleteRateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "id" => "required|exists:ratings,id",
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Id không được bỏ trống!',
            'id.exists' => 'Id không tồn tại!',
        ];
    }
}