<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use App\Services\BillService;

class BillController extends Controller
{
    protected $billService;

    public function __construct(BillService $billService)
    {
        $this->billService = $billService;
    }
    public function index()
    {
        $bills = $this->billService->getBills();
        return view("admin.bill.index", compact("bills"));
    }

    public function showDetailBill(Bill $bill)
    {
        return view("admin.bill.bill_detail", compact("bill"));
    }

    public function preparing()
    {
        $bills = $this->billService->getBillPreparing();
        return view("admin.bill.bill_preparing", compact("bills"));
    }

    public function printBill(Request $request)
    {
        try {
            return $this->billService->printBill($request);
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }

    public function exportExcel()
    {
        return $this->billService->exportExcelBill();
    }
}