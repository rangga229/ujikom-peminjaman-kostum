@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mt-4 mb-5">
        <div class="col-md-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">

                    <div class="col-md-6 bg-light d-flex align-items-center justify-content-center position-relative">
                        @if (!empty($costume->images) && count($costume->images) > 0)
                            <div id="costumeCarousel" class="carousel slide w-100 h-100" data-bs-ride="carousel">
                                <div class="carousel-inner h-100" style="aspect-ratio: 3/4; background-color: #f8f9fa;">

                                    @foreach ($costume->images as $index => $img)
                                        <div class="carousel-item h-100 {{ $index == 0 ? 'active' : '' }}">
                                            <img src="{{ asset('images/kostum/' . $img) }}"
                                                class="d-block w-100 h-100 object-fit-cover"
                                                alt="Foto {{ $costume->name }}">
                                        </div>
                                    @endforeach

                                </div>

                                @if (count($costume->images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#costumeCarousel" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3 shadow" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#costumeCarousel" data-bs-slide="next">
                                        <span class="carousel-control-next-icon bg-dark rounded-circle p-3 shadow" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                @endif
                            </div>
                        @else
                            <div class="h-100 w-100 d-flex flex-column justify-content-center align-items-center bg-light text-muted" style="min-height: 400px;">
                                <div class="display-1 opacity-25 mb-3">📷</div>
                                <span class="fs-5 fw-bold">Belum ada foto</span>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-6 d-flex flex-column bg-white">
                        <div class="card-body p-4 p-lg-5">
                            
                            <span class="badge bg-dark text-warning mb-3 px-3 py-2 rounded-pill shadow-sm fs-6">{{ $costume->type }}</span>
                            <h2 class="card-title fw-bold text-dark mb-4">{{ $costume->name }}</h2>
                            
                            <div class="bg-dark text-white p-4 rounded-4 mb-4 shadow-sm border border-warning">
                                <span class="text-white-50 d-block text-uppercase fw-bold small mb-1">Harga Sewa</span>
                                <h2 class="text-warning fw-bold mb-0">Rp {{ number_format($costume->price, 0, ',', '.') }}
                                    <span class="fs-6 text-white-50 fw-normal">/ hari</span>
                                </h2>
                            </div>

                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-4 h-100 border border-secondary-subtle">
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 11px;"> Ukuran</small>
                                        <span class="fw-bold fs-5 text-dark">{{ $costume->size }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-4 h-100 border border-secondary-subtle">
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 11px;"> Warna</small>
                                        <span class="fw-bold fs-5 text-dark text-truncate d-block" title="{{ $costume->color }}">{{ $costume->color }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-4 h-100 border border-secondary-subtle">
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 11px;"> Bahan</small>
                                        <span class="fw-bold fs-5 text-dark">{{ $costume->material ?: '-' }}</span>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="bg-light p-3 rounded-4 h-100 border border-secondary-subtle">
                                        <small class="text-muted d-block fw-bold text-uppercase" style="font-size: 11px;"> Sisa Stok</small>
                                        @if($costume->stock > 0)
                                            <span class="fw-bold fs-5 text-success">{{ $costume->stock }} Pcs</span>
                                        @else
                                            <span class="fw-bold fs-5 text-danger">Habis</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <hr class="border-secondary-subtle">

                            <div class="mt-auto pt-2">
                                @if (strtolower($costume->condition) == 'rusak' || strtolower($costume->condition) == 'diperbaiki')
                                    <div class="alert alert-warning shadow-sm border-0 mt-3 rounded-4">
                                        <h6 class="fw-bold mb-1 text-dark"> Sedang Dalam Perawatan</h6>
                                        <p class="mb-0 text-dark small">Maaf, kostum ini sedang <strong>{{ $costume->condition }}</strong> dan tidak dapat disewa untuk sementara waktu.
                                        </p>
                                    </div>
                                    <button class="btn btn-outline-secondary w-100 fw-bold mt-2 py-3 rounded-pill" disabled>
                                         Kostum Tidak Tersedia
                                    </button>
                                
                                @elseif($costume->stock < 1)
                                    <div class="alert alert-danger shadow-sm border-0 mt-3 rounded-4">
                                        <h6 class="fw-bold mb-1"> Stok Kosong</h6>
                                        <p class="mb-0 text-dark small">Maaf, kostum ini sedang habis dipinjam oleh pelanggan lain.</p>
                                    </div>
                                    <button class="btn btn-outline-danger w-100 fw-bold mt-2 py-3 rounded-pill" disabled>
                                        Habis Dipinjam
                                    </button>

                                @else
                                    <a href="/sewa/{{ $costume->id }}" class="btn btn-dark text-warning w-100 fw-bold mt-3 py-3 rounded-pill shadow-sm fs-5">
                                         Pilih Tanggal Sewa
                                    </a>
                                @endif
                                
                                <a href="/katalog" class="btn btn-light w-100 mt-3 text-muted fw-bold rounded-pill py-2">
                                    ← Kembali ke Katalog
                                </a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
@endsection