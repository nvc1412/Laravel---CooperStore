<?php

namespace App\Services;

use App\Models\Bill;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class DashBoardService
{
    protected function statusBillQuery(string $status = "Hoàn tất")
    {
        return Bill::where('status', $status);
    }

    public function getRevenueDay()
    {
        return $this->statusBillQuery()
            ->whereDate('updated_at', now())
            ->sum('total');
    }

    public function getRevenueMonth()
    {
        $currentDate = now();

        return $this->statusBillQuery()
            ->whereYear('updated_at', $currentDate->year)
            ->whereMonth('updated_at', $currentDate->month)
            ->sum('total');
    }

    public function getRevenueYear()
    {
        return $this->statusBillQuery()
            ->whereYear('updated_at', now()->year)
            ->sum('total');
    }

    public function getTotalRevenue()
    {
        return $this->statusBillQuery()->sum('total');
    }

    public function getRevenues()
    {
        return [
            "revenueDay" => $this->getRevenueDay(),
            "revenueMonth" => $this->getRevenueMonth(),
            "revenueYear" => $this->getRevenueYear(),
            "totalRevenue" => $this->getTotalRevenue(),
        ];
    }

    public function getTotalOfBillInStatus()
    {
        return [
            "newBill" => $this->statusBillQuery('Đang được chuẩn bị')->count(),
            "transportingBill" => $this->statusBillQuery('Đang vận chuyển')->count(),
            "canceledBill" => $this->statusBillQuery('Đã hủy')->count(),
        ];
    }

    public function getBestSellingProduct()
    {
        return Product::select('products.name', 'products.image', DB::raw('SUM(bill_details.quantity) as total_sold'))
            ->join('bill_details', 'products.id', '=', 'bill_details.product_id')
            ->join('bills', 'bill_details.bill_id', '=', 'bills.id')
            ->where('bills.status', 'hoàn tất')
            ->where('bills.created_at', '>=', DB::raw('DATE_SUB(NOW(), INTERVAL 30 DAY)'))
            ->groupBy('products.id', 'products.name', 'products.image')
            ->orderByDesc('total_sold')
            ->first();
    }

    public function getRevenueOfMonthInYear()
    {
        $result = [];
        $data = Bill::selectRaw('MONTH(updated_at) as month, SUM(total) as revenue')
            ->where('status', 'Hoàn tất')
            ->whereYear('updated_at', now()->year)
            ->groupByRaw('MONTH(updated_at)')
            ->pluck('revenue', 'month')
            ->toArray();
        for ($i = 1; $i <= 12; $i++) {
            $result[] = $data[$i] ?? 0;
        }
        return $result;
    }

    public function getStatusOfBill()
    {
        $currentDate = now();
        $result = [];
        $data = Bill::select('status', DB::raw('COUNT(*) as count'))
            ->whereMonth('updated_at', $currentDate->month)
            ->whereYear('updated_at', $currentDate->year)
            ->whereIn('status', ['Đang vận chuyển', 'Hoàn tất', 'Đã hủy'])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
        foreach (['Đang vận chuyển', 'Hoàn tất', 'Đã hủy'] as $status) {
            $result[] = $data[$status] ?? 0;
        }
        return $result;
    }

    public function getBillsInCurrentMonth()
    {
        $currentDate = now();
        return Bill::whereYear('updated_at', $currentDate->year)
            ->whereMonth('updated_at', $currentDate->month)
            ->orderBy("id", "desc")
            ->paginate(10);
    }
}