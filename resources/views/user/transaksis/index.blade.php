@extends('admin.layouts.apps')

@section('title', 'Data Peminjaman Berkas')

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h2 class="m-0 font-weight-bold text-primary"> Data Peminjaman Berkas user</h2>
                <div class="card-toolbar">
                    <a href="{{ route('user.transaksis.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Peminjaman
                    </a>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <!-- Chart Section -->
                <!-- Chart will be placed here -->
                
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
                                <option value="Belum Diambil">Belum Diambil</option>
                                <option value="Sudah Dikembalikan">Sudah Dikembalikan</option>
                                <option value="Belum Dikembalikan">Belum Dikembalikan</option>
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
                                <th class="min-w-150px">Nama</th>
                                <th class="min-w-150px">NIPs</th>
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
                                <td><span class="text-">{{ $transaksi->name }}</span></td>
                                <td><span class="text-">{{ $transaksi->nip }}</span></td>
                                <td><span class="text-">{{ $transaksi->jenis_berkas }}</span></td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</td>
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
                                            'Belum Diambil' => 'danger',
                                            'Sudah Dikembalikan' => 'success',
                                            'Belum Dikembalikan' => 'warning'
                                        ];
                                        $statusClass = $statusClasses[$transaksi->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }}">{{ $transaksi->status }}</span>
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
<link href="{{ asset('themes/admin/plugins/custom/apexcharts/apexcharts.bundle.css') }}" rel="stylesheet">
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

        //   filters
        $('#filterJenis, #filterStatus').on('change', function() {
            const jenis = $('#filterJenis').val();
            const status = $('#filterStatus').val();
            
            table.column(1).search(jenis).column(5).search(status).draw();
        });
        
        // Date   filter
        $('#filterFromDate, #filterToDate').on('change', function() {
            const fromDate = $('#filterFromDate').val();
            const toDate = $('#filterToDate').val();
            
            if (fromDate || toDate) {
                $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        const dateStr = data[2];  
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

        // Set delete action for modal
        window.setDeleteAction = function(url) {
            const form = document.getElementById('deleteForm');
            form.action = url;
            
           
        }
        
        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip();
    });
</script>
@endpush