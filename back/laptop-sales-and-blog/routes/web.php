<?php

use App\Http\Controllers\Admin\AdminAjaxController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\User\ShopAjaxController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\HomeController;
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
    Route::group(['prefix' => 'admin'], function () {
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

        // Ajax
        // for change product status with ajax
        Route::get('/change-product-status', [AdminAjaxController::class, 'changeStatus']);
    });

    // User
    // Shop Ajax
    Route::get('/shop/products/ratings', [ShopAjaxController::class, 'rateProduct']);
});
