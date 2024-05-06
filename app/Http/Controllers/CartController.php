<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view("home.cart");
    }

    public function add(Product $product, Request $request)
    {
        $request->validate([
            "product_detail_id" => "required|exists:product_details,id",
            "quantity" => "required|numeric|min:1"
        ]);

        $cartExist = Cart::where(["user_id" => auth()->id(), "product_id" => $product->id, "product_detail_id" => $request->product_detail_id]);

        if ($cartExist->first()) {
            $cartExist->increment("quantity", $request->quantity);
            return redirect()->route("cart.index")->with("success", "Cập nhật giỏ hàng thành công!");
        } else {
            $data = [
                "user_id" => auth()->id(),
                "product_id" => $product->id,
                "product_detail_id" => $request->product_detail_id,
                "price" => ($product->discount > 0) ? $product->discount : $product->price,
                "quantity" => $request->quantity,
            ];

            if (Cart::create($data)) {
                return redirect()->route("cart.index")->with("success", "Thêm sản phẩm vào giỏ hàng thành công!");
            }
            return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
        }
    }

    public function update(Product $product, Request $request)
    {
        $request->validate([
            "product_detail_id" => "required|exists:product_details,id",
            "quantity" => "required|numeric|min:1"
        ], [
            "quantity.required" => "Không được để trống!",
            "quantity.numeric" => "Số lượng phải là số!",
            "quantity.min" => "Số lượng phải lớn hơn 0!",
        ]);

        $cartExist = Cart::where(["user_id" => auth()->id(), "product_id" => $product->id, "product_detail_id" => $request->product_detail_id]);

        if ($cartExist->first()) {
            $data = [
                "quantity" => $request->quantity,
            ];

            if ($cartExist->update($data)) {
                return redirect()->back()->with("success", "Cập nhật số lượng thành công!");
            }
            return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
        } else {
            return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
        }
    }

    public function update_plus($product_id, $product_detail_id)
    {
        $cartExist = Cart::where(["user_id" => auth()->id(), "product_id" => $product_id, "product_detail_id" => $product_detail_id]);
        if ($cartExist->first()) {
            $cartExist->increment("quantity");
            return redirect()->back()->with("success", "Cập nhật số lượng thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function update_munis($product_id, $product_detail_id)
    {
        $cartExist = Cart::where(["user_id" => auth()->id(), "product_id" => $product_id, "product_detail_id" => $product_detail_id]);
        if ($cartExist->first()) {
            if ($cartExist->first()->quantity > 1) {
                $cartExist->increment("quantity", -1);
                return redirect()->back()->with("success", "Cập nhật số lượng thành công!");
            }
            return redirect()->back()->with("error", "Số lượng phải lớn hơn 0!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function delete($product_id, $product_detail_id)
    {
        $cartExist = Cart::where(["user_id" => auth()->id(), "product_id" => $product_id, "product_detail_id" => $product_detail_id]);
        if ($cartExist->delete()) {
            return redirect()->back()->with("success", "Xóa sản phẩm khỏi giỏ hàng thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function clear()
    {
        $cartExist = Cart::where("user_id", auth()->id());
        if ($cartExist->delete()) {
            return redirect()->back()->with("success", "Xóa tất cả sản phẩm khỏi giỏ hàng thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function buyAgain(Bill $bill)
    {
        if ($bill->user_id == auth()->id()) {

            $list_bill_detail = $bill->details;
            if ($list_bill_detail) {
                foreach ($list_bill_detail as $detail) {
                    $cartExist = Cart::where(["user_id" => auth()->id(), "product_id" => $detail->product_id, "product_detail_id" => $detail->product_detail_id]);
                    if ($cartExist->first()) {
                        $cartExist->increment("quantity", $detail->quantity);
                    } else {
                        $data = [
                            "user_id" => auth()->id(),
                            "product_id" => $detail->product_id,
                            "product_detail_id" => $detail->product_detail_id,
                            "price" => ($detail->product->discount > 0) ? $detail->product->discount : $detail->product->price,
                            "quantity" => $detail->quantity,
                        ];
                        Cart::create($data);
                    }
                }
                return redirect()->route("cart.index")->with("success", "Đã thêm lại sản phẩm vào giỏ hàng!");
            }
            return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
        }
        return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
    }
}