<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ArsipController;

// Public Routes
Route::get('/', fn() => view('home'))->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/test-login', fn() => view('api-test'))->name('test-login');
Route::get('/check-auth', [AuthController::class, 'checkAuth'])->middleware('web');

// Protected Routes (hanya untuk user yang sudah login)
Route::middleware(['auth'])->group(function () {

    // DASHBOARD Berdasarkan Role
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/superadmin/dashboard', fn() => view('admin.ubah-role'))->name('superadmin.dashboard');
    Route::get('/user/dashboard', fn() => view('user.dashboard'))->name('user.dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('transaksis', TransaksiController::class);

        // Redirect default arsip ke jenis arsip pertama
        Route::get('arsip', function () {
            $first = \App\Models\ArsipJenis::firstOrFail();
            return redirect()->route('admin.arsip.index', ['type' => Str::slug($first->nama_jenis)]);
        })->name('arsip.home');

        // CRUD Arsip berdasarkan jenis
        Route::prefix('arsip')->name('arsip.')->group(function () {
            Route::get('{type}', [ArsipController::class, 'index'])->name('index');
            Route::get('{type}/create', [ArsipController::class, 'create'])->name('create');
            Route::post('{type}', [ArsipController::class, 'store'])->name('store');
            Route::get('{type}/{id}', [ArsipController::class, 'show'])->name('show');
            Route::get('{type}/{id}/edit', [ArsipController::class, 'edit'])->name('edit');
            Route::put('{type}/{id}', [ArsipController::class, 'update'])->name('update');
            Route::delete('{type}/{id}', [ArsipController::class, 'destroy'])->name('destroy');
        });

        // Ubah role (khusus admin & superadmin)
        Route::get('ubah-role', function () {
            if (!in_array(auth()->user()->role, ['admin', 'superadmin'])) abort(403);
            return view('admin.ubah-role');
        })->name('ubah-role');

        Route::post('ubah-role', [RoleController::class, 'ubahRole'])->name('proses-ubah-role');
    });

    /*
    |--------------------------------------------------------------------------
    | USER ROUTE
    |--------------------------------------------------------------------------
    */
    Route::prefix('user')->name('user.')->group(function () {
        // CRUD Transaksi oleh user
        Route::resource('transaksis', TransaksiController::class)
            ->only(['index', 'create', 'store', 'show', 'edit', 'update', 'destroy']);

        // User melihat semua arsip miliknya
        Route::get('arsip', [ArsipController::class, 'index'])->name('arsip.index');
    });

});
