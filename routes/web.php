<?php

use App\Http\Controllers\WeddingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Business Card routes
Route::get('/p/{slug}', [\App\Http\Controllers\BusinessCardController::class, 'show'])->name('business_card.show');

// Wedding routes - ĐẶT Ở CUỐI để hứng mọi slug
Route::match(['get', 'post'], '/{slug}', [WeddingController::class, 'show'])
    ->name('wedding.show')
    ->where('slug', '[a-zA-Z0-9\-]+');
