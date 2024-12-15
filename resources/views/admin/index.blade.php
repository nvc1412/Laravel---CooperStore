@extends("master.admin")
@section("title", "Trang Quản Lý")
@section("dashboard", "active")

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


<!-- Doanh thu -->
<div class="row">

    <!-- Doanh thu ngày -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid IndianRed;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: IndianRed;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Doanh thu ngày</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenues["revenueDay"]) }} VNĐ
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-check fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu tháng -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Doanh thu tháng</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenues["revenueMonth"]) }} VNĐ
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-calendar-alt fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu năm -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Doanh thu năm</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenues["revenueYear"]) }} VNĐ
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Tổng doanh thu -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid orangered;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: orangered;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Tổng doanh thu</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{ number_format($revenues["totalRevenue"]) }} VNĐ
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill-wave fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Đơn hàng -->
<div class="row">

    <!-- Đơn hàng mới -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Đơn hàng mới</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$totalOfBillInStatus["newBill"]}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-receipt  fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng đang giao -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Đơn hàng đang giao</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$totalOfBillInStatus["transportingBill"]}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-truck fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Đơn hàng hủy -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-danger shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                            Đơn hàng hủy</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            {{$totalOfBillInStatus["canceledBill"]}}
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-trash fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sản phẩm bán chạy -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div style="border-left: 0.25rem solid #00c3a4;" class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div style="color: #00c3a4;" class="text-xs font-weight-bold text-uppercase mb-1">
                            Sản phẩm bán chạy</div>
                        @if ($bestSellingProduct)
                            <div class="h6 mb-0 font-weight-bold text-gray-800">
                                {{$bestSellingProduct->name}}
                            </div>
                        @endif

                    </div>
                    <div class="col-auto">
                        @if ($bestSellingProduct)
                            <img src="/img/products/{{$bestSellingProduct->image}}" width="50" height="50">
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>

</div>


<!-- Biểu đồ -->
<div class="row">

    <!-- Biểu đồ cột -->
    <div class="col-xl-8 col-lg-7">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Doanh thu năm nay</h6>
            </div>
            <div class="card-body">
                <div class="chart-bar">
                    <canvas id="bieudocot"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- Biểu đồ tròn -->
    <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Đơn hàng tháng này</h6>
            </div>
            <div class="card-body">
                <div class="chart-pie pt-4">
                    <canvas id="bieudotron"></canvas>
                </div>
                <div class="mt-4 text-center small">
                    <span class="mr-2">
                        <i class="fas fa-circle text-warning"></i> Đang giao
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-success"></i> Thành công
                    </span>
                    <span class="mr-2">
                        <i class="fas fa-circle text-danger"></i> Đã hủy
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Đơn hàng tháng này -->
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
                <h4 class="m-0 font-weight-bold text-primary">Danh sách đơn hàng theo tháng</h4>
                <a href="{{route('bill.exportExcel')}}"
                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                        class="fas fa-download fa-sm text-white-50"></i> Xuất Excel</a>


            </div>
            <div class="card-body">
                <div class="table-responsive">
                    @if($bills->count() <= 0)
                        <p class='lead text-center'><em>Hiện chưa có đơn hàng nào!</em>
                        </p>
                    @else
                                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                                        <thead class="text-center">
                                            <tr>
                                                <th>Mã ĐH</th>
                                                <th>Tài khoản</th>
                                                <th>Email</th>
                                                <th>SĐT</th>
                                                <th>HTTT</th>
                                                <th>Tổng tiền</th>
                                                <th>Trạng thái</th>
                                                <th>Cập nhật</th>
                                                <th>CTĐH</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach($bills as $bill)
                                                                    <tr>
                                                                        <td>#{{ $bill->id }}</td>
                                                                        <td>{{ $bill->customer->name }}</td>
                                                                        <td>{{ $bill->email }}</td>
                                                                        <td>{{ $bill->phone }}</td>
                                                                        <td class="text-uppercase">{{ $bill->payment }}</td>
                                                                        <td>{{ number_format($bill->total) }}đ</td>
                                                                        <td class="text-center">
                                                                            <div
                                                                                class='w-100 btn btn-sm 
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
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        '>
                                                                                {{$bill->status}}
                                                                            </div>
                                                                        </td>
                                                                        <td>{{ $bill->updated_at->format("d/m/Y H:i") }}</td>
                                                                        <td><a href="{{route('bill.showDetailBill', $bill->id)}}" class="btn btn-sm btn-info"><i
                                                                                    class="fa fa-eye"></i></a></td>
                                                                    </tr>
                                            @endforeach
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
<!-- Page level plugins -->
<script src="admin_assets/vendor/chart.js/Chart.min.js"></script>

<script>
    function priceFormat(n) {
        return n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    var xValues = ["Tháng 1", "Tháng 2", "Tháng 3", "Tháng 4", "Tháng 5", "Tháng 6", "Tháng 7", "Tháng 8",
        "Tháng 9", "Tháng 10", "Tháng 11", "Tháng 12"
    ];

    var yValues = <?= json_encode($revenueOfMonthInYear); ?>;
    var barColors = ["blue", "red", "violet", "yellow", "green", "orange", "brown", "cyan", "lime",
        "black", "gray", "pink"
    ];

    new Chart("bieudocot", {
        type: "bar",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            maintainAspectRatio: false,
            layout: {
                padding: {
                    left: 10,
                    right: 25,
                    top: 25,
                    bottom: 0,
                },
            },
            scales: {
                xAxes: [{
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    maxBarThickness: 25,
                },],
                yAxes: [{
                    ticks: {
                        padding: 10,
                        callback: function (value, index, values) {
                            return priceFormat(value);
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },],
            },
            legend: {
                display: false
            },
            tooltips: {
                titleMarginBottom: 10,
                titleFontColor: "#6e707e",
                titleFontSize: 14,
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
                callbacks: {
                    label: function (tooltipItem, chart) {
                        var datasetLabel =
                            chart.datasets[tooltipItem.datasetIndex].label || "";
                        return datasetLabel + priceFormat(tooltipItem.yLabel);
                    },
                },
            },
        }
    });
</script>


<script>
    var xValues = ["Đang giao", "Thành công", "Đã hủy"];
    var yValues = <?= json_encode($statusOfBill); ?>;
    var barColors = [
        "#f6c23e",
        "#1cc88a",
        "#e74a3b"
    ];

    new Chart("bieudotron", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            maintainAspectRatio: false,
            tooltips: {
                backgroundColor: "rgb(255,255,255)",
                bodyFontColor: "#858796",
                borderColor: "#dddfeb",
                borderWidth: 1,
                xPadding: 15,
                yPadding: 15,
                displayColors: false,
                caretPadding: 10,
            },
            legend: {
                display: false,
            },
        },
    });
</script>


@stop