<?php

namespace App\Services;

use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use Illuminate\Http\Request;

class ProductService
{
    public function getProducts()
    {
        return Product::orderBy("id", "desc")->paginate(10);
    }

    public function getCategories()
    {
        return Category::orderBy("name", "asc")->select("id", "name")->get();
    }

    public function createProduct(ProductRequest $request)
    {
        $data = $request->validated();
        $data["image"] = addImage($data["image"], "products");

        // THÊM SẢN PHẨM
        if ($product = Product::create($data)) {

            // Nếu có chọn nhiều ảnh chi tiết sản phẩm
            if ($request->has("other_image")) {
                // thêm từng ảnh vào thư mục và CSDL
                foreach ($request->other_image as $image) {
                    $other_name = addImage($image, "products");
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

            return true;
        }
        return false;
    }

    public function updateProduct(ProductRequest $request, Product $product)
    {
        $data = $request->validated();

        // Nếu chọn thay đổi ảnh chính
        if ($request->has("image")) {
            // thêm ảnh mới vào thư mục
            $data["image"] = addImage($data["image"], "products");
            if (!$data["image"]) {
                return false;
            }
            // Xóa ảnh cũ trong thư mục
            deleteImage($product->image, "products");
        }

        // CẬP NHẬT SẢN PHẨM
        if ($product->update($data)) {

            // Nếu có chọn thay đổi ảnh chi tiết sản phẩm
            if ($request->has("other_image")) {

                // Nếu trong CSDL có ảnh chi tiết của sản phẩm
                if ($product->images()->count() > 0) {

                    // Xóa từng ảnh trong thư mục và trong CSDL
                    foreach ($product->images as $img) {
                        deleteImage($img->image, "products");
                    }
                    ProductImage::where("product_id", $product->id)->delete();
                }

                // Thêm từng ảnh mới được chọn vào thư mục và CSDL
                foreach ($request->other_image as $image) {
                    $other_name = addImage($image, "products");
                    ProductImage::create([
                        "product_id" => $product->id,
                        "image" => $other_name
                    ]);
                }
            }
            return true;
        }
        return false;
    }

    public function deleteProduct(Product $product)
    {
        // Nếu trong CSDL có ảnh chi tiết của sản phẩm
        if ($product->images()->count() > 0) {
            ProductImage::where("product_id", $product->id)->delete();
        }

        // Nếu trong CSDL có size chi tiết của sản phẩm
        if ($product->sizes()->count() > 0) {
            // Xóa hết size của sản phẩm trong CSDL
            ProductDetail::where("product_id", $product->id)->delete();
        }

        return $product->delete();
    }

    public function deleteImageProductDetail(ProductImage $image)
    {
        return $image->delete();
    }

    public function createProductDetail($productId)
    {
        return ProductDetail::create([
            "product_id" => $productId,
            "size" => "",
            "quantity" => 0
        ]);
    }

    public function updateProductDetail(Request $request)
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
            return true;
        }
        return false;
    }

    public function deleteProductDetail(ProductDetail $productDetail)
    {
        return $productDetail->delete();
    }
}