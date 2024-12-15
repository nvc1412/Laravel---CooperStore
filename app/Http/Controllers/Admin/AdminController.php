<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Services\DashBoardService;

class AdminController extends Controller
{
    protected $authService;
    protected $dashBoardService;

    public function __construct(AuthService $authService, DashBoardService $dashBoardService)
    {
        $this->authService = $authService;
        $this->dashBoardService = $dashBoardService;
    }

    public function index()
    {
        $revenues = $this->dashBoardService->getRevenues();
        $totalOfBillInStatus = $this->dashBoardService->getTotalOfBillInStatus();
        $bestSellingProduct = $this->dashBoardService->getBestSellingProduct();
        $revenueOfMonthInYear = $this->dashBoardService->getRevenueOfMonthInYear();
        $statusOfBill = $this->dashBoardService->getStatusOfBill();
        $bills = $this->dashBoardService->getBillsInCurrentMonth();

        return view(
            "admin.index",
            compact(
                "revenues",
                "totalOfBillInStatus",
                "bestSellingProduct",
                "revenueOfMonthInYear",
                "statusOfBill",
                "bills"
            )
        );
    }

    public function login()
    {
        if (auth()->check() && isAdmin() && isActive()) {
            return redirect()->route('admin.index');
        }
        return view("admin.login");
    }

    public function checkLogin(LoginRequest $request)
    {
        try {
            $this->authService->login($request->only(["email", "password"]));
            session()->flash("success", "Đăng nhập thành công!");
            return redirect()->route("admin.index");
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function logout()
    {
        auth()->logout();
        session()->flash("success", "Đăng xuất thành công!");
        return redirect()->route("admin.login");
    }
}