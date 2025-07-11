@extends('admin.layouts.apps')

@section('title', 'Data Peminjaman Berkas')

@section('content')
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <div class="container-xxl" id="kt_content_container">
        <div class="card mb-5 mb-xl-10">
            <div class="card-header border-0 pt-5">
                <div class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold fs-3 mb-1">Data Peminjaman Berkas</span>
                    <span class="text-muted mt-1 fw-semibold fs-7">{{ $transaksis->count() }} transaksi ditemukan</span>
                </div>
                <div class="card-toolbar">
                    <a href="{{ route('admin.transaksis.create') }}" class="btn btn-primary">
                        <i class="ki-duotone ki-plus fs-2"></i> Tambah Transaksi
                    </a>
                </div>
            </div>

            <div class="card-body py-3">
                <div class="table-responsive">
                    <table id="kt_transaksis_table" class="table align-middle table-row-dashed fs-6 gy-5">
                        <thead>
                            <tr class="fw-bold text-muted bg-light">
                                <th class="min-w-50px">No</th>
                                <th class="min-w-150px">Jenis Berkas</th>
                                <th class="min-w-120px">Tanggal Pinjam</th>
                                <th class="min-w-120px">Tanggal Kembali</th>
                                <th class="min-w-200px">Alasan</th>
                                <th class="min-w-120px">Status</th>
                                <th class="min-w-100px text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($transaksis as $transaksi)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="badge badge-light-primary">{{ $transaksi->jenis_berkas }}</span>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($transaksi->tanggal_masuk)->format('d/m/Y') }}</td>
                                <td>
                                    @if($transaksi->tanggal_kembali)
                                        {{ \Carbon\Carbon::parse($transaksi->tanggal_kembali)->format('d/m/Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td title="{{ $transaksi->alasan }}">
                                    {{ Str::limit($transaksi->alasan, 50) }}
                                    @if(strlen($transaksi->alasan) > 50)
                                        <span class="text-primary cursor-pointer" data-bs-toggle="tooltip" title="Lihat selengkapnya">...</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $statusClasses = [
                                            'Belum Diambil' => 'danger',
                                            'Sudah Dikembalikan' => 'success',
                                            'Belum Dikembalikan' => 'warning'
                                        ];
                                        $statusClass = $statusClasses[$transaksi->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge badge-light-{{ $statusClass }}">{{ $transaksi->status }}</span>
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2">
                                        <!-- Edit Button -->
                                        <a href="{{ route('admin.transaksis.edit', $transaksi->id) }}" 
                                           class="btn btn-icon btn-active-light-primary w-30px h-30px"
                                           data-bs-toggle="tooltip" 
                                           title="Edit">
                                            <i class="fas fa-edit fs-4"></i>
                                        </a>
                                        
                                        <!-- Delete Button with Modal Trigger -->
                                        <button class="btn btn-icon btn-active-light-danger w-30px h-30px" 
                                           data-bs-toggle="modal" 
                                           data-bs-target="#deleteModal" 
                                           onclick="setDeleteAction('{{ route('admin.transaksis.destroy', $transaksi->id) }}')"
                                           title="Hapus">
                                            <i class="fas fa-trash fs-4"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" tabindex="-1" id="deleteModal" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Yakin ingin menghapus data transaksi peminjaman ini? Tindakan ini tidak dapat dibatalkan.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">
                        <span class="indicator-label">Hapus</span>
                        <span class="indicator-progress">Menghapus...
                            <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('page_styles')
<link href="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.css') }}" rel="stylesheet">
<style>
    /* Custom table styling */
    #kt_transaksis_table tbody tr td {
        vertical-align: middle;
    }
    
    /* Responsive adjustments */
    @media (max-width: 767px) {
        .card-header {
            flex-direction: column;
            gap: 1rem;
        }
        .card-toolbar {
            width: 100%;
        }
        .card-toolbar a {
            width: 100%;
        }
    }
    
    /* Badge styling */
    .badge {
        padding: 0.35em 0.65em;
        font-size: 0.85em;
    }
</style>
@endsection

@section('page_scripts')
<script src="{{ asset('themes/admin/plugins/custom/datatables/datatables.bundle.js') }}"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Initialize DataTable with responsive settings
        const table = $('#kt_transaksis_table').DataTable({
            responsive: true,
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.4/i18n/id.json"
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                 "<'row'<'col-sm-12'tr>>" +
                 "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            buttons: [
                {
                    extend: 'copy',
                    className: 'btn btn-light-primary',
                    text: '<i class="fas fa-copy"></i> Copy',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn btn-light-success',
                    text: '<i class="fas fa-file-excel"></i> Excel',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn btn-light-danger',
                    text: '<i class="fas fa-file-pdf"></i> PDF',
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn btn-light-info',
                    text: '<i class="fas fa-print"></i> Print',
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ],
            initComplete: function() {
                // Add custom filter for status
                this.api().columns(5).every(function() {
                    const column = this;
                    const select = $('<select class="form-select form-select-sm"><option value="">Semua Status</option></select>')
                        .appendTo($(column.header()).empty())
                        .on('change', function() {
                            const val = $.fn.dataTable.util.escapeRegex($(this).val());
                            column.search(val ? '^' + val + '$' : '', true, false).draw();
                        });

                    column.data().unique().sort().each(function(d) {
                        select.append('<option value="' + d + '">' + d + '</option>');
                    });
                });
            }
        });

        // Initialize tooltips
        $('[data-bs-toggle="tooltip"]').tooltip({
            trigger: 'hover'
        });

        // Responsive adjustments
        function handleResponsive() {
            if ($(window).width() < 768) {
                table.buttons().container().addClass('flex-column');
                $('.dt-buttons .btn').addClass('mb-2').css('width', '100%');
            } else {
                table.buttons().container().removeClass('flex-column');
                $('.dt-buttons .btn').removeClass('mb-2').css('width', 'auto');
            }
        }

        // Initial call and window resize event
        handleResponsive();
        $(window).resize(handleResponsive);
    });

    // Set delete action for modal
    function setDeleteAction(url) {
        const form = document.getElementById('deleteForm');
        form.action = url;
        
        // Add loading state to delete button
        const deleteButton = form.querySelector('.btn-danger');
        deleteButton.addEventListener('click', function(e) {
            if (!form.action) {
                e.preventDefault();
                return;
            }
            
            // Show loading indicator
            deleteButton.setAttribute('data-kt-indicator', 'on');
            deleteButton.disabled = true;
        });
    }
</script>
@endsection