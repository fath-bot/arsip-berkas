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
                    <p>User ID: {{ auth()->id() }}</p>

                @else
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>Nama Arsip</th>
                                    <th>Jenis Arsip</th>
                                    <th>Tanggal Upload</th>
                                    <th>Letak Berkas</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->nama_arsip }}</td>
                                        <td>{{ $item->jenis->nama_jenis ?? '-' }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->tanggal_upload)->format('d M Y') }}</td>
                                        <td>{{ $item->letak_berkas ?? '-' }}</td>
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
