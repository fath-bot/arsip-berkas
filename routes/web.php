<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ArsipController;
use App\Http\Controllers\AuthController;

// Route publik
Route::get('/home', function () {
    return view('home');
})->name('home');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::get('/test-login', function() {
    return view('api-test');
});

// Group admin
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/sidebar', [AdminDashboardController::class, 'index'])->name('layout.sidebar');
    
    // Transaksi
    Route::resource('transaksis', TransaksiController::class);
    
    // Arsip (pendekatan dinamis)
    Route::prefix('arsip')->name('arsip.')->group(function () {
        Route::get('/{type}', [ArsipController::class, 'index'])->name('index');
        Route::get('/{type}/create', [ArsipController::class, 'create'])->name('create');
        Route::post('/{type}', [ArsipController::class, 'store'])->name('store');
        Route::get('/{type}/{id}', [ArsipController::class, 'show'])->name('show');
        Route::get('/{type}/{id}/edit', [ArsipController::class, 'edit'])->name('edit');
        Route::put('/{type}/{id}', [ArsipController::class, 'update'])->name('update');
        Route::delete('/{type}/{id}', [ArsipController::class, 'destroy'])->name('destroy');
    });
});