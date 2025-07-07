@extends('admin.layouts.app')

@section('title')
    Tambah Data Arsip SK Jabatan
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
                    <form class="form" action="{{ route('admin.jabatans.store') }}" method="POST"
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
                                        placeholder="Tuliskan nama pegawai" value="{{ old('nama') }}" />
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
                                        placeholder="Tuliskan NIP" value="{{ old('nip') }}" />
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
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">No SK Jabatan</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="text" name="no_sk"
                                        class="form-control form-control-lg form-control-solid @error('no_sk') is-invalid @enderror"
                                        placeholder="Tuliskan No SK Jabatan" value="{{ old('no_sk') }}" />
                                    @error('no_sk')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            <div class="row mb-6">
                                {{-- begin::Label --}}
                                <label class="col-lg-4 col-form-label required fw-bold fs-6">Tanggal SK Jabatan</label>
                                {{-- end::Label --}}
                                {{-- begin::Col --}}
                                <div class="col-lg-8 fv-row">
                                    <input type="date" name="tanggal"
                                        class="form-control form-control-lg form-control-solid @error('tanggal') is-invalid @enderror"
                                        placeholder="Pilih Tanggal SK Jabatan" value="{{ old('tanggal') }}" />
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            </div>
                            {{-- end::Input group --}}
                            {{-- begin::Input group --}}
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
                            {{-- begin::Input group --}}

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
