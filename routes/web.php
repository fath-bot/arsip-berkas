<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Http\Middleware\CheckSession;      // ← pastikan ada import ini
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\ArsipController;

// Public
Route::get('/', fn() => view('home'))->name('home');
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/test-login', fn() => view('api-test'))->name('test-login');

// Protected (pakai middleware class langsung)
Route::middleware([ CheckSession::class ])->group(function () {

    // Dashboard per role
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
         ->name('admin.dashboard');
    Route::get('/superadmin/dashboard', fn() => view('admin.ubah-role'))
         ->name('superadmin.dashboard');
    Route::get('/user/dashboard', fn() => view('user.dashboard'))
         ->name('user.dashboard');

    // ADMIN
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('transaksis', TransaksiController::class);

        Route::get('arsip', function () {
            $first = \App\Models\ArsipJenis::firstOrFail();
            return redirect()->route('admin.arsip.index', [
                'type' => Str::slug($first->nama_jenis)
            ]);
        })->name('arsip.home');

        Route::prefix('arsip')->name('arsip.')->group(function () {
            Route::get('{type}',   [ArsipController::class, 'index'])->name('index');
            Route::get('{type}/create',[ArsipController::class, 'create'])->name('create');
            Route::post('{type}',  [ArsipController::class, 'store'])->name('store');
            Route::get('{type}/{id}',   [ArsipController::class, 'show'])->name('show');
            Route::get('{type}/{id}/edit',[ArsipController::class, 'edit'])->name('edit');
            Route::put('{type}/{id}',   [ArsipController::class, 'update'])->name('update');
            Route::delete('{type}/{id}',[ArsipController::class, 'destroy'])->name('destroy');
        });

        Route::get('ubah-role', function () {
            if (!in_array(session('role'), ['admin','superadmin'])) abort(403);
            return view('admin.ubah-role');
        })->name('ubah-role');
        Route::post('ubah-role', [RoleController::class, 'ubahRole'])
             ->name('proses-ubah-role');
    });

    // USER
    Route::prefix('user')->name('user.')->group(function () {
        Route::resource('transaksis', TransaksiController::class)
             ->only(['index','create','store','show','edit','update','destroy']);
        Route::get('arsip', [ArsipController::class, 'index'])
             ->name('arsip.index');
    });
});
