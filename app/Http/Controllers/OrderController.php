<?php

namespace App\Http\Controllers;

use App\Mail\VerifyBill;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\BillVerifyToken;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function index()
    {
        $auth = auth()->user();
        return view("home.check_out", compact("auth"));
    }

    public function check_out(Request $request)
    {
        $auth = auth()->user();
        if ($auth->carts->count() > 0) {

            $request->validate([
                "payment" => "required|in:cod,vnpay,momo,paypel",
                "name" => "required",
                "phone" => "required",
                "province" => "required",
                "district" => "required",
                "address_cf" => "required",
                "address" => "required"
            ]);

            $data = $request->only("payment", "name", "phone", "note");

            $data["address"] = $request->address . "/ " . $request->address_cf;

            $data["user_id"] = $auth->id;
            $data["email"] = $auth->email;
            $data["total"] = 0;


            if ($bill = Bill::create($data)) {
                $totalPrice = 0;

                foreach ($auth->carts as $cart) {
                    $totalPrice += ($cart->quantity * $cart->price);
                    $data_cart = [
                        "bill_id" => $bill->id,
                        "product_id" => $cart->product_id,
                        "product_detail_id" => $cart->product_detail_id,
                        "quantity" => $cart->quantity,
                        "price" => $cart->price
                    ];
                    BillDetail::create($data_cart);
                }

                // Xóa giỏ hàng
                Cart::where("user_id", auth()->id())->delete();


                if ($request->payment == "cod") {
                    $token = Str::random(40);
                    $tokenData = [
                        "email" => $auth->email,
                        "bill_id" => $bill->id,
                        "token" => $token
                    ];

                    if (BillVerifyToken::create($tokenData)) {
                        Mail::to($auth->email)->send(new VerifyBill($bill, $token));
                        return redirect()->route("home.index")->with("success", "Đã gửi yêu cầu đặt hàng! Vui lòng kiểm tra email của bạn để xác nhận đặt hàng!");
                    }
                    return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
                } else if ($request->payment == "vnpay") {

                    $vnp_TmnCode = env('VNP_TMN_CODE');
                    $vnp_HashSecret = env('VNP_HASH_SECRET');
                    $vnp_Url = env('VNP_URL');

                    $vnp_Returnurl = route("checkout.returnVnpay", $bill->id);
                    $vnp_TxnRef = date("YmdHis");
                    $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
                    $vnp_OrderType = 'billpayment';
                    $vnp_Amount = $totalPrice * 100;
                    $vnp_Locale = 'vn';
                    $vnp_IpAddr = request()->ip();

                    $inputData = array(
                        "vnp_Version" => "2.1.0",
                        "vnp_TmnCode" => $vnp_TmnCode,
                        "vnp_Amount" => $vnp_Amount,
                        "vnp_Command" => "pay",
                        "vnp_CreateDate" => date('YmdHis'),
                        "vnp_CurrCode" => "VND",
                        "vnp_IpAddr" => $vnp_IpAddr,
                        "vnp_Locale" => $vnp_Locale,
                        "vnp_OrderInfo" => $vnp_OrderInfo,
                        "vnp_OrderType" => $vnp_OrderType,
                        "vnp_ReturnUrl" => $vnp_Returnurl,
                        "vnp_TxnRef" => $vnp_TxnRef,
                    );

                    if (isset($vnp_BankCode) && $vnp_BankCode != "") {
                        $inputData['vnp_BankCode'] = $vnp_BankCode;
                    }
                    ksort($inputData);
                    $query = "";
                    $i = 0;
                    $hashdata = "";
                    foreach ($inputData as $key => $value) {
                        // Thêm urlencode vào trong if else nếu không sẽ bị lỗi chữ ký
                        if ($i == 1) {
                            $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashdata .= urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                        $query .= urlencode($key) . "=" . urlencode($value) . '&';
                    }

                    $vnp_Url = $vnp_Url . "?" . $query;
                    if (isset($vnp_HashSecret)) {
                        $vnpSecureHash =   hash_hmac('sha512', $hashdata, $vnp_HashSecret); //  Sửa về sha 512
                        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
                    }

                    return redirect($vnp_Url);
                }else if($request->payment == "momo"){

                    $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
                    $partnerCode = env('MOMO_PARTNER_CODE');
                    $accessKey = env('MOMO_ACCESS_KEY');
                    $secretKey = env('MOMO_SECRET_KEY');

                    $orderInfo = "Thanh toán qua MoMo";
                    $amount = $totalPrice;
                    $orderId = time() . "";
                    $redirectUrl = route("checkout.returnMomo", $bill->id);
                    $ipnUrl = route("checkout.returnMomo", $bill->id);
                    $extraData = "";

                    $requestId = time() . "";
                    $requestType = "payWithATM";
                    // $extraData = ($_POST["extraData"] ? $_POST["extraData"] : "");
                    
                    //before sign HMAC SHA256 signature
                    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
                    $signature = hash_hmac("sha256", $rawHash, $secretKey);
                    $data = array('partnerCode' => $partnerCode,
                        'partnerName' => "Test",
                        "storeId" => "MomoTestStore",
                        'requestId' => $requestId,
                        'amount' => $amount,
                        'orderId' => $orderId,
                        'orderInfo' => $orderInfo,
                        'redirectUrl' => $redirectUrl,
                        'ipnUrl' => $ipnUrl,
                        'lang' => 'vi',
                        'extraData' => $extraData,
                        'requestType' => $requestType,
                        'signature' => $signature);
                    $result = $this->execPostRequest($endpoint, json_encode($data));
                    $jsonResult = json_decode($result, true);  // decode json

                    //Just a example, please check more in there
                    // header('Location: ' . $jsonResult['payUrl']);
                    return redirect($jsonResult['payUrl']);
                }
            }
        } else {
            return redirect()->back()->with("error", "Bạn chưa có sản phẩm trong giỏ hàng!");
        }
    }

    public function verify($token)
    {
        $tokenData = BillVerifyToken::checkToken($token);
        $bill = $tokenData->bill;

        $data = [
            "status" => "Đang được chuẩn bị"
        ];

        if ($bill->update($data)) {
            BillVerifyToken::deleteToken($token);
            return view("home.check_out_success", compact("bill"))->with("success", "Xác nhận đặt hàng thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function return_vnpay(Bill $bill, Request $request)
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


    public function return_momo(Bill $bill, Request $request)
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


    // Xử lý thanh toán MOMO
    function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
        return $result;
    }
}