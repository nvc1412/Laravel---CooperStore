<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Đơn hàng</title>
    <style>
    body {
        font-family: DejaVu Sans;
        font-size: 13px;
    }

    .content,
    .content th,
    .content td {
        border: 1px solid black;
        border-collapse: collapse;

    }

    .container {
        width: 100%;
        height: 100%;
        margin: -25px 0 0 -25px;
        padding-right: 50px;
        padding-bottom: 25px;
    }

    .page-break {
        page-break-after: always;
    }
    </style>
</head>

<body>

    @php
    $dem = 0;
    @endphp
    @foreach ($listBillPrint as $i => $bill)
    @php
    $dem++;
    @endphp
    <div class="container {{count($listBillPrint)-1 >= $dem ? 'page-break' : ''}}">

        <div style="border: 1px solid #000; border-radius: 10px; padding: 5px; width: 345px;">
            <h6 style="margin: 2px 0;">Bên gửi:</h6>
            <h6 style="margin: 2px 0;">Cooper Store, ******2941</h6>
            <h6 style="margin: 2px 0;">235 Hoàng Quốc Việt, Phường Cổ Nhuế 2, Quận Bắc Từ Liêm, Thành phố Hà Nội, Việt
                Nam.
            </h6>
        </div>

        <div style="border: 1px solid #000; border-radius: 10px; padding: 5px; margin-top: 5px; width: 345px;">
            <h6 style="margin: 2px 0;">Bên nhận:</h6>
            <h6 style="margin: 2px 0;">{{$bill->name}}, ******{{substr($bill->phone, -4)}}</h6>
            <h6 style="margin: 2px 0;">{{$bill->address}}</h6>


            <table style="margin: 0; width: 345px;">
                <tr>
                    <td>
                        <p style="margin: 0; font-size: 8px;">Thu tiền người nhận:</p>
                        <h5 style="margin: 0;">{{ ($bill->payment == "cod") ? number_format($bill->total) : "0" }}đ</h5>
                        <p style="margin: 0; font-size: 8px; ">Cho xem hàng, không cho thử</p>
                        <p style="margin: 0 5px 0 0; font-size: 8px; ">Tạo đơn:
                            {{ $bill->created_at->format("d/m/Y H:i") }}</p>
                    </td>
                    <td>{!! DNS2D::getBarcodeHTML("$bill->id", "QRCODE", 2, 2, )
                        !!}</td>
                </tr>
            </table>
        </div>

        <div style="margin-top: 5px; text-align: center;">
            <h5 style="margin: 0;">{!! DNS1D::getBarcodeHTML(123456789123, "PHARMA", 2,
                60) !!}</h5>
            <h6 style="margin: 3px 0;">{{$bill->id}}</h6>
        </div>

        <div style="margin-top: 5px;  text-align: center; width: 345px;">
            <table class="content" style="width: 100%; padding: 5px; border-radius: 10px;">
                <tr style="text-align: center; font-weight: bold;">
                    <th style="width: 275px;">
                        <p style="margin: 0; font-size: 10px;">Tên sản phẩm</p>
                    </th>
                    <th style="width: 70px;">
                        <p style="margin: 0; font-size: 10px;">SL Tổng: {{$bill->details->sum("quantity")}}</p>
                    </th>
                </tr>
                @foreach($bill->details as $billDetail)
                <tr>
                    <td>
                        <p style="margin: 0; font-size: 10px;">{{$billDetail->product->name}}
                    </td>
                    <td style="text-align: center;">
                        <p style="margin: 0; font-size: 10px;">{{$billDetail->quantity}}</p>
                    </td>
                </tr>
                @endforeach
            </table>
        </div>
    </div>
    @endforeach
</body>

</html>