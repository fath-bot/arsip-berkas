{{-- create.blade.php --}}
@extends('admin.layouts.apps')

@section('title', 'Tambah Data Arsip')

@section('content')

<div class="main-content" id="mainContent">
<div class="col-xl-12 col-lg-12">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tambah Data {{ ucfirst($type) }}</h6>
        </div>
        
        <div class="card-body">
            <form action="{{ route('admin.arsip.store', ['type' => $type]) }}" method="POST">
                @csrf
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Nama</label>
                    <div class="col-lg-8">
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">NIP</label>
                    <div class="col-lg-8">
                        <input type="text" name="nip" class="form-control" required>
                    </div>
                </div>
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Jabatan</label>
                    <div class="col-lg-8">
                        <input type="text" name="jabatan" class="form-control" required>
                    </div>
                </div>
                
                @if($type == 'ijazah')
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Jenjang</label>
                        <div class="col-lg-8">
                            <select name="jenjang" class="form-select" required>
                                <option value="SMA">SMA</option>
                                <option value="D3">D3</option>
                                <option value="S1">S1</option>
                                <option value="S2">S2</option>
                                <option value="S3">S3</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Universitas</label>
                        <div class="col-lg-8">
                            <input type="text" name="universitas" class="form-control" required>
                        </div>
                    </div>
                @else
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">No. SK</label>
                        <div class="col-lg-8">
                            <input type="text" name="no_sk" class="form-control" required>
                        </div>
                    </div>
                    
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Tanggal</label>
                        <div class="col-lg-8">
                            <input type="date" name="tanggal" class="form-control" required>
                        </div>
                    </div>
                @endif
                
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Letak Berkas</label>
                    <div class="col-lg-8">
                        <input type="text" name="letak_berkas" class="form-control" required>
                    </div>
                </div>
                
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                    <a href="{{ route('admin.arsip.index', ['type' => $type]) }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection