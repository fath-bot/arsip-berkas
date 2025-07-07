@extends('admin.layouts.app')

@section('title', 'Edit Transaksi Peminjaman')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Edit Transaksi Peminjaman</span>
                </h3>
            </div>

            <form action="{{ route('admin.transaksis.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="card-body border-top p-9">
                    <!-- Jenis Berkas -->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Jenis Berkas</label>
                        <div class="col-lg-8 fv-row">
                            <select name="jenis_berkas" class="form-select form-select-lg form-select-solid @error('jenis_berkas') is-invalid @enderror">
                                <option value="" disabled>Pilih Jenis Berkas</option>
                                <option value="Ijazah" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'Ijazah' ? 'selected' : '' }}>Ijazah</option>
                                <option value="SK Pangkat" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'SK Pangkat' ? 'selected' : '' }}>SK Pangkat</option>
                                <option value="SK CPNS" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'SK CPNS' ? 'selected' : '' }}>SK CPNS</option>
                                <option value="SK Jabatan" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'SK Jabatan' ? 'selected' : '' }}>SK Jabatan</option>
                                <option value="SK Mutasi Unit" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'SK Mutasi Unit' ? 'selected' : '' }}>SK Mutasi Unit</option>
                                <option value="SK Pemberhentian" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'SK Pemberhentian' ? 'selected' : '' }}>SK Pemberhentian</option>
                                <option value="Sertifikasi" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'Sertifikasi' ? 'selected' : '' }}>Sertifikasi</option>
                                <option value="Satya Lencana" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'Satya Lencana' ? 'selected' : '' }}>Satya Lencana</option>
                                <option value="Penilaian Prestasi Kerja (SKP)" {{ old('jenis_berkas', $transaksi->jenis_berkas) == 'Penilaian Prestasi Kerja (SKP)' ? 'selected' : '' }}>Penilaian Prestasi Kerja (SKP)</option>
                            </select>
                            @error('jenis_berkas')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Pinjam -->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Pinjam</label>
                        <div class="col-lg-8 fv-row">
                            <input type="date" name="tanggal_masuk" 
                                class="form-control form-control-lg form-control-solid @error('tanggal_masuk') is-invalid @enderror"
                                value="{{ old('tanggal_masuk', $transaksi->tanggal_masuk) }}" required>
                            @error('tanggal_masuk')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal Kembali -->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Kembali</label>
                        <div class="col-lg-8 fv-row">
                            <input type="date" name="tanggal_kembali" 
                                class="form-control form-control-lg form-control-solid @error('tanggal_kembali') is-invalid @enderror"
                                value="{{ old('tanggal_kembali', $transaksi->tanggal_kembali) }}" required>
                            @error('tanggal_kembali')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Alasan</label>
                        <div class="col-lg-8 fv-row">
                            <textarea name="alasan" class="form-control form-control-lg form-control-solid @error('alasan') is-invalid @enderror"
                                rows="3" required>{{ old('alasan', $transaksi->alasan) }}</textarea>
                            @error('alasan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Status -->
                    <div class="row mb-6">
                        <label class="col-lg-4 col-form-label required fw-bold fs-6">Status</label>
                        <div class="col-lg-8 fv-row">
                            <select name="status" class="form-select form-select-lg form-select-solid @error('status') is-invalid @enderror" required>
                                <option value="" disabled>Pilih Status</option>
                                <option value="Belum Diambil" {{ old('status', $transaksi->status) == 'Belum Diambil' ? 'selected' : '' }}>Belum Diambil</option>
                                <option value="Sudah Dikembalikan" {{ old('status', $transaksi->status) == 'Sudah Dikembalikan' ? 'selected' : '' }}>Sudah Dikembalikan</option>
                                <option value="Belum Dikembalikan" {{ old('status', $transaksi->status) == 'Belum Dikembalikan' ? 'selected' : '' }}>Belum Dikembalikan</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="{{ route('admin.transaksis.index') }}" class="btn btn-light me-2">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection