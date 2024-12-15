<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $bannerId = $this->route('banner') ? $this->route('banner')->id : null;

        return [
            "name" => "required|min:3|max:99|unique:banners,name," . $bannerId,
            "prioty" => "required|numeric",
            "status" => "required",
            "position" => "required",
            "image" => ($this->isMethod('post') ? 'required|' : '') . "file|mimes:jpg,jpeg,png,gif|max:2048",
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được bỏ trống!',
            'name.min' => 'Tên tối thiểu là 3 ký tự!',
            'name.max' => 'Tên tối đa là 99 ký tự!',
            'name.unique' => 'Tên đã tồn tại!',
            'prioty.required' => 'Độ ưu tiên không được bỏ trống!',
            'prioty.numeric' => 'Độ ưu tiên phải là số!',
            'status.required' => 'Trạng thái không được bỏ trống!',
            'position.required' => 'Vị trí không được bỏ trống!',
            'image.required' => 'Hình ảnh không được bỏ trống!',
            'image.file' => 'Hình ảnh không đúng định dạng!',
            'image.mimes' => 'Hình ảnh phải có kiểu jpg, jpeg, png, gif!',
            'image.max' => 'Hình ảnh tối đa là 2 MB!',
        ];
    }
}