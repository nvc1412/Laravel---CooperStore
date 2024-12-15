<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "payment" => "required|in:cod,vnpay,momo,paypel",
            "name" => "required",
            "phone" => "required",
            "province" => "required",
            "district" => "required",
            "address_cf" => "required",
            "address" => "required"
        ];
    }

    public function messages(): array
    {
        return [
            'payment.required' => 'Phương thức thanh toán không được bỏ trống!',
            'payment.in' => 'Phương thức thanh toán không hợp lệ!',
            'name.required' => 'Tên người nhận hàng không được bỏ trống!',
            'phone.required' => 'Số điện thoại không được bỏ trống!',
            'province.required' => 'Tỉnh/thành phố không được bỏ trống!',
            'district.required' => 'Quận/huyện không được bỏ trống!',
            'address.required' => 'Địa chỉ không được bỏ trống!',
            'address_cf.required' => 'Địa chỉ xác nhận không được bỏ trống!',
        ];
    }
}