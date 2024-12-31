@extends("master.main")
@section("title", "Danh sách yêu thích")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
@stop

@section("main")


<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%;  background-repeat: no-repeat; background-size: cover;">
        <li class="breadcrumb-item"><a href="{{route("home.index")}}">Trang chủ</a></li>
        <li class="breadcrumb-item active" aria-current="page">Danh sách yêu thích</li>
    </ol>
</nav>

<div class="cart-area table-area pt-110 pb-95 float-left w-100">
    <div class="container">
        <div class=" cart-wrapper float-left w-100">
            <div class="table-responsive">
                <table class="table product-table text-center">
                    <thead>
                        <tr>
                            <th class="table-remove text-uppercase">Xóa</th>
                            <th class="table-image text-uppercase">Hình ảnh</th>
                            <th class="table-p-name text-uppercase">sản phẩm</th>
                            <th class="table-p-price text-uppercase">Giá</th>
                            <th class="table-p-qty text-uppercase">Tồn kho</th>
                            <th class="table-total text-uppercase">Thêm vào giỏ hàng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($favorites as $favorite)
                        <tr>
                            <td class="table-remove"><a href="{{route("home.favorite", $favorite->product_id)}}"><i
                                        class="material-icons">delete</i></a></td>
                            <td class="table-image"><a
                                    href="{{route('home.showProductDetail', $favorite->product_id)}}"><img
                                        src="img/products/{{$favorite->product->image}}" alt=""></a></td>
                            <td class="table-p-name text-capitalize"><a
                                    href="{{route('home.showProductDetail', $favorite->product_id)}}">{{$favorite->product->name}}</a>
                            </td>
                            <td class="table-p-price">
                                <p>{{number_format(($favorite->product->discount > 0) ? $favorite->product->discount : $favorite->product->price)}}đ
                                </p>
                            </td>
                            <td class="table-p-qty">{{$favorite->product->quantity}}</td>
                            <td class="table-addtocart"><a
                                    href="{{route("home.showProductDetail", $favorite->product_id)}}"
                                    class="btn-primary btn">thêm vào giỏ hàng</a>
                            </td>
                        </tr>
                        @endforeach

                    </tbody>
                </table>
                @if($favorites->count() <= 0) <p class="lead text-center"> <em>Danh sách yêu thích trống!</em></p>
                    @endif
            </div>
        </div>
    </div>

</div>




@stop
