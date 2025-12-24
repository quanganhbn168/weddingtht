<?php

use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Wedding routes - ĐẶT Ở CUỐI để hứng mọi slug
Route::match(['get', 'post'], '/{slug}', [WeddingController::class, 'show'])
    ->name('wedding.show')
    ->where('slug', '[a-zA-Z0-9\-]+');
