@extends("master.admin")
@section("title", "Quản lý đơn hàng")
@section("bill", "active")
@section("preparingBill", "active")

@section("css")
<style>
.btn-status-unconfirmed {
    color: #fff;
    background-color: #1741b8;
    border-color: #1741b8;
}

.btn-status-unconfirmed:hover {
    background-color: #092c90;
    border-color: #092c90;
}

.btn-status-preparing {
    color: #fff;
    background-color: #17b89a;
    border-color: #17b89a;
}

.btn-status-preparing:hover {
    background-color: #109a80;
    border-color: #109a80;
}

.btn-status-shipping {
    color: #fff;
    background-color: #e49937;
    border-color: #e49937;
}

.btn-status-shipping:hover {
    background-color: #c2791a;
    border-color: #c2791a;
}

.btn-status-delivered,
.btn-status-delivered:hover {
    color: #fff;
    background-color: #9bc01b;
    border-color: #9bc01b;
}

.btn-status-completed,
.btn-status-completed:hover {
    color: #fff;
    background-color: #218838;
    border-color: #218838;
}

.btn-status-refunding {
    color: #fff;
    background-color: #931ba8;
    border-color: #931ba8;
}

.btn-status-refunding:hover {
    background-color: #6f0e80;
    border-color: #6f0e80;
}

.btn-status-refunded,
.btn-status-refunded:hover {
    color: #fff;
    background-color: #6f0e80;
    border-color: #6f0e80;
}

.btn-status-failed,
.btn-status-failed:hover {
    color: #fff;
    background-color: #ff0000;
    border-color: #ff0000;
}

.btn-status-cancelled,
.btn-status-cancelled:hover {
    color: #fff;
    background-color: #900707;
    border-color: #900707;
}
</style>

@stop

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
                <h4 class="m-0 font-weight-bold text-primary">Đơn hàng chưa được in</h4>
                <button type="submit" form="printBill"
                    class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                        class="fas fa-print fa-sm text-white-50"></i> In PDF</button>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if($bills->count() <= 0) <p class='lead text-center'><em>Hiện chưa có đơn hàng mới nào!</em>
                        </p>
                        @else
                        <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                            <thead class="text-center">
                                <tr>
                                    <th><input type="checkbox" id="selectAllBill" /></th>
                                    <th>Mã ĐH</th>
                                    <th>Tài khoản</th>
                                    <th>Email</th>
                                    <th>SĐT</th>
                                    <th>HTTT</th>
                                    <th>Tổng tiền</th>
                                    <th>Trạng thái</th>
                                    <th>Thời gian tạo</th>
                                    <th>CTĐH</th>
                                </tr>
                            </thead>
                            <tbody>
                                <form id="printBill" action="{{route('bill.printBill')}}" method="post" target="_blank">
                                    @csrf
                                    @foreach($bills as $bill)
                                    <tr>

                                        <td><input type="checkbox" id="{{ $bill->id }}" name="listBillPrint[]"
                                                value="{{ $bill->id }}" /></td>
                                        <td><label class="m-0" for="{{ $bill->id }}">#{{ $bill->id }}</label></td>
                                        <td><label class="m-0" for="{{ $bill->id }}">{{ $bill->customer->name }}</label>
                                        </td>
                                        <td><label class="m-0" for="{{ $bill->id }}">{{ $bill->email }}</label></td>
                                        <td><label class="m-0" for="{{ $bill->id }}">{{ $bill->phone }}</label></td>
                                        <td class="text-uppercase"><label class="m-0"
                                                for="{{ $bill->id }}">{{ $bill->payment }}</label></td>
                                        <td><label class="m-0"
                                                for="{{ $bill->id }}">{{ number_format($bill->total) }}đ</label></td>
                                        <td class="text-center">
                                            <div class='w-100 btn btn-sm
                                                                            @php
                                                                                switch ($bill->status) {
                                                                                    case "Chờ xác nhận":
                                                                                        echo "btn-status-unconfirmed";
                                                                                        break;

                                                                                    case "Đang được chuẩn bị":
                                                                                        echo "btn-status-preparing";
                                                                                        break;

                                                                                    case "Đang vận chuyển":
                                                                                        echo "btn-status-shipping";
                                                                                        break;

                                                                                    case "Đã giao hàng":
                                                                                        echo "btn-status-delivered";
                                                                                        break;

                                                                                    case "Hoàn tất":
                                                                                        echo "btn-status-completed";
                                                                                        break;

                                                                                    case "Đang hoàn hàng":
                                                                                        echo "btn-status-refunding";
                                                                                        break;

                                                                                    case "Hoàn hàng thành công":
                                                                                        echo "btn-status-refunded";
                                                                                        break;

                                                                                    case "Thất lạc - hư hỏng":
                                                                                        echo "btn-status-failed";
                                                                                        break;

                                                                                    case "Đã hủy":
                                                                                        echo "btn-status-cancelled";
                                                                                        break;

                                                                                    default:
                                                                                        echo "btn-info";
                                                                                }
                                                                                ;
                                                                            @endphp
                                                                            '><label class="m-0"
                                                    for="{{ $bill->id }}"></label>{{$bill->status}}</div>
                                        </td>
                                        <td><label class="m-0"
                                                for="{{ $bill->id }}">{{ $bill->created_at->format("d/m/Y H:i") }}</label>
                                        </td>
                                        <td><a href="{{route('bill.showDetailBill', $bill->id)}}"
                                                class="btn btn-sm btn-info"><i class="fa fa-eye"></i></a></td>
                                    </tr>
                                    @endforeach
                                </form>
                            </tbody>
                        </table>

                        <div class="pagination justify-content-end">
                            <li class="paginate_button page-item previous"><a href="{{ $bills->url(1) }}"
                                    class="page-link">&laquo;&laquo;</a>
                            </li>
                            {{$bills->links('pagination::bootstrap-4')}}
                            <li class="paginate_button page-item next"><a href="{{ $bills->url($bills->lastPage()) }}"
                                    class="page-link">&raquo;&raquo;</a>
                            </li>
                        </div>
                        @endif

                </div>
            </div>
        </div>
    </div>
</div>


@stop

@section("js")

<script>
$('#selectAllBill').click(function(e) {
    var table = $(e.target).closest('table');
    $('td input:checkbox', table).prop('checked', this.checked);
});
</script>

@stop