<?php

use App\Http\Controllers\Admin\AdminAjaxController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\ShopAjaxController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
// for shop page
Route::get('/shop', [HomeController::class, 'shop'])->name('shop');
// for shop laptop detail page
Route::get('/shop/detail/{id}', [HomeController::class, 'shopDetail'])->name('shop.detail');
// for all brands page when click view more
Route::get('/shop/all-brands', [HomeController::class, 'allBrands'])->name('shop.brands');
// for all laptops page when click view more
Route::get('/shop/all-laptops', [HomeController::class, 'allLaptops'])->name('shop.laptops');
// for search laptops in search bar
Route::get('/shop/search-filter', [HomeController::class, 'searchLaptops'])->name('shop.search');
// for search laptops by clicking brand
Route::get('/shop/search-by-brand/{id}', [HomeController::class, 'searchByBrand'])->name('shop.searchBrand');

Route::middleware(['auth'])->group(function () {
    // Admin
    Route::group(['prefix' => 'admin', 'middleware' => 'isAdmin'], function () {
        // Admin Profile
        Route::get('/profile', [AdminController::class, 'index'])->name('adminProfile.index');
        // for profile edit page
        Route::get('/profile/edit', [AdminController::class, 'edit'])->name('adminProfile.edit');
        // for update profile
        Route::post('/profile/update', [AdminController::class, 'update'])->name('adminProfile.update');

        // Password
        // for password change page
        Route::get('/password/change', [AdminController::class, 'passwordChange'])->name('adminPassword.change');
        // for password update
        Route::post('/password/update', [AdminController::class, 'passwordUpdate'])->name('adminPassword.update');

        // Brands
        Route::resource('brands', BrandController::class);

        // Products
        Route::resource('products', ProductController::class);

        // Orders
        Route::get('/orders', [OrderController::class, 'orders'])->name('admin.orders');
        // for order details
        Route::get('/orders/detail/{id}', [OrderController::class, 'detail'])->name('admin.orderDetail');
        // for delete order
        Route::post('/orders/delete/{id}', [OrderController::class, 'delete'])->name('admin.orderDelete');

        // Ajax
        // for change product status with ajax
        Route::get('/change-product-status', [AdminAjaxController::class, 'changeStatus']);
        // for change order status with ajax
        Route::get('/change-order-status', [AdminAjaxController::class, 'orderStatus']);
    });

    // User
    Route::group(['prefix' => 'shop/products', 'middleware' => 'isUser'], function () {
        // Shop Ajax
        // for rating product with ajax
        Route::get('/ratings', [ShopAjaxController::class, 'rateProduct']);
        // for add to cart with ajax
        Route::get('/add-to-cart', [ShopAjaxController::class, 'addToCart']);
        // for delete cart product when cross btn in cart page
        Route::get('/ajax/clear-current-product', [ShopAjaxController::class, 'clearCartProduct']);
        // for add orderList after proceed to checkout
        Route::get('/ajax/proceed-to-checkout', [ShopAjaxController::class, 'proceedCheckout']);

        // Cart
        Route::get('/cart', [ShopController::class, 'cartPage'])->name('shop.cartPage');
        // Checkout
        Route::get('/checkout', [ShopController::class, 'checkout'])->name('shop.checkout');
    });

    // User
    // Profile
    Route::group(['prefix' => 'profile', 'middleware' => 'isUser'], function () {
        // for profile index
        Route::get('/index', [ProfileController::class, 'index'])->name('userProfile.index');
        // for profile edit
        Route::get('/edit', [ProfileController::class, 'edit'])->name('userProfile.edit');
        // for update profile
        Route::post('/update', [ProfileController::class, 'update'])->name('userProfile.update');

        // for password change page
        Route::get('/password/change', [ProfileController::class, 'passwordChange'])->name('userPassword.change');
        // for password update
        Route::post('/password/update', [ProfileController::class, 'passwordUpdate'])->name('userPassword.update');
    });
});
