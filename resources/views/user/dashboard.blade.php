@extends('components.apps')

@section('title', 'Dashboard')

@section('content')
<div class="main-content" id="mainContent">
    <!-- Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            Selamat Datang {{ session('user_name', 'User') }}
        </h1>
        @php
            $transaksisRoute = session('role') === 'user' ? 'user.transaksis.index' : 'admin.transaksis.index';
        @endphp
        <a href="{{ route($transaksisRoute) }}" class="btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus-circle"></i> Pinjam Arsip
        </a>
    </div>

    <!-- Notifikasi -->
    @if ($berlangsung)
        @php $tglKembali = \Carbon\Carbon::parse($berlangsung->tanggal_kembali); @endphp

        @if ($tglKembali->isPast())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle me-1"></i> Peminjaman ini telah melewati batas waktu pengembalian!
            </div>
        @elseif ($tglKembali->diffInDays(now()) <= 2)
            <div class="alert alert-warning">
                <i class="fas fa-clock me-1"></i> Segera kembalikan arsip ini, batas waktu hampir habis.
            </div>
        @endif
    @endif

     

    <div class="row mb-4">
        @php
            $statusApproved = $terakhir->is_approved ?? null;
            $headerClass = 'bg-secondary'; // Default abu-abu

            if ($pending) {
                $headerClass = 'bg-secondary'; 
            } elseif (!$pending) {
                if ($statusApproved == 0) {
                    $headerClass = 'bg-danger'; // Ditolak
                } elseif ($statusApproved == 1) {
                    $headerClass = 'bg-success'; // Disetujui
                }
            }
        @endphp

        <div class="card shadow mb-4">
            <div class="card-header py-3 {{ $headerClass }}">
                <h6 class="m-0 text-white">Status Peminjaman Terakhir</h6>
            </div>
            <div class="card-body">
                @if ($pending)
                    <p><strong>Nama Arsip:</strong> {{ $pending->keterangan ?? '-' }}</p>
                    <p><strong>Jenis Arsip:</strong> {{ $pending->jenis->nama_jenis ?? '-' }}</p>
                    <p><strong>Tanggal Pinjam:</strong> {{ $pending->tanggal_pinjam ?? '-' }}</p>
                    <p><strong>Status:</strong>
                        <span class="text-secondary">Menunggu Konfirmasi</span>
                    </p>
                @else
                    <p><strong>Nama Arsip:</strong> {{ $terakhir->keterangan ?? '-' }}</p>
                    <p><strong>Jenis Arsip:</strong> {{ $terakhir->jenis->nama_jenis ?? '-' }}</p>
                    <p><strong>Tanggal Pinjam:</strong> {{ $terakhir->tanggal_pinjam ?? '-' }}</p>
                    <p><strong>Status:</strong>
                        @if ($statusApproved == 0)
                            <span class="text-danger">Ditolak</span>
                            
                    <p><strong>alasan di tolak:</strong> {{ $terakhir->alasan_penolakan ?? '-' }}</p>
                        @elseif ($statusApproved == 1)
                            <span class="text-success">Disetujui</span>
                        @else
                            <span class="text-secondary">Menunggu Konfirmasi</span>
                        @endif
                    </p>
                @endif
            </div>
        </div>

        <!-- Status Peminjaman Berlangsung -->
        <div class="col-xl-8 col-lg-7 mb-3">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark py-2 d-flex align-items-center justify-content-between">
                    <strong><i class="fas fa-folder-open me-1"></i> Status Peminjaman Berlangsung</strong>
                </div>
                <div class="card-body p-3">
                    @if ($berlangsung)
                        <p class="mb-1"><strong>Jenis:</strong> {{ $berlangsung->arsip->jenis->nama_jenis ?? '-' }}</p>
                        <p class="mb-1"><strong>Tanggal Pinjam:</strong> {{ \Carbon\Carbon::parse($berlangsung->tanggal_pinjam)->format('d/m/Y') }}</p>
                        <p class="mb-1"><strong>Rencana Kembali:</strong> {{ $tglKembali->format('d/m/Y') }}</p>
                        <p class="mb-1"><strong>Keterangan:</strong> {{ $berlangsung->keterangan }}</p>
                        <span class="badge bg-warning text-dark">
                            {{ $berlangsung->status === 'dipinjam' ? 'Sedang Dipinjam' : 'Belum Diambil' }}
                        </span>

                        @php
                            $tglPinjam = \Carbon\Carbon::parse($berlangsung->tanggal_pinjam);
                            $totalDays = $tglPinjam->diffInDays($tglKembali);
                            $usedDays = $tglPinjam->diffInDays(now());
                            $progress = $totalDays > 0 ? min(100, ($usedDays / $totalDays) * 100) : 100;
                        @endphp
                        <div class="progress mt-3" style="height: 20px;">
                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ $progress }}%">
                                {{ round($progress) }}%
                            </div>
                        </div>

                        <a href="{{ route($transaksisRoute) }}" class="btn btn-sm btn-outline-secondary mt-3">
                            <i class="fas fa-eye"></i> Lihat Detail Transaksi
                        </a>
                    @else
                        <p class="text-muted mb-0"><i class="fas fa-info-circle me-1"></i> Tidak ada peminjaman aktif saat ini.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Riwayat 3 Peminjaman Terakhir -->
        <div class="col-xl-4 col-lg-5 mb-3">
            <div class="card shadow">
                <div class="card-header bg-primary text-white py-2">
                    <strong><i class="fas fa-history me-1"></i> Riwayat 3 Peminjaman Terakhir</strong>
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

                    <a href="{{ route($transaksisRoute) }}" class="btn btn-outline-primary btn-sm mt-3">
                        <i class="fas fa-list"></i> Lihat Semua Riwayat
                    </a>
                </div>
            </div>
        </div>
    </div>

    
</div>
@endsection
