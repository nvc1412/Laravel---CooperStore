<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $categories = $this->categoryService->getCategories();
        return view("admin.category.index", compact("categories"));
    }

    public function store(CategoryRequest $request)
    {
        if ($this->categoryService->createCategory($request->validated())) {
            session()->flash("success", "Thêm danh mục thành công!");
            return redirect()->route("category.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function update(CategoryRequest $request, Category $category)
    {
        if ($this->categoryService->updateCategory($request->validated(), $category)) {
            session()->flash("success", "Cập nhật danh mục thành công!");
            return redirect()->route("category.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }

    public function destroy(Category $category)
    {
        if ($this->categoryService->deleteCategory($category)) {
            session()->flash("success", "Xóa danh mục thành công!");
            return redirect()->route("category.index");
        }
        session()->flash("error", "Đã có lỗi xảy ra!");
        return redirect()->back();
    }
}