<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $cats = Category::orderBy("id", "desc")->paginate(10);
        return view("admin.category.index", compact("cats"))->with("i", (request()->input("page", 1) - 1) * 10);
    }

    public function store(Request $request)
    {
        $request->validate([
            "name" => "required|unique:categories",
        ]);
        $data = $request->all("name");
        Category::create($data);

        return redirect()->route("category.index")->with("success", "Thêm mới thành công!");
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            "name" => "required|unique:categories,name," . $category->id,
        ]);
        $data = $request->all("name");
        $category->update($data);
        return redirect()->route("category.index")->with("success", "Cập nhật thành công!");
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route("category.index")->with("success", "Xóa thành công!");
    }
}