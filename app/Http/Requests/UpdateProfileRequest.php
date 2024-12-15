<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class UpdateProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $auth = auth()->user();
        return [
            "name" => "required|min:3|max:100|unique:users,name," . $auth->id,
            "email" => "required|email|min:6|max:100|unique:users,email," . $auth->id,
            "password" => [
                "required",
                function ($attr, $value, $fail) use ($auth) {
                    if (!Hash::check($value, $auth->password)) {
                        return $fail("Mật khẩu không chính xác!");
                    }
                }
            ],
            "phone" => "nullable",
            "address" => "nullable",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nickname không được để trống!",
            "name.min" => "Nickname tối thiểu 3 ký tự!",
            "name.max" => "Nickname tối đa 100 ký tự!",
            "name.unique" => "Nickname đã tồn tại!",
            'email.required' => 'Email không được bỏ trống!',
            'email.email' => 'Email không đúng định dạng!',
            "email.min" => "Email tối thiểu 6 ký tự!",
            "email.max" => "Email tối đa 100 ký tự!",
            "email.unique" => "Email đã tồn tại!",
            'password.required' => 'Mật khẩu không được bỏ trống!',
        ];
    }
}