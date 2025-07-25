@extends('components.apps')

@section('title', 'Manajemen Arsip ' . $title)

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h2 class="m-0 font-weight-bold text-primary">Data Arsip {{ $title }}</h2>
                <div class="card-toolbar">
                    <!-- Link Tambah Arsip: arahkan ke halaman create sesuai tipe arsip -->
                    <a href="{{ route('admin.arsip.create', ['type' => $type]) }}" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i> Tambah Arsip
                    </a>
                </div>
            </div>

            <div class="card-body">
                <div class="row mb-4">
                     
                     
                     
                </div>
                <div class="table-responsive">
                    <table id="kt_arsip_table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-200px">Nama Berkas</th>
                                <th class="min-w-200px">Keterangan Arsip</th>
                                <th class="min-w-150px">Tanggal Upload</th>
                                <th class="min-w-200px">Letak Berkas</th>
                                <th class="min-w-200px">Berkas Digital</th>
                                <th class="min-w-100px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($items as $index => $item)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $item->nama_arsip ?? '-' }}</td>
                                <td>{{ $item->keterangan_arsip ?? '-' }}</td>
                                <td>{{ $item->tanggal_upload ? \Carbon\Carbon::parse($item->tanggal_upload)->format('d/m/Y') : '-' }}</td>
                                <td>{{ $item->letak_berkas ?? '-' }}</td>
                                <td>
                                    @if($item->file_path)
                                        <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                            <i class="fas fa-file-alt"></i> View
                                        </a>
                                    @else
                                        -
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('user.transaksis.create', ['arsip_id' => $item->id]) }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-plus"></i> Pinjam
                                    </a>
                                    <a href="{{ route('admin.arsip.edit', ['type' => $type, 'id' => $item->id]) }}" class="btn btn-warning btn-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $item->id }}">
                                        <i class="fas fa-trash"></i> Hapus
                                    </button>

                                    <!-- Delete Modal -->
                                    <div class="modal fade" id="deleteModal-{{ $item->id }}" tabindex="-1" aria-labelledby="deleteModalLabel-{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="{{ route('admin.arsip.destroy', ['type' => $type, 'id' => $item->id]) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="deleteModalLabel-{{ $item->id }}">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>Yakin ingin menghapus arsip "{{ $item->nama_arsip }}"? Tindakan ini tidak dapat dibatalkan.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center">Tidak ada arsip.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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

     
     
});

</script>
@endpush

