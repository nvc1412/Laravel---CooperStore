@extends("master.admin")
@section("title", "Quản lý tài khoản")
@section("accountAD", "active")
@section("main")

<div class="row">
    <div class="col-md-12">

        <!-- @if(Session::has('error'))
        <div class="alert alert-danger alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            * {{Session::get("error")}}
        </div>
        @endif

        @if(Session::has('success'))
        <div class="alert alert-success alert-dismissible">
            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
            {{Session::get("success")}}
        </div>
        @endif -->

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">Danh sách tài khoản</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th width="25px">STT</th>
                                <th>Tên tài khoản</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Quyền ADMIN</th>
                                <th>Trạng thái</th>
                                <th>Thời gian xác thực</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($accounts as $i => $acc)
                            <form action="{{ route('accountAD.update') }}" method="POST">
                                @csrf
                                <tr>
                                    <td>
                                        {{ $i + 1 + ($accounts->currentPage() - 1) * $accounts->perPage() }}
                                        <input type="hidden" name="id" value="{{$acc->id}}" />
                                    </td>
                                    <td>{{"@" . $acc->name}}</td>
                                    <td>{{$acc->email}}</td>
                                    <td>{{$acc->phone}}</td>
                                    <td>
                                        <select class='form-control' name="is_admin">
                                            <option value="0" {{ ($acc->is_admin) == 0 ? "selected" : "" }}>
                                                Không
                                            </option>;
                                            <option value="1" {{ ($acc->is_admin) == 1 ? "selected" : "" }}>
                                                Có
                                            </option>;
                                        </select>
                                    </td>
                                    <td>
                                        <select class='form-control' name="status">
                                            <option value="0" {{ ($acc->status) == 0 ? "selected" : "" }}>
                                                Bình thường
                                            </option>;
                                            <option value="1" {{ ($acc->status) == 1 ? "selected" : "" }}>
                                                Khóa
                                            </option>;
                                        </select>
                                    </td>
                                    <td>{{ $acc->email_verified_at ? $acc->email_verified_at->format("d/m/Y H:i") : "chưa xác thực" }}
                                    </td>
                                    <td class="text-center">
                                        <button class='btn btn-sm btn-primary' type='submit' name='submit'><i
                                                title='Cập nhật nhanh' class='fa fa-save'></i></button>
                            </form>

                            <form class="d-inline " action="{{ route('accountAD.destroy') }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa tài khoản này?')">
                                @csrf
                                <input type="hidden" name="id" value="{{$acc->id}}" />
                                <button class='btn btn-sm btn-danger' type='submit' name='submit'><i
                                        title='Xóa tài khoản' class='fa fa-trash'></i></button>
                            </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($accounts->count() <= 0) <p class='lead text-center'><em>Hiện chưa có tài khoản nào!</em>
                        </p>
                        @endif
                        <div class="pagination justify-content-end">
                            <li class="paginate_button page-item previous"><a href="{{ $accounts->url(1) }}"
                                    class="page-link">&laquo;&laquo;</a>
                            </li>
                            {{$accounts->links('pagination::bootstrap-4')}}
                            <li class="paginate_button page-item next"><a
                                    href="{{ $accounts->url($accounts->lastPage()) }}"
                                    class="page-link">&raquo;&raquo;</a>
                            </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop()