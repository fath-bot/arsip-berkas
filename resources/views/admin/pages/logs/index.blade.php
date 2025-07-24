@extends('components.apps')

@section('title', 'Log Aktivitas Pengguna')

@section('content')
<div class="main-content" id="mainContent">
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h2 class="m-0 font-weight-bold text-primary">Log Aktivitas Pengguna</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="logTable" class="table table-bordered table-striped">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Nama User</th>
                                <th>Aktivitas</th>
                                <th>Waktu</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($logs as $index => $log)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $log->user->name ?? '-' }}</td>
                                    <td>{{ $log->aktivitas }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('H:i - d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center">Belum ada log aktivitas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- DataTables Bootstrap 5 CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
@endpush

@push('scripts')
<!-- jQuery (dibutuhkan oleh DataTables) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
    $(document).ready(function () {
        $('#logTable').DataTable({
            pageLength: 10,
            language: {
                url: '//cdn.datatables.net/plug-ins/1.13.6/i18n/id.json' // Bahasa Indonesia
            }
        });
    });
</script>
@endpush
