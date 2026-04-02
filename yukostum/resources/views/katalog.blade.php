@extends('layouts.app')

@section('content')
<div class="mb-4 text-center">
    <h2 class="fw-bold text-primary">Katalog Kostum</h2>
    <p class="text-muted">Pilih kostum impianmu untuk acara spesial. Cepat, sebelum kehabisan!</p>
</div>

<div class="row">
    @forelse($costumes as $kostum)
    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 h-100">
            <div class="card-header bg-dark text-white">
                <h5 class="card-title mb-0 fw-bold">{{ $kostum->name }}</h5>
                <small class="badge bg-secondary mt-1">{{ $kostum->type }}</small>
            </div>
            
            <div class="card-body bg-white">
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>📏 Ukuran</span> <strong>{{ $kostum->size }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>🎨 Warna</span> <strong>{{ $kostum->color }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>🧵 Bahan</span> <strong>{{ $kostum->material ?: '-' }}</strong>
                    </li>
                    <li class="list-group-item d-flex justify-content-between px-0">
                        <span>📦 Tersisa</span> 
                        <span class="badge bg-success rounded-pill fs-6">{{ $kostum->stock }} Pcs</span>
                    </li>
                </ul>
                
                @if($kostum->condition == 'diperbaiki')
                    <div class="alert alert-warning py-2 text-center mb-0" style="font-size: 14px;">
                        ⚠️ Sedang dalam perbaikan ringan, tapi tetap bisa dipesan.
                    </div>
                @endif
            </div>

            <div class="card-footer bg-white border-0 p-3">
                <form action="#" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold">
                        SEWA SEKARANG
                    </button>
                </form>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12 text-center py-5">
        <h4 class="text-muted">Yah, belum ada kostum yang tersedia saat ini 😢</h4>
    </div>
    @endforelse
</div>
@endsection