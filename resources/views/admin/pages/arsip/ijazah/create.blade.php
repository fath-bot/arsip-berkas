@extends('admin.layouts.app')

@section('title')
    Tambah Data Arsip Ijazah
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
        {{-- begin::Container --}}
        <div class=" container-xxl " id="kt_content_container">
            {{-- begin::Tables Widget 9 --}}
            <div class="card mb-5 mb-xl-10">
                {{-- begin::Content --}}
                <div id="kt_account_profile_details" class="collapse show">
                    {{-- begin::Form --}}
                    <form class="form" action="{{ route('admin.ijazahs.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf

                        {{-- begin::Card body --}}
                        <div class="card-body border-top p-9">
                            {{-- begin::Input group --}}
                            <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Nama Pegawai</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="nama"
                                        class="form-control form-control-lg form-control-solid @error('nama') is-invalid @enderror"
                                        placeholder="Tuliskan nama anda" value="{{ old('nama') }}" />
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">NIP</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="integer" name="nip"
                                        class="form-control form-control-lg form-control-solid @error('nip') is-invalid @enderror"
                                        placeholder="Tuliskan NIP anda" value="{{ old('nip') }}" />
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">jabatan</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="jabatan"
                                        class="form-control form-control-lg form-control-solid @error('jabatan') is-invalid @enderror"
                                        placeholder="Tuliskan jabatan anda" value="{{ old('jabatan') }}" />
                                    @error('jabatan')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                             <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Jenjang Studi</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="enum" name="jenjang" list="jenjang"
                                        class="form-control form-control-lg form-control-solid @error('jenjang') is-invalid @enderror"
                                        placeholder="Pilih jenjang studi anda" value="{{ old('jenjang') }}" />
                                {{-- Datalist --}}
                                <datalist id="jenjang">
                                    <option value="SMA">
                                    <option value="D3">
                                    <option value="S1">
                                    <option value="S2">
                                    <option value="S3">
                                </datalist>

                                {{-- Error message --}}
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- end::Col --}}
                        </div>
                        {{-- end::Input group --}}
                </div>
                            <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Universitas</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="universitas"
                                        class="form-control form-control-lg form-control-solid @error('universitas') is-invalid @enderror"
                                        placeholder="Tuliskan universitas anda" value="{{ old('universitas') }}" />
                                    @error('universitas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            {{-- end::Input group --}}
                             <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Letak Berkas</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="letak_berkas"
                                        class="form-control form-control-lg form-control-solid @error('letak_berkas') is-invalid @enderror"
                                        placeholder="Tuliskan Letak Berkas" value="{{ old('letak_berkas') }}" />
                                    @error('letak_berkas')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                {{-- end::Col --}}
                            </div>
                            {{-- end::Input group --}}
                {{-- begin::Actions --}}
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <button type="reset" class="btn btn-white btn-active-light-primary me-2">Reset</button>
                    <button type="submit" class="btn btn-primary" id="kt_account_profile_details_submit">Simpan</button>
                </div>
                {{-- end::Actions --}}
                </form>
                {{-- end::Form --}}
            </div>
            {{-- end::Content --}}
        </div>
        {{-- end::Tables Widget 9 --}}
    </div>
    {{-- end::Container --}}
    </div>
@endsection
