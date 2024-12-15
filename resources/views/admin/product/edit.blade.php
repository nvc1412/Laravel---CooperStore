@extends("master.admin")
@section("title", "Sửa sản phẩm")
@section("product", "active")
@section("main")


<div class="row">
    <div class="col-md-12">

        @error('name')
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            * {{ $message }}
        </div>
        @enderror

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get("success")}}
        </div>
        @endif

        <div class="card shadow mb-4">
            <form action="{{ route('product.update', $product->id) }}" method="post" enctype="multipart/form-data">
                @csrf @method("PUT")
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-warning">Cập nhật thông tin sản phẩm</h4>
                    <button class='btn btn-primary' type="submit"><i title='Cập nhật' class='fa fa-save'></i>
                        Lưu</button>
                </div>
                <div class="card-body d-flex justify-content-around">
                    <div class="card shadow mb-4 col-7 mr-2">
                        <div class="card-body">
                            <label for="name">Tên sản phẩm</label>
                            <input required placeholder="Nhập tên sản phẩm" id="name" type="text" name="name"
                                class="form-control" value="{{$product->name}}">
                            @error('name') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="short_description">Mô Tả ngắn</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="4"
                                cols="50">{{$product->short_description}}</textarea>
                            <br>
                            <label for="description">Mô Tả</label>
                            <textarea class="form-control product-description" id="description" name="description"
                                rows="10" cols="50">{{$product->description}}</textarea>
                            <hr>
                            <label for="other_image">Hình ảnh chi tiết</label>
                            <input id="gallery-photo-add" class="mb-4 w-100" type="file" name="other_image[]"
                                accept="image/*" multiple>
                            <div class="row gallery">
                                @foreach($product->images as $img)
                                <div class="col-md-3 mb-4 position-relative">
                                    <img src="img/products/{{$img->image}}" alt="" class="img-thumbnail">
                                    <a style="top: 5px; right: 18px;" class="text-danger position-absolute"
                                        href="{{route("product.destroyImage", $img->id)}}">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="card shadow mb-4 col-5">
                        <div class="card-body">

                            <label>Chi tiết sản phẩm</label>
                            <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th width="25px">STT</th>
                                        <th>Size</th>
                                        <th>Số lượng</th>
                                        <th class="text-center" width="90px">
                                            <a href="{{route("product.createDetail", $product->id)}}"
                                                class='btn btn-sm btn-success'><i title='Thêm chi tiết sản phẩm'
                                                    class='fa fa-plus'></i> </a>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($product->sizes as $pro_detail)
                                    <tr>
                                        <td>{{$loop->index + 1}}</td>
                                        <td><input required class="form-control" type="text" name="size"
                                                value="{{$pro_detail->size}}">
                                        </td>
                                        <td><input required class="form-control" type="number" min="0" name="quantity"
                                                value="{{$pro_detail->quantity}}"></td>
                                        <td class="text-center">
                                            <button type="button" data-toggle="modal" data-target="#exampleModalCenter"
                                                class='btn btn-sm btn-warning'><i title='Chỉnh sửa'
                                                    class='fa fa-save'></i></button>

                                            <a href="{{route("product.deleteDetail", $pro_detail->id)}}"
                                                class='btn btn-sm btn-danger'><i title='Xóa chi tiết sản phẩm'
                                                    class='fa fa-trash'></i>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @if($product->sizes->count() <= 0) <p class='lead text-center'><em>Vui lòng thêm chi
                                    tiết
                                    sản phẩm!</em>
                                </p>
                                @endif
                                <hr>

                                <label for="category_id">Danh mục</label>
                                <select required id="category_id" class='form-control' name="category_id">
                                    @foreach($categories as $category)
                                    <option value="{{$category->id}}"
                                        {{ ($product->category_id) == ($category->id) ? "selected" : "" }}>
                                        {{$category->name}}
                                    </option>;
                                    @endforeach
                                </select>
                                @error('category_id') <small class="text-danger">* {{ $message }}</small>
                                @enderror
                                <br>
                                <label for="price">Giá</label>
                                <input value="{{$product->price}}" required id="price" type="number" min="0"
                                    name="price" class="form-control">
                                @error('price') <small class="text-danger">* {{ $message }}</small>
                                @enderror
                                <br>
                                <label for="discount">Giá giảm</label>
                                <input value="{{$product->discount}}" id="discount" type="number" min="0"
                                    name="discount" class="form-control">
                                @error('discount') <small class="text-danger">* {{ $message }}</small>
                                @enderror
                                <br>
                                <label for="image">Hình ảnh chính</label>
                                <input class="mb-4" type="file" onchange="readURL(this);" name="image" id="image"
                                    accept="image/*">
                                @error('image') <small class="text-danger">* {{ $message }}</small>
                                @enderror
                                <img src="img/products/{{$product->image}}" width="100%" id="previewImg" alt="" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <form action="{{route("product.updateDetail")}}" method="post" enctype="multipart/form-data">
                @csrf @method("POST")
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalCenterTitle">Chỉnh sửa chi tiết sản phẩm</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="25px">STT</th>
                                <th>Size</th>
                                <th>Số lượng</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($product->sizes as $pro_detail)
                            <tr>
                                <input type="hidden" value="{{$pro_detail->id}}" name="id_product_detail[]">
                                <td>{{$loop->index + 1}}</td>
                                <td><input required class="form-control" type="text" name="size[]"
                                        value="{{$pro_detail->size}}">
                                </td>
                                <td><input required class="form-control" type="number" min="0" name="quantity[]"
                                        value="{{$pro_detail->quantity}}"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($product->sizes->count() <= 0) <p class='lead text-center'><em>Vui lòng thêm chi
                            tiết
                            sản phẩm!</em>
                        </p>
                        @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="submit" class="btn btn-primary">Cập nhật tất cả</button>
                </div>
            </form>
        </div>
    </div>
</div>




@stop

@section("css")
<link href="admin_assets/vendor/summernote/summernote.min.css" rel="stylesheet">
@stop

@section("js")
<script src="admin_assets/vendor/summernote/summernote.min.js"></script>
<script>
$(".product-description").summernote({
    height: 250,
});
</script>
@stop