<?php

namespace App\Exports;

use App\Models\Bill;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BillsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Bill::select("id", "name", "email", "phone", "address", "note", "payment", "status", "total", "created_at")->get();
    }

     public function headings(): array
    {
        return [
            'Mã ĐH',
            'Người Nhận',
            'Email',
            'SĐT',
            'Địa Chỉ',
            'Ghi Chú',
            'Phương Thức Thanh Toán',
            'Trạng Thái Đơn Hàng',
            'Tổng Tiền',
            'Thời gian đặt',
        ];
    }
}