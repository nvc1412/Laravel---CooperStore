@extends("master.main")
@section("title", "Giỏ hàng")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
@stop

@section("main")


<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%; background-repeat: no-repeat; background-size: cover;">
        <li class="breadcrumb-item"><a href="{{route("home.index")}}">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Giỏ Hàng</li>

    </ol>
</nav>

<div class="cart-area table-area pt-110 pb-95 float-left w-100">
    <div class="container">
        @if($carts->count() <= 0) <div class="text-center">
            <img width="150px" class="mr-4" src="img/logos/cart_empty.png" alt="giỏ hàng trống">
            <p class="lead mt-4 mb-5"> <em>Chưa có sản phẩm nào trong giỏ hàng!</em>
            </p>
            <a href="{{route('home.index')}}" class="btn btn-primary">Tiếp tục mua sắm</a>

    </div>
    @else
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 float-left cart-wrapper">
            <div class="table-responsive">
                <table class="table product-table text-center">
                    <thead>
                        <tr>
                            <th class="table-remove text-capitalize"><a title="Xóa tất cả sản phẩm trong giỏ hàng"
                                    href="{{route("cart.clear")}}" class="d-flex text-danger"><i
                                        class="material-icons">delete</i></a></td>
                            </th>
                            <th class="table-image text-capitalize">Hình Ảnh</th>
                            <th class="table-p-name text-capitalize">Sản phẩm</th>
                            <th class="table-p-price text-capitalize">Giá</th>
                            <th class="table-p-name text-capitalize">Size</th>
                            <th class="table-p-qty text-capitalize">Số lượng</th>
                            <th class="table-total text-capitalize">Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $totalPrice = 0;
                        @endphp
                        @foreach($carts as $cart)
                        <tr>
                            <td class="table-remove"><a
                                    href="{{route("cart.delete", [$cart->product_id, $cart->product_detail_id])}}"><i
                                        class="material-icons">close</i></a></td>
                            <td class="table-image"><a
                                    href="{{route("home.showProductDetail", $cart->product_id)}}"><img
                                        src="img/products/{{$cart->product->image}}" alt=""></a></td>
                            <td class="table-p-name text-capitalize"><a
                                    href="{{route("home.showProductDetail", $cart->product_id)}}">{{$cart->product->name}}</a>
                            </td>
                            <td class="table-p-price">
                                <p>{{number_format($cart->price)}}đ</p>
                            </td>
                            <td class="table-p-name text-capitalize">{{$cart->productDetail->size}}</td>
                            <td class="table-p-qty">
                                <div class="d-flex justify-content-center align-items-center">
                                    <a style="height: 24px; border: 1px solid #e0e0e0;"
                                        href="{{route("cart.updateMinus", [$cart->product_id, $cart->product_detail_id])}}"><i
                                            class="material-icons">remove</i></a>
                                    <form class="cart-update-form" action="{{route('cart.update', $cart->product_id)}}"
                                        method="POST">
                                        @csrf
                                        <input required class="m-0 no-spinners cart-quantity"
                                            style="height: 24px; width: 40px; border: 1px solid #e0e0e0;"
                                            value="{{$cart->quantity}}" name="quantity" type="number" min="1">
                                        <input required type="hidden" name="product_detail_id"
                                            value="{{$cart->product_detail_id}}">
                                    </form>
                                    <a style="height: 24px; border: 1px solid #e0e0e0;"
                                        href="{{route("cart.updatePlus", [$cart->product_id, $cart->product_detail_id])}}"><i
                                            class="material-icons">add</i></a>
                                </div>
                                @error("quantity")
                                <small class="text-danger">* {{$message}}</small>
                                @enderror

                            </td>
                            <td class="table-total">
                                <p class="m-0">{{number_format($cart->price * $cart->quantity)}}đ
                                </p>
                            </td>
                        </tr>
                        @php
                        $totalPrice += $cart->price * $cart->quantity
                        @endphp
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-bottom-wrapper">
                <div class="table-coupon d-flex d-xs-block d-lg-flex d-sm-flex fix justify-content-start float-left">
                    <input type="text" placeholder="Mã giảm giá">
                    <button type="submit" class="btn-primary btn">Áp dụng giảm giá</button>
                </div>
                <div class="table-update d-flex d-xs-block d-lg-flex d-sm-flex justify-content-end">
                    <a href="{{route('home.index')}}" class="d-block btn btn-primary">Tiếp tục mua sắm</a>
                </div>
            </div>
        </div>
        <div
            class="table-total-wrapper d-flex justify-content-end pt-60 col-md-12 col-sm-12 col-lg-4 float-left  align-items-center">
            <div class="table-total-content">
                <h2 class="pb-20">Tóm tắt đơn hàng</h2>
                <div class="table-total-amount">
                    <div class="single-total-content d-flex justify-content-between float-left w-100">
                        <strong>Tổng tiền sản phẩm</strong>
                        <span class="c-total-price">{{ number_format($totalPrice) }}đ</span>
                    </div>
                    <div class="single-total-content d-flex justify-content-between float-left w-100">
                        <strong>Phí vận chuyển</strong>
                        <span class="c-total-price"><span>Free:</span> 0đ</span>
                    </div>
                    <div class="single-total-content d-flex justify-content-between float-left w-100">
                        <strong>Mã giảm giá</strong>
                        <span class="c-total-price"> 0đ</span>
                    </div>
                    <div class="single-total-content tt-total d-flex justify-content-between float-left w-100">
                        <strong>Tổng tiền thanh toán</strong>
                        <span
                            class="c-total-price font-weight-bold text-success">{{ number_format($totalPrice) }}đ</span>
                    </div>
                    <a href="{{route('checkout.index')}}" class="btn btn-primary float-left w-100 text-center">Tiến
                        hành
                        thanh toán</a>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>

</div>

@stop

@section("js")
<script>
$(document).ready(function() {
    $('.cart-quantity').change(function() {
        var $form = $(this).closest('.cart-update-form'); // Tìm form gần nhất chứa input
        $form.submit(); // Gửi form
    });
});
</script>
@stop