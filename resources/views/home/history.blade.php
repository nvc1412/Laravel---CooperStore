@extends("master.main")
@section("title", "Lịch sử mua hàng")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">

<style>
.table-bordered {
    border: 1px solid #dee2e6 !important;
}

.table-bordered thead {
    background-color: #000 !important;
    color: #fff !important;
    font-weight: bold !important;
}

.table-bordered td {
    border: 1px solid #ddd !important;
}

.scrollable-table-container-history {
    max-height: 550px;
}

.thead-fixed {
    position: sticky;
    top: -1px;
    z-index: 1;
}

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


<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%; background-repeat: no-repeat; background-size: cover;">
        <li class="breadcrumb-item active" aria-current="page">Lịch sử mua hàng</li>
    </ol>
</nav>

<div class="cart-area table-area pt-110 pb-95 float-left w-100">
    <div class="container">
        @if($bills->count() <= 0) <div class="text-center">
            <img width="150px" class="mr-4" src="img/logos/cart_empty.png" alt="giỏ hàng trống">
            <p class="lead mt-4 mb-5"> <em>Bạn chưa có đơn hàng nào!</em>
            </p>
            <a href="{{route('home.index')}}" class="btn btn-primary">Mua sắm ngay</a>

    </div>
    @else
    <div class="row">
        <div id="content" class="col-lg-12">
            <h2 class="title">Lịch sử mua hàng</h2>
            <div class="table-responsive scrollable-table-container-history">
                <table class="table table-bordered table-hover scrollable-table">
                    <thead class="thead-fixed">
                        <tr>
                            <td class="text-center">Mã ĐH</td>
                            <td class="text-center">Ảnh</td>
                            <td class="text-center">Trạng thái</td>
                            <td class="text-center">HTTT</td>
                            <td class="text-center">Tổng tiền</td>
                            <td class="text-center">Thời gian tạo</td>
                            <td class="text-center">Chi tiết ĐH</td>
                            <td class="text-center">Xác nhận</td>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- <tr>
                                <td class="text-center">
                                    <div class="btn btn-sm btn-status-unconfirmed mt-2">Chờ xác nhận</div>
                                    <div class="btn btn-sm btn-status-preparing mt-2">Đang được chuẩn bị</div>
                                    <div class="btn btn-sm btn-status-shipping mt-2">Đang vận chuyển</div>
                                    <div class="btn btn-sm btn-status-delivered mt-2">Đã giao hàng</div>
                                    <div class="btn btn-sm btn-status-completed mt-2">Hoàn tất</div>
                                    <div class="btn btn-sm btn-status-refunding mt-2">Đang hoàn hàng</div>
                                    <div class="btn btn-sm btn-status-refunded mt-2">Hoàn hàng thành công</div>
                                    <div class="btn btn-sm btn-status-failed mt-2">Thất lạc - hư hỏng</div>
                                    <div class="btn btn-sm btn-status-cancelled mt-2">Đã hủy</div>
                                </td>
                            </tr> -->
                        @foreach($bills as $bill)
                        <tr>
                            <td class="text-center">#{{$bill->id}}</td>
                            <td class="text-center">
                                @foreach($bill->details as $detail)
                                <a href="{{route("home.showProductDetail", $detail->product->id)}}"><img width="70"
                                        class="img-thumbnail" src="img/products/{{$detail->product->image}}">
                                </a>
                                @endforeach

                            </td>
                            <td class="text-center">
                                <div class='w-100 btn btn-sm
                                                            @php
                                                                switch ($bill->status) {
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
                                                                }
                                                                ;
                                                            @endphp
                                                            '>{{$bill->status}}</div>
                            </td>
                            <td class="text-center text-uppercase">{{$bill->payment}}</td>
                            <td class="text-center">{{number_format($bill->total)}}đ</td>
                            <td class="text-center">{{$bill->created_at->format("d/m/Y H:i")}}</td>
                            <td class="text-center"><a class="btn btn-sm btn-primary p-1"
                                    href="{{route('account.showHistoryDetail', $bill->id)}}"><i
                                        class="material-icons">visibility</i></a>
                            </td>
                            <td class="text-center">
                                @if($bill->status == "Đang vận chuyển" || $bill->status == "Đã giao hàng")
                                <a href="{{route('account.complete', $bill->id)}}"
                                    onclick="return confirm('Bạn chắc chắn đã nhận được hàng?\nQuyết định này không thể hoàn tác!')"
                                    class="btn btn-sm btn-success w-100">Đã nhận được hàng</a>
                                @elseif($bill->status == "Chờ xác nhận" || $bill->status == "Đang được chuẩn bị")
                                <a href="{{route('account.cancel', $bill->id)}}"
                                    onclick="return confirm('Bạn chắc chắn muốn hủy đơn hàng này?\nSố tiền đã thanh toán sẽ được chúng tôi chuyển khoản lại tài khoản của bạn!')"
                                    class="btn btn-sm btn-danger w-100">Hủy</a>
                                @else
                                <a href="{{route('cart.buyAgain', $bill->id)}}"
                                    class="btn btn-sm btn-primary w-100 p-1">Mua lại</a>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif
</div>
</div>




@stop
