@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-primary"> Dashboard </h2>
        <p class="text-muted">Ringkasan data operasional Yukostum untuk bulan <strong>{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</strong>.</p>
    </div>
</div>

<div class="row">
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 bg-primary text-white h-100 rounded-4">
            <div class="card-body p-4 d-flex align-items-center">
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 opacity-75">Transaksi Bulan Ini</h6>
                    <h2 class="fw-bold mb-0">{{ $totalTransaksi }} <span class="fs-6 fw-normal">Pesanan</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 bg-success text-white h-100 rounded-4">
            <div class="card-body p-4 d-flex align-items-center">
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 opacity-75">Paling Laris Bulan Ini</h6>
                    <h4 class="fw-bold mb-1 text-truncate" style="max-width: 200px;" title="{{ $kostumTerlaris }}">{{ $kostumTerlaris }}</h4>
                    <small class="opacity-75">Disewa {{ $jumlahDisewa }} kali</small>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 bg-warning text-dark h-100 rounded-4">
            <div class="card-body p-4 d-flex align-items-center">
                <div>
                    <h6 class="text-uppercase fw-bold mb-1 opacity-75">Total Stok Tersedia</h6>
                    <h2 class="fw-bold mb-0">{{ $totalStok }} <span class="fs-6 fw-normal">Pcs</span></h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-2">
    <div class="col-12 text-center text-muted">
        <small>Data di atas diperbarui secara real-time berdasarkan aktivitas sistem hari ini.</small>
    </div>
</div>
@endsection