<?php

namespace App\Services;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;

class HomeService
{
    protected function newProductQuery(string $product)
    {
        return Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'like', '%' . $product . '%')
            ->orderBy('products.created_at', 'desc')
            ->limit(8)
            ->select("products.id", "products.name", "products.image", "products.price", "products.discount")
            ->get();
    }

    public function getListNewProduct()
    {
        return [
            "new_product_pants" => $this->newProductQuery("quần"),
            "new_product_shirts" => $this->newProductQuery("áo"),
            "new_product_accessories" => $this->newProductQuery("phụ kiện")
        ];
    }

    public function effectivePriceQuery($query, $sort = "ASC")
    {
        return $query->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
            ->orderBy('effective_price', $sort);
    }

    public function getListTrendingProduct()
    {
        return Product::inRandomOrder()
            ->select("products.id", "products.name", "products.image", "products.price", "products.discount")
            ->limit(8)
            ->get();
    }

    public function getListBanner()
    {
        return [
            "list_top_banner" => Banner::getBanner("Top-Banner")->get(),
            "list_bottom_banner" => Banner::getBanner("Bottom-Banner")->get(),
        ];
    }

    public function getListRecommendProduct($categoryID)
    {
        return Product::where("category_id", $categoryID)->limit(8)->get();
    }

    public function getMinMaxPrice(Category $category = null)
    {
        if ($category) {
            $minPrice = $this->effectivePriceQuery($category->products())->first()->effective_price - 10000;
            $maxPrice = $this->effectivePriceQuery($category->products(), "DESC")->first()->effective_price + 10000;
        } else {
            $minPrice = $this->effectivePriceQuery(Product::query())->first()->effective_price - 10000;
            $maxPrice = $this->effectivePriceQuery(Product::query(), "DESC")->first()->effective_price + 10000;
        }

        return [$minPrice, $maxPrice];
    }

    public function filterAndSortProducts(Category $category = null, $fromPrice, $toPrice, $sort, $perPage)
    {

        if ($category) {
            if ($sort == 'price-asc') {
                $query = $category->products()->select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                    ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                    ->orderBy('effective_price', 'ASC');
            } elseif ($sort == 'price-desc') {
                $query = $category->products()->select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                    ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                    ->orderBy('effective_price', 'DESC');
            } else {
                $query = $category->products()->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                    ->orderBy('created_at', 'DESC');
            }
        } else {
            if ($sort == 'price-asc') {
                $query = Product::select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                    ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                    ->orderBy('effective_price', 'ASC');
            } elseif ($sort == 'price-desc') {
                $query = Product::select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                    ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                    ->orderBy('effective_price', 'DESC');
            } else {
                $query = Product::whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                    ->orderBy('created_at', 'DESC');
            }
        }

        return $query->paginate($perPage);
    }

    public function favorite($productId)
    {
        $favorited = Favorite::where(["user_id" => auth()->id(), "product_id" => $productId])->first();
        if ($favorited) {
            return $favorited->delete();
        } else {
            $data = [
                "user_id" => auth()->id(),
                "product_id" => $productId
            ];
            return Favorite::create($data);
        }
    }
}