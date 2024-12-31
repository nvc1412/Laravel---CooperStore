<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Models\Category;
use App\Models\Product;
use App\Services\HomeService;

class HomeController extends Controller
{
    protected $homeService;

    public function __construct(HomeService $homeService)
    {
        $this->homeService = $homeService;
    }

    public function index()
    {
        $list_new_product = $this->homeService->getListNewProduct();
        $list_trending_product = $this->homeService->getListTrendingProduct();
        $list_banner = $this->homeService->getListBanner();

        return view("home.index", compact("list_new_product", "list_trending_product", "list_banner"));
    }

    public function showProductDetail(Product $product)
    {
        $list_recommend_product = $this->homeService->getListRecommendProduct($product->category_id);
        return view("home.product_detail", compact("product", "list_recommend_product"));
    }

    public function showShop(ShopRequest $request)
    {
        [$minPrice, $maxPrice] = $this->homeService->getMinMaxPrice();

        $fromPrice = $request->input('fromPrice', $minPrice);
        $toPrice = $request->input('toPrice', $maxPrice);
        $perPage = $request->input('show', 9);
        $sort = $request->input('sort', 'default');

        $products = $this->homeService->filterAndSortProducts(null, $fromPrice, $toPrice, $sort, $perPage);

        return view('home.shop', compact('products', 'perPage', 'sort', 'fromPrice', 'toPrice', 'minPrice', 'maxPrice'));
    }

    public function showPolicy()
    {
        return view('home.policy');
    }

    public function showCategory(ShopRequest $request, Category $category)
    {
        if (!$category->products()->count()) {
            session()->flash("error", "Danh mục chưa có sản phẩm!");
            return redirect()->back();
        }
        [$minPrice, $maxPrice] = $this->homeService->getMinMaxPrice($category);

        $fromPrice = $request->input('fromPrice', $minPrice);
        $toPrice = $request->input('toPrice', $maxPrice);
        $perPage = $request->input('show', 9);
        $sort = $request->input('sort', 'default');

        $products = $this->homeService->filterAndSortProducts($category, $fromPrice, $toPrice, $sort, $perPage);

        return view('home.category', compact('category', 'products', 'perPage', 'sort', 'fromPrice', 'toPrice', 'minPrice', 'maxPrice'));
    }

    public function favorite($productId)
    {
        try {
            $this->homeService->favorite($productId);
            session()->flash("success", "Cập nhật danh sách yêu thích thành công!");
            return redirect()->back();
        } catch (\Exception $e) {
            session()->flash("error", $e->getMessage());
            return redirect()->back();
        }
    }
}