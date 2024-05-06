<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AccountADController extends Controller
{
    public function index()
    {
        $accounts = User::orderBy("id", "desc")->paginate(10);
        return view("admin.account.index", compact("accounts"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function update(Request $request)
    {
        $request->validate([
            "id" => "required|exists:users,id",
            "is_admin" => "required|in:0,1",
            "status" => "required|in:0,1"
        ]);

        $user = User::where("id", $request->id)->firstOrFail();
        $data = $request->only("is_admin", "status");
        if($user->update($data)){
            return redirect()->route("accountAD.index")->with("success", "Cập nhật tài khoản thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }

    public function destroy(Request $request)
    {
        $request->validate([
            "id" => "required|exists:users,id",
        ]);
        $user = User::where("id", $request->id)->firstOrFail();
        if($user->delete()){
            return redirect()->route("accountAD.index")->with("success", "Xóa tài khoản thành công!");
        }
        return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
    }
}