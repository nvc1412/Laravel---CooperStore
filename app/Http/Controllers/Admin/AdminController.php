<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $getRevenueDay = Bill::whereDate('updated_at', now()->toDateString())->where('status', 'Hoàn tất')->sum('total');
        $getRevenueMonth = Bill::whereYear('updated_at', now()->year)->whereMonth('updated_at', now()->month)->where('status', 'Hoàn tất')->sum('total');
        $getRevenueYear = Bill::whereYear('updated_at', now()->year)->where('status', 'Hoàn tất')->sum('total');
        $getTotalRevenue = Bill::where('status', 'Hoàn tất')->sum('total');

        $getNewBill = Bill::where('status', 'Đang được chuẩn bị')->count();
        $getTransportBill = Bill::where('status', 'Đang vận chuyển')->count();
        $getCancelBill = Bill::where('status', 'Đã hủy')->count();
        
        $bestSellingProduct = Product::select('products.name', 'products.image', DB::raw('SUM(bill_details.quantity) as total_sold'))
                                        ->join('bill_details', 'products.id', '=', 'bill_details.product_id')
                                        ->join('bills', 'bill_details.bill_id', '=', 'bills.id')
                                        ->where('bills.status', 'hoàn tất')
                                        ->where('bills.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'))
                                        ->groupBy('products.id', 'products.name', 'products.image')
                                        ->orderByDesc('total_sold')
                                        ->first();

        $result = Bill::selectRaw('MONTH(updated_at) as month, SUM(total) as revenue')
                                        ->where('status', 'Hoàn tất')
                                        ->whereYear('updated_at', '=', date('Y'))
                                        ->groupByRaw('MONTH(updated_at)')
                                        ->pluck('revenue', 'month')
                                        ->toArray();
        $getRevenueOfMonthInYear = [];
        for ($i = 1; $i <= 12; $i++) {
            $getRevenueOfMonthInYear[] = $result[$i] ?? 0;
        }

        $result = Bill::select('status', DB::raw('COUNT(*) as count'))
                                        ->whereMonth('updated_at', '=', now()->month)
                                        ->whereYear('updated_at', '=', now()->year)
                                        ->whereIn('status', ['Đang vận chuyển', 'Hoàn tất', 'Đã hủy'])
                                        ->groupBy('status')
                                        ->pluck('count', 'status')
                                        ->toArray();
        $getStatusOfBill = [];
        foreach (['Đang vận chuyển', 'Hoàn tất', 'Đã hủy'] as $status) {
            $getStatusOfBill[] = $result[$status] ?? 0;
        }

        $bills = Bill::whereYear('updated_at', now()->year)
                        ->whereMonth('updated_at', now()->month)
                        ->orderBy("id", "desc")
                        ->paginate(10);
        return view("admin.index", compact("getRevenueDay", "getRevenueMonth", "getRevenueYear", "getTotalRevenue", "getNewBill", "getTransportBill", "getCancelBill", "bestSellingProduct", "getRevenueOfMonthInYear", "getStatusOfBill", "bills"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function login()
    {
        if (auth()->check()) {
            if (auth()->user()->is_admin == 1 && auth()->user()->status == 0) {
                return redirect()->route('admin.index');
            }
            return view("admin.login");
        }
        return view("admin.login");
    }

    public function check_login(Request $request)
    {
        $request->validate([
            "email" => "required|email|exists:users",
            "password" => "required"
        ]);

        $data = $request->only(["email", "password"]);

        if (auth()->attempt($data)) {

            $user = auth()->user();

            // Kiểm tra xem người dùng có phải là admin không
            if ($user->is_admin == 1) {
                // Nếu là admin, kiểm tra trạng thái tài khoản
                if ($user->status == 1) {
                    // Nếu tài khoản bị khóa, đăng xuất người dùng và chuyển hướng lại với thông báo lỗi
                    auth()->logout();
                    return redirect()->back()->with("error", "Tài khoản của bạn đang bị khóa!");
                } else {
                    // Nếu tài khoản không bị khóa, chuyển hướng đến trang admin
                    return redirect()->route("admin.index")->with("success", "Đăng nhập thành công!");
                }
            } else {
                // Nếu không phải là admin, đăng xuất người dùng và chuyển hướng lại với thông báo lỗi
                auth()->logout();
                return redirect()->back()->with("error", "Tài khoản không có quyền truy cập!");
            }
        }
        return redirect()->back()->with("error", "Tài khoản hoặc mật khẩu không chính xác!");
    }

    public function logout()
    {
        auth()->logout();
        return redirect()->route("admin.login")->with("success", "Đăng xuất thành công!");
    }
}