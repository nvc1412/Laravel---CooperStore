<?php

namespace App\Http\Controllers;

use App\Exceptions\CartException;
use App\Http\Requests\CheckoutRequest;
use App\Models\Bill;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->orderService = $orderService;
    }

    public function index()
    {
        $auth = auth()->user();
        return view("home.check_out", compact("auth"));
    }

    public function checkOut(CheckoutRequest $request)
    {
        $auth = auth()->user();
        try {
            if ($auth->carts->count() > 0) {
                return $this->orderService->checkOut($auth, $request);
            }
            throw new CartException("Bạn chưa có sản phẩm trong giỏ hàng!");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function verifyBill($token)
    {
        try {
            $bill = $this->orderService->verifyBill($token);
            session()->flash("success", "Xác nhận đặt hàng thành công!");
            return view("home.check_out_success", compact("bill"));
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function returnVnpay(Bill $bill, Request $request)
    {
        if ($bill->user_id == auth()->id()) {
            if ($request->vnp_ResponseCode == "00") {
                $data = [
                    "status" => "Đang được chuẩn bị"
                ];
                if ($bill->update($data)) {
                    return view("home.check_out_success", compact("bill"))->with("success", "Thanh toán thành công!");
                }
                return redirect()->route("home.index")->with("error", "Đã có lỗi xảy ra!");
            } else {
                $data = [
                    "status" => "Đã hủy"
                ];
                if ($bill->update($data)) {
                    return redirect()->route("home.index")->with('error', 'Lỗi trong quá trình thanh toán phí dịch vụ! Đơn hàng đã bị hủy bỏ!');
                }
                return redirect()->route("home.index")->with("error", "Đã có lỗi xảy ra!");
            }
        }
        return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
    }

    public function returnMomo(Bill $bill, Request $request)
    {
        if ($bill->user_id == auth()->id()) {
            if ($request->message == "Successful.") {
                $data = [
                    "status" => "Đang được chuẩn bị"
                ];
                if ($bill->update($data)) {
                    return view("home.check_out_success", compact("bill"))->with("success", "Thanh toán thành công!");
                }
                return redirect()->route("home.index")->with("error", "Đã có lỗi xảy ra!");
            } else {
                $data = [
                    "status" => "Đã hủy"
                ];
                if ($bill->update($data)) {
                    return redirect()->route("home.index")->with('error', 'Lỗi trong quá trình thanh toán phí dịch vụ! Đơn hàng đã bị hủy bỏ!');
                }
                return redirect()->route("home.index")->with("error", "Đã có lỗi xảy ra!");
            }
        }
        return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
    }
}