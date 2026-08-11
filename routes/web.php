<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AffiliateDashboardController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ChildProfileController;
use App\Http\Controllers\ChipWebhookController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LearnController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;

Route::get('/', fn () => Inertia::render('Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
]))->name('home');

Route::post('webhooks/chip', ChipWebhookController::class)
    ->middleware('throttle:120,1')
    ->name('webhooks.chip');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', DashboardController::class)->name('dashboard');
    Route::resource('children', ChildProfileController::class)->except(['create', 'show', 'edit']);
    Route::get('learn', [LearnController::class, 'index'])->name('learn.index');
    Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('checkout', [CheckoutController::class, 'store'])
        ->middleware('throttle:10,1')
        ->name('checkout.store');
    Route::get('checkout/{payment}/success', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('checkout/{payment}/failure', [CheckoutController::class, 'failure'])->name('checkout.failure');

    Route::get('affiliate', AffiliateDashboardController::class)
        ->middleware('role:affiliate,admin')
        ->name('affiliate.dashboard');

    Route::prefix('admin')->middleware('role:admin')->group(function () {
        Route::get('/', AdminDashboardController::class)->name('admin.dashboard');
    });
});

require __DIR__.'/settings.php';
