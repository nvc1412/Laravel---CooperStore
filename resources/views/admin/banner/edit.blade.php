@extends("master.admin")
@section("title", "Sửa banner")
@section("setting", "active")
@section("banner", "active")
@section("main")


<div class="row">
    <div class="col-md-12">

        <!-- @error('name')
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
        @endif -->

        <div class="card shadow mb-4">
            <form action="{{ route('banner.update', $banner->id) }}" method="post" enctype="multipart/form-data">
                @csrf @method("PUT")
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-warning">Cập nhật thông tin banner</h4>
                    <button class='btn btn-primary' type="submit"><i title='Cập nhật' class='fa fa-save'></i>
                        Lưu</button>
                </div>
                <div class="card-body d-flex justify-content-around">
                    <div class="card shadow mb-4 col-7 mr-2">
                        <div class="card-body">
                            <label for="name">Tên banner</label>
                            <input required placeholder="Nhập tên banner..." type="text" name="name"
                                class="form-control" value="{{$banner->name}}">
                            @error('name') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="link">Link</label>
                            <input required placeholder="Nhập tên banner" type="text" name="link" class="form-control"
                                value="{{$banner->link}}">
                            @error('link') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="description">Mô Tả</label>
                            <textarea class="form-control" name="description" rows="10"
                                cols="50">{{$banner->description}}</textarea>
                            <br>
                        </div>
                    </div>
                    <div class="card shadow mb-4 col-5">
                        <div class="card-body">
                            <label for="position">Vị trí</label>
                            <select required id="position" class='form-control' name="position">
                                <option value="{{$banner->position}}"
                                    {{ $banner->position == "Top-Banner" ? "selected" : "" }}>
                                    Top-Banner
                                </option>
                                <option value="{{$banner->position}}"
                                    {{ $banner->position == "Bottom-Banner" ? "selected" : "" }}>
                                    Bottom-Banner
                                </option>
                            </select>
                            @error('position') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="prioty">Độ ưu tiên</label>
                            <input value="{{$banner->prioty}}" required id="prioty" type="number" min="0" name="prioty"
                                class="form-control">
                            @error('prioty') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="status">Trạng thái</label>
                            <select required id="status" class='form-control' name="status">
                                <option value="{{$banner->status}}" {{ $banner->status == "Hiện" ? "selected" : "" }}>
                                    Hiện
                                </option>
                                <option value="{{$banner->status}}" {{ $banner->status == "Ẩn" ? "selected" : "" }}>
                                    Ẩn
                                </option>
                            </select>
                            @error('status') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="image">Hình ảnh</label>
                            <input class="mb-4" type="file" onchange="readURL(this);" name="image" id="image"
                                accept="image/*">
                            @error('image') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <img src="img/banner/{{$banner->image}}" width="100%" id="previewImg" alt="" />
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>




@stop