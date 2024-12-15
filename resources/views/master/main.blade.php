<!doctype html>
<html lang="en">

<head>
    <base href="/">
    <title>@yield("title")</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Demo powered by Templatetrip">
    <meta name="author" content="">
    <!-- <link rel="shortcut icon" type="image/x-icon" href="img/favicon.ico"> -->
    <link rel="shortcut icon" href="img/logos/{{$web_logo->image}}" type="image/x-icon">
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,900" rel="stylesheet">

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Bootstrap core CSS -->
    <link href="css/styles.css" rel="stylesheet">
    <link href="css/animate.css" rel="stylesheet">
    <link href="css/owl-carousel.css" rel="stylesheet">
    <link href="css/lightbox.css" rel="stylesheet">
    <link href="css/jquery-ui.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />

    <!-- Custom styles for this template -->
    @yield("css")

</head>


<body class="index layout1">

    <header class="header-area header-sticky text-center header-default">
        <div class="header-main-sticky">
            <div class="header-nav">
                <div class="container">
                    <div class="nav-left float-left">
                        <div class="ttheader-service">Mua sắm trực tuyến với các ưu đãi hấp dẫn!</div>
                    </div>
                    <div class="nav-right float-right d-flex">
                        <div class="ttheader-mail"><a href="mailto:nvc14122002@gmail.com">cooperstore@gmail.com</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-main-head">

                <div class="header-main">
                    <div class="container">
                        <div class="header-left float-left d-flex d-lg-flex d-md-block d-xs-block">
                            <div class="contact">
                                <i class="material-icons">shop</i>
                                <a href="https://shopee.vn/cooperstore.vn" target="_blank">Shopee</a>
                            </div>
                            <div class="contact">
                                <i class="material-icons">tiktok</i>
                                <a href="https://www.tiktok.com/@cooperstore.vn" target="_blank">Tiktok</a>
                            </div>
                            <div class="contact">
                                <i class="material-icons">phone</i>
                                <a href="tel:+84365042941">0365042941</a>
                            </div>
                        </div>
                        <div class="header-middle float-lg-left float-md-left float-sm-left float-xs-none">
                            <div class="logo">
                                <a href="{{$header_logo->link}}"><img src="img/logos/{{$header_logo->image}}" alt="logo"
                                        width="200" height="50"></a>
                            </div>
                        </div>
                        <div class="header-right d-flex d-xs-flex d-sm-flex justify-content-end float-right">
                            <div class="search-wrapper">
                                <a>
                                    <i class="material-icons search">search</i>
                                    <i class="material-icons close">close</i> </a>
                                <form autocomplete="off" action="/action_page.php" class="search-form">
                                    <div class="autocomplete">
                                        <input id="myInput" type="text" name="myCountry" placeholder="Search here">
                                        <button type="button"><i class="material-icons">search</i></button>
                                    </div>
                                </form>
                            </div>
                            <div class="user-info">
                                <button type="button" class="btn">
                                    <i class="material-icons">perm_identity</i> </button>
                                <div id="user-dropdown" class="user-menu">
                                    <ul>
                                        @if(auth()->check())
                                        <li><a href="{{route("account.profile")}}" class="button">Thông tin tài
                                                khoản</a></li>
                                        <li><a href="{{route("account.showFavorite")}}" class="button">Danh sách yêu
                                                thích</a></li>
                                        <li><a href="{{route("account.showHistory")}}" class="button">Lịch sử mua
                                                hàng</a></li>
                                        <li><a href="{{route("account.logout")}}" class="button">Đăng xuất</a></li>
                                        @else
                                        <li><a href="#" class="modal-view button" data-toggle="modal"
                                                data-target="#modalLoginForm">Đăng nhập</a></li>
                                        <li><a href="#" class="modal-view button" data-toggle="modal"
                                                data-target="#modalRegisterForm">Đăng ký</a></li>
                                        @endif

                                    </ul>
                                </div>
                            </div>
                            <div class="cart-wrapper">
                                <button type="button" class="btn">
                                    <i class="material-icons">shopping_cart</i>
                                    @if($carts->sum('quantity') > 0)
                                    <span class="ttcount">{{$carts->sum('quantity')}}</span>
                                    @endif
                                </button>
                                <div id="cart-dropdown" class="cart-menu">
                                    <ul class="w-100 float-left">
                                        @if($carts->count() <= 0) <div class="text-center">
                                            <img width="90px" class="mr-4" src="img/logos/cart_empty_header.png"
                                                alt="giỏ hàng trống">
                                            <p class="mt-4"> <em>Chưa có sản phẩm nào trong giỏ hàng!</em>
                                            </p>
                                </div>

                                @else
                                <li>
                                    <div class="scrollable-table-container">
                                        <table class="table table-striped scrollable-table">
                                            <tbody>
                                                @php
                                                $totalPrice = 0;
                                                @endphp
                                                @foreach($carts as $cart)
                                                <tr>
                                                    <td class="text-center"><a
                                                            href="{{route("home.showProductDetail", $cart->product_id)}}"><img
                                                                src="img/products/{{$cart->product->image}}" alt="01"
                                                                title="01" height="104" width="80"></a>
                                                    </td>
                                                    <td class="text-left product-name"><a
                                                            href="{{route("home.showProductDetail", $cart->product_id)}}">{{$cart->product->name}}</a>
                                                        <div class="quantity float-left w-100">
                                                            <span class="cart-qty">{{$cart->quantity}} × </span>
                                                            <span class="text-left price">
                                                                {{number_format($cart->price)}}đ</span>
                                                        </div>
                                                    </td>
                                                    <td class="text-center close"><a
                                                            href="{{route("cart.delete", [$cart->product_id, $cart->product_detail_id])}}"
                                                            class="close-cart"><i class="material-icons">close</i></a>
                                                    </td>
                                                </tr>
                                                @php
                                                $totalPrice += $cart->price * $cart->quantity
                                                @endphp
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </li>

                                <li>
                                    <table class="table price mb-30">
                                        <tbody>
                                            <tr>
                                                <td class="text-left"><strong>Tạm tính</strong></td>
                                                <td class="text-right text-success">
                                                    <strong>{{number_format($totalPrice)}}đ</strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </li>
                                <li class="buttons w-100 float-left d-flex">
                                    <a href="{{route('cart.index')}}"
                                        class="btn pull-left mt_10 btn-primary btn-rounded w-100 mr-1">Giỏ hàng</a>
                                    <a href="{{route('checkout.index')}}"
                                        class="btn pull-right mt_10 btn-primary btn-rounded w-100 ml-1">Thanh toán</a>
                                </li>
                                @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="menu">
                <div class="container">
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light d-sm-none d-xs-none d-lg-block navbar-full">

                        <!-- Navbar brand -->
                        <a class="navbar-brand text-uppercase d-none" href="#">Navbar</a>

                        <!-- Collapse button -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>

                        <!-- Collapsible content -->
                        <div class="collapse navbar-collapse">

                            <!-- Links -->
                            <ul class="navbar-nav m-auto justify-content-center">
                                <li class="nav-item @yield('home-active')">
                                    <a class="nav-link text-uppercase" href="{{route("home.index")}}">
                                        Trang chủ
                                    </a>
                                </li>
                                <li class="nav-item dropdown @yield('category-active')">
                                    <a class="nav-link dropdown-toggle text-uppercase" href="#">
                                        Danh mục </a>
                                    <div class="dropdown-menu mega-menu v-2 z-depth-1 special-color py-3 px-3">
                                        <div class="sub-menu mb-xl-0 mb-4">
                                            <ul class="list-unstyled">
                                                @foreach($cats as $cat)
                                                <li>
                                                    <a class="menu-item pl-0"
                                                        href="{{route("home.category", $cat->id)}}">
                                                        {{$cat->name}}</a>
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                                <li class="nav-item @yield('shop-active')">
                                    <a class="nav-link text-uppercase" href="{{route("home.shop")}}">
                                        Cửa hàng </a>
                                </li>
                                <li class="nav-item @yield('pay-active')">
                                    <a class="nav-link text-uppercase" href="{{route('checkout.index')}}">Thanh
                                        toán</a>
                                </li>
                                <li class="nav-item @yield('contact-active')">
                                    <a class="nav-link text-uppercase" href="#">LIÊN HỆ</a>
                                </li>
                                <li class="nav-item @yield('policy-active')">
                                    <a class="nav-link text-uppercase" href="#">CHÍNH SÁCH</a>
                                </li>

                            </ul>
                            <!-- Links -->
                        </div>
                        <!-- Collapsible content -->

                    </nav>
                    <!-- Navbar -->
                    <nav class="navbar navbar-expand-lg navbar-light d-lg-none navbar-responsive">

                        <!-- Navbar brand -->
                        <a class="navbar-brand text-uppercase d-none" href="#">Navbar</a>

                        <!-- Collapse button -->
                        <button class="navbar-toggler" type="button" data-toggle="collapse"
                            data-target="#navbarSupportedContent2" aria-controls="navbarSupportedContent2"
                            aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"><i class='material-icons'>sort</i></span>
                        </button>

                        <!-- Collapsible content -->
                        <div class="collapse navbar-collapse" id="navbarSupportedContent2">

                            <!-- Links -->
                            <ul class="navbar-nav m-auto justify-content-center">

                                <!-- Features -->
                                <li class="nav-item active">
                                    <a class="nav-link text-uppercase" href="#">
                                        Trang chủ </a>

                                </li>

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-uppercase" data-toggle="collapse"
                                        data-target="#menu2" aria-controls="menu2" aria-expanded="false"
                                        aria-label="Toggle navigation" href="#">
                                        Danh mục </a>
                                    <div class="dropdown-menu mega-menu v-2 z-depth-1 special-color py-3 px-3"
                                        id="menu2">
                                        <div class="sub-menu mb-xl-0 mb-4">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a class="menu-item pl-0" href="product-grid.html">
                                                        Áo polo </a>
                                                </li>
                                                <li>
                                                    <a class="menu-item pl-0" href="product-sticky-right.html">
                                                        Quần kaki </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>


                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" href="#">
                                        Cửa hàng </a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link text-uppercase" href="{{route('checkout.index')}}">Thanh toán</a>
                                </li>
                                <!-- Technology -->

                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle text-uppercase" data-toggle="collapse"
                                        data-target="#menu5" aria-controls="menu5" aria-expanded="false"
                                        aria-label="Toggle navigation" href="#">Hỗ trợ</a>
                                    <div class="dropdown-menu mega-menu v-2 z-depth-1 special-color py-3 px-3"
                                        id="menu5">
                                        <div class="sub-menu">
                                            <ul class="list-unstyled">
                                                <li>
                                                    <a class="menu-item pl-0" href="#">
                                                        Liên hệ </a>
                                                </li>
                                                <li>
                                                    <a class="menu-item pl-0" href="#">
                                                        Chính sách </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <!-- Links -->
                        </div>
                        <!-- Collapsible content -->

                    </nav>
                </div>
            </div>
        </div>
        </div>
    </header>


    @yield("main")



    <!-- Footer -->
    <div class="block-newsletter">
        <div class="parallax" data-source-url="img/banner/parallax.jpg"
            style="background-image:url(img/banner/parallax.jpg); background-position:50% 65.8718%;">
            <div class="container">
                <div class="tt-newsletter col-sm-7">
                    <h2 class="text-uppercase">Đăng kÝ nhận tin</h2>
                </div>
                <div class="block-content col-sm-5">
                    <form method="post" action="#">
                        <div class="input-group">
                            <input type="email" name="email" value="" placeholder="Nhập email.." required=""
                                class="form-control">
                            <span class="input-group-btn">
                                <button class="btn btn-theme text-uppercase btn-primary" type="submit">Đăng ký</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <footer class="page-footer font-small footer-default">
        <div class="container text-center text-md-left">
            <div class="row">
                <div class="col-md-2 footer-cms footer-column">
                    <div class="ttcmsfooter">
                        <div class="footer-logo"><img src="img/logos/{{$footer_logo->image}}" alt="footer-logo"
                                width="200" height="50"></div>
                        <div class="footer-desc">Hàng hiệu giá tốt</div>
                    </div>
                </div>
                <div class="col-md-2 footer-column">
                    <div class="title">
                        <a href="#company" class="font-weight-normal text-capitalize mb-10" data-toggle="collapse"
                            aria-expanded="false">Sản Phẩm</a>
                    </div>
                    <ul id="company" class="list-unstyled collapse">
                        <li>
                            <a href="#">Áo polo</a>
                        </li>
                        <li>
                            <a href="#">Quần kaki</a>
                        </li>
                    </ul>
                </div>
                <div class="col-md-2 footer-column">
                    <div class="title">
                        <a href="#products" class="font-weight-normal text-capitalize mb-10" data-toggle="collapse"
                            aria-expanded="false">Chính Sách</a>
                    </div>
                    <ul id="products" class="list-unstyled collapse">
                        <li>
                            <a href="#">Chính sách đổi trả</a>
                        </li>
                        <li>
                            <a href="#">Chính sách bảo mật</a>
                        </li>
                        <li>
                            <a href="#">Chính sách vận chuyển</a>
                        </li>
                    </ul>

                </div>
                <div class="col-md-2 footer-column">
                    <div class="title">
                        <a href="#account" class="font-weight-normal text-capitalize mb-10" data-toggle="collapse"
                            aria-expanded="false">Kết Nối</a>
                    </div>
                    <ul id="account" class="list-unstyled collapse">
                        <li class="links">
                            <span class="contact">
                                <span class="icon"><i class="material-icons">shop</i></span>
                                <span class="data"><a href="#">Shopee</a></span> </span>
                        </li>
                        <li class="links">
                            <span class="contact">
                                <span class="icon"><i class="material-icons">tiktok</i></span>
                                <span class="data"><a href="#">Tiktok</a></span> </span>
                        </li>
                        <li class="links">
                            <span class="contact">
                                <span class="icon"><i class="material-icons">facebook</i></span>
                                <span class="data"><a href="#">FaceBook</a></span>
                            </span>
                        </li>
                    </ul>

                </div>
                <div class="col-md-2 footer-column">
                    <div class="title">
                        <a href="#information" class="font-weight-normal text-capitalize mb-10" data-toggle="collapse"
                            aria-expanded="false">Thông tin cửa hàng</a>
                    </div>
                    <ul id="information" class="list-unstyled collapse">
                        <li class="contact-detail links">
                            <span class="address">
                                <span class="icon"><i class="material-icons">location_on</i></span>
                                <span class="data"> 235 Hoàng Quốc Việt, Cổ Nhuế, Bắc Từ Liêm, Hà Nội</span> </span>
                        </li>
                        <li class="links">
                            <span class="contact">
                                <span class="icon"><i class="material-icons">phone</i></span>
                                <span class="data"><a href="tel:0365042941">+ (84) 36-5042-941</a></span> </span>
                        </li>
                        <li class="links">
                            <span class="email">
                                <span class="icon"><i class="material-icons">email</i></span>
                                <span class="data"><a
                                        href="mailto:nvc14122002@gmail.com">cooperstore@gmail.com</a></span>
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Copyright -->
        <div class="footer-bottom-wrap">
            <div class="container">
                <div class="row">
                    <div class="footer-copyright text-center py-3">
                        © 2024 by CooperStore
                    </div>
                </div>
            </div>
        </div>
        <a href="#" id="goToTop" title="Back to top" class="btn-primary"><i
                class="material-icons arrow-up">keyboard_arrow_up</i></a>


    </footer>
    <!-- Footer -->



    @if(auth()->check())
    @else
    <!-- ĐĂNG KÝ -->
    <div class="modal fade" id="modalRegisterForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-medium text-left">Đăng ký tài khoản</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route("account.register") }}" method="POST">
                    @csrf
                    <div class="modal-body mx-3">
                        <div class="md-form mb-4">
                            <input required type="text" id="RegisterForm-name" class="form-control validate" name="name"
                                placeholder="Nickname">
                            @error('name') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="md-form mb-4">
                            <input required type="email" id="RegisterForm-email" class="form-control validate"
                                name="email" placeholder="Email">
                            @error('email') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="md-form mb-4 position-relative">
                            <input required type="password" id="RegisterForm-pass" name="password"
                                class="form-control validate inputPass" placeholder="Mật khẩu">
                            <i style="top: 7px; right: 10px; cursor: pointer;"
                                class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                            @error('password') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="md-form mb-4 position-relative">
                            <input required type="password" id="RegisterForm-cfpass" name="cf_password"
                                class="form-control validate inputPass" placeholder="Nhập lại mật khẩu">
                            <i style="top: 7px; right: 10px; cursor: pointer;"
                                class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                            @error('cf_password') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="checkbox-link d-flex justify-content-between">
                            <div class="left-col"><a href="#" class="modal-view button" data-toggle="modal"
                                    data-target="#modalLoginForm" data-dismiss="modal">Đăng nhập</a>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Đăng ký</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- ĐĂNG NHẬP -->
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-medium text-left">Đăng nhập</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route("account.login") }}" method="POST">
                    @csrf
                    <div class="modal-body mx-3">
                        <div class="md-form mb-4">
                            <input required type="text" id="LoginForm-name" name="email" class="form-control validate"
                                placeholder="Email">
                            @error('email') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="md-form mb-4 position-relative">
                            <input required type="password" id="LoginForm-pass" name="password"
                                class="form-control validate inputPass" placeholder="Mật khẩu">
                            <i style="top: 7px; right: 10px; cursor: pointer;"
                                class="position-absolute iconShowHidePass material-icons">visibility_off</i>
                            @error('password') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>
                        <div class="checkbox-link d-flex justify-content-between">
                            <div class="left-col"><a href="#" class="modal-view button" data-toggle="modal"
                                    data-target="#modalForgotPassForm" data-dismiss="modal">Quên mật khẩu?</a></div>
                            <div class="right-col"><a href="#" class="modal-view button" data-toggle="modal"
                                    data-target="#modalRegisterForm" data-dismiss="modal">Đăng ký</a></div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Đăng nhập</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <!--QUÊN MẬT KHẨU -->
    <div class="modal fade" id="modalForgotPassForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-medium text-left">Quên mật khẩu</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route("account.forgotPassword") }}" method="POST">
                    @csrf
                    <div class="modal-body mx-3">
                        <div class="md-form mb-4">
                            <input required type="text" id="ForgotPassForm-name" name="email"
                                class="form-control validate" placeholder="Nhập email để lấy lại mật khẩu">
                            @error('email') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                        </div>

                        <div class="checkbox-link d-flex justify-content-between">
                            <div class="left-col"><a href="#" class="modal-view button" data-toggle="modal"
                                    data-target="#modalLoginForm" data-dismiss="modal">Đăng nhập</a>
                            </div>
                            <div class="right-col"><a href="#" class="modal-view button" data-toggle="modal"
                                    data-target="#modalLoginForm" data-dismiss="modal">Đăng ký</a>
                            </div>
                        </div>

                        <div class="modal-footer d-flex justify-content-center">
                            <button type="submit" class="btn btn-primary">Đặt lại mật khẩu</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>



    @endif

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/owl.carousel.min.js"></script>
    <script src="js/custom.js"></script>
    <script src="js/parallax.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/lightbox-2.6.min.js"></script>
    <script src="js/ResizeSensor.min.js"></script>
    <script src="js/theia-sticky-sidebar.min.js"></script>
    <script src="js/inview.js"></script>
    <script src="js/cookiealert.js"></script>
    <script src="js/jquery.countdown.min.js"></script>
    <script src="js/masonry.pkgd.min.js"></script>
    <script src="js/imagesloaded.pkgd.min.js"></script>
    <script src="js/jquery.zoom.min.js"></script>
    <script src="js/jquery.lazy.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>
    @yield("js")

    <script>
    $(document).ready(function() {
        $(".iconShowHidePass").click(function(e) {
            e.preventDefault();
            var inputPass = $(this).closest(".position-relative").find(".inputPass");
            var icon = $(this);

            if (inputPass.attr("type") === "password") {
                inputPass.attr("type", "text");
                icon.text("visibility");
            } else {
                inputPass.attr("type", "password");
                icon.text("visibility_off");

            }
        });
    });
    </script>

    @if(Session::has('success'))
    <script>
    $.toast({
        heading: 'Thành công',
        text: '{{Session::get("success")}}',
        showHideTransition: 'slide',
        icon: 'success',
        position: "top-center",
        hideAfter: 6000
    })
    </script>
    @endif

    @if(Session::has('error'))
    <script>
    $.toast({
        heading: 'ERROR',
        text: '{{Session::get("error")}}',
        showHideTransition: 'slide',
        icon: 'error',
        position: "top-center",
        hideAfter: 6000
    })
    </script>
    @endif


</body>

</html>