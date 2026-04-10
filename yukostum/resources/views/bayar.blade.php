@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h3 class="fw-bold text-dark mb-1">Pilih Metode Pembayaran</h3>
        <p class="text-muted">Selesaikan pembayaran untuk mengamankan kostum impianmu.</p>
    </div>

    <form action="/sewa/bayar/{{ $rental->id }}" method="POST">
        @csrf
        <div class="row">
            
            <div class="col-lg-7 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Transfer Bank Virtual Account</h5>
                        
                        <label class="d-flex align-items-center border rounded-3 p-3 mb-3 cursor-pointer">
                            <input type="radio" name="metode_bayar" value="BCA" class="form-check-input mt-0 me-3" style="transform: scale(1.3);" required checked>
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">BCA Virtual Account</h6>
                                <small class="text-muted">Dicek otomatis</small>
                            </div>
                        </label>

                        <label class="d-flex align-items-center border rounded-3 p-3 mb-3 cursor-pointer">
                            <input type="radio" name="metode_bayar" value="Mandiri" class="form-check-input mt-0 me-3" style="transform: scale(1.3);">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">Mandiri Virtual Account</h6>
                                <small class="text-muted">Dicek otomatis</small>
                            </div>
                        </label>

                        <h5 class="fw-bold mb-3 mt-4">E-Wallet / QRIS</h5>
                        <label class="d-flex align-items-center border rounded-3 p-3 cursor-pointer">
                            <input type="radio" name="metode_bayar" value="QRIS" class="form-check-input mt-0 me-3" style="transform: scale(1.3);">
                            <div>
                                <h6 class="fw-bold mb-0 text-dark">QRIS (Gopay, OVO, Dana, LinkAja)</h6>
                                <small class="text-muted">Scan barcode instan</small>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="col-lg-5 mb-4">
                <div class="card border-warning border-2 shadow-sm rounded-4 position-sticky" style="top: 100px;">
                    <div class="card-header bg-warning text-dark pt-3 pb-2 border-0 rounded-top-3">
                        <h5 class="fw-bold mb-0">Ringkasan Belanja</h5>
                    </div>
                    <div class="card-body p-4">
                        <div class="d-flex mb-3">
                            <div class="bg-light rounded-3 d-flex justify-content-center align-items-center me-3" style="width: 60px; height: 60px;">
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1 text-dark">{{ $rental->costume->name }}</h6>
                                <small class="text-muted">Rp {{ number_format($rental->costume->price, 0, ',', '.') }} / hari</small>
                            </div>
                        </div>

                        <hr class="border-secondary-subtle">

                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Durasi Sewa</span>
                            <span class="fw-medium text-dark">{{ $durasi }} Hari</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">Tanggal</span>
                            <span class="fw-medium text-dark text-end">
                                {{ \Carbon\Carbon::parse($rental->borrow_date)->format('d M') }} - {{ \Carbon\Carbon::parse($rental->return_date)->format('d M Y') }}
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-3">
                            <span class="text-muted">Biaya Layanan</span>
                            <span class="fw-medium text-success">Gratis</span>
                        </div>

                        <div class="d-flex justify-content-between align-items-center bg-light p-3 rounded-3 mb-4">
                            <span class="fw-bold text-dark">Total Tagihan</span>
                            <h4 class="fw-bold text-danger mb-0">Rp {{ number_format($rental->total_price, 0, ',', '.') }}</h4>
                        </div>

                        <button type="submit" class="btn btn-dark text-warning w-100 fw-bold py-3 rounded-pill shadow-sm fs-5">
                            Bayar Sekarang
                        </button>
                    </div>
                </div>
            </div>

        </div>
    </form>
</div>
@endsection 