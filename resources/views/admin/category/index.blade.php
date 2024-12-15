@extends("master.admin")
@section("title", "Quản lý danh mục")
@section("category", "active")
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
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-success">Thêm danh mục</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Tên danh mục</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <form action="{{ route("category.store") }}" method="POST">
                                    @csrf
                                    <td>
                                        <input placeholder="Nhập tên danh mục mới..." required type='text' name='name'
                                            class='form-control' value=''>
                                    </td>
                                    <td class="text-center">
                                        <button class='btn btn-success' type='submit' name='submit'><i
                                                title='Thêm mới danh mục' class='fa fa-plus'></i> Thêm</button>
                                    </td>
                                </form>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Danh sách danh mục</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="7%">STT</th>
                                <th>Tên danh mục</th>
                                <th>Thời gian tạo</th>
                                <th>Thời gian cập nhật</th>
                                <th width="10%"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($categories as $i => $cat)
                            <form action="{{ route('category.update', $cat->id) }}" method="POST">
                                @csrf @method('PUT')
                                <tr>
                                    <td>{{ $i + 1 + ($categories->currentPage() - 1) * $categories->perPage() }}</td>
                                    <td><input required class="form-control" type="text" name="name"
                                            value="{{$cat->name}}"></td>
                                    <td>{{$cat->created_at}}</td>
                                    <td>{{$cat->updated_at}}</td>
                                    <td class="text-center">
                                        <button class='btn btn-sm btn-primary' type='submit' name='submit'><i
                                                title='Cập nhật danh mục' class='fa fa-save'></i></button>
                            </form>

                            <form class="d-inline " action="{{ route('category.destroy', $cat->id) }}" method="POST">
                                @csrf @method('DELETE')
                                <button class='btn btn-sm btn-danger' type='submit' name='submit'><i
                                        title='Xóa danh mục' class='fa fa-trash'></i></button>
                            </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="pagination justify-content-end">
                        <li class="paginate_button page-item previous"><a href="{{ $categories->url(1) }}"
                                class="page-link">&laquo;&laquo;</a>
                        </li>
                        {{$categories->links('pagination::bootstrap-4')}}
                        <li class="paginate_button page-item next"><a
                                href="{{ $categories->url($categories->lastPage()) }}"
                                class="page-link">&raquo;&raquo;</a>
                        </li>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop()