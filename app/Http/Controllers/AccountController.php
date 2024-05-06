<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Mail\VerifyAccount;
use App\Models\Bill;
use App\Models\PasswordResetToken;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AccountController extends Controller
{
    public function check_register(Request $request)
    {
        $request->validate([
            "name" => "required|min:3|max:100|unique:users",
            "email" => "required|email|min:6|max:100|unique:users",
            "password" => "required|min:1",
            "cfpassword" => "required|same:password",
        ], [
            "name.required" => "Nickname không được để trống!",
            "name.min" => "Nickname tối thiểu 6 ký tự!",
            "name.max" => "Nickname tối đa 100 ký tự!",
            "name.unique" => "Nickname đã tồn tại!",
        ]);

        $data = $request->only("name", "email");

        $data["password"] = bcrypt($request->password);
        if ($acc = User::create($data)) {
            Mail::to($acc->email)->send(new VerifyAccount($acc));
            return redirect()->route("home.index")->with("success", "Đăng ký tài khoản thành công! Vui lòng kiểm tra email để xác thực tài khoản của bạn!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function verify($email)
    {
        $acc = User::where("email", $email)->whereNull("email_verified_at")->firstOrFail();
        User::where("email", $email)->update(["email_verified_at" => date("Y-m-d H:i:s")]);
        return redirect()->route("home.index")->with("success", "Xác thực tài khoản thành công! Hãy đăng nhập để mua hàng ngay bây giờ!");
    }

    public function check_login(Request $request)
    {
        $request->validate([
            "email" => "required|exists:users",
            "password" => "required",
        ], [
            "email.exists" => "Email chưa được đăng ký!"
        ]);

        $data = $request->only("email", "password");

        $check = auth()->attempt($data);

        if ($check) {
            if (auth()->user()->email_verified_at == "") {
                auth()->logout();
                return redirect()->back()->with("error", "Tài khoản chưa được xác thực! Vui lòng kiểm tra email của bạn để xác thực tài khoản!");
            }
            if (auth()->user()->status == 1) {
                auth()->logout();
                return redirect()->back()->with("error", "Tài khoản của bạn đang bị khóa! Vui lòng liên hệ hoặc gọi hotline để biết thêm chi tiết!");
            }
            return redirect()->back()->with("success", "Đăng nhập thành công!");
        }
        return redirect()->back()->with("error", "Mật khẩu không chính xác!");
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route("home.index")->with("success", "Đăng xuất thành công!");
    }

    public function profile()
    {
        $auth = auth()->user();
        return view("home.profile", compact("auth"));
    }

    public function check_profile(Request $request)
    {
        /** @var \App\Models\User $auth */
        // dùng @var để fix lỗi IDE không tìm thấy method update() của $auth->update()
        $auth = auth()->user();

        $request->validate([
            "name" => "required|min:3|max:100|unique:users,name," . $auth->id,
            "email" => "required|email|min:6|max:100|unique:users,email," . $auth->id,
            "password" => ["required", function ($attr, $value, $fail) use ($auth) {
                if (!Hash::check($value, $auth->password)) {
                    return $fail("Mật khẩu không chính xác!");
                }
            }],
        ], [
            "name.required" => "Nickname không được để trống!",
            "name.min" => "Nickname tối thiểu 6 ký tự!",
            "name.max" => "Nickname tối đa 100 ký tự!",
            "name.unique" => "Nickname đã tồn tại!",
        ]);

        $data = $request->only("name", "email", "phone", "address");

        if ($auth->update($data)) {
            return redirect()->back()->with("success", "Cập nhật thông tin tài khoản thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function change_password(Request $request)
    {
        /** @var \App\Models\User $auth */
        // dùng @var để fix lỗi IDE không tìm thấy method update() của $auth->update()
        $auth = auth()->user();
        $request->validate([
            "old_password" => ["required", function ($attr, $value, $fail) use ($auth) {
                if (!Hash::check($value, $auth->password)) {
                    return $fail("Mật khẩu cũ không chính xác!");
                }
            }],
            "password" => "required|min:1",
            "cf_password" => "required|same:password"
        ], [
            "cf_password.same" => "Mật khẩu xác nhận không khớp!"
        ]);

        $data["password"] = bcrypt($request->password);

        if ($auth->update($data)) {
            auth()->logout();
            return redirect()->route("home.index")->with("success", "Đổi mật khẩu thành công! Vui lòng đăng nhập lại để tiếp tục mua sắm!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function forgot_password(Request $request)
    {
        $request->validate([
            "email" => "required|exists:users",
        ], [
            "email.required" => "Vui lòng nhập email!",
            "email.exists" => "Email chưa được đăng ký!"
        ]);

        $customer = User::where("email", $request->email)->first();

        $token = Str::random(40);
        $tokenData = [
            "email" => $request->email,
            "token" => $token
        ];

        if (PasswordResetToken::create($tokenData)) {
            Mail::to($request->email)->send(new ForgotPassword($customer, $token));
            return redirect()->route("home.index")->with("success", "Gửi yêu cầu thành công! Vui lòng kiểm tra email của bạn để đặt lại mật khẩu!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function show_reset_password($token)
    {
        $tokenData = PasswordResetToken::checkToken($token);
        $customer = $tokenData->customer;
        return view("home.reset_password");
    }

    public function reset_password($token)
    {
        request()->validate([
            "password" => "required|min:1",
            "cf_password" => "required|same:password"
        ]);
        $tokenData = PasswordResetToken::checkToken($token);
        $customer = $tokenData->customer;

        $data = [
            "password" => bcrypt(request("password"))
        ];

        if ($customer->update($data)) {
            PasswordResetToken::deleteToken($token);
            return redirect()->route("home.index")->with("success", "Cập nhật mật khẩu thành công! Vui lòng đăng nhập để tiếp tục mua sắm!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function showFavorite()
    {
        $favorites = auth()->user()->favorites ? auth()->user()->favorites : [];
        return view("home.favorite", compact("favorites"));
    }

    public function showHistory()
    {
        $bills = auth()->user()->bills ? auth()->user()->bills : [];
        return view("home.history", compact("bills"));
    }

    public function showHistoryDetail(Bill $bill)
    {
        if ($bill->user_id == auth()->id()) {
            return view("home.history_detail", compact("bill"));
        }
        return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
    }

    public function cancel(Bill $bill)
    {
        if ($bill->user_id == auth()->id()) {
            if ($bill->status == "Chờ xác nhận" || $bill->status == "Đang được chuẩn bị") {
                $bill->update(["status" => "Đã hủy"]);
                return redirect()->back()->with("success", "Hủy đơn hàng thành công!");
            }
            return redirect()->back()->with("error", "Không thể hủy đơn hàng!");;
        }
        return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
    }

    public function complete(Bill $bill)
    {
        if ($bill->user_id == auth()->id()) {
            if ($bill->status == "Đang vận chuyển" || $bill->status == "Đã giao hàng") {
                $bill->update(["status" => "Hoàn tất"]);
                return redirect()->back()->with("success", "Hoàn tất đơn hàng thành công!");
            }
            return redirect()->back()->with("error", "Không thể cập nhật đơn hàng!");
        }
        return redirect()->route("account.showHistory")->with("error", "Không tìm thấy đơn hàng của bạn!");
    }

    public function rating(Request $request, Product $product){
        $request->validate([
            "rating" => "required|in:1,2,3,4,5",
        ]);

        $check = Rating::where([["user_id", auth()->id()],["product_id", $product->id]])->first();
        if($check){
            return redirect()->back()->with("error", "Bạn đã đánh giá sản phẩm này! Bạn chỉ được đánh giá 1 lần duy nhất!");
        }
        $data = [
            "user_id" => auth()->id(),
            "product_id" => $product->id,
            "rating" => $request->rating,
            "comment" => $request->comment,
        ];
        if(Rating::create($data)){
            return redirect()->back()->with("success", "Đã thêm đánh giá của bạn về sản phẩm!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }
}