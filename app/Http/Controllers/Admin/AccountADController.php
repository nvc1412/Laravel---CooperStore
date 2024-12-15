<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DeleteAccountRequest;
use App\Http\Requests\UpdateAccountRequest;
use App\Services\AccountService;

class AccountADController extends Controller
{
    protected $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function index()
    {
        $accounts = $this->accountService->getAccounts();
        return view("admin.account.index", compact("accounts"));
    }

    public function update(UpdateAccountRequest $request)
    {
        try {
            $this->accountService->updateAccount($request->validated());
            session()->flash("success", "Cập nhật tài khoản thành công!");
            return redirect()->route("accountAD.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy(DeleteAccountRequest $request)
    {
        try {
            $this->accountService->deleteAccount($request->validated());
            session()->flash("success", "Xóa tài khoản thành công!");
            return redirect()->route("accountAD.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}