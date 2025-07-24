@extends('components.apps')

@section('title', 'Data Peminjaman Berkas')

@section('content')
<div class="main-content" id="mainContent">
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Data Peminjaman Berkas</h6>
                <a href="{{ route('user.transaksis.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus-circle"></i> Tambah Peminjaman
                </a>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label>Jenis Berkas</label>
                        <select id="filterJenis" class="form-control form-control-sm">
                            <option value="">Semua Jenis</option>
                            @foreach ($jenisList as $jenis)
                                <option value="{{ $jenis->nama_jenis }}">{{ $jenis->nama_jenis }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Status</label>
                        <select id="filterStatus" class="form-control form-control-sm">
                            <option value="">Semua Status</option>
                            <option value="belum_diambil">Belum Diambil</option>
                            <option value="dipinjam">Dipinjam</option>
                            <option value="dikembalikan">Sudah Dikembalikan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label>Dari Tanggal</label>
                        <input type="date" id="filterFromDate" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3">
                        <label>Sampai Tanggal</label>
                        <input type="date" id="filterToDate" class="form-control form-control-sm">
                    </div>
                </div>

                @if($transaksis->isEmpty())
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Belum ada transaksi peminjaman berkas.
                    </div>
                @else
                    <div class="table-responsive">
                        <table id="kt_transaksis_table" class="table table-bordered table-striped table-hover">
                            <thead class="table-light">
                                <tr class="text-center align-middle">
                                    <th>No</th>
                                    <th>Jenis Berkas</th>
                                    <th>Keterangan</th>
                                    <th>Tanggal Pinjam</th>
                                    <th>Tanggal Kembali</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksis as $transaksi)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $transaksi->jenis->nama_jenis ?? '-' }}</td>
                                        <td title="{{ $transaksi->keterangan }}">{{ Str::limit($transaksi->keterangan, 50) }}</td>
                                        <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('m/d/Y') }}</td>
                                        <td>
                                            @if($transaksi->tanggal_kembali)
                                                {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d/m/Y') }}
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td title="{{ $transaksi->alasan }}">{{ Str::limit($transaksi->alasan, 50) }}</td>
                                        <td class="text-center">
                                            @php
                                                $statusClasses = [
                                                    'belum_diambil' => 'danger',
                                                    'dipinjam' => 'warning',
                                                    'dikembalikan' => 'success'
                                                ];
                                                $statusLabels = [
                                                    'belum_diambil' => 'Belum Diambil',
                                                    'dipinjam' => 'Dipinjam',
                                                    'dikembalikan' => 'Sudah Dikembalikan'
                                                ];
                                                $statusClass = $statusClasses[$transaksi->status] ?? 'secondary';
                                                $statusLabel = $statusLabels[$transaksi->status] ?? $transaksi->status;
                                            @endphp
                                            <span class="badge bg-{{ $statusClass }}">{{ $statusLabel }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
 @push('styles') 
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts') 
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Inisialisasi DataTable
        const table = $('#kt_transaksis_table').DataTable({
            responsive: true,
            language: {
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ - _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "Sebelumnya",
                    next: "Berikutnya"
                }
            }
        });

        // Filter jenis
        $('#filterJenis').on('change', function () {
            table.column(1).search(this.value).draw();
        });

        // Filter status
        $('#filterStatus').on('change', function () {
            table.column(6).search(this.value).draw();
        });

        // Filter tanggal pinjam
        $('#filterFromDate, #filterToDate').on('change', function () {
            const fromDate = $('#filterFromDate').val();
            const toDate = $('#filterToDate').val();

            $.fn.dataTable.ext.search.push(function (settings, data) {
                const dateStr = data[3]; // kolom tanggal pinjam (index 3)
                const [day, month, year] = dateStr.split('/');
                const date = new Date(year, month - 1, day);
                const from = fromDate ? new Date(fromDate) : null;
                const to = toDate ? new Date(toDate) : null;

                return (!from && !to) || (!from && date <= to) || (from <= date && !to) || (from <= date && date <= to);
            });

            table.draw();
            $.fn.dataTable.ext.search.pop(); // bersihkan agar tidak double filter
        });
    });
</script>
@endpush
