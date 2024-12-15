<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category') ? $this->route('category')->id : null;

        return [
            "name" => "required|min:3|max:99|unique:categories,name," . $categoryId,
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được bỏ trống!',
            'name.min' => 'Tên tối thiểu là 3 ký tự!',
            'name.max' => 'Tên tối đa là 99 ký tự!',
            'name.unique' => 'Tên đã tồn tại!',
        ];
    }
}