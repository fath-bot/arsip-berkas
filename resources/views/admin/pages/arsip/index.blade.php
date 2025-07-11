@extends('admin.layouts.apps')

@section('title', $title)

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Data {{ $title }}</h3>
        <div class="card-tools">
            <a href="{{ route('admin.arsip.create', ['type' => $type]) }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Data
            </a>
        </div>
    </div>
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jabatan</th>
                    @if($type === 'ijazah')
                        <th>Jenjang</th>
                        <th>Universitas</th>
                    @else
                        <th>No. SK</th>
                        <th>Tanggal</th>
                    @endif
                    <th>letak_berkas</th>
                    <th>Aksi</th>
                    
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
                    <td>
                        <a href="{{ route('admin.arsip.edit', ['type' => $type, 'id' => $item->id]) }}" 
                           class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.arsip.destroy', ['type' => $type, 'id' => $item->id]) }}" 
                              method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" title="Hapus"
                                    onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection