@extends("master.main")
@section("title", "Lịch sử mua hàng")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
@stop

@section("main")

<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg" style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%;">
        <li class="breadcrumb-item active" aria-current="page">Chi tiết đơn hàng</li>
    </ol>
</nav>

<div class="order-inner float-left w-100">
    <div class="container">
        <div class="row">
            <div id="order-confirmation" class="card float-left w-100 mb-10">
                <div class="card-block p-20">
                    <h3 class="card-title text-success">Đơn hàng của bạn đã được xác nhận</h3>
                    <p>Kiểm tra email của bạn hoặc vào lịch sử mua hàng để xem lại chi tiết đơn hàng.</p>
                </div>
            </div>

            <div id="order-itens" class="card float-left w-100 mb-10">
                <div class="card-block p-20">
                    <h3 class="card-title">Sản phẩm đặt hàng</h3>
                    <div class="order-confirmation-table float-left w-100">
                        @foreach($bill->details as $detail)
                        <div class="order-line float-left w-100">
                            <div class="row">
                                <div class="col-sm-1 col-xs-3 float-left">
                                    <img src="img/products/{{$detail->product->image}}" alt="">
                                </div>
                                <div class="col-sm-5 col-xs-9 details float-left">
                                    <span>{{$detail->product->name}}</span><br>
                                    <small>Size: {{$detail->size->size}}</small>
                                </div>
                                <div class="col-sm-6 col-xs-12 qty float-left d-flex">
                                    <div class="col-xs-5 col-sm-5 text-sm-right text-xs-left">
                                        {{number_format($detail->price)}}đ
                                    </div>
                                    <div class="col-xs-2 col-sm-2">&#215; {{$detail->quantity}}</div>
                                    <div class="col-xs-5 col-sm-5 text-sm-right bold">
                                        {{number_format($detail->quantity * $detail->price)}}đ
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="float-left w-100">
                        @endforeach


                        <table class="float-left w-100 mb-30">
                            <tbody>
                                <tr class="mb-10">
                                    <td>Tổng tiền sản phẩm</td>
                                    <td class="text-right">{{number_format($bill->total)}}đ</td>
                                </tr>
                                <tr class="mb-10">
                                    <td>Phí vận chuyển</td>
                                    <td class="text-right">0đ</td>
                                </tr>
                                <tr class="mb-10">
                                    <td>Giảm giá</td>
                                    <td class="text-right">0đ</td>
                                </tr>

                                <tr class="font-weight-bold">
                                    <td><span class="text-uppercase">Tổng tiền thanh toán</span> (đã bao gồm thuế)</td>
                                    <td class="text-right">{{number_format($bill->total)}}đ</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div id="content-hook_payment_return" class="card definition-list float-left w-100">
                <div class="card-block p-20">
                    <div class="row">
                        <div class="col-md-12">

                            <h3 class="card-title">Chi tiết đơn đặt hàng:</h3>

                            <div class="order-content-main">
                                <div class="order-content mb-10">
                                    <div>Họ và tên:</div>
                                    <div>{{$bill->name}}</div>
                                </div>
                                <div class="order-content mb-10">
                                    <div>Số điện thoại:</div>
                                    <div>{{$bill->phone}}</div>
                                </div>
                                <div class="order-content mb-10">
                                    <div>Địa chỉ:</div>
                                    <div>{{$bill->address}}</div>
                                </div>
                                <div class="order-content mb-10">
                                    <div>Ghi chú:</div>
                                    <div>{{$bill->note}}</div>
                                </div>
                                <div class="order-content mb-10">
                                    <div>Phương thức thanh toán:</div>
                                    <div>
                                        <?php
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
                                        ?>
                                    </div>
                                </div>
                                <div class="order-content mb-10">
                                    <div>Đơn vị vận chuyển:</div>
                                    <div>Giao Hàng Nhanh</div>
                                </div>
                                <div class="order-content mb-10">
                                    <div>Trạng thái cập nhật:</div>
                                    <div>
                                        <table>
                                            <tr>
                                                <td>Thời gian đặt:</td>
                                                <td class="pl-3">
                                                    {{$bill->created_at->format("d/m/Y H:i")}}
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>{{$bill->status}}:</td>
                                                <td class="pl-3">
                                                    {{$bill->updated_at->format("d/m/Y H:i")}}
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            <p>
                                Nếu có bất cứ vấn đề cần hỗ trợ, hãy liên hệ cho chúng tôi qua hotline <a href="tel:0365042941">0365042941</a>.
                            </p>
                            <strong>Cảm ơn bạn đã sử dụng dịch vụ của chúng tôi!</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop