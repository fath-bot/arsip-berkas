@extends('components.apps')

@section('title', 'Dashboard')

@section('content')
<div class="main-content" id="mainContent">
        <!-- Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800"> Selamat Datang {{ session('user_name', 'Admin') }}{{ Auth::user()->name }} </h1>
            <a href="{{ route('user.transaksis.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                <i class="fas fa-download fa-sm text-white-50"></i> pinjam arsip
            </a>
            @php
                $transaksisRoute = session('role') === 'user' ? 'user.transaksis.index' : 'admin.transaksis.index';
            @endphp
            <a class="navbar-brand {{ request()->routeIs($transaksisRoute) ? 'active' : '' }}" href="{{ route($transaksisRoute) }}">
                <i class="fas fa-download fa-sm text-white-50"></i> Pinjam Arsip
            </a>

             
        </div>
        <div class="row">
            <!-- status peminjaman -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">status peminjaman</h6>
                    </div>
                    <div class="card-body">
                        <div id="transaksi_chart">content status peminjaman</div>
                        
                    </div>
                </div>
            </div>
            
            <!-- history peminjaman anda -->
            <div class="col-xl-4 col-lg-5">
                <div class="card shadow mb-2">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary"> history peminjaman anda</h6>
                    </div>
                    <div class="card-body">
                        <div class="card-body">
                        <div id="transaksi_chart">(content) jenis berkas dan kapan meminjam</div>
                    </div>
                    </div>
                </div>
                <div><br></div>
            </div>
        </div>
    </div>
        