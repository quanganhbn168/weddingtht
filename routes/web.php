<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserWeddingController;
use App\Http\Controllers\UserBusinessCardController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboard routes (authenticated users)
Route::middleware(['auth', 'verified'])->group(function () {
    // Main dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pricing', [DashboardController::class, 'pricing'])->name('dashboard.pricing');
    
    // Wedding management
    Route::prefix('dashboard/weddings')->name('dashboard.weddings.')->group(function () {
        Route::get('/', [UserWeddingController::class, 'index'])->name('index');
        Route::get('/create', [UserWeddingController::class, 'create'])->name('create');
        Route::post('/', [UserWeddingController::class, 'store'])->name('store');
        Route::get('/{wedding}/edit', [UserWeddingController::class, 'edit'])->name('edit');
        Route::put('/{wedding}', [UserWeddingController::class, 'update'])->name('update');
        Route::delete('/{wedding}', [UserWeddingController::class, 'destroy'])->name('destroy');
        Route::get('/{wedding}/preview', [UserWeddingController::class, 'preview'])->name('preview');
    });
    
    // Business card management
    Route::prefix('dashboard/cards')->name('dashboard.cards.')->group(function () {
        Route::get('/', [UserBusinessCardController::class, 'index'])->name('index');
        Route::get('/create', [UserBusinessCardController::class, 'create'])->name('create');
        Route::post('/', [UserBusinessCardController::class, 'store'])->name('store');
        Route::get('/{card}/edit', [UserBusinessCardController::class, 'edit'])->name('edit');
        Route::put('/{card}', [UserBusinessCardController::class, 'update'])->name('update');
        Route::delete('/{card}', [UserBusinessCardController::class, 'destroy'])->name('destroy');
        Route::get('/{card}/preview', [UserBusinessCardController::class, 'preview'])->name('preview');
    });
    
    // Payment routes
    Route::post('/payment/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/callback', [PaymentController::class, 'callback'])->name('payment.callback');
    Route::get('/dashboard/payments', [PaymentController::class, 'history'])->name('dashboard.payments');
});

// MoMo IPN callback (no auth required - called by MoMo server)
Route::post('/payment/ipn', [PaymentController::class, 'ipn'])->name('payment.ipn');

// Profile routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

