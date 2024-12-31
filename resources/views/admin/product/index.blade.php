@extends("master.admin")
@section("title", "Quản lý sản phẩm")
@section("product", "active")
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
                <h4 class="m-0 font-weight-bold text-primary">Danh sách sản phẩm</h4>
                <a class='btn btn-success' href="{{ route('product.create') }}"><i title='Thêm mới sản phẩm'
                        class='fa fa-plus'></i>
                    Thêm</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th width="25px">STT</th>
                                <th width="100px">Hình ảnh</th>
                                <th>Tên sản phẩm</th>
                                <th width="190px">Danh mục</th>
                                <th>Giá bán (VNĐ)</th>
                                <th>Giá giảm (VNĐ)</th>
                                <th width="100px">Tổng SL</th>
                                <th width="130px"></th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($products as $i => $product)
                            <form action="{{ route('product.update', $product->id) }}" method="POST">
                                @csrf @method('PUT')
                                <tr>
                                    <td>{{ $i + 1 + ($products->currentPage() - 1) * $products->perPage() }}</td>
                                    <td><img width="50px" height="50px" src="/img/products/{{$product->image}}" alt="">
                                    </td>
                                    <td><input required class="form-control" type="text" name="name"
                                            value="{{$product->name}}"></td>
                                    <td>
                                        <select class='form-control' name="category_id">
                                            @foreach($categories as $category)
                                            <option value="{{$category->id}}"
                                                {{ ($product->category_id) == ($category->id) ? "selected" : "" }}>
                                                {{$category->name}}
                                            </option>;
                                            @endforeach
                                        </select>
                                    </td>
                                    <td><input required class="form-control" type="text" name="price"
                                            value="{{$product->price}}"></td>
                                    <td><input required class="form-control" type="text" name="discount"
                                            value="{{$product->discount}}"></td>
                                    <td>{{$product->quantity}}</td>
                                    <input type="hidden" name="description" value="{{$product->description}}">
                                    <td class="text-center">
                                        <button class='btn btn-sm btn-primary' type='submit' name='submit'><i
                                                title='Cập nhật nhanh' class='fa fa-save'></i></button>
                            </form>

                            <a class='btn btn-sm btn-warning' href="{{ route('product.edit', $product->id) }}"><i
                                    title='Cập nhật sản phẩm' class='fa fa-edit'></i>
                            </a>

                            <form class="d-inline " action="{{ route('product.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                @csrf @method('DELETE')
                                <button class='btn btn-sm btn-danger' type='submit' name='submit'><i
                                        title='Xóa sản phẩm' class='fa fa-trash'></i></button>
                            </form>
                            </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if($products->count() <= 0) <p class='lead text-center'><em>Hiện chưa có sản phẩm nào, vui lòng
                            thêm
                            sản phẩm!</em>
                        </p>
                        @endif
                        <div class="pagination justify-content-end">
                            <li class="paginate_button page-item previous"><a href="{{ $products->url(1) }}"
                                    class="page-link">&laquo;&laquo;</a>
                            </li>
                            {{$products->links('pagination::bootstrap-4')}}
                            <li class="paginate_button page-item next"><a
                                    href="{{ $products->url($products->lastPage()) }}"
                                    class="page-link">&raquo;&raquo;</a>
                            </li>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop()