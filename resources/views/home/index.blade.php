@extends("master.main")
@section("title", "Cooper Store")
@section("home-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
@stop

@section("main")

<main>

    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="slider-wrapper my-40 my-sm-25 float-left w-100">
        <div class="container">
            <div class="ttloading-bg"></div>
            <div class="slider slider-for owl-carousel">
                @foreach($list_banner["list_top_banner"] as $banner)
                <div>
                    <a href="{{$banner->link}}">
                        <img src="img/banner/{{$banner->image}}" alt="" height="800" width="1600" />
                    </a>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="main-content">

        <div id="main">
            <div id="hometab" class="home-tab my-40 my-sm-25 bottom-to-top hb-animate-element">
                <div class="container">
                    <div class="row">
                        <div class="tt-title d-inline-block float-none w-100 text-center">Sản Phẩm mới nhất</div>
                        <div class="tabs">
                            <ul class="nav nav-tabs justify-content-center">
                                <li class="nav-item"><a class="nav-link active" data-toggle="tab"
                                        href="#ttfeatured-main" id="featured-tab">
                                        <div class="tab-title">Quần</div>
                                    </a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ttnew-main"
                                        id="new-tab">
                                        <div class="tab-title">Áo</div>
                                    </a></li>
                                <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#ttbestseller-main"
                                        id="bestseller-tab">
                                        <div class="tab-title">Phụ kiện</div>
                                    </a></li>
                            </ul>
                        </div>
                        <div class="tab-content float-left w-100">
                            <div class="tab-pane active float-left w-100" id="ttfeatured-main" role="tabpanel"
                                aria-labelledby="featured-tab">
                                <section id="ttfeatured" class="ttfeatured-products">
                                    <div class="ttfeatured-content products grid owl-carousel" id="owl1">

                                        @foreach($list_new_product["new_product_pants"] as $product)
                                        <div class="product-layouts">
                                            <div class="product-thumb">
                                                <div class="image zoom">
                                                    <a href="{{route("home.showProductDetail", $product->id)}}">
                                                        <img src="img/products/{{$product->image}}" alt="02"
                                                            height="501" width="385" />

                                                        <img src="img/products/{{$product->image}}" alt="03"
                                                            class="second_image img-responsive" height="501"
                                                            width="385" />
                                                    </a>
                                                </div>
                                                <div class="thumb-description">
                                                    <div class="caption">
                                                        <h4 class="product-title text-capitalize"><a
                                                                href="{{route("home.showProductDetail", $product->id)}}">{{$product->name}}</a>
                                                        </h4>
                                                    </div>
                                                    <div class="rating">
                                                        <div class="product-ratings d-inline-block align-middle">
                                                            @for($x = 1; $x <= 5; $x++) @if( $x
                                                                <=average_rate($product->ratings)
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
                                </section>
                            </div>
                            <div class="tab-pane float-left w-100" id="ttnew-main" role="tabpanel"
                                aria-labelledby="new-tab">
                                <section id="ttnew" class="ttnew-products">
                                    <div class="ttnew-content products grid owl-carousel" id="owl2">



                                        @foreach($list_new_product["new_product_shirts"] as $product)
                                        <div class="product-layouts">
                                            <div class="product-thumb">
                                                <div class="image zoom">
                                                    <a href="{{route("home.showProductDetail", $product->id)}}">
                                                        <img src="img/products/{{$product->image}}" alt="02"
                                                            height="501" width="385" />

                                                        <img src="img/products/{{$product->image}}" alt="03"
                                                            class="second_image img-responsive" height="501"
                                                            width="385" /></a>
                                                </div>
                                                <div class="thumb-description">
                                                    <div class="caption">
                                                        <h4 class="product-title text-capitalize"><a
                                                                href='{{route("home.showProductDetail", $product->id)}}'>{{$product->name}}</a>
                                                        </h4>
                                                    </div>
                                                    <div class="rating">
                                                        <div class="product-ratings d-inline-block align-middle">
                                                            @for($x = 1; $x <= 5; $x++) @if( $x
                                                                <=average_rate($product->
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
                                </section>
                            </div>
                            <div class="tab-pane float-left w-100" id="ttbestseller-main" role="tabpanel"
                                aria-labelledby="bestseller-tab">
                                <section id="ttbestseller" class="ttbestseller-products">
                                    <div class="ttbestseller-content products grid owl-carousel" id="owl3">



                                        @foreach($list_new_product["new_product_accessories"] as $product)
                                        <div class="product-layouts">
                                            <div class="product-thumb">
                                                <div class="image zoom">
                                                    <a href="{{route("home.showProductDetail", $product->id)}}">
                                                        <img src="img/products/{{$product->image}}" alt="02"
                                                            height="501" width="385" />

                                                        <img src="img/products/{{$product->image}}" alt="03"
                                                            class="second_image img-responsive" height="501"
                                                            width="385" /></a>
                                                </div>
                                                <div class="thumb-description">
                                                    <div class="caption">
                                                        <h4 class="product-title text-capitalize"><a
                                                                href="{{route("home.showProductDetail", $product->id)}}">{{$product->name}}</a>
                                                        </h4>
                                                    </div>
                                                    <div class="rating">
                                                        <div class="product-ratings d-inline-block align-middle">
                                                            @for($x = 1; $x <= 5; $x++) @if( $x
                                                                <=average_rate($product->
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
                                                        @if($product->discount > 0)
                                                        <div class="regular-price">
                                                            {{number_format($product->discount)}}đ
                                                        </div>
                                                        <div class="old-price">{{number_format($product->price)}}đ
                                                        </div>
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
                                </section>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ttcmstestimonial" class="my-40 my-sm-25 bottom-to-top hb-animate-element">
                <div class="tttestimonial-content container">
                    <div class="tttestimonial-inner">
                        <div class="tttestimonial owl-carousel">
                            <div>
                                <div class="testimonial-block">
                                    <div class="testimonial-image"><img alt="" src="img/banner/gianni _versace.jpg"
                                            height="120" width="120" /></div>
                                    <div class="testimonial-content">
                                        <div class="testimonial-desc">
                                            <p>Đừng theo đuổi các xu hướng. Đừng để thời trang chiếm lấy bạn, mà hãy
                                                tự quyết định bạn là ai, bạn muốn thể hiện điều gì thông qua cách ăn
                                                mặc và cách sống của bạn.
                                            </p>
                                        </div>
                                        <div class="testimonial-user-title">
                                            <h4>Nazli dof</h4>
                                            <div class="user-designation">Nhà thiết kế thời trang</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div class="testimonial-block">
                                    <div class="testimonial-image"><img alt="" src="img/banner/vreeland_diana.jpg"
                                            height="120" width="120" /></div>
                                    <div class="testimonial-content">
                                        <div class="testimonial-desc">
                                            <p>Thời trang là một phần của không khí hàng ngày và nó luôn thay đổi,
                                                chuyển động cùng với mọi sự kiện diễn ra. Bạn thậm chí có thể nhận
                                                biết sự đến gần của một cuộc cách mạng trong trang phục. Bạn có thể
                                                nhìn và cảm nhận mọi điều thông qua trang phục.
                                            </p>
                                        </div>
                                        <div class="testimonial-user-title">
                                            <h4>Diana Vreeland</h4>
                                            <div class="user-designation">Biên tập viên thời trang</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="testimonial-block">
                                    <div class="testimonial-image"><img alt="" src="img/banner/rihanna.jpg" height="120"
                                            width="120" /></div>
                                    <div class="testimonial-content">
                                        <div class="testimonial-desc">
                                            <p>Cách tôi ăn mặc phụ thuộc vào cảm giác của tôi. Tôi không bao giờ
                                                phải chuẩn bị tinh thần. Thông thường nó chỉ cảm thấy như nó hoạt
                                                động.
                                            </p>
                                        </div>
                                        <div class="testimonial-user-title">
                                            <h4>Rihanna</h4>
                                            <div class="user-designation">Ca sĩ</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ttcmssubbanner" class="ttcmssubbanner my-40 my-sm-25 bottom-to-top hb-animate-element">
                <div class="ttbannerblock container">
                    <div class="row">
                        <div class="ttbanner1 ttbanner col-sm-6 col-xs-6">
                            <div class="ttbanner-img"><a href="#"><img src="img/banner/cms-03.jpg" alt="cms-03"
                                        height="600" width="400"></a></div>
                            <div class="ttbanner-inner">
                                <div class="ttbanner-desc text-center">
                                    <span class="title text-uppercase">Hiện đại</span>
                                    <span class="subtitle text-uppercase py-20">giảm đến 50%</span>
                                    <span class="shop-now text-capitalize"><a href="#" class="btn-primary">xem
                                            ngay</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="ttbanner2 ttbanner col-sm-6">
                            <div class="ttbanner-img"><a href="#"><img src="img/banner/cms-04.jpg" alt="cms-04"
                                        height="600" width="400"></a></div>
                            <div class="ttbanner-inner">
                                <div class="ttbanner-desc text-center">
                                    <span class="title text-uppercase">Lịch lãm</span>
                                    <span class="subtitle text-uppercase py-20">giảm đến 50%</span>
                                    <span class="shop-now text-capitalize"><a href="#" class="btn-primary">xem
                                            ngay</a></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="ttspecial" class="ttspecial my-40 bottom-to-top hb-animate-element">
                <div class="container">
                    <div class="row">
                        <div class="tt-title d-inline-block float-none w-100 text-center">Sản Phẩm thịnh hành</div>
                        <div class="ttspecial-content products grid owl-carousel">


                            @foreach($list_trending_product as $product)
                            <div class="product-layouts">
                                <div class="product-thumb">
                                    <div class="image zoom">
                                        <a href="{{route("home.showProductDetail", $product->id)}}">
                                            <img src="img/products/{{$product->image}}" alt="02" height="501"
                                                width="385" />

                                            <img src="img/products/{{$product->image}}" alt="03"
                                                class="second_image img-responsive" height="501" width="385" /></a>
                                    </div>
                                    <div class="thumb-description">
                                        <div class="caption">
                                            <h4 class="product-title text-capitalize"><a
                                                    href="{{route("home.showProductDetail", $product->id)}}">{{$product->name}}</a>
                                            </h4>
                                        </div>
                                        <div class="rating">
                                            <div class="product-ratings d-inline-block align-middle">
                                                @for($x = 1; $x <= 5; $x++) @if( $x <=average_rate($product->
                                                    ratings)
                                                    )
                                                    <span class="fa fa-stack"><i class="material-icons">star</i></span>
                                                    @else
                                                    <span class="fa fa-stack"><i
                                                            class="material-icons off">star</i></span>
                                                    @endif
                                                    @endfor
                                            </div>
                                        </div>
                                        <div class="price">
                                            @if($product->discount > 0)
                                            <div class="regular-price">
                                                {{number_format($product->discount)}}đ
                                            </div>
                                            <div class="old-price">{{number_format($product->price)}}đ
                                            </div>
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


            <!-- Main jumbotron for a primary marketing message or call to action -->
            <div class="slider-wrapper my-40 my-sm-25 float-left w-100">
                <div class="container">
                    <div class="ttloading-bg"></div>
                    <div class="slider slider-for owl-carousel">
                        @foreach($list_banner["list_bottom_banner"] as $banner)
                        <div>
                            <a href="{{$banner->link}}">
                                <img src="img/banner/{{$banner->image}}" alt="" height="800" width="1600" />
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>


            <div id="ttbrandlogo" class="my-40 my-sm-25 bottom-to-top hb-animate-element">
                <div class="container">
                    <div class="tt-brand owl-carousel">
                        <div class="item">
                            <a href="#"><img src="img/logos/brand-logo-01.png" alt="brand-logo-01" width="140"
                                    height="100"></a>
                        </div>
                        <div class="item">
                            <a href="#"><img src="img/logos/brand-logo-02.png" alt="brand-logo-02" width="140"
                                    height="100"></a>
                        </div>
                        <div class="item">
                            <a href="#"><img src="img/logos/brand-logo-03.png" alt="brand-logo-03" width="140"
                                    height="100"></a>
                        </div>
                        <div class="item">
                            <a href="#"><img src="img/logos/brand-logo-04.png" alt="brand-logo-04" width="140"
                                    height="100"></a>
                        </div>
                        <div class="item">
                            <a href="#"><img src="img/logos/brand-logo-05.png" alt="brand-logo-05" width="140"
                                    height="100"></a>
                        </div>
                        <div class="item">
                            <a href="#"><img src="img/logos/brand-logo-06.png" alt="brand-logo-06" width="140"
                                    height="100"></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</main>


@stop