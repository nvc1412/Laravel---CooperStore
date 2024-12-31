<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "prioty" => "required|numeric",
            "link" => "required",
            "status" => "required",
            "position" => "required",
            "image" => ($this->isMethod('post') ? 'required|' : '') . "file|mimes:jpg,jpeg,png,gif|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            'prioty.required' => 'Độ ưu tiên không được bỏ trống!',
            'prioty.numeric' => 'Độ ưu tiên phải là số!',
            'link.required' => 'Link không được bỏ trống!',
            'status.required' => 'Trạng thái không được bỏ trống!',
            'position.required' => 'Vị trí không được bỏ trống!',
            'image.required' => 'Hình ảnh không được bỏ trống!',
            'image.file' => 'Hình ảnh không đúng định dạng!',
            'image.mimes' => 'Hình ảnh phải có kiểu jpg, jpeg, png, gif!',
            'image.max' => 'Hình ảnh tối đa là 2 MB!',
        ];
    }
}