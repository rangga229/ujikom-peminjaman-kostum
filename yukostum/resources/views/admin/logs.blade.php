@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold text-dark text-uppercase">Log Aktivitas Sistem</h3>
        <p class="text-muted">Pantau semua pergerakan dan perubahan data di dalam sistem Yukostum.</p>
    </div>
</div>

<div class="card shadow-sm border-0 rounded-4">
    <div class="card-header bg-dark text-warning fw-bold py-3 px-4 fs-5 rounded-top-4 border-0 d-flex align-items-center gap-2">
        <span>🕵️‍♂️</span> Rekam Jejak Sistem
    </div>
    <div class="card-body p-0 table-responsive rounded-bottom-4">
        <table class="table table-hover mb-0 align-middle border-light">
            <thead class="table-light text-muted small text-uppercase">
                <tr>
                    <th class="ps-4 py-3">Waktu Kejadian</th>
                    <th class="py-3">Pelaku (User)</th>
                    <th class="py-3">Aksi</th>
                    <th class="pe-4 py-3">Detail Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td class="ps-4 py-3 border-bottom-0 text-muted small">
                        <strong class="text-dark d-block">{{ $log->created_at->format('d M Y') }}</strong>
                        <span class="opacity-75"> {{ $log->created_at->format('H:i:s') }}</span>
                    </td>
                    <td class="py-3 border-bottom-0">
                        <strong class="text-dark d-block mb-1">{{ $log->user ? $log->user->name : 'Sistem Otomatis' }}</strong>
                        @if($log->user)
                            <span class="badge bg-dark text-warning fw-medium px-3 py-1 rounded-pill shadow-sm" style="font-size: 0.65rem;">
                                {{ strtoupper($log->user->role) }}
                            </span>
                        @endif
                    </td>
                    <td class="py-3 border-bottom-0">
                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning fw-bold px-3 py-1 rounded-pill">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="pe-4 py-3 border-bottom-0 text-muted small lh-sm">
                        {{ $log->description ?: '-' }}
                    </td>
                </tr>
                <tr><td colspan="4" class="p-0 border-bottom border-light"></td></tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center text-muted py-5 bg-light">
                        <div class="fs-1 mb-3 opacity-25"></div>
                        <h6 class="fw-bold">Belum ada catatan aktivitas di sistem.</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="d-flex justify-content-center mt-5 mb-4">
    {{ $logs->links('pagination::bootstrap-5') }}
</div>
@endsection