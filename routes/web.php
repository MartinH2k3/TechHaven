<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrowseController;

// Authentication Routes
Route::get('login', [AuthController::class, 'loginView'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'registerView']);
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->middleware('auth');


Route::get('/', function () {
    return view('homepage');
})->name('homepage');;


Route::get('/browse', [BrowseController::class, 'index'])->name('browse');

Route::get('/product/{product-id}', function () {
    return view('homepage');
})->name('product-page');;
