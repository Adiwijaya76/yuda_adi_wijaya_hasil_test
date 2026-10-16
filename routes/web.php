<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\MerchantController as AdminMerchantController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Customer\CateringController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\DashboardController as CustomerDashboardController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Merchant\DashboardController as MerchantDashboardController;
use App\Http\Controllers\Merchant\MenuController;
use App\Http\Controllers\Merchant\OrderController as MerchantOrderController;
use App\Http\Controllers\Merchant\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])
        ->middleware('throttle:5,1')
        ->name('login.store');

    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register'])
        ->middleware('throttle:10,1')
        ->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', AdminUserController::class)->except(['show']);

        Route::get('/merchants', [AdminMerchantController::class, 'index'])->name('merchants.index');

        Route::get('/orders', [AdminOrderController::class, 'index'])->name('orders.index');
    });

Route::middleware(['auth', 'role:merchant'])
    ->prefix('merchant')
    ->name('merchant.')
    ->group(function () {
        Route::get('/dashboard', [MerchantDashboardController::class, 'index'])->name('dashboard');

        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::resource('menus', MenuController::class)
            ->except(['show']);

        Route::get('/orders', [MerchantOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [MerchantOrderController::class, 'show'])->name('orders.show');
        Route::patch('/orders/{order}/status', [MerchantOrderController::class, 'updateStatus'])->name('orders.status');
    });

Route::middleware(['auth', 'role:customer'])
    ->prefix('customer')
    ->name('customer.')
    ->group(function () {
        Route::get('/dashboard', [CustomerDashboardController::class, 'index'])->name('dashboard');

        Route::get('/caterings', [CateringController::class, 'index'])->name('caterings.index');
        Route::get('/caterings/{merchant}', [CateringController::class, 'show'])->name('caterings.show');

        Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

        Route::get('/orders', [CustomerOrderController::class, 'index'])->name('orders.index');
        Route::get('/orders/{order}', [CustomerOrderController::class, 'show'])->name('orders.show');
    });

Route::get('/', function () {
    return redirect()->route('login');
});
