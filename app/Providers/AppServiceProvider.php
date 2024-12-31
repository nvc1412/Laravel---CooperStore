<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Logo;
use App\Models\Product;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {

        view()->composer(["master.main", "home.category", "home.shop", "home.policy"], function ($view) {
            $cats = Category::orderBy("name", "asc")->select("id", "name")->get();
            $view->with(compact("cats"));
        });

        view()->composer(["home.category", "home.profile", "home.reset_password", "home.shop", "home.policy"], function ($view) {
            $discount_products = Product::inRandomOrder()->where("products.discount", ">", 0)->limit(3)->get();
            $view->with(compact("discount_products"));
        });

        view()->composer("*", function ($view) {
            $header_logo = Logo::getLogo("Header-Logo")->first();
            $footer_logo = Logo::getLogo("footer-Logo")->first();
            $web_logo = Logo::getLogo("web-Logo")->first();
            $carts = Cart::where("user_id", auth()->id())->orderBy("created_at", "DESC")->get();
            $view->with(compact("header_logo", "footer_logo", "web_logo", "carts"));
        });
    }
}