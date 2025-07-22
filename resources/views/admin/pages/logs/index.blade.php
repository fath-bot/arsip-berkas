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
                    <table class="table table-bordered">
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
                                    <td>{{ $logs->firstItem() + $index }}</td>
                                    <td>{{ $log->user->name ?? '-' }}</td>
                                    <td>{{ $log->aktivitas  }}</td>
                                    <td>{{ \Carbon\Carbon::parse($log->created_at)->format('H:i - d/m/Y ') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Belum ada log aktivitas</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $logs->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
