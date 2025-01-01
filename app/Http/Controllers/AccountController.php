<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RatingRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Models\Bill;
use App\Models\PasswordResetToken;
use App\Models\Product;
use App\Services\AccountService;

class AccountController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function checkRegister(RegisterRequest $request)
    {
        try {
            $this->accountService->registerAccount($request->validated());
            session()->flash("success", "Đăng ký tài khoản thành công! Vui lòng kiểm tra email để xác thực tài khoản của bạn!");
            return redirect()->route("home.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function verify($email)
    {
        try {
            $this->accountService->verifyEmail($email);
            session()->flash("success", "Xác thực tài khoản thành công! Hãy đăng nhập để mua hàng ngay bây giờ!");
            return redirect()->route("home.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function checkLogin(LoginRequest $request)
    {
        try {
            $this->accountService->checkLogin($request->validated());
            session()->flash("success", "Đăng nhập thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        auth()->logout();
        session()->flash("success", "Đăng xuất thành công!");
        return redirect()->route("home.index");
    }

    public function profile()
    {
        $auth = auth()->user();
        return view("home.profile", compact("auth"));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $this->accountService->updateProfile($request->validated());
            session()->flash("success", "Cập nhật thông tin tài khoản thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $this->accountService->changePassword($request->password);
            session()->flash("success", "Đổi mật khẩu thành công! Vui lòng đăng nhập lại để tiếp tục mua sắm!");
            return redirect()->route("home.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function forgotPassword(ForgotPasswordRequest $request)
    {
        try {
            $this->accountService->forgotPassword($request->email);
            session()->flash("success", "Gửi yêu cầu thành công! Vui lòng kiểm tra email của bạn để đặt lại mật khẩu!");
            return redirect()->route("home.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function showResetPassword($token)
    {
        $tokenData = PasswordResetToken::checkToken($token);
        if ($tokenData->customer) {
            return view("home.reset_password");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->route("home.index");
    }

    public function resetPassword(ResetPasswordRequest $request, $token)
    {
        try {
            $this->accountService->resetPassword($request->password, $token);
            session()->flash("success", "Cập nhật mật khẩu thành công! Vui lòng đăng nhập để tiếp tục mua sắm!");
            return redirect()->route("home.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function showFavorite()
    {
        $favorites = auth()->user()->favorites ?? [];
        return view("home.favorite", compact("favorites"));
    }

    public function showHistory()
    {
        $bills = auth()->user()->bills ?? [];
        return view("home.history", compact("bills"));
    }

    public function showHistoryDetail(Bill $bill)
    {
        if ($this->accountService->isBillOwner($bill)) {
            return view("home.history_detail", compact("bill"));
        }
        session()->flash("error", "Không tìm thấy đơn hàng của bạn!");
        return redirect()->route("account.showHistory");
    }

    public function cancel(Bill $bill)
    {
        try {
            $this->accountService->cancelBill($bill);
            session()->flash("success", "Hủy đơn hàng thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function complete(Bill $bill)
    {
        try {
            $this->accountService->completeBill($bill);
            session()->flash("success", "Hoàn tất đơn hàng thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function rating(RatingRequest $request, Product $product)
    {
        try {
            $this->accountService->ratingProduct($product, $request->validated());
            session()->flash("success", "Đã thêm đánh giá của bạn về sản phẩm!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}
