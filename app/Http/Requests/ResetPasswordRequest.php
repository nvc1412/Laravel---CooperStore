<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "password" => "required|min:1",
            "cf_password" => "required|same:password",
        ];
    }

    public function messages(): array
    {
        return [
            'password.required' => 'Mật khẩu không được bỏ trống!',
            "password.min" => "Mật khẩu tối thiểu 1 ký tự!",
            'cf_password.required' => 'Mật khẩu xác nhận không được bỏ trống!',
            'cf_password.same' => 'Mật khẩu xác nhận không trùng khớp!',
        ];
    }
}