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
                <form action="{{ route('admin.arsip.update', ['type' => $type, 'id' => $item->id]) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Nama</label>
                        <div class="col-lg-8">
                            <input type="text" name="nama" class="form-control"
                                   value="{{ old('nama', $item->nama) }}" required
                                   placeholder="Masukkan nama lengkap">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">NIP</label>
                        <div class="col-lg-8">
                            <input type="text" name="nip" class="form-control"
                                   value="{{ old('nip', $item->nip) }}" required
                                   placeholder="Masukkan NIP">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Jabatan</label>
                        <div class="col-lg-8">
                            <input type="text" name="jabatan" class="form-control"
                                   value="{{ old('jabatan', $item->jabatan) }}" required
                                   placeholder="Masukkan jabatan">
                        </div>
                    </div>

                    @if($type == 'ijazah')
                        <div class="row mb-3">
                            <label class="col-lg-4 col-form-label required">Jenjang</label>
                            <div class="col-lg-8">
                                <select name="jenjang" class="form-control" required>
                                    @foreach(['SMA', 'D3', 'S1', 'S2', 'S3'] as $jenjang)
                                        <option value="{{ $jenjang }}" {{ old('jenjang', $item->jenjang) == $jenjang ? 'selected' : '' }}>
                                            {{ $jenjang }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-lg-4 col-form-label required">Universitas</label>
                            <div class="col-lg-8">
                                <input type="text" name="universitas" class="form-control"
                                       value="{{ old('universitas', $item->universitas) }}" required
                                       placeholder="Masukkan nama universitas">
                            </div>
                        </div>
                    @else
                        <div class="row mb-3">
                            <label class="col-lg-4 col-form-label required">No. SK</label>
                            <div class="col-lg-8">
                                <input type="text" name="no_sk" class="form-control"
                                       value="{{ old('no_sk', $item->no_sk) }}" required
                                       placeholder="Masukkan nomor SK">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-lg-4 col-form-label required">Tanggal</label>
                            <div class="col-lg-8">
                                <input type="date" name="tanggal" class="form-control"
                                       value="{{ old('tanggal', $item->tanggal) }}" required>
                            </div>
                        </div>
                    @endif

                    <div class="row mb-3">
                        <label class="col-lg-4 col-form-label required">Letak Berkas</label>
                        <div class="col-lg-8">
                            <input type="text" name="letak_berkas" class="form-control"
                                   value="{{ old('letak_berkas', $item->letak_berkas) }}" required
                                   placeholder="Contoh: Lemari A / Rak 3 / Map Kuning">
                        </div>
                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <a href="{{ route('admin.arsip.index', ['type' => $type]) }}" class="btn btn-light">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
