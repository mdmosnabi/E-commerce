<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CoreController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\AdminDashboardController;


Route::get('/admin/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminAuthController::class, 'login']);


// Add this for dashboard or any other admin protected routes
Route::middleware('admin')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    //  controll product
    Route::get('/admin/product', [AdminDashboardController::class, 'product'])->name('admin.product');
    Route::get('/admin/product/add', [AdminDashboardController::class, 'productAdd'])->name('admin.product.create');
    Route::post('/admin/product/add', [AdminDashboardController::class, 'productAdd'])->name('admin.product.create');
    Route::delete('/admin/product/add', [AdminDashboardController::class, 'productAdd'])->name('admin.product.create');

    // controll user
    Route::get('/admin/user', [AdminDashboardController::class, 'user'])->name('admin.user');
    Route::get('/admin/user/edit/', [AdminDashboardController::class, 'userEdit'])->name('admin.user.edit');
    Route::post('/admin/user/edit/', [AdminDashboardController::class, 'userEdit'])->name('admin.user.edit');
    Route::delete('/admin/user/edit/', [AdminDashboardController::class, 'userEdit'])->name('admin.user.edit');

    //  controll category
    Route::get('/admin/category', [AdminDashboardController::class, 'category'])->name('admin.category');
    Route::get('/admin/category/edit', [AdminDashboardController::class, 'categoryEdit'])->name('admin.category.edit');
    Route::post('/admin/category/edit', [AdminDashboardController::class, 'categoryEdit'])->name('admin.category.edit');
    Route::delete('/admin/category/edit', [AdminDashboardController::class, 'categoryEdit'])->name('admin.category.edit');

    // payment request controll 
    Route::get('/admin/paymentReq', [AdminDashboardController::class, 'paymentReq'])->name('admin.paymentReq');
    Route::get('/admin/pendingReq', [AdminDashboardController::class, 'pendingReq'])->name('admin.pendingReq');
    Route::get('/admin/cart/{cart_key}', [AdminDashboardController::class, 'paymentReqDetail'])->name('admin.cart.detail');

    // / cart controll
    Route::post('/admin/cart/product',[AdminDashboardController::class, 'detailProduct']);
    Route::get('/admin/accept',[AdminDashboardController::class, 'PreqAccept'])->name('admin.cart.accept');

    Route::post('/admin/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/scripts.js', [AdminDashboardController::class, 'serveAdminJs'])->name('admin.scripts');

});


/// checke koray user login asay ki na 
Route::middleware(['auth.user'])->group(function () {
    Route::post('/order', [CoreController::class, 'makeOrder']);
    Route::get('/cart-items/{cart_key}', [CoreController::class, 'getCartItem'])->name('cart.items');
    Route::get('/delete-cart/{cart_key}', [CoreController::class, 'deleteCart'])->name('cart.delete');
    Route::get('/payment-address/{cart_key}', [CoreController::class, 'payAddress'])->name('payment.address');
    Route::post('/save-billing-address', [CoreController::class, 'saveBillingAddress'])->name('save.billing.address');
    Route::get('/contact',[CoreController::class,'contact'])->name('contact');

});

//  public root any one can access
Route::get('/',[CoreController::class,'home'])->name('home');
Route::get('/product/{id}', [CoreController::class, 'detail'])->name('product.detail');
Route::post('/cart/{id}', [CoreController::class, 'cart'])->name('cart.add');
Route::get('/category/{id}',[CoreController::class, 'category'])->name('category');
Route::post('/api/cart-items', [CoreController::class, 'getCartItems']);
Route::get('/account',[CoreController::class, 'account'])->name('account');
Route::get('/search',[CoreController::class, 'search'])->name('search');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


