@extends("master.admin")
@section("title", "Quản lý đánh giá")
@section("rate", "active")

@section("css")
<style>
.ellipsis {
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    cursor: pointer;
}

.rating-comment {
    max-width: 350px;
}

.rating-nameproduct {
    max-width: 150px;
}

.ellipsis:hover::before {
    content: attr(title_show);
    background-color: #333;
    color: #fff;
    font-size: 14px;
    font-family: Arial, sans-serif;
    border-radius: 5px;
    padding: 5px;
    position: absolute;
    z-index: 1;
    white-space: pre-line;
    bottom: 100%;
}
</style>

@stop

@section("main")

<div class="row">
    <div class="col-md-12">

        @if(Session::has('error'))
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
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h4 class="m-0 font-weight-bold text-primary">Danh sách đánh giá</h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead class="text-center">
                            <tr>
                                <th>STT</th>
                                <th>Sản phẩm</th>
                                <th>Tài khoản</th>
                                <th width="150px">Đánh giá</th>
                                <th width="400px">Nội dung</th>
                                <th width="160px">Thời gian</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($rates as $i => $rate)
                            <tr>
                                <td>{{ $i + 1 + ($rates->currentPage() - 1) * $rates->perPage() }}</td>
                                <td class="text-left position-relative d-flex align-items-center"><img width="35px"
                                        height="35px" src="/img/products/{{$rate->product->image}}" alt="">
                                    <p title_show="{{$rate->product->name}}" class="ellipsis m-0 rating-nameproduct">
                                        {{$rate->product->name}}
                                    </p>
                                </td>
                                <td>{{"@" . $rate->customer->name}}</td>
                                <td>
                                    @for($x = 1; $x <= 5; $x++) @if($x <=$rate->rating)
                                        <i class="fas fa-fw fa-star text-warning"></i>
                                        @else
                                        <i class="fas fa-fw fa-star"></i>
                                        @endif
                                        @endfor
                                </td>
                                <td class="position-relative">
                                    <p title_show="{{$rate->comment}}" class="ellipsis m-0 rating-comment">
                                        {{$rate->comment}}
                                    </p>
                                </td>
                                <td>{{ $rate->created_at->format("d/m/Y H:i") }}</td>
                                <td>
                                    <form class="d-inline " action="{{ route('rating.destroy') }}" method="POST"
                                        onsubmit="return confirm('Bạn có chắc muốn xóa đánh giá này?')">
                                        @csrf
                                        <input type="hidden" name="id" value="{{$rate->id}}" />
                                        <button class='btn btn-sm btn-danger' type='submit' name='submit'><i
                                                title='Xóa đánh giá' class='fa fa-trash'></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($rates->count() <= 0) <p class='lead text-center'><em>Hiện chưa có đánh giá nào!</em>
                        </p>
                        @endif
                        <div class="pagination justify-content-end">
                            <li class="paginate_button page-item previous"><a href="{{ $rates->url(1) }}"
                                    class="page-link">&laquo;&laquo;</a>
                            </li>
                            {{$rates->links('pagination::bootstrap-4')}}
                            <li class="paginate_button page-item next"><a href="{{ $rates->url($rates->lastPage()) }}"
                                    class="page-link">&raquo;&raquo;</a>
                            </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop()