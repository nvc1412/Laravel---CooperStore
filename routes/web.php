<?php

use App\Http\Controllers\Admin\AccountADController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BillController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LogoController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\RatingController;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



// TRANG NGƯỜI DÙNG

Route::group(["prefix" => ""], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home.index');
    Route::get('/shop', [HomeController::class, 'showShop'])->name('home.shop');
    Route::get('/policy', [HomeController::class, 'showPolicy'])->name('home.policy');
    Route::get('/category/{category}', [HomeController::class, 'showCategory'])->name('home.category');
    Route::get('product-detail/{product}', [HomeController::class, 'showProductDetail'])->name('home.showProductDetail');
    Route::get('/favorite/{product}', [HomeController::class, 'favorite'])->name('home.favorite')->middleware("customer");
});

Route::group(["prefix" => "account"], function () {
    Route::post('/login', [AccountController::class, 'checkLogin'])->name('account.login');
    Route::get('/logout', [AccountController::class, 'logout'])->name('account.logout');
    Route::get('/verify-account/{email}', [AccountController::class, 'verify'])->name('account.verify');
    Route::post('/register', [AccountController::class, 'checkRegister'])->name('account.register');
    Route::post('/forgot-password', [AccountController::class, 'forgotPassword'])->name('account.forgotPassword');
    Route::get('/reset-password/{token}', [AccountController::class, 'showResetPassword'])->name('account.showResetPassword');
    Route::post('/reset-password/{token}', [AccountController::class, 'resetPassword']);

    Route::group(["middleware" => "customer"], function () {
        Route::get('/profile', [AccountController::class, 'profile'])->name('account.profile');
        Route::post('/profile', [AccountController::class, 'updateProfile']);
        Route::post('/change-password', [AccountController::class, 'changePassword'])->name('account.changePassword');
        Route::get('/favorite', [AccountController::class, 'showFavorite'])->name("account.showFavorite");
        Route::get('/history', [AccountController::class, 'showHistory'])->name("account.showHistory");
        Route::get('/history-detail/{bill}', [AccountController::class, 'showHistoryDetail'])->name("account.showHistoryDetail");
        Route::get('/history/cancel/{bill}', [AccountController::class, 'cancel'])->name("account.cancel");
        Route::get('/history/complete/{bill}', [AccountController::class, 'complete'])->name("account.complete");

        Route::post('/rating/{product}', [AccountController::class, 'rating'])->name('account.rating');

    });
});

Route::group(["prefix" => "cart", "middleware" => "customer"], function () {
    Route::get('/', [CartController::class, 'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::post('/update/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::get('/update/plus/{product}/{productDetailId}', [CartController::class, 'updatePlus'])->name('cart.updatePlus');
    Route::get('/update/munis/{product}/{productDetailId}', [CartController::class, 'updateMinus'])->name('cart.updateMinus');
    Route::get('/delete/{product}/{productDetailId}', [CartController::class, 'delete'])->name('cart.delete');
    Route::get('/clear', [CartController::class, 'clear'])->name('cart.clear');

    Route::get('/buy-again/{bill}', [CartController::class, 'buyAgain'])->name('cart.buyAgain');
});

Route::group(["prefix" => "check-out", "middleware" => "customer"], function () {
    Route::get('/', [OrderController::class, 'index'])->name('checkout.index');
    Route::get('/return-vnpay/{bill}', [OrderController::class, 'returnVnpay'])->name("checkout.returnVnpay");
    Route::get('/return-momo/{bill}', [OrderController::class, 'returnMomo'])->name("checkout.returnMomo");
    Route::post('/', [OrderController::class, 'checkOut']);
    Route::get('/{token}', [OrderController::class, 'verifyBill'])->name('checkout.verifyBill');
});





// TRANG QUẢN TRỊ ADMIN

Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'checkLogin']);

Route::group(["prefix" => "admin", "middleware" => ["auth", "admin"]], function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

    Route::resource("category", CategoryController::class);
    Route::resource("banner", BannerController::class);
    Route::resource("logo", LogoController::class);
    Route::resource("product", ProductController::class);

    Route::get("product-deleteimage/{image}", [ProductController::class, "destroyImage"])->name("product.destroyImage");

    Route::get("product-createdetail/{productId}", [ProductController::class, "createDetail"])->name("product.createDetail");
    Route::post("product-updatedetail", [ProductController::class, "updateDetail"])->name("product.updateDetail");
    Route::get("product-deletedetail/{productDetail}", [ProductController::class, "deleteDetail"])->name("product.deleteDetail");

    Route::group(["prefix" => "bill"], function () {
        Route::get('/', [BillController::class, 'index'])->name('bill.index');
        Route::get('/preparing', [BillController::class, 'preparing'])->name('bill.preparing');
        Route::post('/print-bill', [BillController::class, 'printBill'])->name('bill.printBill');
        Route::get('/export-excel', [BillController::class, 'exportExcel'])->name('bill.exportExcel');
        Route::get('/bill-detail/{bill}', [BillController::class, 'showDetailBill'])->name('bill.showDetailBill');
    });

    Route::group(["prefix" => "accountAD"], function () {
        Route::get('/', [AccountADController::class, 'index'])->name('accountAD.index');
        Route::post('/update', [AccountADController::class, 'update'])->name('accountAD.update');
        Route::post('/destroy', [AccountADController::class, 'destroy'])->name('accountAD.destroy');
    });

    Route::group(["prefix" => "rating"], function () {
        Route::get('/', [RatingController::class, 'index'])->name('rating.index');
        Route::post('/destroy', [RatingController::class, 'destroy'])->name('rating.destroy');
    });
});
