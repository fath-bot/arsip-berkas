@extends('admin.layouts.apps')

@section('title', 'Data Peminjaman Berkas')

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h2 class="m-0 font-weight-bold text-primary">Data Peminjaman Berkas</h2>
                <div class="card-toolbar">
                    <a href="{{ route('user.transaksis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Peminjaman
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!-- Filter Section -->
                <div class="mb-4">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Jenis Berkas</label>
                            <select id="filterJenis" class="form-select form-select-sm">
                                <option value="">Semua Jenis</option>
                                @foreach ($jenisList as $jenis)
                                    <option value="{{ $jenis }}">{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Status</label>
                            <select id="filterStatus" class="form-select form-select-sm">
                                <option value="">Semua Status</option>
                                <option value="belum_diambil">Belum Diambil</option>
                                <option value="dipinjam">Dipinjam</option>
                                <option value="dikembalikan">Sudah Dikembalikan</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Dari Tanggal</label>
                            <input type="date" id="filterFromDate" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="date" id="filterToDate" class="form-control form-control-sm">
                        </div>
                    </div>
                </div>
                
                <!-- Table Section -->
                <div class="table-responsive">
                    <table id="kt_transaksis_table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-150px">Nama Berkas</th>
                                <th class="min-w-150px">Jenis Berkas</th>
                                <th class="min-w-120px">Tanggal Pinjam</th>
                                <th class="min-w-120px">Tanggal Kembali</th>
                                <th class="min-w-200px">Alasan</th>
                                <th class="min-w-120px">Status</th> 
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->arsip->nama_arsip }}</td>
                                <td>{{ $transaksi->arsip->jenis->nama_jenis }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_pinjam)->format('d/m/Y') }}</td>
                                <td>
                                    @if($transaksi->tanggal_kembali)
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td title="{{ $transaksi->alasan }}">
                                    {{ Str::limit($transaksi->alasan, 50) }}
                                </td>
                                <td>
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
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const table = $('#kt_transaksis_table').DataTable({
            responsive: true,
            language: {
                lengthMenu: "Tampilkan _MENU_ baris",
                search: "Cari:",
                zeroRecords: "Data tidak ditemukan",
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ baris",
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });

        // Filter jenis (kolom 1)
        $('#filterJenis').on('change', function() {
            const jenis = $(this).val();
            table.column(1).search(jenis).draw();
        });

        // Filter status (kolom 5)
        $('#filterStatus').on('change', function() {
            const status = $(this).val();
            table.column(5).search(status).draw();
        });
        
        // Date filter (kolom tanggal pinjam: 2)
        $('#filterFromDate, #filterToDate').on('change', function() {
            const fromDate = $('#filterFromDate').val();
            const toDate = $('#filterToDate').val();
            
            if (fromDate || toDate) {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        const dateStr = data[2]; // Kolom tanggal pinjam (index 2)
                        // Format di tabel: dd/mm/yyyy
                        const [day, month, year] = dateStr.split('/');
                        const rowDate = new Date(year, month - 1, day);
                        
                        const from = fromDate ? new Date(fromDate) : null;
                        const to = toDate ? new Date(toDate) : null;
                        
                        if ((from === null && to === null) ||
                            (from === null && rowDate <= to) ||
                            (from <= rowDate && to === null) ||
                            (from <= rowDate && rowDate <= to)) {
                            return true;
                        }
                        return false;
                    }
                );
                table.draw();
                $.fn.dataTable.ext.search.pop();
            } else {
                table.draw();
            }
        });

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush