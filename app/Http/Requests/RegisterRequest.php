<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "name" => "required|min:3|max:100|unique:users",
            "email" => "required|email|min:6|max:100|unique:users",
            "password" => "required|min:1",
            "cf_password" => "required|same:password",
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "Nickname không được để trống!",
            "name.min" => "Nickname tối thiểu 6 ký tự!",
            "name.max" => "Nickname tối đa 100 ký tự!",
            "name.unique" => "Nickname đã tồn tại!",
            'email.required' => 'Email không được bỏ trống!',
            'email.email' => 'Email không đúng định dạng!',
            "email.min" => "Email tối thiểu 6 ký tự!",
            "email.max" => "Email tối đa 100 ký tự!",
            "email.unique" => "Email đã tồn tại!",
            'password.required' => 'Mật khẩu không được bỏ trống!',
            "password.min" => "Mật khẩu tối thiểu 1 ký tự!",
            'cf_password.required' => 'Mật khẩu xác nhận không được bỏ trống!',
            'cf_password.same' => 'Mật khẩu xác nhận không trùng khớp!',
        ];
    }
}