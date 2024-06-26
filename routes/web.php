<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\CheckStage;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrowseController;

// Authentication Routes
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::get('register', [AuthController::class, 'registerView'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    return view('customer.homepage');
})->name('homepage');;


Route::get('/browse', [BrowseController::class, 'index'])->name('browse');

Route::post('/product/{product_id}/upload-image', [ProductController::class, 'uploadProductImage'])->name('product.upload-image');

Route::get('/admin-page', function () {
    return view('admin.main');
})->middleware(AdminMiddleware::class)->name('admin-page');

Route::get('/admin-add', function () {
    return view('admin.add');
})->middleware(AdminMiddleware::class)->name('admin.add');

Route::post('/admin-add', [ProductController::class, 'store'])->middleware(AdminMiddleware::class)->name('admin.add');

// Search in admin
Route::get('/admin-search', [ProductController::class, 'search'])->middleware(AdminMiddleware::class)->name('admin.search');

// Changing and deleting products in admin
Route::get('/admin-manage/{id}', [ProductController::class, 'showManage'])->middleware(AdminMiddleware::class)->name('admin.manage');
Route::post('/admin-manage', [ProductController::class, 'manage'])->middleware(AdminMiddleware::class)->name('admin.manage.post');
// Removing an image from a product in admin when managing a product
Route::delete('/admin/remove_image/{imageId}', [ProductController::class, 'removeImage'])->name('admin.remove_image');


Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('product-page');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

// Updating cart quantity
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');

// Removing item from cart
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Refreshing stage 1 of the cart
Route::get('/cart/refresh', [CartController::class, 'refreshCart'])->name('cart.refresh');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show')->middleware(CheckStage::class);

// Payment and delivery form, address form, and order summary
Route::post('/cart/paymentDelivery', [CartController::class, 'submitPaymentAndDelivery'])->name('cart.paymentDelivery.submit');
Route::post('/cart/address', [CartController::class, 'submitAddress'])->name('cart.address.submit');
Route::post('/cart/summary', [CartController::class, 'createOrder'])->name('cart.summary.order.submit');



