<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::orderBy("position", "ASC")->paginate(10);
        return view("admin.logo.index", compact("logos"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function store(Request $request)
    {
        $request->validate([
            "prioty" => "required|numeric",
            "status" => "required",
            "position" => "required",
            "image" => "required|image|mimes:jpg,jpeg,png,gif"  //Phải viết liền các dạng mimes không được cách
        ]);

        $data = $request->only("prioty", "status", "link", "position");

        // thêm ảnh vào thư mục trước khi thêm logo
        $img_name = $request->image->hashName();
        $request->image->move(public_path("img/logos"), $img_name);
        $data["image"] = $img_name;

        // THÊM logo
        if (Logo::create($data)) {
            return redirect()->route("logo.index")->with("success", "Thêm logo thành công!");
        }
        return redirect()->back()->with("error", "Có lỗi xảy ra! Thêm logo thất bại!");
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            "prioty" => "required|numeric",
            "status" => "required",
            "position" => "required",
            "image" => "file|mimes:jpg,jpeg,png,gif" //Phải viết liền các dạng mimes không được cách
        ]);

        $data = $request->only("name", "prioty", "status", "description", "link", "position");

        // Nếu chọn thay đổi ảnh
        if ($request->has("image")) {
            $img_name = $logo->image;
            $img_path = public_path("img/logos") . "/" . $img_name;

            // Xóa ảnh cũ trong thư mục
            if (file_exists($img_path)) {
                unlink($img_path);
            }

            // thêm ảnh mới vào thư mục
            $img_name = $request->image->hashName();
            $request->image->move(public_path("img/logos"), $img_name);
            $data["image"] = $img_name;
        }

        // CẬP NHẬT LOGO
        if ($logo->update($data)) {
            return redirect()->route("logo.index")->with("success", "Cập nhật logo thành công!");
        }
        return redirect()->back()->with("error", "Có lỗi xảy ra! Cập nhật logo thất bại!");
    }

    public function destroy(Logo $logo)
    {
        $img_name = $logo->image;
        $img_path = public_path("img/logos") . "/" . $img_name;

        // XÓA LOGO
        if ($logo->delete()) {

            // Xóa ảnh chính trong thư mục
            if (file_exists($img_path)) {
                unlink($img_path);
            }
            return redirect()->route("logo.index")->with("success", "Xóa thành công!");
        }
        return redirect()->back()->with(["error", "Đã có lỗi xảy ra!"]);
    }
}