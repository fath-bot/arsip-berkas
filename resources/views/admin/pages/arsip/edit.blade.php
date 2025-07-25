@extends('components.apps')

@section('title', 'Edit Arsip ' . ucfirst($type))

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">

            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Edit Arsip {{ ucfirst($type) }}</h6>
            </div>

            <div class="card-body">
                <form action="{{ route('admin.arsip.update', ['type' => $type, 'id' => $item->id]) }}"
                      method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Nama --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Nama</label>
                        <div class="col-lg-8">
                            <input type="text" name="nama" class="form-control"
                                   value="{{ old('nama', $item->nama ?? ($item->user->name ?? '')) }}"
                                   required placeholder="Masukkan nama lengkap" readonly>
                                   <input type="hidden" name="user_id" value="{{ $item->user_id }}">

                        </div>
                    </div>

                    {{-- NIP --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">NIP</label>
                        <div class="col-lg-8">
                            <input type="text" name="nip" class="form-control"
                                   value="{{ old('nip', $item->user->nip ?? '') }}" required
                                   placeholder="Masukkan NIP" readonly>
                        </div>
                    </div>
                    {{-- nama Arsip --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Nama Arsip</label>
                        <div class="col-lg-8">
                            <input type="text" name="nama_arsip" class="form-control"
                                   value="{{ old('nama_arsip', $item->nama_arsip) }}" required
                                   placeholder="Masukkan keterangan atau nomor SK">
                        </div>
                    </div>

                    {{-- Keterangan Arsip --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label ">Keterangan Arsip</label>
                        <div class="col-lg-8">
                            <input type="text" name="keterangan_arsip" class="form-control"
                                value="{{ old('keterangan_arsip', $item->keterangan_arsip) }}"
                                placeholder="Masukkan keterangan Arsip">
                        </div>
                    </div>

                    {{-- Letak Berkas --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label ">Letak Berkas</label>
                        <div class="col-lg-8">
                            <input type="text" name="letak_berkas" class="form-control"
                                   value="{{ old('letak_berkas', $item->letak_berkas) }}" 
                                   placeholder="Contoh: Lemari A / Rak 3 / Map Kuning">
                        </div>
                    </div>

                    {{-- File Upload --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label">Berkas Digital (PDF, JPG, PNG)</label>
                        <div class="col-lg-8">
                            <input type="file" name="file" class="form-control">

                            @if (!empty($item->file_path))
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $item->file_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary">
                                        <i class="fas fa-file-alt"></i> Lihat Berkas Sebelumnya
                                    </a>
                                </div>
                            @else
                                <small class="text-muted fst-italic">Belum ada dokumen digital yang diunggah.</small>
                            @endif
                        </div>
                    </div>

                    {{-- Tanggal Upload --}}
                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label ">Tanggal Upload</label>
                        <div class="col-lg-8">
                            <input type="date" name="tanggal_upload" class="form-control"
                                   value="{{ old('tanggal_upload', \Carbon\Carbon::parse($item->tanggal_upload)->format('Y-m-d')) }}"
                                   >
                        </div>
                    </div>

                    {{-- Tombol Aksi --}}
                    <div class=" text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.arsip.index', ['type' => $type]) }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
