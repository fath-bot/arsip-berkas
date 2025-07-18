{{-- edit.blade.php --}}
@extends('admin.layouts.apps')

@section('title', 'Edit Transaksi Peminjaman')

@section('content')
<div class="main-content" id="mainContent">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Transaksi Peminjaman</h6>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.transaksis.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Nama Peminjam</label>
                    <div class="col-lg-8">
                        <input type="text" name="name" class="form-control" 
                               value="{{ $transaksi->name }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">NIP</label>
                    <div class="col-lg-8">
                        <input type="text" name="nip" class="form-control" 
                               value="{{ $transaksi->nip }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Jabatan</label>
                    <div class="col-lg-8">
                        <input type="text" name="jabatan" class="form-control" 
                               value="{{ $transaksi->jabatan }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Jenis Berkas</label>
                    <div class="col-lg-8">
                        <select name="jenis_berkas" class="form-select" required>
                            <option value="Ijazah" {{ $transaksi->jenis_berkas == 'Ijazah' ? 'selected' : '' }}>Ijazah</option>
                            <option value="SK Pangkat" {{ $transaksi->jenis_berkas == 'SK Pangkat' ? 'selected' : '' }}>SK Pangkat</option>
                            <option value="SK CPNS" {{ $transaksi->jenis_berkas == 'SK CPNS' ? 'selected' : '' }}>SK CPNS</option>
                            <option value="SK Jabatan" {{ $transaksi->jenis_berkas == 'SK Jabatan' ? 'selected' : '' }}>SK Jabatan</option>
                            <option value="SK Mutasi Unit" {{ $transaksi->jenis_berkas == 'SK Mutasi Unit' ? 'selected' : '' }}>SK Mutasi Unit</option>
                        </select>
                    </div>
                </div>@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Tanggal Pinjam</label>
                    <div class="col-lg-8">
                        <input type="date" name="tanggal_pinjam" class="form-control" 
                               value="{{ $transaksi->tanggal_pinjam }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Tanggal Kembali</label>
                    <div class="col-lg-8">
                        <input type="date" name="tanggal_kembali" class="form-control" 
                               value="{{ $transaksi->tanggal_kembali }}" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Alasan</label>
                    <div class="col-lg-8">
                        <textarea name="alasan" class="form-control" rows="3" required>{{ $transaksi->alasan }}</textarea>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Status</label>
                    <div class="col-lg-8">
                        <select name="status" class="form-select" required>
                            <option value="" disabled selected>Pilih Status</option>
                                <option value="Belum Diambil" {{ old('status') == 'Belum Diambil' ? 'selected' : '' }}>Belum Diambil</option>
                                <option value="Sudah Dikembalikan" {{ old('status') == 'Sudah Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                                <option value="Belum Dikembalikan" {{ old('status') == 'Belum Dikembalikan' ? 'selected' : '' }}>Belum Dikembalikan</option>
                             </select>
                    </div>
                </div>
                
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.transaksis.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection