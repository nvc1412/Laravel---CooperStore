@extends("master.main")
@section("title", "Thông tin tài khoản")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
@stop

@section("main")

<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%;">
        <li class="breadcrumb-item"><a href="{{route("home.index")}}">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Thông tin tài khoản</li>
    </ol>
</nav>
<div class="main-content w-100 float-left blog-list">
    <div class="container">
        <div class="row">

            <div class="products-grid col-xl-9 col-lg-8 order-lg-2">
                <div class="row">
                    <div class="col-lg-12 order-lg-last account-content">
                        <h4>Chỉnh sửa thông tin tài khoản</h4>
                        <form action="" class="myacoount-form" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group required-field">
                                                <label for="acc-name">Nick Name <span class="required">*</span></label>
                                                <input type="text" class="form-control" id="acc-name" name="name"
                                                    value="{{$auth->name}}" required="">
                                                @error("name")
                                                <small class="text-danger">* {{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="acc-email">Email <span class="required">*</span></label>
                                                <input type="email" class="form-control" id="acc-email" name="email"
                                                    value="{{$auth->email}}" required="">
                                                @error("email")
                                                <small class="text-danger">* {{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group required-field">
                                                <label for="phone">Số điện thoại</label>
                                                <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{$auth->phone}}">
                                                @error("phone")
                                                <small class="text-danger">* {{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="form-group ">
                                                <label for="address">Địa chỉ</label>
                                                <input type="text" class="form-control" id="address" name="address"
                                                    value="{{$auth->address}}">
                                                @error("address")
                                                <small class="text-danger">* {{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-md-4">
                                            <div class="form-group required-field position-relative">
                                                <label for="account-password">Mật khẩu xác nhận <span
                                                        class="required">*</span></label>
                                                <input type="password" class="form-control inputPass"
                                                    id="account-password" name="password" required="">
                                                <i style="top: 35px; right: 10px; cursor: pointer;"
                                                    class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                                                @error("password")
                                                <small class="text-danger">* {{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            </div>

                            <div class="mt-2 d-flex justify-content-end align-items-center">
                                <div class="form-footer-right">
                                    <button type="submit" class="btn btn-primary btn-primary">Lưu</button>
                                </div>
                            </div>
                        </form>

                        <hr class="mt-4 mb-4">

                        <form action="{{route("account.changePassword")}}" method="post">
                            @csrf
                            <div>
                                <h4>Đổi mật khẩu</h4>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group required-field position-relative">
                                            <label for="account-pass2">Mật khẩu cũ <span
                                                    class="required">*</span></label>
                                            <input required type="password" class="form-control inputPass"
                                                id="account-pass2" name="old_password">
                                            <i style="top: 35px; right: 10px; cursor: pointer;"
                                                class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                                            @error("old_password")
                                            <small class="text-danger">* {{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group required-field position-relative">
                                            <label for="account-pass3">Mật khẩu mới <span
                                                    class="required">*</span></label>
                                            <input required type="password" class="form-control inputPass"
                                                id="account-pass3" name="password">
                                            <i style="top: 35px; right: 10px; cursor: pointer;"
                                                class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                                            @error("password")
                                            <small class="text-danger">* {{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group required-field position-relative">
                                            <label for="account-pass4">Nhập lại mật khẩu mới <span
                                                    class="required">*</span></label>
                                            <input required type="password" class="form-control inputPass"
                                                id="account-pass4" name="cf_password">
                                            <i style="top: 35px; right: 10px; cursor: pointer;"
                                                class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                                            @error("cf_password")
                                            <small class="text-danger">* {{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-2 d-flex justify-content-end align-items-center">

                                    <div class="form-footer-right">
                                        <button type="submit" class="btn btn-primary btn-primary">Lưu</button>
                                    </div>
                                </div>
                            </div>
                        </form>


                    </div>
                </div>
            </div>


            <div class="sidebar col-xl-3 col-lg-3 order-lg-1">
                <div class="sidebar-product left-sidebar w-100 float-left">
                    <div class="title">
                        <a data-toggle="collapse" href="#sidebar-product" aria-expanded="false"
                            aria-controls="sidebar-product" class="d-lg-none block-toggler">Sản phẩm giảm giá</a>
                    </div>
                    <div id="sidebar-product" class="collapse w-100 float-left">
                        <div class="sidebar-block sale ">
                            <h3 class="widget-title text-capitalize">Sản phẩm giảm giá</h3>
                            <div class="products owl-carousel">
                                <div class="sale-col">

                                    @foreach($discount_products as $pro)
                                    <div class="product-layouts">
                                        <div class="product-thumb">
                                            <div class="image col-sm-4 float-left">
                                                <a href="#">
                                                    <img src="img/products/{{$pro->image}}" alt="01" /> </a>
                                            </div>
                                            <div class="thumb-description col-sm-8 text-left float-left">
                                                <div class="caption">
                                                    <h4 class="product-title text-capitalize"><a
                                                            href="{{route("home.showProductDetail", $pro->id)}}">{{$pro->name}}</a>
                                                    </h4>
                                                </div>
                                                <div class="rating">
                                                    <div class="product-ratings d-inline-block align-middle">
                                                        @for($x = 1; $x <= 5 ; $x++) @if($x <=average_rate($pro->
                                                            ratings))
                                                            <span class="fa fa-stack"><i
                                                                    class="material-icons">star</i></span>
                                                            @else
                                                            <span class="fa fa-stack"><i
                                                                    class="material-icons off">star</i></span>
                                                            @endif
                                                            @endfor
                                                    </div>
                                                </div>
                                                <div class="price">
                                                    @if($pro->discount > 0)
                                                    <div class="regular-price">
                                                        {{number_format($pro->discount)}}đ
                                                    </div>
                                                    <div class="old-price">{{number_format($pro->price)}}đ</div>
                                                    @else
                                                    <div class="regular-price">
                                                        {{number_format($pro->price)}}đ
                                                    </div>
                                                    @endif
                                                </div>
                                                <div class="button-wrapper">
                                                    <div class="button-group text-center">
                                                        <a href='{{route("home.showProductDetail", $pro->id)}}'
                                                            class="btn btn-primary btn-cart"><i
                                                                class="material-icons">shopping_cart</i><span>Add
                                                                to cart</span></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop