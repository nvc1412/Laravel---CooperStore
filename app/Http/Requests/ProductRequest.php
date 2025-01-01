<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $productId = $this->route('product') ? $this->route('product')->id : null;

        return [
            "name" => "required|min:3|max:99|unique:products,name," . $productId,
            "price" => "required|numeric",
            "description" => "nullable",
            "short_description" => "nullable",
            "discount" => "numeric|lte:price",
            "image" => ($this->isMethod('post') ? 'required|' : '') . "file|mimes:jpg,jpeg,png,gif|max:2048",
            "category_id" => "required|exists:categories,id",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được bỏ trống!',
            'name.min' => 'Tên tối thiểu là 3 ký tự!',
            'name.max' => 'Tên tối đa là 99 ký tự!',
            'name.unique' => 'Tên đã tồn tại!',
            'price.required' => 'Giá bán không được bỏ trống!',
            'price.numeric' => 'Giá bán phải là số!',
            'discount.numeric' => 'Giá giảm phải là số!',
            'discount.lte' => 'Giá giảm phải nhỏ hơn giá bán!',
            'image.required' => 'Hình ảnh không được bỏ trống!',
            'image.file' => 'Hình ảnh không đúng định dạng!',
            'image.mimes' => 'Hình ảnh phải có kiểu jpg, jpeg, png, gif!',
            'image.max' => 'Hình ảnh tối đa là 2 MB!',
            'category_id.required' => 'Danh mục không được bỏ trống!',
            'category_id.exists' => 'Danh mục không tồn tại!',
        ];
    }
}