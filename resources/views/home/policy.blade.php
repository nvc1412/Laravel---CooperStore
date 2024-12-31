@extends("master.main")
@section("title", "Chính sách")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
<style>
.introduce h1 {
    text-align: center;
    margin-top: 0px;
    color: #ff4900;
}

.introduce p {
    font-size: 20px;
    font-family: 'Quicksand', sans-serif;
    text-align: justify;
    text-indent: 50px;
    line-height: 1.3;
}

.introduce h3 {
    text-align: center;
    margin: 50px 0;
    font-weight: 400;
    text-shadow: 1px 1px red;
}

.introduce h4 {
    text-indent: 30px;
    margin: 20px 0;
}

@media (max-width: 767px) {
    .introduce {
        padding-right: 15px;
    }
}
</style>
@stop

@section("main")

<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%; background-repeat: no-repeat; background-size: cover;">
        <li class="breadcrumb-item"><a href="{{route("home.index")}}">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Thông tin tài khoản</li>
    </ol>
</nav>
<div class="main-content w-100 float-left blog-list">
    <div class="container">
        <div class="row">

            <div class="products-grid col-xl-9 col-lg-8 order-lg-2 introduce">

                <h1>Hướng Dẫn Đặt hàng</h1>

                <p>Quý Khách hàng có thể chọn một trong hai cách sau:</p>
                <p><b>Cách thứ nhất:</b> Gọi điện thoại đến số hotline nhân viên của công ty sẽ tư vấn và hỗ
                    trợ cho
                    khách hàng tất cả các thông tin về sản phẩm và dịch vụ..</p>
                <p><b>Cách thứ hai:</b> Đặt hàng qua website:<br>
                    Bước 1: Bấm vào nút “mua hàng” để đưa sản phẩm vào giỏ hàng sau khi đã lựa chọn sản phẩm
                    mình muốn
                    mua.<br>
                    Bước 2: Sau khi chọn xong sản phẩm đặt mua, điền các thông tin theo yêu cầu của chúng
                    tôi: size, màu
                    sắc, số lượng ….<br>
                    Bước 3: Bấm nút “Gửi”.<br>
                    Đơn hàng của bạn đã hoàn tất và được chuyển tới chúng tôi. Chúng tôi sẽ xử lý và liên
                    lạc lại với
                    bạn để thực hiện giao dịch.
                </p>


                <h1>Chính sách bảo mật</h1>

                <p><b>MỤC ĐÍCH VÀ PHẠM VI THU THẬP</b></p>
                <p>Việc thu thập dữ liệu chủ yếu trên website bao gồm: họ tên, email, điện thoại, địa chỉ
                    khách hàng
                    trong mục liên hệ. Đây là các thông tin mà chúng tôi cần thành viên cung cấp bắt buộc
                    khi gửi thông
                    tin nhờ tư vấn hay muốn mua sản phẩm và để chúng tôi liên hệ xác nhận lại với khách hàng
                    trên
                    website nhằm đảm bảo quyền lợi cho cho người tiêu dùng.</p>
                <p>Các thành viên sẽ tự chịu trách nhiệm về bảo mật và lưu giữ mọi hoạt động sử dụng dịch vụ
                    dưới thông
                    tin mà mình cung cấp và hộp thư điện tử của mình. Ngoài ra, thành viên có trách nhiệm
                    thông báo kịp
                    thời cho webiste chúng tôi về những hành vi sử dụng trái phép, lạm dụng, vi phạm bảo
                    mật, lưu giữ
                    tên đăng ký và mật khẩu của bên thứ ba để có biện pháp giải quyết phù hợp.</p>

                <p><b>PHẠM VI SỬ DỤNG THÔNG TIN</b></p>
                <p>Chúng tôi sử dụng thông tin thành viên cung cấp để:<br>
                    &bull; Liên hệ xác nhận đơn hàng và giao hàng cho thành viên khi nhận được yêu cầu từ
                    thành
                    viên;<br>
                    &bull; Cung cấp thông tin về sản phẩm đến khách hàng nếu có yêu cầu từ khách hàng;<br>
                    &bull; Gửi email tiếp thị, khuyến mại về hàng hóa do chúng tôi bán;<br>
                    &bull; Gửi các thông báo về các hoạt động trên website<br>
                    &bull; Liên lạc và giải quyết với người dùng trong những trường hợp đặc biệt;<br>
                    &bull; Không sử dụng thông tin cá nhân của người dùng ngoài mục đích xác nhận và liên hệ
                    có liên
                    quan đến giao dịch</p>
                <p>Khi có yêu cầu của cơ quan tư pháp bao gồm: Viện kiểm sát, tòa án, cơ quan công an điều
                    tra liên quan
                    đến hành vi vi phạm pháp luật nào đó của khách hàng.</p>


                <h1>Chính sách vận chuyển</h1>
                <p>Thông thường sau khi nhận được thông tin đặt hàng chúng tôi sẽ xử lý đơn hàng trong vòng
                    24h và phản
                    hồi lại thông tin cho khách hàng về việc thanh toán và giao nhận. Thời gian giao hàng
                    thường trong
                    khoảng từ 3-5 ngày kể từ ngày chốt đơn hàng hoặc theo thỏa thuận với khách khi đặt hàng.
                    Tuy nhiên,
                    cũng có trường hợp việc giao hàng kéo dài hơn nhưng chỉ xảy ra trong những tình huống
                    bất khả kháng
                    như sau:<br>
                    &bull; Nhân viên công ty sẽ liên lạc với khách hàng qua điện thoại không được nên không
                    thể giao
                    hàng.<br>
                    &bull; Địa chỉ giao hàng bạn cung cấp không chính xác hoặc khó tìm.<br>
                    &bull; Số lượng đơn hàng của công ty tăng đột biến khiến việc xử lý đơn hàng bị
                    chậm.<br>
                    &bull; Đối tác cung cấp nguyên liệu cho công ty chậm hơn dự kiến khiến việc giao hàng bị
                    chậm lại
                    hoặc đối tác vận chuyển giao hàng bị chậm chỉ vận chuyển phân phối cho đại lý hoặc khách
                    hàng có nhu
                    cầu lớn, lâu dài. Vì thế công ty đa phần sẽ hỗ trợ chi phí vận chuyển như một cách chăm
                    sóc đại lý
                    của mình. Đối với khách lẻ nếu có nhu cầu sử dụng lớn vui lòng liên hệ trực tiếp để thỏa
                    thuận hợp
                    đồng cũng như phí vận chuyển.
                </p>

                <h1>Hình thức thanh toán</h1>
                <p>Các hình thức thanh toán:<br>
                    &bull; Thanh toán trực tiếp tiền mặt khi nhận hàng<br>
                    &bull; Thanh toán bằng hình thức chuyển khoản<br>
                    &bull; Thanh toán qua các cổng thanh toán Online<br>
                </p>
                <p><b>Lưu ý:</b> Nội dung chuyển khoản ghi rõ họ tên hoăc công ty và chuyển cho đơn hàng
                    nào. Sau khi
                    chuyển khoản, chúng tôi sẽ liên hệ xác nhận và tiến hành giao hàng. Nếu sau thời gian
                    thỏa thuận mà
                    chúng tôi không giao hàng hoặc không phản hồi lại, quý khách có thể gửi khiếu nại trực
                    tiếp về công
                    ty và yêu cầu bồi thường nếu chứng minh được sự chậm trễ làm ảnh hưởng đến kinh doanh
                    của quý khách.
                </p>
                <p>Đối với khách hàng có nhu cầu mua số lượng lớn để kinh doanh hoặc buôn sỉ vui lòng liên
                    hệ trực tiếp
                    với chúng tôi để có chính sách giá cả hợp lý. Và việc thanh toán sẽ được thực hiện theo
                    hợp đồng.
                </p>


                <h3>CHÚNG TÔI CAM KẾT KINH DOANH MINH BẠCH, HỢP PHÁP, BÁN HÀNG CHẤT LƯỢNG, CÓ NGUỒN GỐC RÕ
                    RÀNG.</h3>


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
                                                        @for($x = 1; $x <= 5; $x++) @if( $x <=average_rate($pro->
                                                            ratings)
                                                            )
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