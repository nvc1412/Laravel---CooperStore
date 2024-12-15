<?php

namespace App\Services;

use App\Models\Banner;

class BannerService
{
    public function getBanners()
    {
        return Banner::orderBy("position", "ASC")->paginate(10);
    }

    public function createBanner($data)
    {
        // thêm ảnh vào thư mục trước khi thêm banner
        $data["image"] = addImage($data["image"], "banner");

        // THÊM banner
        return Banner::create($data);
    }

    public function updateBanner($data, Banner $banner)
    {
        // Nếu chọn thay đổi ảnh
        if (isset($data["image"])) {
            // thêm ảnh mới vào thư mục
            $data["image"] = addImage($data["image"], "banner");
            if (!$data["image"]) {
                return false;
            }
            // Xóa ảnh cũ trong thư mục
            deleteImage($banner->image, "banner");
        }

        // CẬP NHẬT BANNER
        return $banner->update($data);
    }

    public function deleteBanner(Banner $banner)
    {
        return $banner->delete();
    }
}