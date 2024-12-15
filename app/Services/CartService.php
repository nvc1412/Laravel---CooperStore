<?php

namespace App\Services;

use App\Exceptions\BillException;
use App\Exceptions\CartException;
use App\Models\Bill;
use App\Models\Cart;
use App\Models\Product;

class CartService
{
    protected function getCartExist($productId, $productDetailId)
    {
        return Cart::where(["user_id" => auth()->id(), "product_id" => $productId, "product_detail_id" => $productDetailId]);
    }

    public function addToCart(Product $product, $productDetailId, $quantity)
    {
        $cartExist = $this->getCartExist($product->id, $productDetailId);

        if ($cartExist->first()) {
            return $cartExist->increment("quantity", $quantity);
        } else {
            $data = [
                "user_id" => auth()->id(),
                "product_id" => $product->id,
                "product_detail_id" => $productDetailId,
                "price" => ($product->discount > 0) ? $product->discount : $product->price,
                "quantity" => $quantity,
            ];

            return Cart::create($data);
        }
    }

    public function updateQuantity(Product $product, $productDetailId, $quantity)
    {
        $cartExist = $this->getCartExist($product->id, $productDetailId);

        if ($cartExist->first()) {
            $data = [
                "quantity" => $quantity,
            ];
            return $cartExist->update($data);
        }
        throw new CartException();
    }

    public function updatePlus($productId, $productDetailId)
    {
        $cartExist = $this->getCartExist($productId, $productDetailId);
        if ($cartExist->first()) {
            return $cartExist->increment("quantity");
        }
        throw new CartException();
    }

    public function updateMinus($productId, $productDetailId)
    {
        $cartExist = $this->getCartExist($productId, $productDetailId);

        if ($cartExist->first()) {
            if ($cartExist->first()->quantity > 1) {
                return $cartExist->increment("quantity", -1);
            }
            throw new CartException("Số lượng phải lớn hơn 0!");
        }
        throw new CartException();
    }

    public function delete($productId, $productDetailId)
    {
        return $this->getCartExist($productId, $productDetailId)->delete();
    }

    public function clear()
    {
        return Cart::where("user_id", auth()->id())->delete();
    }

    public function buyAgain(Bill $bill)
    {
        if ($bill->user_id == auth()->id()) {
            if ($list_bill_detail = $bill->details) {
                foreach ($list_bill_detail as $billDetail) {
                    $this->addToCart($billDetail->product, $billDetail->product_detail_id, $billDetail->quantity);
                }
                return true;
            }
            throw new BillException();
        }
        throw new BillException();
    }
}