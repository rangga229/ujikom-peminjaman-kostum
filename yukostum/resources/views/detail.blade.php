@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-4">
        <div class="col-md-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">

                    <div class="col-md-6 bg-dark">
                        @if (!empty($costume->images) && count($costume->images) > 0)
                            <div id="costumeCarousel" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner" style="aspect-ratio: 3/4; background-color: #f8f9fa;">

                                    @foreach ($costume->images as $index => $img)
                                        <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('images/kostum/' . $img) }}"
                                                class="d-block w-100 h-100 object-fit-cover"
                                                alt="Foto {{ $costume->name }}">
                                        </div>
                                    @endforeach

                                </div>

                                @if (count($costume->images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#costumeCarousel"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#costumeCarousel"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="h-100 d-flex justify-content-center align-items-center bg-light text-muted"
                                style="min-height: 400px;">
                                <span class="fs-5">🚫 Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 d-flex flex-column">
                        <div class="card-body p-5">
                            <span class="badge bg-secondary mb-2">{{ $costume->type }}</span>
                            <h2 class="card-title fw-bold text-primary mb-4">{{ $costume->name }}</h2>
                            <div class="bg-light p-3 rounded-3 mb-4">
                                <span class="text-muted d-block">Harga Sewa</span>
                                <h2 class="text-primary fw-bold mb-0">Rp {{ number_format($costume->price, 0, ',', '.') }}
                                    <span class="fs-6 text-muted">/ hari</span>
                                </h2>
                            </div>
                            <div class="row mb-4">
                                <div class="col-6 mb-3">
                                    <span class="text-muted d-block">Ukuran</span>
                                    <span class="fw-bold fs-5">{{ $costume->size }}</span>
                                </div>
                                <div class="col-6 mb-3">
                                    <span class="text-muted d-block">Warna</span>
                                    <span class="fw-bold fs-5">{{ $costume->color }}</span>
                                </div>
                                <div class="col-6 mb-3">
                                    <span class="text-muted d-block">Bahan</span>
                                    <span class="fw-bold fs-5">{{ $costume->material ?: '-' }}</span>
                                </div>
                                <div class="col-6 mb-3">
                                    <span class="text-muted d-block">Sisa Stok</span>
                                    <span class="badge bg-success fs-5">{{ $costume->stock }} Pcs</span>
                                </div>
                            </div>

                            <hr>

                            <div class="mt-auto pt-3">
                                @if (strtolower($costume->condition) == 'rusak' || strtolower($costume->condition) == 'diperbaiki')
                                    <div class="alert alert-danger shadow-sm border-0 mt-4">
                                        <h6 class="fw-bold mb-1">⚠️ Tidak Dapat Disewa</h6>
                                        <p class="mb-0 text-dark small">Maaf, kostum ini sedang dalam kondisi
                                            <strong>{{ $costume->condition }}</strong> dan tidak dapat disewa untuk
                                            sementara waktu.
                                        </p>
                                    </div>
                                    <button class="btn btn-secondary w-100 fw-bold mt-2 py-2" disabled>
                                        🚫 Kostum Tidak Tersedia
                                    </button>
                                @else
                                    <a href="/sewa/{{ $costume->id }}" class="btn btn-primary w-100 fw-bold mt-3 py-2">
                                        📅 Pilih Tanggal Sewa
                                    </a>
                                @endif
                                <a href="/katalog" class="btn btn-light w-100 mt-2 text-muted fw-bold">Kembali ke
                                    Katalog</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection
