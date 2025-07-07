@extends('admin.layouts.app')

@include('sweetalert::alert')
@section('title' )
    Data Arsip SK Jabatan
@endsection

@section('content')
    <div class="content d-flex flex-column flex-column-fluid text-align=center" id="kt_content">
        {{-- begin::Container --}}
        <div class=" container-xxl " id="kt_content_container">
            {{-- begin::Tables Widget 9 --}}
            <div class="card mb-5 mb-xl-10">
                {{-- begin::Header --}}
                <div class="card-header border-0 pt-5">
                    <h3 class="card-title align-items-start flex-column">
                    </h3>
                    {{-- begin::Toolbar --}}
                    <div class="d-flex justify-content-end" data-kt-customer-table-toolbar="base">
                        {{-- begin::Add admin --}}
                        <button type="button" onclick="location.href='{{ route('admin.jabatans.create') }}';"
                            class="btn btn-primary">
                            Tambah Data
                        </button>
                        {{-- end::Add admin --}}
                    </div>
                    {{-- end::Toolbar --}}
                </div>
                {{-- end::Header --}}
                {{-- begin::Body --}}
                <div class="card-body py-3">
                    {{-- begin::Table container --}}
                    <div class="table-responsive">
                        {{-- begin::Table --}}
                        <table id="kt_ijazahs_table" class="table align-middle table-row-dashed fs-6 gy-5">
                            {{-- begin::Table head --}}
                            <thead>
                                <tr class="fw-bold text-muted">
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>NIP</th>
                                    <th>No SK Pangkat</th>
                                    <th>Tanggal SK</th>
                                    <th>Letak Berkas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            {{-- end::Table head --}}
                            {{-- begin::Table body --}}
                            <tbody>
                                @foreach ($jabatans as $jabatan)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>

                                        <td>{{ $jabatan->nama }}</td>
                                        <td>{{ $jabatan->nip }}</td>
                                        <td>{{ $jabatan->jabatan }}</td>
                                        <td>{{ $jabatan->no_sk }}</td>
                                        <td>{{ $jabatan->tanggal }}</td>
                                        <td>{{ $jabatan->letak_berkas }}</td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-light btn-active-light-primary"
                                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end"
                                                data-kt-menu-flip="top-end">
                                                {{-- begin::Svg Icon | path: icons/duotone/Navigation/Angle-down.svg --}}
                                                <span class="svg-icon svg-icon-5 m-0">
                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                        xmlns:xlink="http://www.w3.org/1999/xlink" width="24px"
                                                        height="24px" viewBox="0 0 24 24" version="1.1">
                                                        <g stroke="none" stroke-width="1" fill="none"
                                                            fill-rule="evenodd">
                                                            <polygon points="0 0 24 0 24 24 0 24" />
                                                            <path
                                                                d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z"
                                                                fill="currentColor" fill-rule="nonzero"
                                                                transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)" />
                                                        </g>
                                                    </svg>
                                                </span>
                                                {{-- end::Svg Icon --}}
                                            </a>
                                            {{-- begin::Menu --}}
                                            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4"
                                                data-kt-menu="true">
                                                {{-- begin::Menu item --}}
                                                <div class="menu-item px-3">
                                                    <a href="{{ route('admin.pangkats.edit', $jabatan->id) }}"
                                                        class="menu-link px-3">Edit</a>
                                                </div>
                                                {{-- end::Menu item --}}
                                                {{-- begin::Menu item --}}
                                                <div class="menu-item px-3">
                                                    <a href="#" class="menu-link px-3" data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal"
                                                        onclick="setDelete('{{ route('admin.jabatans.destroy', $jabatan->id) }}')">Hapus</a>
                                                </div>
                                                {{-- end::Menu item --}}
                                            </div>
                                            {{-- end::Menu --}}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            {{-- end::Table body --}}
                        </table>
                        {{-- end::Table --}}
                    </div>
                    {{-- end::Table container --}}
                </div>
                {{-- begin::Body --}}
            </div>
            {{-- end::Tables Widget 9 --}}
        </div>
        {{-- end::Container --}}
    </div>

    {{-- begin::Modal Delete --}}
    <div class="modal fade" tabindex="-1" id="deleteModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <div class="modal-header">
                        <h5 class="modal-title">Konfirmasi Hapus Data SK Jabatan</h5>
                        {{-- begin::Close --}}
                        <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal"
                            aria-label="Close">
                            <span class="svg-icon svg-icon-2x">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                    <g transform="translate(12.000000, 12.000000) rotate(-45.000000) translate(-12.000000, -12.000000) translate(4.000000, 4.000000)"
                                        fill="currentColor">
                                        <rect fill="currentColor" x="0" y="7" width="16" height="2" rx="1">
                                        </rect>
                                        <rect fill="currentColor" opacity="0.5"
                                            transform="translate(8.000000, 8.000000) rotate(-270.000000) translate(-8.000000, -8.000000)"
                                            x="0" y="7" width="16" height="2" rx="1">
                                        </rect>
                                    </g>
                                </svg>
                            </span>
                        </div>
                        {{-- end::Close --}}
                    </div>
                    <div class="modal-body">
                        <p>Yakin ingin menghapus data SK Jabatan ini? </p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Tidak</button>
                        <button type="submit" class="btn btn-primary">Ya</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- end::Modal Delete --}}
@endsection

@section('page_styles')
    <link href="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet"
        type="text/css" />
@endsection

@section('page_scripts')
    <script src="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
    <script>
        $("#kt_pangkatss_table").DataTable({
            "dom": "<'row'" +
                "<'col-sm-6 d-flex align-items-center justify-conten-start'l>" +
                "<'col-sm-6 d-flex align-items-center justify-content-end'f>" +
                ">" +

                "<'table-responsive'tr>" +

                "<'row'" +
                "<'col-sm-12 col-md-5 d-flex align-items-center justify-content-center justify-content-md-start'i>" +
                "<'col-sm-12 col-md-7 d-flex align-items-center justify-content-center justify-content-md-end'p>" +
                ">"
        });
    </script>
    <script>
        function setDelete(action) {
            document.getElementById('deleteForm').action = action;
        }
    </script>
@endsection
