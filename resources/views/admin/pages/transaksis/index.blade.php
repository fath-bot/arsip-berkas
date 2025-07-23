@extends('components.apps')

@section('title', 'Data Peminjaman Berkas')

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h2 class="m-0 font-weight-bold text-primary">Data Peminjaman Berkas</h2>
                <div class="card-toolbar">
                    <a href="{{ route('admin.transaksis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Peminjaman
                    </a>
                </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-md-3">
                        <label>Jenis Berkas</label>
                        <select id="filterJenis" class="form-select form-select-sm">
                            <option value="">Semua Jenis</option>
                            @foreach($jenisList as $jenis)
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
                <!-- Table Section -->
                <div class="table-responsive">
                    <table id="kt_transaksis_table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th>No</th>
                                <th>Nama Berkas</th>
                                <th>Jenis Berkas</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Alasan</th>
                                <th>Keterangan</th>
                                <th>Status</th>
                                <th class="text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $transaksi->arsip->nama_arsip ?? '-' }}</td>
                                <td>{{ $transaksi->jenis->nama_jenis ?? '-' }}</td>

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
                                <td title="{{ $transaksi->keterangan }}">
                                    {{ Str::limit($transaksi->keterangan, 50) }}
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
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.transaksis.edit', $transaksi->id) }}" 
                                           class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit fs-4"></i>
                                        </a>
                                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#deleteModal" 
                                           onclick="setDeleteAction('{{ route('admin.transaksis.destroy', $transaksi->id) }}')"
                                           title="Hapus">
                                            <i class="fas fa-trash fs-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Delete Confirmation Modal -->
                <div class="modal fade" tabindex="-1" id="deleteModal" aria-labelledby="deleteModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <form id="deleteForm" method="POST">
                                @csrf
                                @method('DELETE')
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin menghapus data transaksi peminjaman ini? Tindakan ini tidak dapat dibatalkan.</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                    <button type="submit" class="btn btn-danger">
                                        <span class="indicator-label">Hapus</span>   
                                    </button>
                                </div>  
                            </form>
                        </div>
                    </div>
                </div>

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

    // Filter Jenis Berkas (kolom ke-2)
    $('#filterJenis').on('change', function () {
        table.column(2).search(this.value).draw();
    });

    // Filter Status (kolom ke-7)
    $('#filterStatus').on('change', function () {
        const statusValue = this.value;

        table.column(7).search(statusValue ? statusValue.replace(/_/g, ' ') : '', true, false).draw();
    });

    // Filter Tanggal Pinjam (kolom ke-3)
    $('#filterFromDate, #filterToDate').on('change', function () {
        const fromDateStr = $('#filterFromDate').val(); // yyyy-mm-dd
        const toDateStr = $('#filterToDate').val();     // yyyy-mm-dd

        $.fn.dataTable.ext.search.push(function (settings, data) {
            const tableDateStr = data[3]; // kolom tanggal pinjam (format: dd/mm/yyyy)
            const [day, month, year] = tableDateStr.split('/');
            const tableDate = new Date(`${year}-${month}-${day}`);

            let fromDate = fromDateStr ? new Date(fromDateStr) : null;
            let toDate = toDateStr ? new Date(toDateStr) : null;

            return (!fromDate && !toDate) ||
                   (!fromDate && tableDate <= toDate) ||
                   (fromDate <= tableDate && !toDate) ||
                   (fromDate <= tableDate && tableDate <= toDate);
        });

        table.draw();
        $.fn.dataTable.ext.search.pop(); // hindari akumulasi filter
    });
});

</script>
@endpush

