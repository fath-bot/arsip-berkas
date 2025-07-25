@extends('components.apps')

@section('title', 'Tambah Transaksi Peminjaman (Admin)')

@section('content')
<div class="main-content" id="mainContent">
  <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
      <div class="card mb-5 mb-xl-10">
        <div class="card-header border-0 pt-5">
          <h3 class="card-title fw-bold fs-3 mb-1">Tambah Transaksi (Admin)</h3>
        </div>
        <form action="{{ route('admin.transaksis.store') }}" method="POST">
          @csrf
          <div class="card-body border-top p-9">
            @if ($errors->any())
              <div class="alert alert-danger alert-dismissible fade show">
                <strong>Terjadi kesalahan:</strong>
                <ul class="mb-0">
                  @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
            @endif

            {{-- Pilih User --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Peminjam</label>
              <div class="col-lg-8 fv-row">
                <select name="user_id" class="form-select form-select-lg form-select-solid @error('user_id') is-invalid @enderror" required>
                  <option value="" disabled selected>-- Pilih User --</option>
                  @foreach ($users as $user)
                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->nip }})</option>
                  @endforeach
                </select>
                @error('user_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Pilih Jenis Arsip --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Jenis Arsip</label>
              <div class="col-lg-8 fv-row">
                <select id="selectJenis" name="arsip_jenis_id" class="form-select form-select-lg form-select-solid @error('arsip_jenis_id') is-invalid @enderror" required>
                  <option value="" disabled selected>-- Pilih Jenis Arsip --</option>
                  @foreach ($jenis_arsips as $jenis)
                    <option value="{{ $jenis->id }}" {{ old('arsip_jenis_id') == $jenis->id ? 'selected' : '' }}>{{ $jenis->nama_jenis }}</option>
                  @endforeach
                </select>
                @error('arsip_jenis_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Pilih Nama Berkas --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Nama Berkas</label>
              <div class="col-lg-8 fv-row">
                <select id="selectArsip" name="arsip_id" class="form-select form-select-lg form-select-solid @error('arsip_id') is-invalid @enderror" required>
                  <option value="" disabled selected>-- Pilih Berkas --</option>
                  {{-- Akan diisi otomatis via JS --}}
                </select>
                @error('arsip_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Tanggal Pinjam & Kembali --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Pinjam</label>
              <div class="col-lg-8 fv-row">
                <input type="date" name="tanggal_pinjam" id="tanggal_pinjam"
                  class="form-control form-control-lg form-control-solid @error('tanggal_pinjam') is-invalid @enderror"
                  value="{{ old('tanggal_pinjam') }}" onchange="setTanggalKembali(this.value)" required>
                @error('tanggal_pinjam') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal Kembali</label>
              <div class="col-lg-8 fv-row">
                <input type="date" name="tanggal_kembali" id="tanggal_kembali"
                  class="form-control form-control-lg form-control-solid @error('tanggal_kembali') is-invalid @enderror"
                  value="{{ old('tanggal_kembali') }}" readonly required>
                @error('tanggal_kembali') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Alasan & Keterangan --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Alasan</label>
              <div class="col-lg-8 fv-row">
                <textarea name="alasan" class="form-control form-control-lg form-control-solid @error('alasan') is-invalid @enderror" required>{{ old('alasan') }}</textarea>
                @error('alasan') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label fw-bold fs-6">Keterangan</label>
              <div class="col-lg-8 fv-row">
                <textarea name="keterangan" class="form-control form-control-lg form-control-solid @error('keterangan') is-invalid @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

            {{-- Status --}}
            <div class="row mb-2">
              <label class="col-lg-4 col-form-label required fw-bold fs-6">Status</label>
              <div class="col-lg-8 fv-row">
                <select name="status" class="form-select form-select-lg form-select-solid @error('status') is-invalid @enderror" required>
                  <option value="belum_diambil" {{ old('status') == 'belum_diambil' ? 'selected' : '' }}>Belum Diambil</option>
                  <option value="sudah_diambil" {{ old('status') == 'sudah_diambil' ? 'selected' : '' }}>Sudah Diambil</option>
                  <option value="dikembalikan" {{ old('status') == 'dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                </select>
                @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
              </div>
            </div>

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
@endsection

@push('scripts')
<script>
  const allArsip = @json($arsips);

  document.getElementById('selectJenis').addEventListener('change', function() {
    const jenisId = Number(this.value);
    const target = document.getElementById('selectArsip');
    target.innerHTML = '<option value="" disabled selected>-- Pilih Berkas --</option>';

    allArsip
      .filter(a => a.arsip_jenis_id === jenisId)
      .forEach(a => {
        const opt = document.createElement('option');
        opt.value = a.id;
        opt.textContent = `${a.nama_arsip}`;
        target.appendChild(opt);
      });

    target.disabled = false;
  });

  function setTanggalKembali(pinjam) {
    if (!pinjam) return;
    const d = new Date(pinjam);
    d.setDate(d.getDate() + 2);
    const yyyy = d.getFullYear();
    const mm = String(d.getMonth() + 1).padStart(2, '0');
    const dd = String(d.getDate()).padStart(2, '0');
    document.getElementById('tanggal_kembali').value = `${yyyy}-${mm}-${dd}`;
  }

  document.addEventListener('DOMContentLoaded', () => {
    const v = document.getElementById('tanggal_pinjam').value;
    if (v) setTanggalKembali(v);
  });
</script>
@endpush
