@extends("master.admin")
@section("title", "Quản lý logo")
@section("setting", "active")
@section("logo", "active")
@section("main")


<div class="row">
    <div class="col-md-12">

        @if(Session::has('error'))
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
        @endif

        <div class="card shadow mb-4">
            <form action="{{ route("logo.store") }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class=" card-header py-3 d-flex justify-content-between align-items-center">
                    <h6 class="m-0 font-weight-bold text-success">Thêm logo</h6>
                    <button class='btn btn-success' type='submit' name='submit'><i title='Thêm mới logo'
                            class='fa fa-plus'></i> Thêm</button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="10%">Hình ảnh</th>
                                    <th>Link</th>
                                    <th>Vị trí</th>
                                    <th width="12%">Độ ưu tiên</th>
                                    <th width="10%">Trạng thái</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <input class="mb-1" required type="file" onchange="readURL(this);" name="image"
                                            id="image" accept="image/*">
                                        <div>
                                            <img width="50%" id="previewImg" alt="" />
                                        </div>
                                        @error('image') <small class="text-danger">* {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <input placeholder="#" required type='text' name='link' class='form-control'
                                            value='#'>
                                        @error('link') <small class="text-danger">* {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td>
                                        <select class="form-control" required name="position">
                                            <option selected value="Header-Logo">Header-Logo</option>
                                            <option value="Footer-Logo">Footer-Logo</option>
                                            <option value="Web-Logo">Web-Logo</option>
                                        </select>
                                        @error('position') <small class="text-danger">* {{ $message }}</small>
                                        @enderror
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
                                        @error('status') <small class="text-danger">* {{ $message }}</small>
                                        @enderror
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách logo</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="7%">STT</th>
                                <th width="150px">Hình ảnh</th>
                                <th>Link</th>
                                <th width="14%">Vị trí</th>
                                <th width="12%">Độ ưu tiên</th>
                                <th width="12%">Trạng thái</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($logos as $i => $logo)
                            <form action="{{ route('logo.update', $logo->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf @method('PUT')
                                <tr>
                                    <td>{{ $i + 1 + ($logos->currentPage() - 1) * $logos->perPage() }}</td>
                                    <td>
                                        <input class="mb-1" type="file" onchange="readURL(this, '{{ $logo->id }}');"
                                            name="image" id="image" accept="image/*">
                                        <div>
                                            <img width="50%" id="previewImg_{{$logo->id}}"
                                                src="img/logos/{{$logo->image}}" alt="" />
                                        </div>
                                        @error('image') <small class="text-danger">* {{ $message }}</small>
                                        @enderror
                                    </td>
                                    <td><input required class="form-control" type="text" name="link"
                                            value="{{$logo->link}}">
                                    </td>
                                    <td>
                                        <select class="form-control" required name="position">
                                            <option {{ $logo->position == "Header-Logo" ? "selected" : "" }}
                                                value="Header-Logo">Header-Logo</option>
                                            <option {{ $logo->position == "Footer-Logo" ? "selected" : "" }}
                                                value="Footer-Logo">Footer-Logo</option>
                                            <option {{ $logo->position == "Web-Logo" ? "selected" : "" }}
                                                value="Web-Logo">Web-Logo</option>
                                        </select>
                                    </td>
                                    <td><input required class="form-control" type="number" name="prioty" min="0"
                                            value="{{$logo->prioty}}"></td>
                                    <td>
                                        <select class="form-control" required name="status">
                                            <option {{ $logo->status == "Hiện" ? "selected" : "" }} value="Hiện">Hiện
                                            </option>
                                            <option {{ $logo->status == "Ẩn" ? "selected" : "" }} value="Ẩn">Ẩn</option>
                                        </select>
                                    </td>
                                    <td class="text-center">
                                        <button class='btn btn-sm btn-primary' type='submit' name='submit'><i
                                                title='Cập nhật logo' class='fa fa-save'></i></button>
                            </form>

                            <form class="d-inline " action="{{ route('logo.destroy', $logo->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class='btn btn-sm btn-danger' type='submit' name='submit'><i title='Xóa logo'
                                        class='fa fa-trash'></i></button>
                            </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-content-end">
                        <li class="paginate_button page-item previous"><a href="{{ $logos->url(1) }}"
                                class="page-link">&laquo;&laquo;</a>
                        </li>
                        {{$logos->links('pagination::bootstrap-4')}}
                        <li class="paginate_button page-item next"><a href="{{ $logos->url($logos->lastPage()) }}"
                                class="page-link">&raquo;&raquo;</a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop