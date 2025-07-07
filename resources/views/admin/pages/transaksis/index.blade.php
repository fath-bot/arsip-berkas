@extends('admin.layouts.app')

@section('title', 'Data Peminjaman Berkas')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Data Peminjaman Berkas</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">{{ $transaksis->count() }} transaksi ditemukan</span>
                </h3>
                <div class="card-toolbar">
                    <a href="{{ route('admin.transaksis.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i> Tambah Transaksi
                    </a>
                </div>
            </div>

            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="kt_transaksis_table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-150px">Jenis Berkas</th>
                                <th class="min-w-120px">Tanggal Pinjam</th>
                                <th class="min-w-120px">Tanggal Kembali</th>
                                <th class="min-w-200px">Alasan</th>
                                <th class="min-w-120px">Status</th>
                                <th class="min-w-100px text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    
                                            <span class="badge badge-light-success">{{ $transaksi->jenis_berkas }}</span>
                                    
                                </td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d/m/Y') }}</td>
                                <td>{{ Str::limit($transaksi->alasan, 50) }}</td>
                                <td>
                                    @switch($transaksi->status)
                                        @case('Belum Diambil')
                                            <span class="badge badge-light-danger">Belum Diambil</span>
                                            @break
                                        @case('Sudah Dikembalikan')
                                            <span class="badge badge-light-success">Sudah Dikembalikan</span>
                                            @break
                                        @default
                                            <span class="badge badge-light-warning">Belum Dikembalikan</span>
                                    @endswitch
                                </td>
                                <td class="text-end">
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-light btn-active-light-primary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                            Aksi
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" href="{{ route('admin.transaksis.edit', $transaksi->id) }}">Edit</a>
                                            <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDelete('{{ route('admin.transaksis.destroy', $transaksi->id) }}')">Hapus</a>
                                        </div>
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
</div>

<!-- Delete Modal -->
<div class="modal fade" tabindex="-1" id="deleteModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus data transaksi peminjaman ini?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page_styles')
<link href="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
@endsection

@section('page_scripts')
<script src="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#kt_transaksis_table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.10.25/i18n/Indonesian.json"
            },
            dom: "<'row'<'col-sm-6'B><'col-sm-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-5'i><'col-sm-7'p>>",
            buttons: [
                'copy', 'excel', 'pdf'
            ]
        });
    });

    function setDelete(action) {
        document.getElementById('deleteForm').action = action;
    }
</script>
@endsection