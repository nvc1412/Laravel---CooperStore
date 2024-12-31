@extends("master.admin")
@section("title", "Thêm sản phẩm")
@section("product", "active")
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
            <form action="{{ route('product.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="card-header py-3 d-flex justify-content-between align-items-center">
                    <h4 class="m-0 font-weight-bold text-success">Thông tin sản phẩm mới</h4>
                    <button class='btn btn-primary' type="submit"><i title='Thêm' class='fa fa-save'></i>
                        Lưu</button>
                </div>
                <div class="card-body d-flex justify-content-around">
                    <div class="card shadow mb-4 col-7 mr-2">
                        <div class="card-body">
                            <label for="name">Tên sản phẩm</label>
                            <input required placeholder="Nhập tên sản phẩm" id="name" type="text" name="name"
                                class="form-control">
                            @error('name') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="short_description">Mô Tả ngắn</label>
                            <textarea class="form-control" id="short_description" name="short_description" rows="4"
                                cols="50"></textarea>
                            <br>
                            <label for="description">Mô Tả</label>
                            <textarea class="form-control product-description" id="description" name="description"
                                rows="10" cols="50"></textarea>
                            <hr>
                            <label for="other_image">Hình ảnh chi tiết</label>
                            <input id="gallery-photo-add" class="mb-4 w-100" type="file" name="other_image[]"
                                accept="image/*" multiple>
                            <div class="row gallery">

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
                                            <div id="addDetailProduct" class='btn btn-sm btn-success'><i
                                                    title='Thêm chi tiết sản phẩm' class='fa fa-plus'></i> </div>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- <tr>
                                        <td>1</td>
                                        <td><input required class="form-control" type="text" name="size" value="S">
                                        </td>
                                        <td><input required class="form-control" type="number" min="0" name="quantity"
                                                value="123"></td>
                                        <td class="text-center">
                                            <button class='btn btn-sm btn-primary' type='submit' name='submit'><i title='Cập nhật nhanh' class='fa fa-save'></i></button>

                                            <div class='btn btn-sm btn-danger deleteRow'><i
                                                    title='Xóa chi tiết sản phẩm' class='fa fa-trash deleteRow'></i>
                                            </div>
                                        </td>
                                    </tr> -->
                                </tbody>
                            </table>
                            <p id="emptyMessage" class='lead text-center'><em>Vui lòng thêm chi tiết
                                    sản phẩm!</em>
                            </p>
                            <hr>

                            <label for="category_id">Danh mục</label>
                            <select required id="category_id" class='form-control' name="category_id">
                                @foreach($categories as $category)
                                <option value="{{$category->id}}">
                                    {{$category->name}}
                                </option>;
                                @endforeach
                            </select>
                            @error('category_id') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="price">Giá</label>
                            <input required id="price" type="number" min="0" name="price" class="form-control">
                            @error('price') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="discount">Giá giảm</label>
                            <input id="discount" type="number" min="0" name="discount" class="form-control">
                            @error('discount') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <br>
                            <label for="image">Hình ảnh chính</label>
                            <input class="mb-4" required type="file" onchange="readURL(this);" name="image" id="image"
                                accept="image/*">
                            @error('image') <small class="text-danger">* {{ $message }}</small>
                            @enderror
                            <div class="text-center">
                                <img width="100%" id="previewImg" alt="" />
                            </div>
                        </div>
                    </div>
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
// Hàm cập nhật lại chỉ số STT
function updateSTT() {
    var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
    var rows = table.getElementsByTagName('tr');
    var emptyMessage = document.getElementById('emptyMessage');
    for (var i = 0; i < rows.length; i++) {
        rows[i].getElementsByTagName('td')[0].innerHTML = i + 1;
    }
    if (table.rows.length === 0) {
        emptyMessage.style.display = 'block'; // Hiển thị thông báo khi bảng rỗng
    } else {
        emptyMessage.style.display = 'none'; // Ẩn thông báo khi bảng có dữ liệu
    }
}

document.getElementById('addDetailProduct').addEventListener('click', function() {
    var table = document.getElementById('dataTable').getElementsByTagName('tbody')[0];
    var newRow = table.insertRow(table.rows.length);
    var cell1 = newRow.insertCell(0);
    var cell2 = newRow.insertCell(1);
    var cell3 = newRow.insertCell(2);
    var cell4 = newRow.insertCell(3);

    cell1.innerHTML = table.rows.length; // STT
    cell2.innerHTML = "<input required class='form-control' type='text' name='size[]'>";
    cell3.innerHTML = "<input required class='form-control' type='number' min='0' name='quantity[]'>";
    cell4.innerHTML =
        "<td class='text-center'><div class='btn btn-sm btn-danger deleteRow'><i title='Xóa chi tiết sản phẩm' class='fa fa-trash deleteRow'></i></div></td>";

    updateSTT();
});
document.addEventListener('click', function(e) {
    if (e.target && e.target.classList.contains('deleteRow')) {
        var row = e.target.closest('tr');
        row.parentNode.removeChild(row);
        updateSTT();
    }
});
</script>
<script>
$(".product-description").summernote({
    height: 250,
});
</script>
@stop
