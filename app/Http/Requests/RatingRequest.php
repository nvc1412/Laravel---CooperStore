<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RatingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            "rating" => "required|in:1,2,3,4,5",
            "comment" => "nullable"
        ];
    }

    public function messages(): array
    {
        return [
            'rating.required' => 'Đánh giá sao không được bỏ trống!',
            'rating.in' => 'Đánh giá sao phải là 1, 2, 3, 4 hoặc 5!',
        ];
    }
}