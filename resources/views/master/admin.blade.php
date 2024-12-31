<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>@yield("title")</title>

    <link rel="shortcut icon" href="img/logos/{{$web_logo->image}}" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="admin_assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="admin_assets/css/sb-admin-2.min.css" rel="stylesheet">
    <link href="admin_assets/css/styles.css" rel="stylesheet">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.css" />
    @yield("css")

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style="background-color: #2a4050;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route("admin.index")}}">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-home"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Trang Chủ</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Báo cáo thống kê -->
            <li class="nav-item @yield('dashboard')">
                <a class="nav-link" href="{{route("admin.index")}}">
                    <i class="fas fa-fw fa-chart-bar"></i>
                    <span>BÁO CÁO - THỐNG KÊ</span></a>
            </li>
            <hr class="sidebar-divider">

            <!-- Danh mục -->
            <li class="nav-item @yield('category')">
                <a class="nav-link" href="{{route("category.index")}}">
                    <i class="fas fa-fw fa-th-list"></i>
                    <span>DANH MỤC</span></a>
            </li>
            <hr class="sidebar-divider">

            <!-- Sản phẩm -->
            <li class="nav-item @yield('product')">
                <a class="nav-link" href="{{route("product.index")}}">
                    <i class="fas fa-fw fa-tshirt"></i>
                    <span>SẢN PHẨM</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Đơn hàng -->
            <li class="nav-item @yield('bill')">
                <a class="nav-link collapsed" href="{{route("bill.index")}}" data-toggle="collapse"
                    data-target="#collapsePagesBill" aria-expanded="true" aria-controls="collapsePagesBill">
                    <i class="fas fa-fw fa-credit-card"></i>
                    <span>ĐƠN HÀNG</span></a>
                <div id="collapsePagesBill" class="collapse" aria-labelledby="headingPages"
                    data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item @yield('listBill')" href="{{route("bill.index")}}">TẤT CẢ ĐƠN HÀNG</a>
                        <a class="collapse-item @yield('preparingBill')" href="{{route('bill.preparing')}}">CHƯA ĐƯỢC
                            IN</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">


            <!-- Đánh giá -->
            <li class="nav-item @yield('rate')">
                <a class="nav-link" href="{{route("rating.index")}}">
                    <i class="fas fa-fw fa-comment-alt"></i>
                    <span>ĐÁNH GIÁ</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Tài khoản -->
            <li class="nav-item @yield('accountAD')">
                <a class="nav-link" href="{{route("accountAD.index")}}">
                    <i class="fas fa-fw fa-user-cog"></i>
                    <span>TÀI KHOẢN</span></a>
            </li>
            <hr class="sidebar-divider d-none d-md-block">

            <!-- Cấu hình -->
            <li class="nav-item @yield('setting')">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                    aria-expanded="true" aria-controls="collapsePages">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>CẤU HÌNH</span></a>
                <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <a class="collapse-item @yield('banner')" href="{{route("banner.index")}}">BANNER</a>
                        <a class="collapse-item @yield('logo')" href="{{route("logo.index")}}">LOGO</a>
                    </div>
                </div>
            </li>
            <hr class="sidebar-divider d-none d-md-block">


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form
                        class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Tìm kiếm..."
                                aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Tìm kiếm..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span
                                    class="mr-2 d-none d-lg-inline text-gray-600 small">{{auth()->user()->name}}</span>
                                <img class="img-profile rounded-circle" src="admin_assets/img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Đăng xuất
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    @yield("main")

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Cooper Store 2024</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Bạn muốn đăng xuất?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Vui lòng xác nhận lựa chọn.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Trở về</button>
                    <a class="btn btn-primary" href="{{route("admin.logout")}}">Đăng Xuất</a>
                </div>
            </div>
        </div>
    </div>

    <script src="admin_assets/vendor/jquery/jquery.min.js"></script>
    <script src="admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="admin_assets/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="admin_assets/js/sb-admin-2.min.js"></script>
    <script src="admin_assets/js/scripts.js"></script>
    @yield("js")
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-toast-plugin/1.3.2/jquery.toast.min.js"></script>

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
