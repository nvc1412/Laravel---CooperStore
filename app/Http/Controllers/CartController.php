<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Models\Bill;
use App\Models\Product;
use App\Services\CartService;

class CartController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index()
    {
        return view("home.cart");
    }

    public function add(Product $product, CartRequest $request)
    {
        try {
            $this->cartService->addToCart($product, $request->product_detail_id, $request->quantity);
            session()->flash("success", "Thêm sản phẩm vào giỏ hàng thành công!");
            return redirect()->route("cart.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(Product $product, CartRequest $request)
    {
        try {
            $this->cartService->updateQuantity($product, $request->product_detail_id, $request->quantity);
            session()->flash("success", "Cập nhật số lượng thành công!");
            return redirect()->route("cart.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function updatePlus($productId, $productDetailId)
    {
        try {
            $this->cartService->updatePlus($productId, $productDetailId);
            session()->flash("success", "Cập nhật số lượng thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function updateMinus($productId, $productDetailId)
    {
        try {
            $this->cartService->updateMinus($productId, $productDetailId);
            session()->flash("success", "Cập nhật số lượng thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function delete($productId, $productDetailId)
    {
        try {
            $this->cartService->delete($productId, $productDetailId);
            session()->flash("success", "Xóa sản phẩm khỏi giỏ hàng thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function clear()
    {
        try {
            $this->cartService->clear();
            session()->flash("success", "Xóa tất cả sản phẩm khỏi giỏ hàng thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function buyAgain(Bill $bill)
    {
        try {
            $this->cartService->buyAgain($bill);
            session()->flash("success", "Đã thêm lại sản phẩm vào giỏ hàng!");
            return redirect()->route("cart.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->route("account.showHistory");
        }
    }
}