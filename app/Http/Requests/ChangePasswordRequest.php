<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $auth = auth()->user();
        return [
            "old_password" => [
                "required",
                function ($attr, $value, $fail) use ($auth) {
                    if (!Hash::check($value, $auth->password)) {
                        return $fail("Mật khẩu cũ không chính xác!");
                    }
                }
            ],
            "password" => "required|min:1",
            "cf_password" => "required|same:password"
        ];
    }

    public function messages(): array
    {
        return [
            'old_password.required' => 'Mật khẩu cũ không được bỏ trống!',
            'password.required' => 'Mật khẩu không được bỏ trống!',
            "password.min" => "Mật khẩu tối thiểu 1 ký tự!",
            'cf_password.required' => 'Mật khẩu xác nhận không được bỏ trống!',
            'cf_password.same' => 'Mật khẩu xác nhận không trùng khớp!',
        ];
    }
}