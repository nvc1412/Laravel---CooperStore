<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "id" => "required|exists:users,id",
            "is_admin" => "required|in:0,1",
            "status" => "required|in:0,1"
        ];
    }

    public function messages(): array
    {
        return [
            'id.required' => 'Id không được bỏ trống!',
            'id.exists' => 'Id không tồn tại!',
            'is_admin.required' => 'Is_admin không được bỏ trống!',
            'is_admin.in' => 'Is_admin phải là 0 hoặc 1!',
            'status.required' => 'Status không được bỏ trống!',
            'status.in' => 'Status phải là 0 hoặc 1!',
        ];
    }
}