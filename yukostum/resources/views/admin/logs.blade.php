@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-primary"> Log Aktivitas Sistem</h2>
        <p class="text-muted">Pantau semua pergerakan dan perubahan data di dalam sistem Yukostum.</p>
    </div>
</div>

<div class="card shadow-sm border-0">
    <div class="card-body p-0 table-responsive">
        <table class="table table-hover table-striped mb-0">
            <thead class="table-dark">
                <tr>
                    <th class="px-4 py-3">Waktu Kejadian</th>
                    <th class="py-3">Pelaku (User)</th>
                    <th class="py-3">Aksi</th>
                    <th class="py-3">Detail Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="px-4 text-muted small">
                        {{ $log->created_at->format('d M Y, H:i:s') }}
                    </td>
                    <td class="fw-bold text-primary">
                        {{ $log->user ? $log->user->name : 'Sistem Otomatis' }}
                        @if($log->user)
                            <span class="badge bg-secondary ms-1" style="font-size: 0.6rem;">{{ strtoupper($log->user->role) }}</span>
                        @endif
                    </td>
                    <td>
                        <span class="badge bg-info text-dark fw-bold">{{ $log->action }}</span>
                    </td>
                    <td class="text-muted">
                        {{ $log->description ?: '-' }}
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center py-4 text-muted">Belum ada catatan aktivitas di sistem.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-4">
    {{ $logs->links('pagination::bootstrap-5') }}
</div>
@endsection