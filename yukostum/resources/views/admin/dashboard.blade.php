@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold text-dark">Dashboard Operasional</h3>
        <p class="text-muted mb-0">Ringkasan aktivitas Yukostum untuk bulan <strong>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</strong>.</p>
    </div>
</div>

<div class="row mb-4">
    
    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow-sm border-warning border-2 bg-white h-100 rounded-4">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <h6 class="text-uppercase fw-bold text-muted mb-0 mt-1">Total Pendapatan</h6>
                    
                    <div class="dropdown">
                        <button class="btn btn-sm btn-dark text-warning fw-bold dropdown-toggle rounded-pill px-3" type="button" data-bs-toggle="dropdown">
                            {{ $labelPendapatan }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 rounded-3 mt-2">
                            <li><a class="dropdown-item fw-medium {{ $filterPendapatan == 'minggu' ? 'bg-warning text-dark' : '' }}" href="?filter=minggu">📅 7 Hari Terakhir</a></li>
                            <li><a class="dropdown-item fw-medium {{ $filterPendapatan == 'bulan' ? 'bg-warning text-dark' : '' }}" href="?filter=bulan">📅 Bulan Ini</a></li>
                        </ul>
                    </div>
                </div>
                
                <h2 class="fw-bold text-dark mb-1">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</h2>
                <small class="text-success fw-bold">✓ Termasuk biaya sewa & denda</small>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow-sm border-0 bg-dark text-white h-100 rounded-4">
            <div class="card-body p-4 d-flex align-items-center">
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 opacity-75 text-warning">Pesanan Bulan Ini</h6>
                    <h2 class="fw-bold mb-0">{{ $totalTransaksi }} <span class="fs-6 fw-normal opacity-75">Transaksi masuk</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-3 mb-md-0">
        <div class="card shadow-sm bg-light border border-secondary-subtle h-100 rounded-4">
            <div class="card-body p-4 d-flex align-items-center">
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 text-muted">Stok Kostum di Gudang</h6>
                    <h2 class="fw-bold text-dark mb-0">{{ $totalStok }} <span class="fs-6 fw-normal text-muted">Pcs tersedia</span></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-7 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white border-bottom pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                <h6 class="fw-bold text-dark mb-0 text-uppercase">🔥 Top 5 Kostum Terlaris (Bulan Ini)</h6>
                <a href="/admin/kostum" class="text-muted small fw-bold text-decoration-none">Kelola Kostum →</a>
            </div>
            <div class="card-body p-0">
                <ul class="list-group list-group-flush rounded-bottom-4">
                    
                    @forelse($kostumTerlarisList as $index => $item)
                        <li class="list-group-item d-flex justify-content-between align-items-center px-4 py-3 border-bottom border-light">
                            <div class="d-flex align-items-center">
                                <span class="badge {{ $index == 0 ? 'bg-warning text-dark' : 'bg-dark text-white' }} rounded-circle me-3 d-flex justify-content-center align-items-center shadow-sm" style="width: 38px; height: 38px; font-size: 1rem;">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <h6 class="fw-bold mb-0 text-dark">{{ $item->costume->name ?? 'Kostum Telah Dihapus' }}</h6>
                                    <small class="text-muted">{{ $item->costume->type ?? '-' }}</small>
                                </div>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold text-dark fs-5">{{ $item->total_sewa }}</span>
                                <small class="text-muted d-block" style="font-size: 11px;">kali disewa</small>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item text-center py-5 text-muted bg-light">
                            <div class="fs-1 mb-2 opacity-50">📉</div>
                            <h6 class="fw-bold">Belum ada penyewaan bulan ini.</h6>
                        </li>
                    @endforelse

                </ul>
            </div>
        </div>
    </div>
</div>

<div class="row mt-3">
    <div class="col-12 text-center text-muted">
        <small>Data di atas ditarik langsung dari sistem dan diperbarui secara real-time.</small>
    </div>
</div>
@endsection