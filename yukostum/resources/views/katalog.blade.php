@extends('layouts.app')

@section('content')
    <div class="mb-4 text-center">
        <h2 class="fw-bold text-primary">Katalog Kostum</h2>
        <p class="text-muted">Pilih kostum impianmu untuk acara spesial. Cepat, sebelum kehabisan!</p>
    </div>

    @if (session('sukses'))
        <div class="row">
            <div class="col-12 mb-3">
                <div class="alert alert-success fw-bold text-center shadow-sm">
                    🎉 {{ session('sukses') }}
                </div>
            </div>
        </div>
    @endif

    <div class="row">
        @forelse($costumes as $kostum)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 h-100 overflow-hidden">

                    @if (!empty($kostum->images) && count($kostum->images) > 0)
                        <img src="{{ asset('images/kostum/' . $kostum->images[0]) }}" class="card-img-top object-fit-cover"
                            style="height: 250px; width: 100%;" alt="{{ $kostum->name }}">
                    @else
                        <div class="card-img-top bg-light d-flex justify-content-center align-items-center"
                            style="height: 250px;">
                            <span class="text-muted">🚫 Belum ada foto</span>
                        </div>
                    @endif

                    <div class="card-header bg-dark text-white">
                        <h5 class="card-title mb-0 fw-bold">{{ $kostum->name }}</h5>
                        <small class="badge bg-secondary mt-1">{{ $kostum->type }}</small>
                        <h4 class="text-primary fw-bold">Rp {{ number_format($kostum->price, 0, ',', '.') }} <small
                                class="text-muted" style="font-size: 12px;">/hari</small></h4>
                    </div>

                    <div class="card-body bg-white">
                        <ul class="list-group list-group-flush mb-3">
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span> Ukuran</span> <strong>{{ $kostum->size }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span> Warna</span> <strong>{{ $kostum->color }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between px-0">
                                <span> Tersisa</span>
                                <span class="badge {{ $kostum->stock > 0 ? 'bg-success' : 'bg-danger' }} rounded-pill fs-6">
                                    {{ $kostum->stock > 0 ? $kostum->stock . ' Pcs' : 'Habis' }}
                                </span>
                            </li>
                        </ul>

                        @if ($kostum->condition == 'diperbaiki')
                            <div class="alert alert-warning py-2 text-center mb-0" style="font-size: 14px;">
                                ⚠️ Sedang dalam perbaikan ringan.
                            </div>
                        @endif
                    </div>

                    <div class="card-footer bg-white border-0 p-3">
                        <a href="/katalog/{{ $kostum->id }}"
                            class="btn btn-outline-primary btn-lg w-100 fw-bold text-center">
                             LIHAT DETAIL
                        </a>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <h4 class="text-muted">Yah, belum ada kostum yang tersedia saat ini </h4>
            </div>
        @endforelse
    </div>
    <div class="d-flex justify-content-center mt-5 mb-4">
        {{ $costumes->links() }}
    </div>
    </div>
@endsection
