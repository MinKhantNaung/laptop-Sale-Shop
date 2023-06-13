<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\User\ShopController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\User\ShopAjaxController;
use App\Http\Controllers\Admin\AdminAjaxController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\User\BlogAjaxController;
use App\Http\Controllers\User\ContactAjaxController;
use App\Models\Contact;

Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop
Route::group(['prefix' => 'shop'], function() {
    // for shop page
    Route::get('/', [HomeController::class, 'shop'])->name('shop');
    // for shop laptop detail page
    Route::get('/detail/{id}', [HomeController::class, 'shopDetail'])->name('shop.detail');
    // for all brands page when click view more
    Route::get('/all-brands', [HomeController::class, 'allBrands'])->name('shop.brands');
    // for all laptops page when click view more
    Route::get('/all-laptops', [HomeController::class, 'allLaptops'])->name('shop.laptops');
    // for search laptops in search bar
    Route::get('/search-filter', [HomeController::class, 'searchLaptops'])->name('shop.search');
    // for search laptops by clicking brand
    Route::get('/search-by-brand/{id}', [HomeController::class, 'searchByBrand'])->name('shop.searchBrand');
});

// for contact page
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');

// Blog
Route::group(['prefix' => 'blog'], function() {
    // for blog page
    Route::get('/posts', [HomeController::class, 'blog'])->name('blog');
    // for search posts by category
    Route::get('/posts/search-by-category/{id}', [HomeController::class, 'searchByCategory'])->name('blog.categorySearch');
    // for search posts with input
    Route::get('/posts/search-by', [HomeController::class, 'searchPosts'])->name('blog.search');
    // for post detail page
    Route::get('/posts/detail/{id}', [HomeController::class, 'postDetail'])->name('blog.detail');
});

// Authenticated
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

        // Shop
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

        // Shop Ajax
        // for change product status with ajax
        Route::get('/change-product-status', [AdminAjaxController::class, 'changeStatus']);
        // for change order status with ajax
        Route::get('/change-order-status', [AdminAjaxController::class, 'orderStatus']);

        // Blog
        // Categories
        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.categories');
            // for category create page
            Route::get('/create', [CategoryController::class, 'createPage'])->name('admin.categoryCreatePage');
            // for create category
            Route::post('/create', [CategoryController::class, 'create'])->name('admin.categoryCreate');
            // for category edit page
            Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('admin.categoryEdit');
            // for category update
            Route::post('/update/{id}', [CategoryController::class, 'update'])->name('admin.categoryUpdate');
            // for delete category
            Route::post('/delete/{id}', [CategoryController::class, 'delete'])->name('admin.categoryDelete');
        });

        // Blog
        // Posts
        Route::group(['prefix' => 'posts'], function() {
            Route::get('/', [PostController::class, 'index'])->name('admin.posts');
            // for post create page
            Route::get('/create', [PostController::class, 'createPage'])->name('admin.postCreatePage');
            // for create post
            Route::post('/create', [PostController::class, 'create'])->name('admin.postCreate');
            // for post edit page
            Route::get('/edit/{id}', [PostController::class, 'edit'])->name('admin.postEdit');
            // for update post
            Route::post('/update/{id}', [PostController::class, 'update'])->name('admin.postUpdate');
            // for delete post
            Route::post('/delete/{id}', [PostController::class, 'delete'])->name('admin.postDelete');

            // Post Comments
            Route::get('/{id}/comments', [PostController::class, 'comments'])->name('admin.postComments');
            // for toggle comment show/hide with ajax
            Route::get('/comments/ajax/manage', [AdminAjaxController::class, 'manageComment'])->name('admin.manageComment');
        });

        // Manage Users
        Route::group(['prefix' => 'users'], function() {
            Route::get('/list', [AdminController::class, 'usersList'])->name('admin.usersList');
            // for admins list with role admin
            Route::get('/with-admin-role', [AdminController::class, 'adminsList'])->name('admin.adminsList');
            // for users list with role user
            Route::get('/with-user-role', [AdminController::class, 'normalUsers'])->name('admin.normalUsers');
            // for create user page by admin
            Route::get('/create', [AdminController::class, 'createUserPage'])->name('admin.createUserPage');
            // for create user by admin
            Route::post('/create-user', [AdminController::class, 'createUser'])->name('admin.createUser');
        });

        // Users Ajax
        // for change role with ajax
        Route::get('/users/change-role', [AdminAjaxController::class, 'changeRole'])->name('admin.changeRole');

        // Contact
        Route::group(['prefix' => 'contact'], function () {
            Route::get('/', [ContactController::class, 'index'])->name('admin.contact');
            // for create contact page
            Route::get('/create', [ContactController::class, 'createContactPage'])->name('admin.createContactPage');
            // for create contact
            Route::post('/create', [ContactController::class, 'createContact'])->name('admin.createContact');
            // for edit contact page
            Route::get('/edit/{id}', [ContactController::class, 'editContact'])->name('admin.editContact');
            // for update contact
            Route::post('/update/{id}', [ContactController::class, 'updateContact'])->name('admin.updateContact');
            // Messages
            Route::get('/messages', [ContactController::class, 'viewMessages'])->name('admin.messages');
            // for delete messages
            Route::post('/messages/delete/{id}', [ContactController::class, 'deleteMessage'])->name('admin.deleteMessage');
        });
    });

    // User
    // Shop
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

    // User
    // Blog
    Route::get('/blog/posts/ajax/like', [BlogAjaxController::class, 'like'])->name('blog.ajaxLike');
    // to add comment with ajax
    Route::get('/blog/posts/ajax/comment', [BlogAjaxController::class, 'comment'])->name('blog.ajaxComment');
    // to delete comment with ajax
    Route::get('/blog/posts/ajax/delete-comment', [BlogAjaxController::class, 'deleteComment'])->name('blog.ajaxCommentDelete');

    // User
    // for storing message from contact form with ajax
    Route::get('/contact-message', [ContactAjaxController::class, 'messageAccept'])->name('contact.messageAccept');
});



