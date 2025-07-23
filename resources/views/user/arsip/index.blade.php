@extends('components.apps')  
@section('title', $title ?? 'Daftar Arsip Saya')

@section('content')
<div class="main-content" id="mainContent">
    <div class="container-fluid">

        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Arsip Saya</h6>
            </div>

            <div class="card-body">
                @if($items->isEmpty())
                    <div class="alert alert-info mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        Belum ada arsip yang dimiliki.
                    </div>
                @else

                    <!-- Search Bar & Filter Dropdown -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="searchInput" class="form-control" placeholder="Cari Nama Arsip...">
                        </div>
                        <div class="col-md-6">
                            <select id="filterJenis" class="form-select">
                                <option value="">Semua Jenis Arsip</option>
                                @foreach($items->pluck('jenis.nama_jenis')->unique() as $jenis)
                                    <option value="{{ $jenis }}">{{ $jenis }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama Arsip</th>
                                    <th>Jenis Arsip</th>
                                    <th>Tanggal Upload</th>
                                    <th>Letak Berkas</th>
                                    <th class="min-w-200px">Berkas Digital</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr class="arsip-row"
                                        data-nama="{{ strtolower($item->nama_arsip) }}"
                                        data-jenis="{{ strtolower($item->jenis->nama_jenis ?? '') }}">
                                        <td>{{ $item->nama_arsip }}</td>
                                        <td>{{ $item->jenis->nama_jenis ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d M Y') }}</td>
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
                                            <a href="{{ route('user.transaksis.create', ['arsip_id' => $item->id]) }}"
                                               class="btn btn-sm btn-primary">
                                                <i class="fas fa-plus-circle me-1"></i> Pinjam
                                            </a>
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

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('searchInput');
    const filterJenis = document.getElementById('filterJenis');
    const rows = document.querySelectorAll('.arsip-row');

    function filterTable() {
        const searchText = searchInput.value.toLowerCase();
        const selectedJenis = filterJenis.value.toLowerCase();

        rows.forEach(row => {
            const nama = row.getAttribute('data-nama');
            const jenis = row.getAttribute('data-jenis');

            const matchSearch = nama.includes(searchText);
            const matchJenis = !selectedJenis || jenis === selectedJenis;

            row.style.display = (matchSearch && matchJenis) ? '' : 'none';
        });
    }

    searchInput.addEventListener('input', filterTable);
    filterJenis.addEventListener('change', filterTable);
});
</script>
@endpush
