<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\IjazahController;
use App\Http\Controllers\PangkatController;
use App\Http\Controllers\CpnsController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\MutasiController;
use App\Http\Controllers\PemberhentianController;

Route::get('/home', function () {
    return view('home');
})->name('home');

;

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
Route::get('/admin/sidebar', [AdminDashboardController::class, 'index'])->name('admin.layout.sidebar');
Route::get('/transaksis', [TransaksiController::class, 'index']);
Route::get('/transaksis/create', [TransaksiController::class, 'create'])->name('admin.pages.transaksis.create');
Route::get('/transaksis/{id}/edit', [TransaksiController::class, 'edit'])->name('admin.pages.transaksis.edit');
Route::put('/transaksis/{id}', [TransaksiController::class, 'update'])->name('admin.pages.transaksis.update');
Route::delete('/transaksis/{id}', [TransaksiController::class, 'delete'])->name('admin/pages/transaksis/delete');
Route::post('/admin/transaksis/save', [TransaksiController::class, 'save'])->name('admin.pages.transaksis.save');
Route::post('/admin/transaksis/index', [TransaksiController::class, 'index'])->name('admin.pages.transaksis.index');
Route::post('/transaksis', [TransaksiController::class, 'save'])->name('admin.transaksis.save');
Route::prefix('admin')->name('admin.')->group(function () {
Route::resource('transaksis', TransaksiController::class);

Route::get('/ijazahs', [IjazahController::class, 'index'])->name('ijazahs.index');
Route::get('/ijazahs/create', [IjazahController::class, 'create'])->name('admin.pages.arsip.ijazah.create');
Route::get('/ijazahs/{id}/edit', [IjazahController::class, 'edit'])->name('admin.pages.arsip.ijazah.edit');
Route::put('/ijazahs/{id}', [IjazahController::class, 'update'])->name('admin.pages.arsip.ijazah.update');
Route::delete('/ijazahs/{id}', [IjazahController::class, 'delete'])->name('admin/pages/arsip/ijazah/delete');
Route::post('/admin/ijazahs/save', [IjazahController::class, 'save'])->name('admin.pages.arsip.ijazah.save');
Route::post('/admin/ijazahs/index', [IjazahController::class, 'index'])->name('admin.pages.arsip.ijazah.index');
Route::post('/ijazahs', [IjazahController::class, 'save'])->name('admin.arsip.ijazah.save');
Route::resource('ijazahs', IjazahController::class);

Route::get('/pangkats', [PangkatController::class, 'index'])->name('pangkats.index');
Route::get('/pangkats/create', [PangkatController::class, 'create'])->name('admin.pages.arsip.pangkat.create');
Route::get('/pangkats/{id}/edit', [PangkatController::class, 'edit'])->name('admin.pages.arsip.pangkat.edit');
Route::put('/pangkats/{id}', [PangkatController::class, 'update'])->name('admin.pages.arsip.pangkat.update');
Route::delete('/pangkats/{id}', [PangkatController::class, 'delete'])->name('admin/pages/arsip/pangkat/delete');
Route::post('/admin/pangkats/save', [PangkatController::class, 'save'])->name('admin.pages.arsip.pangkat.save');
Route::post('/admin/pangkats/index', [PangkatController::class, 'index'])->name('admin.pages.arsip.pangkat.index');
Route::post('/pangkats', [PangkatController::class, 'save'])->name('admin.arsip.pangkat.save');
Route::resource('pangkats', PangkatController::class);

Route::get('/cpnss', [CpnsController::class, 'index'])->name('cpnss.index');
Route::get('/cpnss/create', [CpnsController::class, 'create'])->name('admin.pages.arsip.cpns.create');
Route::get('/cpnss/{id}/edit', [CpnsController::class, 'edit'])->name('admin.pages.arsip.cpns.edit');
Route::put('/cpnss/{id}', [CpnsController::class, 'update'])->name('admin.pages.arsip.cpns.update');
Route::delete('/cpnss/{id}', [CpnsController::class, 'delete'])->name('admin/pages/arsip/cpns/delete');
Route::post('/admin/cpnss/save', [CpnsController::class, 'save'])->name('admin.pages.arsip.cpns.save');
Route::post('/admin/cpnss/index', [CpnsController::class, 'index'])->name('admin.pages.arsip.cpns.index');
Route::post('/cpnss', [CpnsController::class, 'save'])->name('admin.arsip.cpns.save');
Route::resource('cpnss', CpnsController::class);

Route::get('/jabatans', [JabatanController::class, 'index'])->name('jabatans.index');
Route::get('/jabatans/create', [JabatanController::class, 'create'])->name('admin.pages.arsip.jabatan.create');
Route::get('/jabatans/{id}/edit', [JabatanController::class, 'edit'])->name('admin.pages.arsip.jabatan.edit');
Route::put('/jabatans/{id}', [JabatanController::class, 'update'])->name('admin.pages.arsip.jabatan.update');
Route::delete('/jabatans/{id}', [JabatanController::class, 'delete'])->name('admin/pages/arsip/jabatan/delete');
Route::post('/admin/jabatans/save', [JabatanController::class, 'save'])->name('admin.pages.arsip.jabatan.save');
Route::post('/admin/jabatans/index', [JabatanController::class, 'index'])->name('admin.pages.arsip.jabatan.index');
Route::post('/jabatans', [JabatanController::class, 'save'])->name('admin.arsip.jabatan.save');
Route::resource('jabatans', JabatanController::class);

Route::get('/mutasis', [MutasiController::class, 'index'])->name('mutasis.index');
Route::get('/mutasis/create', [MutasiController::class, 'create'])->name('admin.pages.arsip.mutasi.create');
Route::get('/mutasis/{id}/edit', [MutasiController::class, 'edit'])->name('admin.pages.arsip.mutasi.edit');
Route::put('/mutasis/{id}', [MutasiController::class, 'update'])->name('admin.pages.arsip.mutasi.update');
Route::delete('/mutasis/{id}', [MutasiController::class, 'delete'])->name('admin/pages/arsip/mutasi/delete');
Route::post('/admin/mutasis/save', [MutasiController::class, 'save'])->name('admin.pages.arsip.mutasi.save');
Route::post('/admin/mutasis/index', [MutasiController::class, 'index'])->name('admin.pages.arsip.mutasi.index');
Route::post('/mutasis', [MutasiController::class, 'save'])->name('admin.arsip.mutasi.save');
Route::resource('mutasis', MutasiController::class);

Route::get('/pemberhentians', [PemberhentianController::class, 'index'])->name('pemberhentians.index');
Route::get('/pemberhentians/create', [PemberhentianController::class, 'create'])->name('admin.pages.arsip.pemberhentian.create');
Route::get('/pemberhentians/{id}/edit', [PemberhentianController::class, 'edit'])->name('admin.pages.arsip.pemberhentian.edit');
Route::put('/pemberhentians/{id}', [PemberhentianController::class, 'update'])->name('admin.pages.arsip.pemberhentian.update');
Route::delete('/pemberhentians/{id}', [PemberhentianController::class, 'delete'])->name('admin/pages/arsip/pemberhentian/delete');
Route::post('/admin/pemberhentians/save', [PemberhentianController::class, 'save'])->name('admin.pages.arsip.pemberhentian.save');
Route::post('/admin/pemberhentians/index', [PemberhentianController::class, 'index'])->name('admin.pages.arsip.pemberhentian.index');
Route::post('/pemberhentians', [PemberhentianController::class, 'save'])->name('admin.arsip.pemberhentian.save');
Route::resource('pemberhentians', PemberhentianController::class);

});


