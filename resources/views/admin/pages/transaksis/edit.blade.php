{{-- resources/views/admin/pages/transaksis/edit.blade.php --}}
@extends('components.apps')

@section('title', 'Edit Transaksi Peminjaman')

@section('content')
<div class="main-content" id="mainContent">
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Edit Transaksi Peminjaman</h6>
        </div>
        <div class="card-body">
            {{-- Tampilkan error validasi --}}
            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.transaksis.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="arsip_id" value="{{ $transaksi->arsip_id }}">
                <input type="hidden" name="arsip_jenis_id" value="{{ $transaksi->arsip->arsip_jenis_id }}">

                

                {{-- Nama Peminjam (readonly) --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Nama Peminjam</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control"
                               value="{{ $transaksi->user->name }}"
                               readonly>
                    </div>
                </div>

                {{-- NIP Peminjam (readonly) --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">NIP</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control"
                               value="{{ $transaksi->user->nip }}"
                               readonly>
                    </div>
                </div>

                {{-- Jenis Berkas (readonly) --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Jenis Berkas</label>
                    <div class="col-lg-8">
                        <input type="text"
                               class="form-control"
                               value="{{ $transaksi->arsip->jenis->nama_jenis }}"
                               readonly>
                    </div>
                </div>

                {{-- Letak Berkas (editable) --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label">Letak Berkas</label>
                    <div class="col-lg-8">
                        <input type="text"
                               name="letak_berkas"
                               class="form-control"
                               value="{{ old('letak_berkas', $transaksi->arsip->letak_berkas) }}"
                               placeholder="{{ $transaksi->arsip->letak_berkas ? '' : 'Letak berkas belum diinput' }}">
                    </div>
                </div>

                {{-- Tanggal Pinjam --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Tanggal Pinjam</label>
                    <div class="col-lg-8">
                        <input type="date"
                               name="tanggal_pinjam"
                               class="form-control"
                               value="{{ old('tanggal_pinjam', $transaksi->tanggal_pinjam->format('Y-m-d')) }}"
                               required>
                    </div>
                </div>

                {{-- Tanggal Kembali --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Tanggal Kembali</label>
                    <div class="col-lg-8">
                        <input type="date"
                               name="tanggal_kembali"
                               class="form-control"
                               value="{{ old('tanggal_kembali', optional($transaksi->tanggal_kembali)->format('Y-m-d')) }}"
                               required>
                    </div>
                </div>

                {{-- Alasan --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Alasan</label>
                    <div class="col-lg-8">
                        <textarea name="alasan"
                                  class="form-control"
                                  rows="3"
                                  required>{{ old('alasan', $transaksi->alasan) }}</textarea>
                    </div>
                </div>

                {{-- Keterangan --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Keterangan</label>
                    <div class="col-lg-8">
                        <textarea name="keterangan"
                                  class="form-control"
                                  rows="3"
                                  required>{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                    </div>
                </div>

                {{-- Status --}}
                <div class="row mb-3">
                    <label class="col-lg-4 col-form-label required">Status</label>
                    <div class="col-lg-8">
                        <select name="status" class="form-select" required>
                            @php
                                $options = [
                                    'belum_diambil' => 'Belum Diambil',
                                    'dipinjam'      => 'Dipinjam',
                                    'dikembalikan'  => 'Sudah Dikembalikan',
                                ];
                                $current = old('status', $transaksi->status);
                            @endphp

                            @foreach($options as $value => $label)
                                <option value="{{ $value }}"
                                        {{ $current === $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Submit --}}
                <div class="card-footer text-end">
                    <button type="submit" class="btn btn-primary">Update</button>
                    <a href="{{ route('admin.transaksis.index') }}" class="btn btn-light">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
