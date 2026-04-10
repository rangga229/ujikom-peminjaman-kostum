@extends('layouts.app')

@section('content')
<div class="container py-5 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <div class="card-body p-5">
                    
                    <div class="bg-success text-white rounded-circle d-inline-flex justify-content-center align-items-center mb-4 shadow" style="width: 90px; height: 90px; font-size: 3rem;">
                        ✓
                    </div>

                    <h2 class="fw-bold text-dark mb-2">Pembayaran Berhasil!</h2>
                    <p class="text-muted mb-4">Terima kasih, dana Anda telah kami terima dengan aman.</p>

                    <div class="bg-light p-4 rounded-4 mb-4 border border-secondary-subtle border-dashed">
                        <span class="text-muted d-block text-uppercase fw-bold small mb-1">Nomor Pesanan Anda</span>
                        <h2 class="fw-bold text-primary mb-0" style="letter-spacing: 2px;">#ORD-00{{ $rental->id }}</h2>
                    </div>

                    <div class="alert alert-warning border-0 rounded-3 text-start small mb-4">
                        <strong class="text-dark d-block mb-1"> Langkah Terakhir!</strong>
                        Tekan tombol <strong>"Ajukan Pesanan"</strong> di bawah ini untuk mengirimkan pesanan Anda ke Admin. Kostum Anda akan segera disiapkan!
                    </div>

                    <form action="/sewa/ajukan/{{ $rental->id }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning text-dark w-100 fw-bold py-3 rounded-pill shadow-sm fs-5">
                            Ajukan Pesanan Sekarang
                        </button>
                    </form>

                </div>
            </div>

        </div>
    </div>
</div>
@endsection