@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center py-3">
                <h4 class="mb-0 fw-bold">📅 Tentukan Tanggal Sewa</h4>
            </div>
            <div class="card-body p-4">
                
                <div class="alert alert-info border-0 shadow-sm mb-4">
                    Anda akan menyewa: <br>
                    <strong class="fs-5">{{ $costume->name }}</strong><br>
                    <small>Ukuran: <strong>{{ $costume->size }}</strong> | Warna: <strong>{{ $costume->color }}</strong></small>
                </div>

                <form action="/sewa/{{ $costume->id }}" method="POST">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Mulai Pinjam (Tanggal Ambil)</label>
                        <input type="date" name="borrow_date" class="form-control form-control-lg bg-light" required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Selesai Pinjam (Tanggal Kembali)</label>
                        <input type="date" name="return_date" class="form-control form-control-lg bg-light" required>
                    </div>

                    <div class="d-flex gap-2 mt-4">
                        <a href="/katalog" class="btn btn-secondary btn-lg w-50 fw-bold rounded-pill">BATAL</a>
                        <button type="submit" class="btn btn-success btn-lg w-50 fw-bold rounded-pill">KONFIRMASI</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection