@extends('components.apps')

@section('title', 'Dashboard')

@section('content')
<div class="main-content" id="mainContent">
    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Selamat Datang {{ session('user_name', 'User') }}
            <p class="mb-0">User ID Anda: {{ session('user_id') }}</p>
        </h1>
        @php
            $transaksisRoute = session('role') === 'user' ? 'user.transaksis.index' : 'admin.transaksis.index';
        @endphp
        <a href="{{ route($transaksisRoute) }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-download fa-sm text-white-50"></i> Pinjam Arsip
        </a>
    </div>

    <div class="row mb-4">
        <!-- Status Peminjaman Berlangsung -->
        <div class="col-xl-8 col-lg-7 mb-3">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark py-2 d-flex align-items-center justify-content-between">
                    <strong>Status Peminjaman Berlangsung</strong>
                </div>
                <div class="card-body p-3">
                    @if ($berlangsung)
                        <p class="mb-1"><strong>Jenis:</strong> {{ $berlangsung->arsip->jenis->nama_jenis ?? '-' }}</p>
                        <p class="mb-1"><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($berlangsung->tanggal_pinjam)->format('d/m/Y') }}</p>
                        <p class="mb-1"><strong>Rencana Kembali:</strong> {{ \Carbon\Carbon::parse($berlangsung->tanggal_kembali)->format('d/m/Y') }}</p>
                        <p class="mb-1"><strong>Keterangan:</strong> {{ $berlangsung->keterangan }}</p>
                        <span class="badge bg-warning text-dark">
                            {{ $berlangsung->status === 'dipinjam' ? 'Sedang Dipinjam' : 'Belum Diambil' }}
                        </span>
                    @else
                        <p class="text-muted mb-0"><i class="fas fa-info-circle me-1"></i> Tidak ada peminjaman aktif saat ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Riwayat 3 Transaksi Terakhir -->
        <div class="col-xl-4 col-lg-5 mb-3">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-2">
                    <strong>Riwayat 3 Peminjaman Terakhir</strong>
                </div>
                <div class="card-body p-3">
                    @forelse ($riwayat as $item)
                        <div class="mb-2">
                            <small class="text-muted">{{ \Carbon\Carbon::parse($item->tanggal_kembali)->format('d M Y') }}</small><br>
                            <strong>{{ $item->jenis->nama_jenis ?? '-' }}</strong><br>
                            <span class="text-truncate d-block">{{ \Illuminate\Support\Str::limit($item->keterangan, 60) }}</span>
                        </div>
                        @if (!$loop->last)
                            <hr class="my-2">
                        @endif
                    @empty
                        <p class="text-muted mb-0"><i class="fas fa-history me-1"></i> Belum ada riwayat pengembalian.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
