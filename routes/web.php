<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// Public / Guest Routes
Route::get('/', [ProductController::class, 'index'])->name('home');
Route::get('/produk/{slug}', [ProductController::class, 'show'])->name('products.show');
Route::get('/dashboard', function () {
    return auth()->user()?->isAdmin() ? redirect()->route('admin.dashboard') : redirect()->route('home');
})->middleware('auth')->name('dashboard');

// Customer Routes (Authenticated Users)
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Cart
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang/{product}', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang/{product}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{product}', [CartController::class, 'destroy'])->name('cart.destroy');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // Customer Orders
    Route::get('/pesanan', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/pesanan/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::post('/pesanan/{order}/bukti-bayar', [OrderController::class, 'uploadBuktiBayar'])->name('orders.bukti-bayar');
});

// Admin Routes (Authenticated + Admin Middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('kategori', AdminCategoryController::class)->except(['show']);
    Route::resource('produk', AdminProductController::class)->except(['show']);

    Route::get('/pesanan', [AdminOrderController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{order}', [AdminOrderController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('pesanan.update-status');
    Route::patch('/pesanan/{order}/verifikasi-bayar', [AdminOrderController::class, 'verifikasiPembayaran'])->name('pesanan.verifikasi-bayar');

    Route::get('/laporan', [AdminReportController::class, 'index'])->name('laporan.index');
});

require __DIR__.'/auth.php';
