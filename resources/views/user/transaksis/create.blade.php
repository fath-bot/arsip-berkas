@extends('components.apps')

@section('title', 'Tambah Transaksi Peminjaman')

@section('content')
<div class="main-content" id="mainContent">
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
      <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 pt-5">
          <h3 class="card-title fw-bold fs-3 mb-1">Tambah Transaksi Peminjaman</h3>
        </div>
        <form action="{{ route('user.transaksis.store') }}" method="POST">
          @csrf
          <div class="card-body border-top p-9">
            @if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 20px;">
        <strong>Terjadi kesalahan:</strong>
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

            {{-- Nama & NIP Sesi --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Nama Peminjam</label>
              <div class="col-lg-8 fv-row">
                <input type="text" class="form-control form-control-lg form-control-solid"
                       value="{{ session('user_name') }}" readonly>
                <input type="hidden" name="user_id" value="{{ session('user_id') }}">
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">NIP Peminjam</label>
              <div class="col-lg-8 fv-row">
                <input type="text" class="form-control form-control-lg form-control-solid"
                       value="{{ session('user_nip') }}" readonly>
              </div>
            </div>

            {{-- 1) Pilih Jenis Arsip --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Jenis Arsip</label>
              <div class="col-lg-8 fv-row">
                <select id="selectJenis" name="arsip_jenis_id"
                        class="form-select form-select-lg form-select-solid @error('arsip_jenis_id') is-invalid @enderror"
                        required>
                  <option value="" disabled selected>-- Pilih Jenis Arsip --</option>
                  @foreach($jenis_arsips as $jenis)
                    <option value="{{ $jenis->id }}"
                      {{ old('arsip_jenis_id') == $jenis->id ? 'selected' : '' }}>
                      {{ $jenis->nama_jenis }}
                    </option>
                  @endforeach
                </select>
                @error('arsip_jenis_id')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            {{-- 2) Pilih Nama Berkas --}}
           <select id="selectArsip" name="arsip_id"
                class="form-select form-select-lg form-select-solid @error('arsip_id') is-invalid @enderror">
                <option value="" selected>-- Pilih Jenis Terlebih Dahulu --</option>
            </select>

            @if(isset($selectedArsip))
            <input type="hidden" name="arsip_id" value="{{ $selectedArsip->id }}">
            <div class="alert alert-info">
                Anda akan meminjam berkas: <strong>{{ $selectedArsip->nama_arsip }}</strong>
            </div>
            @endif

            {{-- Tanggal Pinjam & Kembali --}}
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
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Kembali</label>
              <div class="col-lg-8 fv-row">
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                  class="form-control form-control-lg form-control-solid @error('tanggal_kembali') is-invalid @enderror"
                  value="{{ old('tanggal_kembali') }}"
                  readonly required>
                @error('tanggal_kembali')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

            {{-- Alasan & Keterangan --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Alasan</label>
              <div class="col-lg-8 fv-row">
                <textarea name="alasan"
                  class="form-control form-control-lg form-control-solid @error('alasan') is-invalid @enderror"
                  rows="3" required>{{ old('alasan') }}</textarea>
                @error('alasan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Keterangan</label>
              <div class="col-lg-8 fv-row">
                <textarea name="keterangan"
                  class="form-control form-control-lg form-control-solid @error('keterangan') is-invalid @enderror"
                  rows="3" required>{{ old('keterangan') }}</textarea>
                @error('keterangan')
                  <div class="invalid-feedback">{{ $message }}</div>
                @enderror
              </div>
            </div>

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

@endsection
@push('scripts')
<script>
  // Kirim semua arsip (termasuk relasi 'jenis') sebagai JSON
  const allArsip = @json($arsips);

  // Populate opsi "Nama Berkas" saat jenis berubah
  document.getElementById('selectJenis').addEventListener('change', function() {
    const jenisId = Number(this.value);
    const target  = document.getElementById('selectArsip');

    // Reset dropdown
    target.innerHTML = '<option value="" disabled selected>-- Pilih Berkas --</option>';

    // Filter dan append
    allArsip
      .filter(a => a.arsip_jenis_id === jenisId)
      .forEach(a => {
        const opt = document.createElement('option');
        opt.value = a.id;
        // Bangun label: "Nama Berkas (Nama Jenis)"
        opt.textContent = `${a.nama_arsip} (${a.jenis.nama_jenis})`;
        target.appendChild(opt);
      });

    target.disabled = false;
  });

  // Auto isi Tanggal Kembali = Pinjam + 2 hari
  function setTanggalKembali(pinjam) {
    if (!pinjam) return;
    const d = new Date(pinjam);
    d.setDate(d.getDate() + 2);
    const yyyy = d.getFullYear();
    const mm   = String(d.getMonth() + 1).padStart(2, '0');
    const dd   = String(d.getDate()).padStart(2, '0');
    document.getElementById('tanggal_kembali').value = `${yyyy}-${mm}-${dd}`;
  }

  document.addEventListener('DOMContentLoaded', () => {
    const v = document.getElementById('tanggal_pinjam').value;
    if (v) setTanggalKembali(v);
  });
</script>
@endpush

