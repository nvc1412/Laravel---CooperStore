@extends("master.admin")
@section("title", "Quản lý banner")
@section("setting", "active")
@section("banner", "active")
@section("main")


<div class="row">
    <div class="col-md-12">

        <!-- @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get("error")}}
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get("success")}}
        </div>
        @endif -->

        <div class="card shadow mb-4">
            <form action="{{ route("banner.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class=" card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">Thêm Banner</h6>
                    <button class='btn btn-success' type='submit' name='submit'><i title='Thêm mới banner'
                            class='fa fa-plus'></i> Thêm</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Tên banner</th>
                                    <th>Mô tả</th>
                                    <th>Link</th>
                                    <th>Vị trí</th>
                                    <th width="12%">Độ ưu tiên</th>
                                    <th width="10%">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input placeholder="Nhập tên banner mới..." required type='text' name='name'
                                            class='form-control'>
                                    </td>
                                    <td>
                                        <textarea class="form-control" name="description" cols="30" rows="2"></textarea>
                                    </td>
                                    <td>
                                        <input placeholder="#" required type='text' name='link' class='form-control'
                                            value='#'>
                                    </td>
                                    <td>
                                        <select class="form-control" required name="position">
                                            <option selected value="Top-Banner">Top-Banner</option>
                                            <option value="Bottom-Banner">Bottom-Banner</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input required class="form-control" type="number" name="prioty" min="0"
                                            value="0">
                                    </td>
                                    <td>
                                        <select class="form-control" required name="status">
                                            <option selected value="Hiện">Hiện</option>
                                            <option value="Ẩn">Ẩn</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <input class="mb-1 text-center" required type="file" onchange="readURL(this);"
                                        name="image" id="image" accept="image/*">
                                    <div class="text-center mb-2">
                                        <img width="70%" id="previewImg" alt="" />
                                    </div>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách banner</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="7%">STT</th>
                                <th width="200px">Hình ảnh</th>
                                <th>Link</th>
                                <th width="14%">Vị trí</th>
                                <th width="12%">Độ ưu tiên</th>
                                <th width="12%">Trạng thái</th>
                                <th width="130px"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($banners as $i => $ban)
                            <form action="{{ route('banner.update', $ban->id) }}" method="POST">
                                @csrf @method('PUT')
                                <tr>
                                    <td>{{ $i + 1 + ($banners->currentPage() - 1) * $banners->perPage() }}</td>
                                    <input type="hidden" name="name" value="{{$ban->name}}">
                                    <input type="hidden" name="description" value="{{$ban->description}}">
                                    <td><img width="100%" src="/img/banner/{{$ban->image}}" alt=""></td>
                                    <td><input required class="form-control" type="text" name="link"
                                            value="{{$ban->link}}">
                                    </td>
                                    <td>
                                        <select class="form-control" required name="position">
                                            <option {{ $ban->position == "Top-Banner" ? "selected" : "" }}
                                                value="Top-Banner">Top-Banner</option>
                                            <option {{ $ban->position == "Bottom-Banner" ? "selected" : "" }}
                                                value="Bottom-Banner">Bottom-Banner</option>
                                        </select>
                                    </td>
                                    <td><input required class="form-control" type="number" name="prioty" min="0"
                                            value="{{$ban->prioty}}"></td>
                                    <td>
                                        <select class="form-control" required name="status">
                                            <option {{ $ban->status == "Hiện" ? "selected" : "" }} value="Hiện">Hiện
                                            </option>
                                            <option {{ $ban->status == "Ẩn" ? "selected" : "" }} value="Ẩn">Ẩn</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button class='btn btn-sm btn-primary' type='submit' name='submit'><i
                                                title='Cập nhật banner' class='fa fa-save'></i></button>
                            </form>

                            <a class='btn btn-sm btn-warning' href="{{ route('banner.edit', $ban->id) }}"><i
                                    title='Cập nhật banner' class='fa fa-edit'></i>
                            </a>

                            <form class="d-inline " action="{{ route('banner.destroy', $ban->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class='btn btn-sm btn-danger' type='submit' name='submit'><i title='Xóa banner'
                                        class='fa fa-trash'></i></button>
                            </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-content-end">
                        <li class="paginate_button page-item previous"><a href="{{ $banners->url(1) }}"
                                class="page-link">&laquo;&laquo;</a>
                        </li>
                        {{$banners->links('pagination::bootstrap-4')}}
                        <li class="paginate_button page-item next"><a href="{{ $banners->url($banners->lastPage()) }}"
                                class="page-link">&raquo;&raquo;</a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
