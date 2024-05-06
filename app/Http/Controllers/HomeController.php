<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $news_pros_quan = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'like', '%quần%')
            ->orderBy('products.created_at', 'desc')
            ->limit(8)
            ->select("products.id", "products.name", "products.image", "products.price", "products.discount")
            ->get();

        $news_pros_ao = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'like', '%áo%')
            ->orderBy('products.created_at', 'desc')
            ->limit(8)
            ->select("products.id", "products.name", "products.image", "products.price", "products.discount")
            ->get();

        $news_pros_phukien = Product::join('categories', 'products.category_id', '=', 'categories.id')
            ->where('categories.name', 'like', '%phụ kiện%')
            ->orderBy('products.created_at', 'desc')
            ->limit(8)
            ->select("products.id", "products.name", "products.image", "products.price", "products.discount")
            ->get();

        $trends_pros = Product::inRandomOrder()->select("products.id", "products.name", "products.image", "products.price", "products.discount")->limit(8)->get();

        $top_bans = Banner::getBanner("Top-Banner")->get();
        $bottom_bans = Banner::getBanner("Bottom-Banner")->get();

        return view("home.index", compact("news_pros_quan", "news_pros_ao", "news_pros_phukien", "trends_pros", "top_bans", "bottom_bans"));
    }

    public function showProductDetail(Product $product)
    {
        $recommends_pros = Product::where("category_id", $product->category_id)->limit(8)->get();
        return view("home.product_detail", compact("product", "recommends_pros"));
    }

    public function showShop(Request $request){
        $request->validate([
            'show' => 'nullable|in:9,30,90',
            'sort' => 'nullable|in:default,price-asc,price-desc',
            'fromPrice' => 'nullable|numeric',
            'toPrice' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ( (int)$value <= (int)$request->fromPrice) {
                        $fail('toPrice phải lớn hơn fromPrice.');
                    }
                },
            ],
        ]);

        // Lấy giá sản phẩm thấp nhất và giá sản phẩm cao nhất
        $minPrice = Product::selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')->orderBy('effective_price', 'asc')->first()->effective_price -10000;
        $maxPrice = Product::selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')->orderBy('effective_price', 'desc')->first()->effective_price +10000;

        $fromPrice = $request->input('fromPrice', $minPrice);
        $toPrice = $request->input('toPrice', $maxPrice);

        $perPage = $request->input('show', 9);
        $sort = $request->input('sort', 'default');
        
        $products = 0;
        if ($sort == 'default') {
            $products = Product::whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                            ->orderBy('created_at', 'desc')->paginate($perPage);
        } elseif ($sort == 'price-asc') {
            $products = Product::select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                            ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                            ->orderBy('effective_price', 'asc')->paginate($perPage);
        } elseif ($sort == 'price-desc') {
            $products = Product::select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                            ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                            ->orderBy('effective_price', 'desc')->paginate($perPage);
        }

        return view('home.shop', compact('products', 'perPage', 'sort', 'fromPrice', 'toPrice', 'minPrice', 'maxPrice'));
    }

    public function showCategory(Request $request, Category $category)
    {
        $request->validate([
            'show' => 'nullable|in:9,30,90',
            'sort' => 'nullable|in:default,price-asc,price-desc',
            'fromPrice' => 'nullable|numeric',
            'toPrice' => [
                'nullable',
                'numeric',
                function ($attribute, $value, $fail) use ($request) {
                    if ( (int)$value <= (int)$request->fromPrice) {
                        $fail('toPrice phải lớn hơn fromPrice.');
                    }
                },
            ],
        ]);

        // Lấy giá sản phẩm thấp nhất và giá sản phẩm cao nhất
        $minPrice = $category->products()->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')->orderBy('effective_price', 'asc')->first()->effective_price -10000;
        $maxPrice = $category->products()->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')->orderBy('effective_price', 'desc')->first()->effective_price +10000;

        $fromPrice = $request->input('fromPrice', $minPrice);
        $toPrice = $request->input('toPrice', $maxPrice);

        $perPage = $request->input('show', 9);
        $sort = $request->input('sort', 'default');
        
        $products = 0;
        if ($sort == 'default') {
            $products = $category->products()->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                            ->orderBy('created_at', 'desc')->paginate($perPage);
        } elseif ($sort == 'price-asc') {
            $products = $category->products()->select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                            ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                            ->orderBy('effective_price', 'asc')->paginate($perPage);
        } elseif ($sort == 'price-desc') {
            $products = $category->products()->select('*')->selectRaw('CASE WHEN discount = 0 THEN price ELSE discount END AS effective_price')
                            ->whereRaw('CASE WHEN discount = 0 THEN price ELSE discount END BETWEEN ? AND ?', [$fromPrice, $toPrice])
                            ->orderBy('effective_price', 'desc')->paginate($perPage);
        }

        return view("home.category", compact('category','products', 'perPage', 'sort', 'fromPrice', 'toPrice', 'minPrice', 'maxPrice'));
    }

    public function favorite($product_id)
    {
        $data = [
            "user_id" => auth()->id(),
            "product_id" => $product_id
        ];
        $favorited = Favorite::where(["user_id" => auth()->id(), "product_id" => $product_id])->first();
        if ($favorited) {
            $favorited->delete();
            return redirect()->back()->with("success", "Đã xóa sản phẩm khỏi danh sách yêu thích!");
        } else {
            if (Favorite::create($data)) {
                return redirect()->back()->with("success", "Đã thêm sản phẩm vào danh sách yêu thích!");
            }
            return redirect()->back()->with("error", "Đã có lỗi xảy ra!");
        }
    }
}