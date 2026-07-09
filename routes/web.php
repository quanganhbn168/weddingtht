<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserWeddingController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Dashboard routes replaced by Filament (/dashboard)
// Agent routes replaced by Filament (/agent)

// Payment routes
Route::middleware(['auth', 'verified'])->group(function () {
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

// ====================================
// PUBLIC ROUTES (No Auth Required)
// ====================================
use App\Http\Controllers\WeddingController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\WishController;

// Wedding invitation pages
Route::get('/w/{slug}/{guestCode}', [WeddingController::class, 'show'])
    ->where('guestCode', '[A-Za-z0-9_-]+')
    ->name('wedding.show.guest');
Route::post('/w/{slug}/{guestCode}', [WeddingController::class, 'show'])
    ->where('guestCode', '[A-Za-z0-9_-]+');
Route::get('/w/{slug}', [WeddingController::class, 'show'])->name('wedding.show');
Route::post('/w/{slug}', [WeddingController::class, 'show']); // For password form

// RSVP & Guestbook routes
Route::post('/w/{wedding:slug}/rsvp', [RsvpController::class, 'store'])->name('wedding.rsvp.store');
Route::post('/w/{wedding:slug}/wish', [WishController::class, 'store'])->name('wedding.wish.store');
Route::get('/api/w/{wedding:slug}/wishes', [WishController::class, 'index'])->name('wedding.wishes.api');

// Business card routes - REMOVED

Route::get('/{slug}/{guestCode}', [WeddingController::class, 'show'])
    ->where('slug', '^(?!admin|dashboard|login|register|profile|payment|api|w$)[A-Za-z0-9_-]+$')
    ->where('guestCode', '[A-Za-z0-9_-]+')
    ->name('wedding.short.guest');
Route::post('/{slug}/{guestCode}', [WeddingController::class, 'show'])
    ->where('slug', '^(?!admin|dashboard|login|register|profile|payment|api|w$)[A-Za-z0-9_-]+$')
    ->where('guestCode', '[A-Za-z0-9_-]+');

// Fallback: /{slug} can be wedding OR card (check wedding first)
Route::get('/{slug}', [\App\Http\Controllers\HomeController::class, 'resolveSlug'])
    ->where('slug', '^(?!admin|dashboard|login|register|profile|payment|api).*$')
    ->name('resolve.slug');
