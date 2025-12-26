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
        
        // Livewire edit route
        Route::get('/{wedding}/edit', \App\Livewire\Wedding\EditWedding::class)->name('edit');
        
        // Keep legacy PUT for non-livewire fallback
        Route::put('/{wedding}', [UserWeddingController::class, 'update'])->name('update');
        Route::delete('/{wedding}', [UserWeddingController::class, 'destroy'])->name('destroy');
        Route::get('/{wedding}/preview', [UserWeddingController::class, 'preview'])->name('preview');
        Route::get('/{wedding}/rsvps', [UserWeddingController::class, 'rsvps'])->name('rsvps');
        Route::get('/{wedding}/wishes', [UserWeddingController::class, 'wishes'])->name('wishes');
        Route::patch('/{wedding}/wishes/{wish}/approve', [UserWeddingController::class, 'approveWish'])->name('wishes.approve');
        Route::delete('/{wedding}/wishes/{wish}', [UserWeddingController::class, 'deleteWish'])->name('wishes.delete');
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
    
    // Agent Dashboard routes
    Route::prefix('agent')->name('agent.')->middleware('auth')->group(function () {
        Route::get('/', [\App\Http\Controllers\AgentController::class, 'dashboard'])->name('dashboard');
        Route::get('/customers', [\App\Http\Controllers\AgentController::class, 'customers'])->name('customers');
        Route::post('/customers', [\App\Http\Controllers\AgentController::class, 'createCustomer'])->name('customers.store');
        Route::get('/weddings', [\App\Http\Controllers\AgentController::class, 'weddings'])->name('weddings');
        Route::get('/settings', [\App\Http\Controllers\AgentController::class, 'settings'])->name('settings');
        Route::post('/settings', [\App\Http\Controllers\AgentController::class, 'updateSettings'])->name('settings.update');
    });
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
use App\Http\Controllers\BusinessCardController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\WishController;

// Wedding invitation pages
Route::get('/w/{slug}', [WeddingController::class, 'show'])->name('wedding.show');
Route::post('/w/{slug}', [WeddingController::class, 'show']); // For password form

// RSVP & Guestbook routes
Route::post('/w/{wedding:slug}/rsvp', [RsvpController::class, 'store'])->name('wedding.rsvp.store');
Route::post('/w/{wedding:slug}/wish', [WishController::class, 'store'])->name('wedding.wish.store');
Route::get('/api/w/{wedding:slug}/wishes', [WishController::class, 'index'])->name('wedding.wishes.api');

// Business card / landing pages  
Route::get('/p/{slug}', [BusinessCardController::class, 'show'])->name('business.show');

// Fallback: /{slug} can be wedding OR card (check wedding first)
Route::get('/{slug}', function ($slug) {
    $wedding = \App\Models\Wedding::where('slug', $slug)->first();
    if ($wedding) {
        return app(WeddingController::class)->show($slug, request());
    }
    
    $card = \App\Models\BusinessCard::where('slug', $slug)->first();
    if ($card) {
        return app(BusinessCardController::class)->show($slug);
    }
    
    abort(404);
})->where('slug', '^(?!admin|dashboard|login|register|profile|payment|api).*$');
