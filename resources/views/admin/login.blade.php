<!DOCTYPE html>
<html lang="en">

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Trang Quản Trị - Đăng Nhập</title>

    <link rel="shortcut icon" href="img/logos/{{$web_logo->image}}" type="image/x-icon">

    <!-- Custom fonts for this template-->
    <link href="{{asset('admin_assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('admin_assets/css/sb-admin-2.min.css')}}" rel="stylesheet">
    <link href="{{asset('admin_assets/css/styles.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                @if(Session::has('error'))
                <div class="alert alert-danger mt-4" id="login-err-msg">
                    {{Session::get("error")}}
                </div>
                @endif

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row  p-5">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image bg-login-image-fixstyle"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form action="" method="POST" class="user">
                                        @csrf
                                        <div class="form-group">
                                            <input required type="email" class="form-control form-control-user"
                                                name="email" aria-describedby="emailHelp" placeholder="Email...">
                                            @error('email') <small class="text-danger">* {{ $message }}</small>
                                            @enderror
                                        </div>
                                        <div class="form-group">
                                            <div class="position-relative">
                                                <input required type="password"
                                                    class="form-control form-control-user inputPass" name="password"
                                                    placeholder="Mật khẩu...">
                                                <i style="top: 16px; right: 20px;"
                                                    class="position-absolute iconShowHidePass fa fa-eye-slash"></i>
                                                @error('password') <small class="text-danger">* {{ $message }}</small>
                                                @enderror
                                            </div>
                                        </div>

                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Đăng nhập
                                        </button>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="">Quên mật khẩu?</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('admin_assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('admin_assets/js/sb-admin-2.min.js')}}"></script>

    <script>
    $(document).ready(function() {
        $(".iconShowHidePass").click(function(e) {
            e.preventDefault();
            var inputPass = $(this).closest(".position-relative").find(".inputPass");
            var icon = $(this);

            if (inputPass.attr("type") === "password") {
                inputPass.attr("type", "text");
                icon.removeClass("fa-eye-slash").addClass("fa-eye");
            } else {
                inputPass.attr("type", "password");
                icon.removeClass("fa-eye").addClass("fa-eye-slash");
            }
        });
    });
    </script>

</body>

</html>