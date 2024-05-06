<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $bans = Banner::orderBy("position", "ASC")->paginate(10);
        return view("admin.banner.index", compact("bans"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:99|unique:banners",
            "prioty" => "required|numeric",
            "status" => "required",
            "position" => "required",
            "image" => "required|file|mimes:jpg,jpeg,png,gif" //Phải viết liền các dạng mimes không được cách
        ]);

        $data = $request->only("name", "prioty", "status", "description", "link", "position");

        // thêm ảnh vào thư mục trước khi thêm banner
        $img_name = $request->image->hashName();
        $request->image->move(public_path("img/banner"), $img_name);
        $data["image"] = $img_name;

        // THÊM banner
        if (Banner::create($data)) {
            return redirect()->route("banner.index")->with("success", "Thêm banner thành công!");
        }
        return redirect()->back()->with("error", "Có lỗi xảy ra! Thêm banner thất bại!");
    }

    public function edit(Banner $banner)
    {
        return view("admin.banner.edit", compact("banner"));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            "name" => "required|min:3|max:99|unique:banners,name," . $banner->id,
            "prioty" => "required|numeric",
            "status" => "required",
            "position" => "required",
            "image" => "file|mimes:jpg,jpeg,png,gif" //Phải viết liền các dạng mimes không được cách
        ]);

        $data = $request->only("name", "prioty", "status", "description", "link", "position");

        // Nếu chọn thay đổi ảnh
        if ($request->has("image")) {
            $img_name = $banner->image;
            $img_path = public_path("img/banner") . "/" . $img_name;

            // Xóa ảnh cũ trong thư mục
            if (file_exists($img_path)) {
                unlink($img_path);
            }

            // thêm ảnh mới vào thư mục
            $img_name = $request->image->hashName();
            $request->image->move(public_path("img/banner"), $img_name);
            $data["image"] = $img_name;
        }

        // CẬP NHẬT BANNER
        if ($banner->update($data)) {
            return redirect()->route("banner.index")->with("success", "Cập nhật banner thành công!");
        }
        return redirect()->back()->with("error", "Có lỗi xảy ra! Cập nhật banner thất bại!");
    }
    public function destroy(Banner $banner)
    {
        $img_name = $banner->image;
        $img_path = public_path("img/banner") . "/" . $img_name;

        // XÓA BANNER
        if ($banner->delete()) {

            // Xóa ảnh chính trong thư mục
            if (file_exists($img_path)) {
                unlink($img_path);
            }
            return redirect()->route("banner.index")->with("success", "Xóa thành công!");
        }
        return redirect()->back()->with(["error", "Đã có lỗi xảy ra!"]);
    }
}