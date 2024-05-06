<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use App\Exports\BillsExport;
use Maatwebsite\Excel\Facades\Excel;

class BillController extends Controller
{
    public function index()
    {
        $bills = Bill::orderBy("id", "desc")->paginate(10);
        return view("admin.bill.index", compact("bills"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function showDetailBill(Bill $bill)
    {
        return view("admin.bill.bill_detail", compact("bill"));
    }

    public function preparing()
    {
        $bills = Bill::where("status", "Đang được chuẩn bị")->orderBy("updated_at", "desc")->paginate(10);
        return view("admin.bill.bill_preparing", compact("bills"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function printBill(Request $request) {
        // Kiểm tra có chọn đơn hàng
        if ($request->has("listBillPrint")) {
            $listBillPrint = [];
            foreach($request->listBillPrint as $i =>$billID){
                $bill = Bill::find($billID);
                if($bill && ($bill->status == "Đang được chuẩn bị" || $bill->status == "Đang vận chuyển")){
                    if($bill->status == "Đang được chuẩn bị"){
                        $bill->update(["status" => "Đang vận chuyển"]);
                    }
                    $listBillPrint[] = $bill;
                }
            }
            
            $view = view('admin.bill.printpdf', compact("listBillPrint"));
            $html = $view->render();
            $pdf = App::make('dompdf.wrapper');
            $pdf->loadHTML($html)->setPaper('a6');

            // Lấy ngày và giờ hiện tại
            $currentDateTime = date('d_m_Y_H_i_s');
            // Tạo tên file PDF dựa trên thời gian hiện tại
            $fileName = "danhsachdonhangin_" . $currentDateTime . ".pdf";
            
            return $pdf->stream($fileName);
        }
        return redirect()->back()->with("error", "Vui lòng chọn đơn hàng cần in!");
    }

    public function exportExcel(){
        // Lấy ngày và giờ hiện tại
        $currentDateTime = date('d_m_Y_H_i_s');
        // Tạo tên file PDF dựa trên thời gian hiện tại
        $fileName = "danhsachdonhangxuatexcel_" . $currentDateTime . ".xlsx";

        return Excel::download(new BillsExport, $fileName);
    }
}