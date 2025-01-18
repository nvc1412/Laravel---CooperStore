<?php

namespace App\Services;

use App\Events\ForgotedPassword;
use App\Events\RegisterAccount;
use App\Exceptions\AccountActiveException;
use App\Exceptions\BillException;
use App\Exceptions\EmailVerifiedException;
use App\Exceptions\RatingException;
use App\Models\Bill;
use App\Models\PasswordResetToken;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class AccountService
{
    public function isBillOwner(Bill $bill)
    {
        return $bill->user_id == auth()->id();
    }

    public function getAccounts()
    {
        return User::orderBy("id", "desc")->paginate(10);
    }

    public function updateAccount($data)
    {
        $user = User::where("id", $data["id"])->firstOrFail();
        $data = array_intersect_key($data, array_flip(["is_admin", "status"]));
        return $user->update($data);
    }

    public function deleteAccount($data)
    {
        $user = User::where("id", $data["id"])->firstOrFail();
        return $user->delete();
    }

    public function registerAccount($data)
    {
        $data["password"] = bcrypt($data["password"]);
        $data = array_intersect_key($data, array_flip(["name", "email", "password"]));
        $data["phone"] = "0987654321";
        $data["address"] = "Hà Nội";

        if ($account = User::create($data)) {
            return event(new RegisterAccount($account));
        }
        return false;
    }

    public function verifyEmail($email)
    {
        $check = User::where("email", $email)->whereNull("email_verified_at")->firstOrFail();
        if ($check) {
            return User::where("email", $email)->update(["email_verified_at" => date("Y-m-d H:i:s")]);
        }
        return false;
    }

    public function checkLogin($data)
    {
        $data = array_intersect_key($data, array_flip(["email", "password"]));
        if (!auth()->attempt($data)) {
            throw ValidationException::withMessages([
                'password' => ['Mật khẩu không chính xác!'],
            ]);
        }
        if (!isEmailVerified()) {
            auth()->logout();
            throw new EmailVerifiedException();
        }
        if (!isActive()) {
            auth()->logout();
            throw new AccountActiveException("Tài khoản của bạn đang bị khóa! Vui lòng liên hệ hoặc gọi hotline để biết thêm chi tiết!");
        }
        return true;
    }

    public function updateProfile($data)
    {
        /** @var \App\Models\User $auth */
        $auth = auth()->user();
        $data = array_intersect_key($data, array_flip(["name", "email", "phone", "address"]));
        return $auth->update($data);
    }

    public function changePassword($password)
    {
        /** @var \App\Models\User $auth */
        $auth = auth()->user();
        $data["password"] = bcrypt($password);
        return $auth->update($data) ? auth()->logout() : false;
    }

    public function forgotPassword($email)
    {
        $customer = User::where("email", $email)->first();

        $token = Str::random(40);
        $tokenData = [
            "email" => $email,
            "token" => $token
        ];

        if (PasswordResetToken::create($tokenData)) {
            return event(new ForgotedPassword($customer, $token));
        }
        return false;
    }

    public function resetPassword($password, $token)
    {
        $tokenData = PasswordResetToken::checkToken($token);
        $customer = $tokenData->customer;

        $data["password"] = bcrypt($password);

        return $customer->update($data) ? PasswordResetToken::deleteToken($token) : false;
    }

    public function cancelBill(Bill $bill)
    {
        if ($this->isBillOwner($bill)) {
            if ($bill->status == "Chờ xác nhận" || $bill->status == "Đang được chuẩn bị") {
                return $bill->update(["status" => "Đã hủy"]);
            }
            throw new BillException("Không thể hủy đơn hàng!");
        }
        throw new BillException();
    }

    public function completeBill(Bill $bill)
    {
        if ($this->isBillOwner($bill)) {
            if ($bill->status == "Đang vận chuyển" || $bill->status == "Đã giao hàng") {
                return $bill->update(["status" => "Hoàn tất"]);
            }
            throw new BillException("Không thể cập nhật đơn hàng!");
        }
        throw new BillException();
    }

    public function ratingProduct(Product $product, $request)
    {
        $hasPurchased = auth()->user()->bills()
            ->whereHas('details', function ($query) use ($product) {
                $query->where('product_id', $product->id);
            })
            ->exists();

        if (!$hasPurchased) {
            throw new RatingException("Bạn cần mua sản phẩm trước khi đánh giá!");
        }

        $check = Rating::where([["user_id", auth()->id()], ["product_id", $product->id]])->first();
        if ($check) {
            throw new RatingException();
        }
        $data = [
            "user_id" => auth()->id(),
            "product_id" => $product->id,
            "rating" => $request["rating"],
            "comment" => $request["comment"],
        ];
        return Rating::create($data);
    }
}