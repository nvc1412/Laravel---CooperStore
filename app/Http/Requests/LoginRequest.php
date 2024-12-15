<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "email" => "required|email|exists:users",
            "password" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email không được bỏ trống!',
            'email.email' => 'Email không đúng định dạng!',
            'email.exists' => 'Email không tồn tại!',
            'password.required' => 'Password không được bỏ trống!',
        ];
    }
}