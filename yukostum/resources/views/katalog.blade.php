@extends('layouts.app')

@section('content')
    <style>
        .kostum-card {
            transition: all 0.3s ease;
        }
        .kostum-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 25px rgba(0,0,0,0.1) !important;
        }
        .kostum-img-wrapper {
            overflow: hidden;
        }
        .kostum-img-wrapper img {
            transition: transform 0.5s ease;
        }
        .kostum-card:hover .kostum-img-wrapper img {
            transform: scale(1.05);
        }
        /* Style khusus untuk search bar agar border-nya hilang saat diklik */
        .search-bar-custom input:focus, .search-bar-custom select:focus {
            box-shadow: none;
            outline: none;
        }
    </style>

    <div class="mb-4 text-center mt-4">
        <h2 class="fw-bold text-dark text-uppercase">Katalog Kostum</h2>
        <p class="text-muted mb-2">Pilih kostum impianmu untuk acara spesial. Cepat, sebelum kehabisan!</p>
        <hr class="mx-auto border-warning opacity-100" style="width: 60px; border-width: 3px; border-radius: 5px;">
    </div>

    <div class="row justify-content-center mb-5 px-3">
        <div class="col-lg-8 col-md-10">
            <form action="/katalog" method="GET" class="search-bar-custom d-flex flex-column flex-md-row gap-2 bg-white shadow-sm border rounded-pill p-2">
                
                <input type="text" name="cari" class="form-control border-0 bg-transparent px-3 py-2 fw-medium" placeholder="🔍 Cari nama kostum..." value="{{ request('cari') }}">
                
                <div class="vr d-none d-md-block mx-1 text-muted"></div>
                
                <select name="tipe" class="form-select border-0 bg-transparent px-3 py-2 fw-medium text-muted" style="min-width: 180px;">
                    <option value="">Semua Tipe</option>
                    <option value="Cosplay" {{ request('tipe') == 'Cosplay' ? 'selected' : '' }}>Cosplay</option>
                    <option value="Acara Sekolah" {{ request('tipe') == 'Acara Sekolah' ? 'selected' : '' }}>Acara Sekolah</option>
                    <option value="Pentas Tari" {{ request('tipe') == 'Pentas Tari' ? 'selected' : '' }}>Pentas Tari</option>
                    <option value="Pernikahan" {{ request('tipe') == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                    <option value="Pesta Umum" {{ request('tipe') == 'Pesta Umum' ? 'selected' : '' }}>Pesta Umum</option>
                </select>

                <button type="submit" class="btn btn-dark text-warning fw-bold rounded-pill px-4 py-2 shadow-sm">
                    Cari Kostum
                </button>
            </form>
        </div>
    </div>
    @if (session('sukses'))
        <div class="row justify-content-center">
            <div class="col-md-8 mb-4">
                <div class="alert alert-success fw-bold text-center shadow-sm border-0 rounded-pill">
                     {{ session('sukses') }}
                </div>
            </div>
        </div>
    @endif

    @if(request('cari') || request('tipe'))
        <div class="mb-4 text-center">
            <p class="text-muted">Menampilkan hasil pencarian untuk: 
                <strong class="text-dark">{{ request('cari') ?: 'Semua Kostum' }}</strong> 
                @if(request('tipe')) (Tipe: <strong class="text-dark">{{ request('tipe') }}</strong>) @endif
            </p>
        </div>
    @endif

    <div class="row px-md-3">
        @forelse($costumes as $kostum)
            <div class="col-md-4 col-lg-3 mb-4 d-flex align-items-stretch">
                <div class="card kostum-card shadow-sm border-0 rounded-4 w-100 bg-white">

                    <div class="kostum-img-wrapper position-relative rounded-top-4" style="height: 260px;">
                        @if (!empty($kostum->images) && count($kostum->images) > 0)
                            <img src="{{ asset('images/kostum/' . $kostum->images[0]) }}" class="w-100 h-100 object-fit-cover" alt="{{ $kostum->name }}">
                        @else
                            <div class="w-100 h-100 bg-light d-flex justify-content-center align-items-center">
                                <span class="text-muted"><i class="fs-1 opacity-50">📷</i><br>Belum ada foto</span>
                            </div>
                        @endif
                        
                        <span class="badge bg-dark text-warning position-absolute top-0 end-0 m-3 px-3 py-2 rounded-pill shadow-sm">
                            {{ $kostum->type }}
                        </span>
                    </div>

                    <div class="card-body p-4 d-flex flex-column">
                        <h5 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $kostum->name }}">{{ $kostum->name }}</h5>
                        <h4 class="fw-bold text-warning mb-3">Rp {{ number_format($kostum->price, 0, ',', '.') }}<span class="text-muted fw-normal" style="font-size: 13px;">/hari</span></h4>

                        <div class="row bg-light rounded-3 py-2 mb-3 mx-0 text-center">
                            <div class="col-4 border-end border-secondary-subtle px-1">
                                <small class="text-muted d-block" style="font-size: 11px;">Ukuran</small>
                                <strong class="text-dark" style="font-size: 13px;">{{ $kostum->size }}</strong>
                            </div>
                            <div class="col-4 border-end border-secondary-subtle px-1">
                                <small class="text-muted d-block" style="font-size: 11px;">Warna</small>
                                <strong class="text-dark text-truncate d-block" style="font-size: 13px;" title="{{ $kostum->color }}">{{ $kostum->color }}</strong>
                            </div>
                            <div class="col-4 px-1">
                                <small class="text-muted d-block" style="font-size: 11px;">Stok</small>
                                @if($kostum->stock > 0)
                                    <strong class="text-success" style="font-size: 13px;">{{ $kostum->stock }} Pcs</strong>
                                @else
                                    <strong class="text-danger" style="font-size: 13px;">Habis</strong>
                                @endif
                            </div>
                        </div>

                        @if ($kostum->condition == 'diperbaiki')
                            <div class="alert alert-warning py-1 px-2 text-center mb-3 border-0" style="font-size: 12px;">
                                 Sedang diperbaiki
                            </div>
                        @endif

                        <div class="mt-auto pt-2">
                            <a href="/katalog/{{ $kostum->id }}" class="btn btn-dark text-warning fw-bold w-100 rounded-pill py-2 shadow-sm">
                                Lihat Detail
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <div class="display-1 text-muted opacity-25 mb-3">🔍</div>
                <h4 class="text-muted fw-bold">Yah, kostum yang kamu cari tidak ditemukan.</h4>
                <p class="text-muted">Coba gunakan kata kunci atau tipe yang berbeda.</p>
                <a href="/katalog" class="btn btn-outline-dark fw-bold mt-2 rounded-pill px-4">Tampilkan Semua Kostum</a>
            </div>
        @endforelse
    </div>

    <div class="d-flex justify-content-center mt-5 mb-4">
        {{ $costumes->withQueryString()->links() }}
    </div>
@endsection