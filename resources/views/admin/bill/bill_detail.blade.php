@extends("master.admin")
@section("title", "Chi tiết đơn hàng")
@section("bill", "active")

@section("css")

<style>
    .btn-status-unconfirmed {
        color: #fff;
        background-color: #1741b8;
        border-color: #1741b8;
    }

    .btn-status-unconfirmed:hover {
        background-color: #092c90;
        border-color: #092c90;
    }

    .btn-status-preparing {
        color: #fff;
        background-color: #17b89a;
        border-color: #17b89a;
    }

    .btn-status-preparing:hover {
        background-color: #109a80;
        border-color: #109a80;
    }

    .btn-status-shipping {
        color: #fff;
        background-color: #e49937;
        border-color: #e49937;
    }

    .btn-status-shipping:hover {
        background-color: #c2791a;
        border-color: #c2791a;
    }

    .btn-status-delivered,
    .btn-status-delivered:hover {
        color: #fff;
        background-color: #9bc01b;
        border-color: #9bc01b;
    }

    .btn-status-completed,
    .btn-status-completed:hover {
        color: #fff;
        background-color: #218838;
        border-color: #218838;
    }

    .btn-status-refunding {
        color: #fff;
        background-color: #931ba8;
        border-color: #931ba8;
    }

    .btn-status-refunding:hover {
        background-color: #6f0e80;
        border-color: #6f0e80;
    }

    .btn-status-refunded,
    .btn-status-refunded:hover {
        color: #fff;
        background-color: #6f0e80;
        border-color: #6f0e80;
    }

    .btn-status-failed,
    .btn-status-failed:hover {
        color: #fff;
        background-color: #ff0000;
        border-color: #ff0000;
    }

    .btn-status-cancelled,
    .btn-status-cancelled:hover {
        color: #fff;
        background-color: #900707;
        border-color: #900707;
    }
</style>

@stop


@section("main")

<div class="row">
    <div class="col-md-12">

        @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            * {{Session::get("error")}}
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get("success")}}
        </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-success">Thông tin nhận hàng</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th>Họ và tên</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</th>
                                <th>Ghi chú đơn hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $bill->name }}</td>
                                <td>{{ $bill->email }}</td>
                                <td>{{ $bill->phone }}</td>
                                <td>{{ $bill->address }}</td>
                                <td>{{ $bill->note }}</td>
                            </tr>
                        </tbody>
                    </table>

                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th>Đơn vị vận chuyển</th>
                                <th>Phương thức thanh toán</th>
                                <th>Trạng thái đơn</th>
                                <th>Thời gian đặt</th>
                                <th>Thời gian cập nhật trạng thái</th>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Giao hàng nhanh</td>
                                <td>
                                    @php
                                    switch ($bill->payment) {
                                    case "cod":
                                    echo "Thanh toán khi nhận hàng";
                                    break;
                                    case "vnpay":
                                    echo "Ví điện tử VNPAY";
                                    break;
                                    case "momo":
                                    echo "Ví điện tử MOMO";
                                    break;
                                    case "paypal":
                                    echo "Ví điện tử PAYPAL";
                                    break;
                                    default:
                                    echo "";
                                    }
                                    @endphp
                                </td>
                                <td class="text-center">
                                    <div class='w-100 btn btn-sm 
                                @php
                                switch($bill->status){
                                case "Chờ xác nhận": 
                                echo "btn-status-unconfirmed";
                                break;

                                case "Đang được chuẩn bị": 
                                echo "btn-status-preparing";
                                break;

                                case "Đang vận chuyển": 
                                echo "btn-status-shipping";
                                break;

                                case "Đã giao hàng": 
                                echo "btn-status-delivered";
                                break;

                                case "Hoàn tất": 
                                echo "btn-status-completed";
                                break;

                                case "Đang hoàn hàng": 
                                echo "btn-status-refunding";
                                break;

                                case "Hoàn hàng thành công": 
                                echo "btn-status-refunded";
                                break;

                                case "Thất lạc - hư hỏng": 
                                echo "btn-status-failed";
                                break;

                                case "Đã hủy": 
                                echo "btn-status-cancelled";
                                break;

                                default:
                                echo "btn-info";
                                };
                                @endphp
                                '>{{$bill->status}}</div>
                                </td>
                                <td>{{ $bill->created_at->format("d/m/Y H:i:s") }}</td>
                                <td>{{ $bill->updated_at->format("d/m/Y H:i:s") }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">Chi tiết đơn hàng</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th>Ảnh</th>
                                <th>Sản phẩm</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                                <th>Giá mua</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $totalPrice = 0;
                            @endphp
                            @foreach($bill->details as $detail)
                            <tr>
                                <td><img width="50px" height="50px" src="/img/products/{{ $detail->product->image }}" alt=""></td>
                                <td>{{ $detail->product->name }}</td>
                                <td>{{ $detail->size->size }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>{{ number_format($detail->price) }}đ</td>
                                <td>{{ number_format($detail->quantity*$detail->price) }}đ</td>
                            </tr>
                            @php
                            $totalPrice += $detail->quantity * $detail->price;
                            @endphp
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr style="font-weight: bold;">
                                <td colspan="5" style="padding: 10px; border: 1px solid #dddddd; text-align: left;">
                                    Tổng tiền sản phẩm</td>
                                <td style="padding: 10px; border: 1px solid #dddddd; text-align: center;">
                                    {{number_format($totalPrice)}}đ
                                </td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="5" style="padding: 10px; border: 1px solid #dddddd; text-align: left;">Phí
                                    vận chuyển</td>
                                <td style="padding: 10px; border: 1px solid #dddddd; text-align: center;">0đ</td>
                            </tr>
                            <tr style="font-weight: bold;">
                                <td colspan="5" style="padding: 10px; border: 1px solid #dddddd; text-align: left;">
                                    Giảm giá</td>
                                <td style="padding: 10px; border: 1px solid #dddddd; text-align: center;">0đ</td>
                            </tr>
                            <tr style="color: green; font-weight: bold;">
                                <td colspan="5" style="padding: 10px; border: 1px solid #dddddd; text-align: left;">
                                    Tổng tiền thanh toán
                                </td>
                                <td style="padding: 10px; border: 1px solid #dddddd; text-align: center;">
                                    {{number_format($totalPrice)}}đ
                                </td>
                            </tr>
                        </tfoot>
                    </table>

                </div>
            </div>
        </div>


    </div>
</div>


@stop()