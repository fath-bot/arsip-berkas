@extends('admin.layouts.apps')

@section('title', $title)

@section('content')

<div class="main-content" id="mainContent">
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Data Arsip {{ $title }}</h2>
            <div class="card-toolbar">
                <a href="{{ route('admin.arsip.create', ['type' => $type]) }}" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i> Tambah Data
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table id="kt_arsip_table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-50px">No</th>
                            <th class="min-w-150px">Nama</th>
                            <th class="min-w-150px">NIP</th>
                            <th class="min-w-150px">Jabatan</th>
                            @if($type === 'ijazah')
                                <th class="min-w-150px">Jenjang</th>
                                <th class="min-w-200px">Universitas</th>
                            @else
                                <th class="min-w-150px">No. SK</th>
                                <th class="min-w-150px">Tanggal</th>
                            @endif
                            <th class="min-w-200px">Letak Berkas</th>
                            <th class="min-w-100px text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>{{ $item->nip }}</td>
                            <td>{{ $item->jabatan }}</td>
                            @if($type === 'ijazah')
                                <td>{{ $item->jenjang }}</td>
                                <td>{{ $item->universitas }}</td>
                            @else
                                <td>{{ $item->no_sk }}</td>
                                <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            @endif
                            <td>{{ $item->letak_berkas }}</td>
                            <td class="text-end">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.arsip.edit', ['type' => $type, 'id' => $item->id]) }}" 
                                       class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                       data-bs-toggle="tooltip" 
                                       title="Edit">
                                        <i class="fas fa-edit fs-4"></i>
                                    </a>
                                    <form action="{{ route('admin.arsip.destroy', ['type' => $type, 'id' => $item->id]) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-icon btn-active-light-danger w-30px h-30px"
                                                data-bs-toggle="tooltip" 
                                                title="Hapus"
                                                onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                            <i class="fas fa-trash fs-4"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
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
@endsection

@push('styles')
<link href="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endpush

@push('scripts')
<script src="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize DataTable for Arsip
        $('#kt_arsip_table').DataTable({
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
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-light-primary',
                    text: '<i class="fas fa-copy"></i> Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-light-success',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-light-danger',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-light-info',
                    text: '<i class="fas fa-print"></i> Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });
    });
</script>
@endpush