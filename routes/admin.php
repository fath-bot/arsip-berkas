<?php

// use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use Illuminate\Support\Facades\Route;


    Route::resource('/transaksi', AdminTransaksiController::class);


