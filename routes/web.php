<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ArsipController;

//  ROUTE PUBLIK  

Route::get('/', fn() => view('home'))->name('home');

// Login & Logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// API Test View
Route::get('/test-login', fn() => view('api-test'))->name('test-login');

// Check login session status
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->middleware('web');

//  DASHBOARD PER ROLE ( MIDDLEWARE SESSION )  

Route::middleware(['auth.session'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/superadmin/dashboard', fn() => view('admin.ubah-role'))->name('superadmin.dashboard');
    Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('transaksis', TransaksiController::class);
    });

    // USER
    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('transaksis', TransaksiController::class);
    });
});

//   USER AREA  

Route::prefix('user')->name('user.')->middleware(['auth.session'])->group(function () {

    // Transaksi
    Route::resource('transaksis', TransaksiController::class);

    // Arsip dinamis (index & show)
    Route::prefix('arsip')->name('arsip.')->group(function () {
        Route::get('/{type}', [ArsipController::class, 'index'])->name('index');
        Route::get('/{type}/{id}', [ArsipController::class, 'show'])->name('show');
    });
});

 
//   ADMIN AREA  
 

Route::prefix('admin')->name('admin.')->middleware(['auth.session'])->group(function () {

    // Transaksi
    Route::resource('transaksis', TransaksiController::class);

    // Arsip dinamis (full CRUD)
    Route::prefix('arsip')->name('arsip.')->group(function () {
        Route::get('/{type}', [ArsipController::class, 'index'])->name('index');
        Route::get('/{type}/create', [ArsipController::class, 'create'])->name('create');
        Route::post('/{type}', [ArsipController::class, 'store'])->name('store');
        Route::get('/{type}/{id}', [ArsipController::class, 'show'])->name('show');
        Route::get('/{type}/{id}/edit', [ArsipController::class, 'edit'])->name('edit');
        Route::put('/{type}/{id}', [ArsipController::class, 'update'])->name('update');
        Route::delete('/{type}/{id}', [ArsipController::class, 'destroy'])->name('destroy');
    });

    // Role Management
    Route::get('/ubah-role', function () {
        if (!in_array(session('role'), ['admin', 'superadmin'])) {
            abort(403, 'Akses ditolak.');
        }
        return view('admin.ubah-role');
    })->name('ubah-role');

    Route::post('/ubah-role', [RoleController::class, 'ubahRole'])->name('proses-ubah-role');
});
