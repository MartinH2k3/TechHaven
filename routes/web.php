<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrowseController;

// Authentication Routes
Route::get('login', [AuthController::class, 'loginView'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'registerView']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/', function () {
    return view('homepage');
})->name('homepage');;


Route::get('/browse', [BrowseController::class, 'index'])->name('browse');

Route::get('/product/{product_id}', function () {
    return view('homepage');
})->name('product-page');

Route::post('/product/{product_id}/upload-image', [ProductController::class, 'uploadProductImage'])->name('product.upload-image');

Route::get('/admin-page', function () {
    return view('admin-page');
})->name('admin-page');

Route::get('/admin-add', function () {
    return view('admin-add');
})->name('admin-add');

Route::get('/admin-manage', function () {
    return view('admin-manage');
})->name('admin-manage');
