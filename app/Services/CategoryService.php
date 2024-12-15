<?php

namespace App\Services;

use App\Models\Category;

class CategoryService
{
    public function getCategories()
    {
        return Category::orderBy("id", "desc")->paginate(10);
    }

    public function createCategory($data)
    {
        return Category::create($data);
    }

    public function updateCategory($data, Category $category)
    {
        return $category->update($data);
    }

    public function deleteCategory(Category $category)
    {
        return $category->delete();
    }
}