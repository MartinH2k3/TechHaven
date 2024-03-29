<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BrowseController;

Route::get('/', function () {
    return view('homepage');
})->name('homepage');;


Route::get('/browse', [BrowseController::class, 'index'])->name('browse');
