<?php

namespace App\Services;

use App\Exceptions\BillPrintException;
use App\Exports\BillsExport;
use App\Models\Bill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Maatwebsite\Excel\Facades\Excel;

class BillService
{
    public function getBills()
    {
        return Bill::orderBy("id", "desc")->paginate(10);
    }

    public function getBillPreparing()
    {
        return Bill::where("status", "Đang được chuẩn bị")->orderBy("updated_at", "desc")->paginate(10);
    }

    public function printBill(Request $request)
    {
        // Kiểm tra có chọn đơn hàng
        if ($request->has("listBillPrint")) {
            $listBillPrint = [];
            foreach ($request->listBillPrint as $i => $billID) {
                $bill = Bill::find($billID);
                if ($bill && ($bill->status == "Đang được chuẩn bị" || $bill->status == "Đang vận chuyển")) {
                    if ($bill->status == "Đang được chuẩn bị") {
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
        throw new BillPrintException();
    }

    public function exportExcelBill()
    {
        // Lấy ngày và giờ hiện tại
        $currentDateTime = date('d_m_Y_H_i_s');
        // Tạo tên file PDF dựa trên thời gian hiện tại
        $fileName = "danhsachdonhangxuatexcel_" . $currentDateTime . ".xlsx";

        return Excel::download(new BillsExport, $fileName);
    }
}