@extends('admin.layouts.apps')

@section('title', 'Tambah Transaksi Peminjaman')

@section('content')

<div class="main-content" id="mainContent">
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Tambah Transaksi Peminjaman (user)</span>
                </h3>
            </div>

            <form action="{{ route('admin.transaksis.store') }}" method="POST">
                @csrf
                <div class="card-body border-top p-9">
                    <!-- Nama Peminjam -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Nama Peminjam</label>
                        <div class="col-lg-8 fv-row"> 
                            <input type="text" 
                                class="form-control form-control-lg form-control-solid" 
                                value="{{ session('user_name', 'Admin') }}" 
                                readonly> 
                            <input type="hidden" name="name" value="{{ session('user_name', 'Admin') }}">
                        </div>
                    </div>

                    <!-- NIP Peminjam -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">NIP Peminjam</label>
                        <div class="col-lg-8 fv-row">
                            <input type="text" 
                                class="form-control form-control-lg form-control-solid" 
                                value="{{ session('user_nip', 'Admin') }}" 
                                readonly>
                            <!-- YANG BENAR: name="nip" -->
                            <input type="hidden" name="nip" value="{{ session('user_nip', 'Admin') }}">
                        </div>
                    </div>

                    <!-- Jenis Berkas -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Jenis Berkas</label>
                        <div class="col-lg-8 fv-row">
                            <select name="jenis_berkas" class="form-select form-select-lg form-select-solid @error('jenis_berkas') is-invalid @enderror" required>
                                <option value="" disabled selected>Pilih Jenis Berkas</option>
                                <option value="Ijazah" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'Ijazah' ? 'selected' : '' }}>Ijazah</option>
                                <option value="SK Pangkat" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'SK Pangkat' ? 'selected' : '' }}>SK Pangkat</option>
                                <option value="SK CPNS" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'SK CPNS' ? 'selected' : '' }}>SK CPNS</option>
                                <option value="SK Jabatan" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'SK Jabatan' ? 'selected' : '' }}>SK Jabatan</option>
                                <option value="SK Mutasi Unit" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'SK Mutasi Unit' ? 'selected' : '' }}>SK Mutasi Unit</option>
                                <option value="SK Pemberhentian" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'SK Pemberhentian' ? 'selected' : '' }}>SK Pemberhentian</option>
                                <option value="Sertifikasi" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                <option value="Satya Lencana" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'Satya Lencana' ? 'selected' : '' }}>Satya Lencana</option>
                                <option value="Penilaian Prestasi Kerja (SKP)" {{ old('jenis_berkas', $transaksi->jenis_berkas ?? '') == 'Penilaian Prestasi Kerja (SKP)' ? 'selected' : '' }}>Penilaian Prestasi Kerja (SKP)</option>
                            </select>
                            @error('jenis_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="row mb-2">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Pinjam</label>
                        <div class="col-lg-8 fv-row">
                            <input type="date" name="tanggal_masuk" id="tanggal_masuk"
                                class="form-control form-control-lg form-control-solid @error('tanggal_masuk') is-invalid @enderror"
                                value="{{ old('tanggal_masuk') }}" 
                                onchange="setTanggalKembali(this.value)" required>
                            @error('tanggal_masuk')
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

                    <!-- Status -->
                    <!-- status yang dikirim dari user default Belum Diambil dan akan di kirim ke admin untuk disetujui -->
                    <input type="hidden" name="status" value="Belum Diambil">

                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('admin.transaksis.index') }}" class="btn btn-light me-2">Kembali</a>
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
        const tanggalPinjam = document.getElementById('tanggal_masuk').value;
        if (tanggalPinjam) {
            setTanggalKembali(tanggalPinjam);
        }
    });
</script>
@endsection