<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrowseController;
use App\Http\Controllers\PaymentDeliveryController;
use App\Http\Controllers\AddressController;

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

Route::get('/admin-manage', function () {
    return view('admin.manage');
})->middleware(AdminMiddleware::class)->name('admin.manage');

Route::get('/product/{product_id}', [ProductController::class, 'show'])->name('product-page');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');

// Updating cart quantity
Route::post('/cart/update', [CartController::class, 'updateQuantity'])->name('cart.update');

// Removing item from cart
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');

// Refreshing stage 1 of the cart
Route::get('/cart/refresh', [CartController::class, 'refreshCart'])->name('cart.refresh');

Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');

//Route::get('/paymentDelivery', [PaymentDeliveryController::class, 'showPaymentDelivery'])->name('paymentDelivery.show');
//Route::post('/paymentDelivery', [PaymentDeliveryController::class, 'submitPaymentAndDelivery'])->name('paymentDelivery.submit');
Route::post('cart/paymentDelivery', [CartController::class, 'submitPaymentAndDelivery'])->name('cart.paymentDelivery.submit');

//Route::post('/cart/paymentDelivery', [CartController::class, 'showSummary'])->name('cart.summary');

//Route::get('/address', [AddressController::class, 'showAddress'])->name('address.show');
Route::post('/cart/address', [CartController::class, 'submitAddress'])->name('cart.address.submit');

//Route::get('/summary', [OrderController::class, 'showSummary'])->name('summary.show');
//Route::get('/cart/summaryShow', [CartController::class, 'showSummary'])->name('cart.summary.show');
Route::post('/cart/summary', [CartController::class, 'createOrder'])->name('cart.summary.order.submit');



