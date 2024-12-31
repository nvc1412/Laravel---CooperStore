<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\ProductImage;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index()
    {
        $products = $this->productService->getProducts();
        $categories = $this->productService->getCategories();
        return view("admin.product.index", compact("products", "categories"));
    }

    public function create()
    {
        $categories = $this->productService->getCategories();
        return view("admin.product.create", compact("categories"));
    }

    public function store(ProductRequest $request)
    {
        if ($this->productService->createProduct($request)) {
            session()->flash("success", "Thêm sản phẩm thành công!");
            return redirect()->route("product.create");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function edit(Product $product)
    {
        $categories = $this->productService->getCategories();
        return view("admin.product.edit", compact("categories", "product"));
    }

    public function update(ProductRequest $request, Product $product)
    {
        if ($this->productService->updateProduct($request, $product)) {
            session()->flash("success", "Cập nhật sản phẩm thành công!");
            return redirect()->route("product.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function destroy(Product $product)
    {
        if ($this->productService->deleteProduct($product)) {
            session()->flash("success", "Xóa sản phẩm thành công!");
            return redirect()->route("product.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    // Xóa ảnh của bảng ProductImage (lưu trữ các ảnh chi tiết sản phẩm)
    public function destroyImage(ProductImage $image)
    {
        if ($this->productService->deleteImageProductDetail($image)) {
            session()->flash("success", "Xóa thành công!");
            return redirect()->route("product.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function createDetail(Request $request)
    {
        if ($this->productService->createProductDetail($request->productId)) {
            session()->flash("success", "Thêm chi tiết sản phẩm thành công!");
            return redirect()->back();
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function updateDetail(Request $request)
    {
        if ($this->productService->updateProductDetail($request)) {
            session()->flash("success", "Cập nhật chi tiết sản phẩm thành công!");
            return redirect()->back();
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function deleteDetail(ProductDetail $productDetail)
    {
        if ($this->productService->deleteProductDetail($productDetail)) {
            session()->flash("success", "Xóa chi tiết sản phẩm thành công!");
            return redirect()->back();
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }
}