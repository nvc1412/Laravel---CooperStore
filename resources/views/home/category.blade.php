@extends("master.main")
@section("title", "Danh mục - $category->name")
@section("category-active", "active")

@section("css")
<link rel="stylesheet" href="css/style_edit.css">
<style>
.slider {
    border: none;
    height: 5px;
    position: relative;
    background: #e5e5e5;
    border-radius: 25px;
    margin: 15px 0 0;
}

.slider .progress {
    height: 100%;
    left: 0%;
    right: 0%;
    position: absolute;
    border-radius: 5px;
    background: #000;
}

.range-input {
    position: relative;
}

.range-input input {
    position: absolute;
    width: 100%;
    height: 5px;
    top: -5px;
    background: none;
    pointer-events: none;
    -webkit-appearance: none;
    -moz-appearance: none;
}

input[type="range"]::-webkit-slider-thumb {
    height: 13px;
    width: 13px;
    border-radius: 50%;
    background: gray;
    pointer-events: auto;
    -webkit-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
}

input[type="range"]::-moz-range-thumb {
    height: 13px;
    width: 13px;
    border: none;
    border-radius: 50%;
    background: gray;
    pointer-events: auto;
    -moz-appearance: none;
    box-shadow: 0 0 6px rgba(0, 0, 0, 0.05);
}

/* Định dạng nút trượt cho WebKit (Chrome, Safari) */
input[type="range"]::-webkit-slider-thumb:active,
input[type="range"]::-webkit-slider-thumb:focus {
    background: black;
    /* Màu đen khi nhấn hoặc được focus */
}

/* Định dạng nút trượt cho Firefox */
input[type="range"]::-moz-range-thumb:active,
input[type="range"]::-moz-range-thumb:focus {
    background: black;
    /* Màu đen khi nhấn hoặc được focus */
}
</style>
@stop

@section("main")

<nav aria-label="breadcrumb" class="w-100 float-left">
    <ol class="breadcrumb parallax justify-content-center" data-source-url="img/banner/parallax.jpg"
        style="background-image: url(&quot;img/banner/parallax.jpg&quot;); background-position: 50% 0.809717%; background-repeat: no-repeat; background-size: cover;">
        <li class="breadcrumb-item"><a href="#">Danh mục</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{$category->name}}</li>
    </ol>
</nav>
<div class="main-content w-100 float-left">
    <div class="container">
        <div class="row">
            <div class="content-wrapper col-xl-9 col-lg-9 order-lg-2">
                <div class="block-category mb-30 w-100 float-left">
                    <div class="category-cover">
                        <img src="img/banner/category-banner.jpg" alt="category-banner" />
                    </div>
                </div>
                <header class="product-grid-header d-flex d-xs-block d-sm-flex d-lg-flex w-100 float-left">
                    <div
                        class="hidden-sm-down total-products d-flex d-xs-block d-lg-flex col-md-3 col-sm-3 col-xs-12 align-items-center">
                        <div class="row">
                            <div class="nav" role="tablist">
                                <a class="grid active" href="#grid" data-toggle="tab" role="tab" aria-selected="true"
                                    aria-controls="grid"><i class="material-icons align-middle">grid_on</i></a>
                                <a class="list" href="#list" data-toggle="tab" role="tab" aria-selected="false"
                                    aria-controls="list"><i
                                        class="material-icons align-middle">format_list_bulleted</i></a>

                            </div>
                        </div>
                    </div>
                    <div
                        class="shop-results-wrapper d-flex d-sm-flex d-xs-block d-lg-flex justify-content-end col-md-9 col-sm-9 col-xs-12">
                        <div class="shop-results d-flex align-items-center"><span>Hiển thị</span>
                            <div class="shop-select">
                                <form class="product-update-show" action="{{route("home.category", $category->id)}}"
                                    method="get">
                                    @if($sort != "default")
                                    <input type="hidden" name="sort" value="{{ $sort }}">
                                    @endif

                                    @if((int) $fromPrice != (int) $minPrice)
                                    <input type="hidden" name="fromPrice" value="{{ $fromPrice }}">
                                    @endif
                                    @if((int) $toPrice != (int) $maxPrice)
                                    <input type="hidden" name="toPrice" value="{{ $toPrice }}">
                                    @endif
                                    <select name="show" id="show">
                                        <option value="9" {{ $perPage == 9 ? 'selected' : '' }}>9</option>
                                        <option value="30" {{ $perPage == 30 ? 'selected' : '' }}>30</option>
                                        <option value="90" {{ $perPage == 90 ? 'selected' : '' }}>90</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                        <div class="shop-results d-flex align-items-center"><span>Sắp xếp theo</span>
                            <div class="shop-select">
                                <form class="product-update-sort" action="{{route("home.category", $category->id)}}"
                                    method="get">
                                    @if($perPage != "9")
                                    <input type="hidden" name="show" value="{{ $perPage }}">
                                    @endif
                                    @if($fromPrice != $minPrice)
                                    <input type="hidden" name="fromPrice" value="{{ $fromPrice }}">
                                    @endif
                                    @if($toPrice != $maxPrice)
                                    <input type="hidden" name="toPrice" value="{{ $toPrice }}">
                                    @endif
                                    <select name="sort" id="sort">
                                        <option {{ $sort == 'default' ? 'selected' : '' }} value="default">Mặc định
                                        </option>
                                        <option {{ $sort == 'price-asc' ? 'selected' : '' }} value="price-asc">Giá thấp
                                            -> cao</option>
                                        <option {{ $sort == 'price-desc' ? 'selected' : '' }} value="price-desc">Giá Cao
                                            -> thấp</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                </header>
                <div class="tab-content text-center products w-100 float-left">
                    <div class="tab-pane grid fade active" id="grid" role="tabpanel">
                        <div class="row">

                            @foreach($products as $pro)
                            <div class="product-layouts col-lg-3 col-md-3 col-sm-6 col-xs-6">
                                <div class="product-thumb">
                                    <div class="image zoom">
                                        <a href="{{route("home.showProductDetail", $pro->id)}}">
                                            <img src="img/products/{{$pro->image}}" alt="03" />
                                            <img src="img/products/{{$pro->image}}" alt="04"
                                                class="second_image img-responsive" /> </a>
                                    </div>
                                    <div class="thumb-description">
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
                                                    <span class="fa fa-stack"><i class="material-icons">star</i></span>
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
                                                <div class="button-group text-center">
                                                    <a href='{{route("home.showProductDetail", $pro->id)}}'
                                                        class="btn btn-primary btn-cart"><i
                                                            class="material-icons">shopping_cart</i><span>Add
                                                            to cart</span></a>
                                                    @if(auth()->check())
                                                    <a href='{{route("home.favorite", $pro->id)}}'
                                                        class="btn btn-primary btn-wishlist {{($pro->favorited == true) ? 'wishlist-active' : ''}}"><i
                                                            class="material-icons">favorite</i><span>wishlist</span></a>
                                                    @endif
                                                    <a href="{{route("home.showProductDetail", $pro->id)}}"
                                                        class="btn btn-primary btn-quickview"><i
                                                            class="material-icons">visibility</i><span>Quick
                                                            View</span></a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach

                        </div>

                    </div>
                    <div class="tab-pane fade list text-left" id="list" role="tabpanel">
                        @foreach($products as $pro)
                        <div class="product-layouts">
                            <div class="product-thumb row">
                                <div class="image zoom col-xs-12 col-sm-5 col-md-4">
                                    <a href="{{route("home.showProductDetail", $pro->id)}}"
                                        class="d-block position-relative">
                                        <img src="img/products/{{$pro->image}}" alt="03" />
                                        <img src="img/products/{{$pro->image}}" alt="04"
                                            class="second_image img-responsive" />
                                    </a>
                                </div>
                                <div class="thumb-description col-xs-12  col-sm-7 col-md-8 position-static text-left">
                                    <div class="caption">
                                        <h4 class="product-title text-capitalize"><a
                                                href="{{route("home.showProductDetail", $pro->id)}}">{{$pro->name}}</a>
                                        </h4>
                                    </div>
                                    <div class="rating mb-10">
                                        <div class="product-ratings d-inline-block align-middle">
                                            @for($x = 1; $x <= 5; $x++) @if( $x <=average_rate($pro->
                                                ratings)
                                                )
                                                <span class="fa fa-stack"><i class="material-icons">star</i></span>
                                                @else
                                                <span class="fa fa-stack"><i class="material-icons off">star</i></span>
                                                @endif
                                                @endfor
                                        </div>
                                    </div>
                                    <div class="description">{{$pro->short_description}}</div>

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
                                            @if(auth()->check())
                                            <a href='{{route("home.favorite", $pro->id)}}'
                                                class="btn btn-primary btn-wishlist {{($pro->favorited == true) ? 'wishlist-active' : ''}}"><i
                                                    class="material-icons">favorite</i><span>wishlist</span></a>
                                            @endif
                                            <a href="{{route("home.showProductDetail", $pro->id)}}"
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
                <div class="pagination-wrapper float-left w-100">
                    <p>Hiển thị {{ $products->firstItem() }} đến {{ $products->lastItem() }} của
                        {{ $products->total() }} sản phẩm
                    </p>
                    <nav aria-label="Page navigation example">
                        <ul class="pagination">

                            @if ($products->previousPageUrl())
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $products->previousPageUrl() }}{{($perPage != "9") ? '&show=' . $perPage : ''}}{{($sort != "default") ? '&sort=' . $sort : ''}}{{($fromPrice != $minPrice) ? '&fromPrice=' . $fromPrice : ''}}{{($toPrice != $maxPrice) ? '&toPrice=' . $toPrice : ''}}"
                                    aria-label="Previous">
                                    <span aria-hidden="true">&laquo;</span>
                                    <span class="sr-only">Previous</span>
                                </a>
                            </li>
                            @endif

                            @foreach(range(1, $products->lastPage()) as $page)
                            <li class="page-item {{ $page == $products->currentPage() ? 'active' : '' }}">
                                <a class="page-link"
                                    href="{{ $products->url($page) }}{{($perPage != "9") ? '&show=' . $perPage : ''}}{{($sort != "default") ? '&sort=' . $sort : ''}}{{($fromPrice != $minPrice) ? '&fromPrice=' . $fromPrice : ''}}{{($toPrice != $maxPrice) ? '&toPrice=' . $toPrice : ''}}">{{ $page }}</a>
                            </li>
                            @endforeach

                            @if ($products->nextPageUrl())
                            <li class="page-item">
                                <a class="page-link"
                                    href="{{ $products->nextPageUrl() }}{{($perPage != "9") ? '&show=' . $perPage : ''}}{{($sort != "default") ? '&sort=' . $sort : ''}}{{($fromPrice != $minPrice) ? '&fromPrice=' . $fromPrice : ''}}{{($toPrice != $maxPrice) ? '&toPrice=' . $toPrice : ''}}"
                                    aria-label="Next">
                                    <span aria-hidden="true">&raquo;</span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </li>
                            @endif

                        </ul>
                    </nav>
                </div>
            </div>
            <div class="left-column sidebar col-xl-3 col-lg-3 order-lg-1">
                <div class="sidebar-filter left-sidebar w-100 float-left">
                    <div class="title">
                        <a data-toggle="collapse" href="#sidebar-main" aria-expanded="false"
                            aria-controls="sidebar-main" class="d-lg-none block-toggler">Danh mục sản phẩm</a>
                    </div>
                    <div id="sidebar-main" class="sidebar-main collapse">
                        <div class="sidebar-block categories">
                            <h3 class="widget-title"><a data-toggle="collapse" href="#categoriesMenu" role="button"
                                    aria-expanded="true" aria-controls="categoriesMenu">Danh mục</a></h3>
                            <div id="categoriesMenu" class="expand-lg collapse show">
                                <div class="nav nav-pills flex-column mt-4">
                                    @foreach($cats as $cat)
                                    <a href="{{route("home.category", $cat->id)}}"
                                        class="nav-link d-flex justify-content-between mb-2 "><span>{{$cat->name}}</span><span
                                            class="sidebar-badge"> {{$cat->products->count()}}</span></a>
                                    @endforeach
                                </div>
                            </div>
                        </div>

                        <div class="sidebar-block price">
                            <h3 class="widget-title"><a data-toggle="collapse" href="#price" role="button"
                                    aria-expanded="true" aria-controls="price">Giá</a></h3>
                            <div id="price" class="collapse show">
                                <div class="price-inner">
                                    <label>Lọc giá:</label>

                                    <form id="fillter-price-form" action="{{route("home.category", $category->id)}}"
                                        method="get">
                                        @if($perPage != "9")
                                        <input type="hidden" name="show" value="{{ $perPage }}">
                                        @endif
                                        @if($sort != "default")
                                        <input type="hidden" name="sort" value="{{ $sort }}">
                                        @endif
                                        <div class="d-flex justify-content-start w-100 m-0 price-input">
                                            <div class="field">
                                                <input name="fromPrice" type="hidden" class="input-min"
                                                    value="{{$fromPrice}}">
                                                <span
                                                    class="font-weight-bold text-dark">{{number_format($fromPrice)}}đ</span>
                                            </div>
                                            <div
                                                class="d-flex align-items-center justify-content-center font-weight-bold mr-2 ml-2">
                                                &#x2192;</div>
                                            <div class="field">
                                                <input name="toPrice" type="hidden" class="input-max"
                                                    value="{{$toPrice}}">
                                                <span
                                                    class="font-weight-bold text-dark">{{number_format($toPrice)}}đ</span>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="slider">
                                        <div class="progress"></div>
                                    </div>
                                    <div class="range-input">
                                        <input type="range" class="range-min" min="{{$minPrice}}" max="{{$maxPrice}}"
                                            value="{{ ($fromPrice == $minPrice) ? $minPrice : $fromPrice}}" step="1000">
                                        <input type="range" class="range-max" min="{{$minPrice}}" max="{{$maxPrice}}"
                                            value="{{ ($toPrice == $maxPrice) ? $maxPrice : $toPrice}}" step="1000">
                                    </div>
                                    <div class="mt-3 text-center">
                                        <button type="submit" form="fillter-price-form"
                                            class="btn btn-sm btn-primary w-50 p-2">Lọc</button>
                                    </div>

                                </div>
                            </div>

                        </div>


                    </div>
                </div>
                <div class="sidebar-left-banner left-sidebar w-100 float-left">
                    <div class="ttleftbanner">
                        <a href="#">
                            <img src="img/banner/left-banner.jpg" alt="left-banner" />
                        </a>
                    </div>
                </div>
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

@section("js")
<script>
$(document).ready(function() {
    $('#show').change(function() {
        var $form = $(this).closest('.product-update-show'); // Tìm form gần nhất chứa select
        $form.submit(); // Gửi form
    });

    $('#sort').change(function() {
        var $form = $(this).closest('.product-update-sort'); // Tìm form gần nhất chứa select
        $form.submit(); // Gửi form
    });
});
</script>
<script>
function formatCurrency(number) {
    // Convert number to string and add commas every three digits from the right
    let formattedNumber = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    // Add currency symbol at the end
    formattedNumber += "đ";
    return formattedNumber;
}

const rangeInput = document.querySelectorAll(".range-input input"),
    priceInput = document.querySelectorAll(".price-input input"),
    range = document.querySelector(".slider .progress");
let priceGap = 1000;

const priceSpan = document.querySelectorAll(".price-input span");

// Gọi hàm khi tài liệu đã được tải hoàn toàn
document.addEventListener("DOMContentLoaded", function() {
    let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

    priceInput[0].value = minVal;
    priceInput[1].value = maxVal;

    priceSpan[0].textContent = formatCurrency(minVal);
    priceSpan[1].textContent = formatCurrency(maxVal);

    range.style.left = (((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0].min)) * 100) + "%";
    range.style.right = 100 - ((maxVal - rangeInput[1].min) / (rangeInput[1].max - rangeInput[1].min)) * 100 +
        "%";
});

priceInput.forEach((input) => {
    input.addEventListener("input", (e) => {
        let minPrice = parseInt(priceInput[0].value),
            maxPrice = parseInt(priceInput[1].value);

        if (maxPrice - minPrice >= priceGap && maxPrice <= rangeInput[1].max) {
            if (e.target.className === "input-min") {
                rangeInput[0].value = minPrice;
                range.style.left = (((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0]
                    .min)) * 100) + "%";
            } else {
                rangeInput[1].value = maxPrice;
                range.style.right = 100 - ((maxVal - rangeInput[1].min) / (rangeInput[1].max -
                        rangeInput[1].min)) * 100 +
                    "%";
            }
        }
    });
});

rangeInput.forEach((input) => {
    input.addEventListener("input", (e) => {
        let minVal = parseInt(rangeInput[0].value),
            maxVal = parseInt(rangeInput[1].value);

        if (maxVal - minVal < priceGap) {
            if (e.target.className === "range-min") {
                rangeInput[0].value = maxVal - priceGap;
            } else {
                rangeInput[1].value = minVal + priceGap;
            }
        } else {
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;

            priceSpan[0].textContent = formatCurrency(minVal);
            priceSpan[1].textContent = formatCurrency(maxVal);

            range.style.left = (((minVal - rangeInput[0].min) / (rangeInput[0].max - rangeInput[0]
                .min)) * 100) + "%";
            range.style.right = 100 - ((maxVal - rangeInput[1].min) / (rangeInput[1].max - rangeInput[1]
                    .min)) * 100 +
                "%";
        }
    });
});
</script>
@stop