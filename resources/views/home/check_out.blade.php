@extends("master.main")
@section("title", "Thanh toán")
@section("pay-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
@stop

@section("main")


<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%; background-repeat: no-repeat; background-size: cover;">
        <li class="breadcrumb-item active" aria-current="page">Thanh toán</li>

    </ol>
</nav>



<div class="checkout-inner float-left w-100">
    <div class="container">
        @if($carts->count() <= 0) <div class="text-center">
            <img width="150px" class="mr-4" src="img/logos/cart_empty.png" alt="giỏ hàng trống">
            <p class="lead mt-4 mb-5"> <em>Chưa có hóa đơn nào cần thanh toán!</em>
            </p>
            <a href="{{route('home.index')}}" class="btn btn-primary">Tiếp tục mua sắm</a>
    </div>
    @else
    <form class="needs-validation" action="" method="POST">
        @csrf
        <div class="row">
            <div class="cart-block-left col-md-5 order-md-2 mb-4">
                <h4 class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-uppercase">Đơn hàng của bạn</span>
                </h4>
                <div class="list-group mb-3">
                    <div class="list-group-item d-flex justify-content-between lh-condensed">
                        <h6 class="my-0 text-uppercase">Sản Phẩm</h6>
                        <h6 class="text-muted text-uppercase">Tạm tính</h6>
                    </div>

                    @php
                    $totalPrice = 0;
                    @endphp
                    @foreach($carts as $cart)
                    <hr style="width: 100%; margin: 5px;">
                    <div class="list-group-item d-flex justify-content-between lh-condensed">
                        <div>
                            <h7 class="my-0">{{$cart->product->name }} &#215; {{$cart->quantity}}</h7><br>
                            <small>Size: {{$cart->productDetail->size}}</small>
                        </div>
                        <span class="text-muted">{{number_format($cart->price * $cart->quantity)}}đ</span>
                    </div>
                    @php
                    $totalPrice += $cart->price * $cart->quantity
                    @endphp
                    @endforeach

                    <hr style="width: 100%; margin: 5px;">

                    <div class="list-group-item d-flex justify-content-between pb-0">

                        <h6 class="my-0">Tổng tiền sản phẩm:</h6><br>

                        <h6 class="text-muted">{{number_format($totalPrice)}}đ</h6>
                    </div>

                    <hr style="width: 100%; margin: 5px;">

                    <div class="list-group-item d-flex justify-content-between">
                        <div>
                            <h7 class="my-0">Phí vận chuyển (DVVC: GHN)</h7><br>
                            <img width="100px" src="img/logos/ghn.png" alt="ghn">
                        </div>
                        <h7 class="text-muted">0đ</h7>
                    </div>

                    <hr style="width: 100%; margin: 5px;">

                    <div class="list-group-item d-flex justify-content-between">
                        <h7 class="my-0">Mã giảm giá:</h7><br>
                        <h7 class="text-muted">0đ</h7>
                    </div>

                    <hr style="width: 100%; margin: 5px;">

                    <div class="list-group-item d-flex justify-content-between pb-0">

                        <h6 class="my-0 font-weight-bold text-success">Tổng tiền thanh toán:</h6><br>

                        <h6 class="font-weight-bold text-success">{{number_format($totalPrice)}}đ</h6>
                    </div>

                    <div class="list-group-item justify-content-between">
                        <div class="custom-control custom-radio" id="checkbox-card-cod">
                            <input checked id="cod" name="payment" value="cod" type="radio" class="custom-control-input"
                                required="">
                            <label class="custom-control-label" for="cod">Thanh toán khi nhận hàng (COD)</label>
                        </div>

                        <div class="custom-control custom-radio" id="checkbox-card-vnpay">
                            <input id="vnpay" name="payment" type="radio" value="vnpay" class="custom-control-input"
                                required="">
                            <label class="custom-control-label" for="vnpay">Ví điện tử VNPAY</label>
                        </div>

                        <div class="custom-control custom-radio" id="checkbox-card-momo">
                            <input id="momo" name="payment" type="radio" value="momo" class="custom-control-input"
                                required="">
                            <label class="custom-control-label" for="momo">Ví điện tử MOMO</label>
                        </div>

                        <!-- <div class="custom-control custom-radio" id="checkbox-card-paypal">
                                    <input id="paypal" name="payment" type="radio" value="paypal" class="custom-control-input"
                                        required="">
                                    <label class="custom-control-label" for="paypal">Ví điện tử Paypal</label>
                                </div> -->
                        @error("payment")
                        <small class="text-danger">* {{$message}}</small>
                        @enderror

                    </div>

                    <div id="card-dropdown">
                        <div class="list-group-item justify-content-between">
                            <div class="image"><img width="100px" src="img/logos/vnpay.png"></div>
                        </div>
                    </div>

                    <hr style="width: 100%; margin: 5px;">

                    <button type="submit" class="btn btn-primary btn-lg btn-primary">Đặt hàng</button>
                    </ul>
                </div>
            </div>

            <div class="cart-block-right col-md-7 order-md-1">
                <h4 class="mb-3 text-uppercase">ĐỊA CHỈ GIAO HÀNG</h4>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="username">Nickname <span class="required">*</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">@</span>
                            </div>
                            <input disabled type="text" class="form-control" placeholder="Nickname"
                                value="{{$auth->name}}" required="">
                        </div>

                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email">Email <span class="required">*</span></label>
                        <input disabled type="email" class="form-control" value="{{$auth->email}}"
                            placeholder="you@gmail.com">
                    </div>
                </div>

                <hr class="mb-4">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name">Họ và tên <span class="required">*</span></label>
                        <input type="text" class="form-control" id="name" placeholder="Họ tên người nhận hàng"
                            name="name" required="">
                        @error("name")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="phone">Số điện thoại <span class="required">*</span></label>
                        <input type="text" class="form-control" id="phone" placeholder="Số điện thoại người nhận hàng"
                            name="phone" value="{{$auth->phone}}" required="">
                        @error("phone")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="province">Tỉnh/Thành phố <span class="required">*</span></label>
                        <select class="custom-select d-block w-100" id="province" name="province" required="">
                            <option>Chọn tỉnh/thành phố</option>
                        </select>
                        @error("province")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="district">Quận/Huyện <span class="required">*</span></label>
                        <select class="custom-select d-block w-100" id="district" name="district" required="">
                            <option>Chọn quận/huyện</option>
                        </select>
                        @error("district")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="ward">Xã/Phường <span class="required">*</span></label>
                        <select class="custom-select d-block w-100" id="ward" name="ward" required="">
                            <option>Chọn xã/phường</option>
                        </select>
                        @error("ward")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="address">Xác nhận địa chỉ</label>
                        <input readonly data-address-cf="" type="text" class="form-control" id="address-cf"
                            name="address_cf" placeholder="Tỉnh/Thành phố, Quận/Huyện, Xã/Phường" value="" required="">
                        @error("address-cf")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="address">Địa chỉ chi tiết <span class="required">*</span></label>
                        <input data-address="{{$auth->address}}" type="text" class="form-control" id="address"
                            name="address" placeholder="Số nhà/đường, ngõ/ngách, thôn/xóm/làng..."
                            value="{{$auth->address}}" required="">
                        @error("address")
                        <div class="invalid-feedback d-block">
                            {{$message}}
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="note">Ghi chú đơn hàng </label>
                        <textarea class="form-control" id="note" name="note"
                            placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."
                            cols="5" rows="6"></textarea>
                    </div>
                </div>
            </div>
        </div>
    </form>
    @endif
</div>
</div>

@stop

@section("js")
<script>
$(document).ready(function() {
    // Bắt sự kiện khi radio button thay đổi
    $('input[name="payment"]').change(function() {
        // Lấy id của radio button được chọn
        var selectedpayment = $(this).attr('id');

        // Nếu chọn COD thì ẩn hình ảnh và không set src
        if (selectedpayment === 'cod') {
            $('#card-dropdown').hide(); // Ẩn hình ảnh
        } else {
            // Nếu chọn các phương thức thanh toán khác thì hiển thị hình ảnh tương ứng
            $('#card-dropdown').show(); // Hiển thị hình ảnh
            // Thay đổi src của ảnh tương ứng với phương thức thanh toán
            $('#card-dropdown .image img').attr('src', 'img/logos/' + selectedpayment + '.png');
        }
    });
});
</script>

<script>
$(document).ready(function() {
    // Tải danh sách tỉnh/thành phố khi trang được tải
    $.get("https://vapi.vnappmob.com/api/province/", function(data) {
        var options = "<option value=''>Chọn tỉnh/thành phố</option>";
        data.results.forEach(function(province) {
            options += "<option value='" + province.province_id + "' data-province='" + province
                .province_name + "'>" + province.province_name + "</option>";
        });
        $("#province").html(options);
    });

    // Xử lý sự kiện khi tỉnh/thành phố được chọn
    $("#province").change(function() {
        var provinceId = $(this).val();
        if (provinceId !== '') {
            $.get("https://vapi.vnappmob.com/api/province/district/" + provinceId, function(data) {
                var options = "<option value=''>Chọn quận/huyện</option>";
                data.results.forEach(function(district) {
                    options += "<option value='" + district.district_id +
                        "' data-district='" + district.district_name + "'>" + district
                        .district_name + "</option>";
                });
                $("#district").html(options);
            });
        } else {
            $("#district").html("<option value=''>Chọn quận/huyện</option>");
        }
    });

    // Xử lý sự kiện khi quận/huyện được chọn
    $("#district").change(function() {
        var districtId = $(this).val();
        if (districtId !== '') {
            $.get("https://vapi.vnappmob.com/api/province/ward/" + districtId, function(data) {
                var options = "<option value=''>Chọn xã/phường</option>";
                data.results.forEach(function(ward) {
                    options += "<option value='" + ward.ward_id + "' data-ward='" + ward
                        .ward_name + "'>" + ward.ward_name + "</option>";
                });
                $("#ward").html(options);
            });
        } else {
            $("#ward").html("<option value=''>Chọn xã/phường</option>");
        }
    });

    // Xử lý sự kiện khi chọn các option
    $("#province, #district, #ward").change(function() {
        var province = $("#province option:selected").data("province");
        var district = $("#district option:selected").data("district");
        var ward = $("#ward option:selected").data("ward");

        // Lấy giá trị hiện tại của input address
        var currentAddress = $("#address-cf").data("address-cf");

        // Tạo địa chỉ mới từ các giá trị được chọn
        var newAddress = province ? (district ? (ward ? ward + ", " : "") + district + ", " : "") +
            province : "";

        // Nối chuỗi mới vào giá trị hiện tại
        var finalAddress = currentAddress + newAddress;

        // Gán giá trị mới vào input address-cf
        $("#address-cf").val(finalAddress);
    });
});
</script>
@stop
