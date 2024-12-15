<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "product_detail_id" => "required|exists:product_details,id",
            "quantity" => "required|numeric|min:1"
        ];
    }

    public function messages(): array
    {
        return [
            "product_detail_id.required" => "Không được để trống!",
            "product_detail_id.exists" => "Sản phẩm không tồn tại!",
            "quantity.required" => "Không được để trống!",
            "quantity.numeric" => "Số lượng phải là số!",
            "quantity.min" => "Số lượng phải lớn hơn 0!",
        ];
    }
}