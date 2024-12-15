@extends("master.main")
@section("title", $product->name)
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
<style>
.product-tab-area .tab-content .reviews-tab .ttreview-tab .review-title .time:before {
    font-family: "Material Icons";
    content: "\e192";
    font-size: 17px;
    vertical-align: middle;
}
</style>
@stop

@section("main")

<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%;">
        <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Chi tiết sản phẩm</li>
    </ol>
</nav>
<div class="product-deatils-section float-left w-100">
    <div class="container">
        <div class="row">
            <div class="left-columm col-lg-5 col-md-5">
                <div class="product-large-image tab-content">
                    <div class="tab-pane active">
                        <div class="single-img img-full">
                            <a href="#"><img src="img/products/{{$product->image}}" class="zoomImg" alt=""></a>
                        </div>
                    </div>
                </div>
                <div class="default small-image-list float-left w-100">
                    <div class="nav-add owl-carousel">
                        @foreach($product->images as $img)
                        <div class="single-small-image img-full">
                            <a href="#" class="img"><img src="img/products/{{$img->image}}" class="img-mini" alt=""></a>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="right-columm col-lg-7 col-md-7">
                <div class="product-information">
                    <h4 class="product-title text-capitalize float-left w-100"><a href="product-details.html"
                            class="float-left w-100">{{$product->name}}</a></h4>
                    <div class="description">{{$product->short_description}}</div>
                    <div class="rating">
                        <div class="product-ratings d-inline-block align-middle">
                            @for($x = 1; $x <= 5; $x++) @if($x <=average_rate($product->ratings)) <span
                                    class="fa fa-stack"><i class="material-icons">star</i></span>
                                @else
                                <span class="fa fa-stack"><i class="material-icons off">star</i></span>
                                @endif
                                @endfor
                        </div>
                        <a href="#product-tab2" class="review-down">(đánh giá của khách hàng)</a>

                    </div>

                    <div class="price float-left w-100 d-flex">
                        @if($product->discount > 0)
                        <div class="regular-price">
                            {{number_format($product->discount)}}đ
                        </div>
                        <div class="old-price">{{number_format($product->price)}}đ</div>
                        @else
                        <div class="regular-price">
                            {{number_format($product->price)}}đ
                        </div>
                        @endif
                    </div>
                    <form action="{{route("cart.add", $product->id)}}" method="POST">
                        @csrf
                        <div class="product-variants float-left w-100">
                            <div class="col-md-3 col-sm-6 col-xs-12 size-options d-flex align-items-center">
                                <h5>Size:</h5>
                                <select required class="form-control" name="product_detail_id">
                                    @foreach($product->sizes as $size)
                                    <option value="{{$size->id}}" data-quantity="{{$size->quantity}}">{{$size->size}}
                                    </option>
                                    @endforeach
                                </select>
                                @error("product_detail_id")
                                <small class="text-danger">* {{$message}}</small>
                                @enderror
                            </div>
                        </div>
                        <div class="btn-cart d-flex align-items-center float-left w-100">
                            <h5>Số lượng:</h5>
                            <input required name="quantity" value="1" min="1" type="number">
                            @error("quantity")
                            <small class="text-danger">* {{$message}}</small>
                            @enderror
                            <button type="submit" class="btn btn-primary btn-cart m-0"><i
                                    class="material-icons">shopping_cart</i> Thêm vào giỏ hàng</button>
                        </div>

                    </form>
                    <div class="float-left">
                        <h8>Kho hàng: <span id="current-size-quantity">{{$product->sizes->first()->quantity}}</span> sản
                            phẩm có sẵn</h8>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<div class="product-tab-area float-left w-100">
    <div class="container">
        <div class="tabs">
            <ul class="nav nav-tabs justify-content-start">
                <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#product-tab1" id="tab1">
                        <div class="tab-title">Mô tả</div>
                    </a></li>
                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#product-tab2" id="tab2">
                        <div class="tab-title">Đánh giá ({{$product->ratings->count()}})</div>
                    </a></li>
            </ul>
        </div>
        <div class="tab-content float-left w-100">
            <div class="tab-pane active" id="product-tab1" role="tabpanel" aria-labelledby="tab1">
                <div class="description">
                    {!! $product->description !!}
                </div>
            </div>
            <div class="tab-pane" id="product-tab2" role="tabpanel" aria-labelledby="tab2">
                <div class="reviews-tab  float-left w-100">
                    <div class="ttreview-tab float-left w-100 p-30">
                        @if($product->ratings->count() <= 0) <h2 class="mb-3">Chưa có đánh giá nào!</h2>
                            @else
                            <h2 class="mb-3">Các đánh giá của khách hàng</h2>
                            @foreach($product->ratings as $rate)
                            <div class="d-inline-block border border-warning rounded mb-2 p-2 w-100">
                                <div class="review-title float-left w-100 m-0"><span
                                        class="user">{{$rate->customer->name}}</span> <span
                                        class="date">{{ $rate->created_at->format("d-m-Y") }}</span>
                                    <span class="time">{{ $rate->created_at->format("H:i") }}</span>
                                </div>
                                <div class="rating float-left w-100">
                                    <div class="product-ratings d-inline-block align-middle">
                                        @for($x = 1; $x <= 5; $x++) @if($x <=$rate->rating)
                                            <span class="fa fa-stack"><i class="material-icons">star</i></span>
                                            @else
                                            <span class="fa fa-stack"><i class="material-icons off">star</i></span>
                                            @endif
                                            @endfor
                                    </div>
                                </div>
                                <div class="review-desc float-left w-100 text-justify">{{$rate->comment}}</div>
                            </div>
                            @endforeach
                            @endif
                    </div>
                    <form action="{{route('account.rating', $product->id)}}" class="rating-form float-left w-100"
                        method="post">
                        @csrf
                        <h5>Thêm đánh giá của bạn</h5>
                        <div class="rating">
                            <div class='rating-stars text-left'>
                                <input required type="hidden" name="rating" id="rating" value="0">
                                <ul id='stars'>
                                    <li class='star' title='Tệ' data-value='1'>
                                        <i class="material-icons">star</i>
                                    </li>
                                    <li class='star' title='Tạm ổn' data-value='2'>
                                        <i class="material-icons">star</i>
                                    </li>
                                    <li class='star' title='Tốt' data-value='3'>
                                        <i class="material-icons">star</i>
                                    </li>
                                    <li class='star' title='Xuất sắc' data-value='4'>
                                        <i class="material-icons">star</i>
                                    </li>
                                    <li class='star' title='Tuyệt vời' data-value='5'>
                                        <i class="material-icons">star</i>
                                    </li>
                                </ul>
                            </div>
                            <div class='success-box'>
                                <div class='clearfix'></div>
                                <div class='text-message text-success'></div>
                                <div class='clearfix'></div>
                            </div>
                        </div>
                        <div class="row d-block">

                            <div class="col-sm-6 float-left form-group">
                                <label>Name <span class="required">*</span></label>
                                <input class="bg-secondary text-white" type="text"
                                    value="{{auth()->check() ? '@' . auth()->user()->name : 'Vui lòng đăng nhập!'}}"
                                    placeholder="" required="" disabled>
                            </div>
                            <div class="col-sm-6 float-left form-group">
                                <label>Email <span class="required">*</span></label>
                                <input class="bg-secondary text-white" type="email"
                                    value="{{auth()->check() ? auth()->user()->email : 'Vui lòng đăng nhập!'}}"
                                    placeholder="" id="r-email" required disabled>
                            </div>
                            <div class="col-sm-12 float-left form-group">
                                <label for="r-textarea">Đánh giá của bạn</label>
                                <textarea name="comment" id="r-textarea" cols="30" rows="10" class="w-100"></textarea>
                            </div>
                        </div>
                        <input type="submit" class="btn btn-primary submit" value="Gửi đánh giá">
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<div id="product-accessories" class="product-accessories my-40 w-100 float-left">
    <div class="container">
        <div class="row">
            <div class="tt-title d-inline-block float-none w-100 text-center">sản phẩm tương tự</div>
            <div class="product-accessories-content products grid owl-carousel">



                @foreach($list_recommend_product as $product)
                <div class="product-layouts">
                    <div class="product-thumb">
                        <div class="image zoom">
                            <a href="{{route("home.showProductDetail", $product->id)}}">
                                <img src="img/products/{{$product->image}}" alt="02" height="501" width="385" />

                                <img src="img/products/{{$product->image}}" alt="03" class="second_image img-responsive"
                                    height="501" width="385" /></a>
                        </div>
                        <div class="thumb-description">
                            <div class="caption">
                                <h4 class="product-title text-capitalize"><a
                                        href="{{route("home.showProductDetail", $product->id)}}">{{$product->name}}</a>
                                </h4>
                            </div>
                            <div class="rating">
                                <div class="product-ratings d-inline-block align-middle">
                                    @for($x = 1; $x <= 5; $x++) @if($x <=average_rate($product->ratings)) <span
                                            class="fa fa-stack"><i class="material-icons">star</i></span>
                                        @else
                                        <span class="fa fa-stack"><i class="material-icons off">star</i></span>
                                        @endif
                                        @endfor
                                </div>
                            </div>
                            <div class="price">
                                @if($product->discount > 0)
                                <div class="regular-price">
                                    {{number_format($product->discount)}}đ
                                </div>
                                <div class="old-price">{{number_format($product->price)}}đ</div>
                                @else
                                <div class="regular-price">
                                    {{number_format($product->price)}}đ
                                </div>
                                @endif
                            </div>
                            <div class="button-wrapper">
                                <div class="button-group text-center">
                                    <a href='{{route("home.showProductDetail", $product->id)}}'
                                        class="btn btn-primary btn-cart"><i
                                            class="material-icons">shopping_cart</i><span>Add
                                            to cart</span></a>
                                    @if(auth()->check())
                                    <a href='{{route("home.favorite", $product->id)}}'
                                        class="btn btn-primary btn-wishlist {{($product->favorited == true) ? 'wishlist-active' : ''}}"><i
                                            class="material-icons">favorite</i><span>wishlist</span></a>
                                    @endif
                                    <a href="{{route("home.showProductDetail", $product->id)}}"
                                        class="btn btn-primary btn-quickview"><i
                                            class="material-icons">visibility</i><span>Quick
                                            View</span></a>
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


@stop

@section("js")
<script>
$(".img-mini").click(function(e) {
    e.preventDefault();
    var _url = $(this).attr("src");
    $(".zoomImg").attr("src", _url);
});

$(document).ready(function() {
    $('select[name="product_detail_id"]').on('change', function() {
        var selectedSize = $(this).val(); // Lấy giá trị của size được chọn
        var quantity = $(this).find('option:selected').data(
            'quantity'); // Lấy số lượng tồn kho tương ứng với size được chọn
        $('#current-size-quantity').text(quantity); // Hiển thị số lượng tồn kho của size được chọn
    });
});

$(".star").click(function(e) {
    e.preventDefault();
    var rate = $(this).attr("data-value");
    $("#rating").val(rate);
});
</script>



@stop