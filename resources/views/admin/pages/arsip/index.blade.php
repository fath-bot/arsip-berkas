@extends('components.apps')

@section('title', 'Manajemen Arsip ' . $title)

@section('content')

<div class="main-content" id="mainContent">
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h2 class="m-0 font-weight-bold text-primary">Data Arsip {{ $title }}</h2>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table id="kt_arsip_table" class="table align-middle table-row-dashed fs-6 gy-5">
                    <thead>
                        <tr class="fw-bold text-muted bg-light">
                            <th class="min-w-50px">No</th>
                            <th class="min-w-200px">Nama Berkas</th>
                            <th class="min-w-150px">Tanggal</th>
                            <th class="min-w-200px">Letak Berkas</th>
                            <th class="min-w-100px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $item->nama_arsip }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d/m/Y') }}</td>
                            <td>{{ $item->letak_berkas ?? '-' }}</td>
                            <td>
                                <a href="{{ route('user.transaksis.create', ['arsip_id' => $item->id]) }}"
                                   class="btn btn-sm btn-light-primary">
                                   <i class="fas fa-plus"></i> Pinjam
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>"
        });
    });
</script>
@endpush
