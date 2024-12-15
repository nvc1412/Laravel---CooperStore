<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShopRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'show' => 'nullable|in:9,30,90',
            'sort' => 'nullable|in:default,price-asc,price-desc',
            'fromPrice' => 'nullable|numeric',
            'toPrice' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) {
                    if ((int) $value <= (int) $this->fromPrice) {
                        $fail('toPrice phải lớn hơn fromPrice.');
                    }
                },
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'show.in' => 'Hiển thị phải có giá trị là 9, 30 hoặc 90!',
            'sort.in' => 'Sắp xếp phải có giá trị là default, price-asc hoặc price-desc!',
            'fromPrice.numeric' => 'Giá bắt đầu phải là số!',
            'toPrice.numeric' => 'Giá kết thúc phải là số!',
        ];
    }
}