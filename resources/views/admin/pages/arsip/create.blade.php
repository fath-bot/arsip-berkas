@extends('components.apps')

@section('title', 'Tambah Arsip ' . $jenisArsip->nama_jenis)

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-8 col-lg-10 mx-auto">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold text-primary">Tambah Arsip: {{ $jenisArsip->nama_jenis }}</h2>
            </div>
            <div class="card-body">
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                <form action="{{ route('admin.arsip.store', ['type' => $type]) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="user_id" class="form-label">Pilih User</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            <option value="">-- Pilih --</option>
                            @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan_arsip" class="form-label">Keterangan Arsip</label>
                        <input type="text" name="keterangan_arsip" id="keterangan_arsip" class="form-control" value="{{ old('keterangan_arsip') }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_arsip" class="form-label">Nama Arsip</label>
                        <input type="text" name="nama_arsip" id="nama_arsip" class="form-control" value="{{ old('nama_arsip') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Berkas Digital (PDF, JPG, PNG)</label>
                        <input type="file" name="file" id="file" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="letak_berkas" class="form-label">Letak Berkas</label>
                        <input type="text" name="letak_berkas" id="letak_berkas" class="form-control" value="{{ old('letak_berkas') }}">
                    </div>
                    <div class="mb-3">
                        <label for="tanggal_upload" class="form-label">Tanggal Upload</label>
                        <input type="date" name="tanggal_upload" id="tanggal_upload" class="form-control" value="{{ old('tanggal_upload', now()->format('Y-m-d')) }}" required>
                    </div>
                    <div class=" text-end">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                    <a href="{{ route('admin.arsip.index', ['type' => $type]) }}" class="btn btn-secondary">Batal</a>
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
@endpush
