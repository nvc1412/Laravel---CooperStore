<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $pros = Product::orderBy("id", "desc")->paginate(10);
        $cats = Category::orderBy("name", "asc")->select("id", "name")->get();
        return view("admin.product.index", compact("pros", "cats"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function create()
    {
        $cats = Category::orderBy("name", "asc")->select("id", "name")->get();
        return view("admin.product.create", compact("cats"));
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:99|unique:products",
            "price" => "required|numeric",
            "discount" => "numeric|lte:price",
            "image" => "required|file|mimes:jpg,jpeg,png,gif", //Phải viết liền các dạng mimes không được cách
            "category_id" => "required|exists:categories,id",
        ]);

        $data = $request->only("name", "price", "discount", "short_description", "description", "category_id");

        // thêm ảnh vào thư mục trước khi thêm sản phẩm
        $img_name = $request->image->hashName();
        $request->image->move(public_path("img/products"), $img_name);
        $data["image"] = $img_name;

        // THÊM SẢN PHẨM
        if ($product = Product::create($data)) {

            // Nếu có chọn nhiều ảnh chi tiết sản phẩm
            if ($request->has("other_image")) {
                // thêm từng ảnh vào thư mục và CSDL
                foreach ($request->other_image as $image) {
                    $other_name = $image->hashName();
                    $image->move(public_path("img/products"), $other_name);
                    ProductImage::create([
                        "product_id" => $product->id,
                        "image" => $other_name
                    ]);
                }
            }

            // Nếu có chọn chi tiết sản phẩm
            if ($request->has("size") && $request->has("quantity")) {

                //Thêm từng chi tiết sản phẩm vào CSDL(size và số lượng)
                foreach ($request->size as $i => $size) {
                    ProductDetail::create([
                        "product_id" => $product->id,
                        "size" => $size,
                        "quantity" => $request->quantity[$i]
                    ]);
                }
            }
            return redirect()->route("product.create")->with("success", "Thêm sản phẩm thành công!");
        }
        return redirect()->back()->with("error", "Có lỗi xảy ra! Thêm sản phẩm thất bại!");
    }

    public function edit(Product $product)
    {
        $cats = Category::orderBy("name", "asc")->select("id", "name")->get();
        return view("admin.product.edit", compact("cats", "product"));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            "name" => "required|min:3|max:99|unique:products,name," . $product->id,
            "price" => "required|numeric",
            "discount" => "numeric|lte:price",
            "image" => "file|mimes:jpg,jpeg,png,gif", //Phải viết liền các dạng mimes không được cách
            "category_id" => "required|exists:categories,id",
        ]);

        $data = $request->only("name", "price", "discount", "short_description", "description", "category_id");

        // Nếu chọn thay đổi ảnh chính
        if ($request->has("image")) {
            $img_name = $product->image;
            $img_path = public_path("img/products") . "/" . $img_name;

            // Xóa ảnh chính cũ trong thư mục
            if (file_exists($img_path)) {
                unlink($img_path);
            }

            // thêm ảnh chính mới vào thư mục
            $img_name = $request->image->hashName();
            $request->image->move(public_path("img/products"), $img_name);
            $data["image"] = $img_name;
        }

        // CẬP NHẬT SẢN PHẨM
        if ($product->update($data)) {

            // Nếu có chọn thay đổi ảnh chi tiết sản phẩm
            if ($request->has("other_image")) {

                // Nếu trong CSDL có ảnh chi tiết của sản phẩm
                if ($product->images()->count() > 0) {

                    // Xóa từng ảnh trong thư mục và trong CSDL
                    foreach ($product->images as $img) {
                        $other_img_name = $img->image;
                        $other_img_path = public_path("img/products") . "/" . $other_img_name;
                        if (file_exists($other_img_path)) {
                            unlink($other_img_path);
                        }
                    }
                    ProductImage::where("product_id", $product->id)->delete();
                }

                // Thêm từng ảnh mới được chọn vào thư mục và CSDL
                foreach ($request->other_image as $image) {
                    $other_name = $image->hashName();
                    $image->move(public_path("img/products"), $other_name);
                    ProductImage::create([
                        "product_id" => $product->id,
                        "image" => $other_name
                    ]);
                }
            }
            return redirect()->route("product.index")->with("success", "Cập nhật sản phẩm thành công!");
        }
        return redirect()->back()->with("error", "Có lỗi xảy ra! Thêm sản phẩm thất bại!");
    }

    public function destroy(Product $product)
    {
        $img_name = $product->image;
        $img_path = public_path("img/products") . "/" . $img_name;

        // Nếu trong CSDL có ảnh chi tiết của sản phẩm
        if ($product->images()->count() > 0) {

            // Xóa từng ảnh trong thư mục và trong CSDL
            foreach ($product->images as $img) {
                $other_img_name = $img->image;
                $other_img_path = public_path("img/products") . "/" . $other_img_name;
                if (file_exists($other_img_path)) {
                    unlink($other_img_path);
                }
            }
            ProductImage::where("product_id", $product->id)->delete();
        }

        // Nếu trong CSDL có size chi tiết của sản phẩm
        if ($product->sizes()->count() > 0) {

            // Xóa hết size của sản phẩm trong CSDL
            ProductDetail::where("product_id", $product->id)->delete();
        }

        // XÓA SẢN PHẨM
        if ($product->delete()) {

            // Xóa ảnh chính trong thư mục
            if (file_exists($img_path)) {
                unlink($img_path);
            }
            return redirect()->route("product.index")->with("success", "Xóa thành công!");
        }
        return redirect()->back()->with(["error", "Đã có lỗi xảy ra!"]);
    }

    // Xóa ảnh của bảng ProductImage (lưu trữ các ảnh chi tiết sản phẩm)
    public function destroyImage(ProductImage $image)
    {
        $img_name = $image->image;
        if ($image->delete()) {
            $img_path = public_path("img/products") . "/" . $img_name;
            if (file_exists($img_path)) {
                unlink($img_path);
            }
            return redirect()->back()->with("success", "Xóa ảnh thành công!");
        }
        return redirect()->back()->with(["error", "Đã có lỗi xảy ra!"]);
    }

    public function createDetail(Request $request)
    {
        $check = ProductDetail::create([
            "product_id" => $request->product_id,
            "size" => "",
            "quantity" => 0
        ]);
        if ($check) {
            return redirect()->back()->with("success", "Thêm chi tiết sản phẩm thành công!");
        }
        return redirect()->back()->with(["error", "Đã có lỗi xảy ra!"]);
    }

    public function updateDetail(Request $request)
    {
        if ($request->has("id_product_detail") && $request->has("size") && $request->has("quantity")) {

            // Lặp qua các phần tử của mảng id_product_detail, size và quantity
            foreach ($request->id_product_detail as $key => $id) {
                // Tìm chi tiết sản phẩm bằng id sử dụng model ProductDetail
                $productDetail = ProductDetail::find($id);

                // Kiểm tra xem có sản phẩm được tìm thấy không
                if ($productDetail) {
                    // Cập nhật dữ liệu trong bảng product_details
                    $productDetail->update([
                        'size' => $request->size[$key],
                        'quantity' => $request->quantity[$key]
                    ]);
                }
            }
            return redirect()->back()->with("success", "Cập nhật chi tiết sản phẩm thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function deleteDetail(ProductDetail $product_detail)
    {
        if ($product_detail->delete()) {
            return redirect()->back()->with("success", "Xóa chi tiết sản phẩm thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }
}