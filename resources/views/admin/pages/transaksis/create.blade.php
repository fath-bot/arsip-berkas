@extends('admin.layouts.apps')

@section('title', 'Tambah Transaksi Peminjaman')

@section('content')

<div class="main-content" id="mainContent">
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Tambah Transaksi Peminjaman</span>
                </h3>
            </div>

            <form action="{{ route('user.transaksis.store') }}" method="POST">
                @csrf
                <div class="card-body border-top p-9">
                    <!-- Nama Peminjam -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Nama Peminjam</label>
                        <div class="col-lg-8 fv-row"> 
                            <input type="text" 
                                class="form-control form-control-lg form-control-solid" 
                                value="{{ session('user_name') }}" 
                                readonly> 
                            <input type="hidden" name="user_id" value="{{ session('user_id') }}">
                        </div>
                    </div>

                    <!-- NIP Peminjam -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">NIP Peminjam</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" 
                                class="form-control form-control-lg form-control-solid" 
                                value="{{ session('user_nip') }}" 
                                readonly>
                        </div>
                    </div>

                    <!-- Pilih Berkas -->
                    <!-- ambil dari sini <td>{{ $transaksi->arsip->jenis->nama_jenis }}</td>  dan perbaiki kode di-->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Pilih Berkas</label>
                        <div class="col-lg-8 fv-row">
                            <select name="arsip_id" class="form-select form-select-lg form-select-solid @error('arsip_id') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Berkas</option>
                                @foreach ($arsips as $arsip)
                                    <option value="{{ $arsip->id }}" {{ old('arsip_id') == $arsip->id ? 'selected' : '' }}>
                                        {{ $arsip->nama_arsip }} ({{ $arsip->jenis->nama_jenis }})
                                    </option>
                                @endforeach
                            </select>
                            @error('arsip_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Pinjam</label>
                        <div class="col-lg-8 fv-row">
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                                class="form-control form-control-lg form-control-solid @error('tanggal_pinjam') is-invalid @enderror"
                                value="{{ old('tanggal_pinjam') }}" 
                                onchange="setTanggalKembali(this.value)" required>
                            @error('tanggal_pinjam')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Kembali</label>
                        <div class="col-lg-8 fv-row">
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                                class="form-control form-control-lg form-control-solid @error('tanggal_kembali') is-invalid @enderror"
                                value="{{ old('tanggal_kembali') }}" readonly required>
                            @error('tanggal_kembali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Alasan</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="alasan" class="form-control form-control-lg form-control-solid @error('alasan') is-invalid @enderror"
                                rows="3" placeholder="Jelaskan alasan meminjam" required>{{ old('alasan') }}</textarea>
                            @error('alasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status (default untuk user) -->
                    <input type="hidden" name="status" value="belum_diambil">

                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('user.transaksis.index') }}" class="btn btn-light me-2">Kembali</a>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script>
    function setTanggalKembali(tanggalPinjam) {
        if (tanggalPinjam) {
            const date = new Date(tanggalPinjam);
            date.setDate(date.getDate() + 2);
            
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');
            const tanggalKembali = `${year}-${month}-${day}`;
            
            document.getElementById('tanggal_kembali').value = tanggalKembali;
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const tanggalPinjam = document.getElementById('tanggal_pinjam').value;
        if (tanggalPinjam) {
            setTanggalKembali(tanggalPinjam);
        }
    });
</script>
@endsection