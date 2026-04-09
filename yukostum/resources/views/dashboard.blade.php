@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 border-bottom pb-3">
        <div class="mb-3 mb-md-0">
            <h3 class="fw-bold text-dark mb-0">Halo, {{ Auth::user()->name }}!</h3>
            <p class="text-muted mb-0 small">Selamat datang kembali di Yukostum.</p>
        </div>
        <div>
            <a href="/katalog" class="btn btn-warning text-dark fw-bold px-4 shadow-sm">Sewa Kostum Baru</a>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-warning shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold text-dark mb-0">{{ $menunggu }}</h2>
                    <span class="text-muted small text-uppercase fw-bold">Menunggu Persetujuan</span>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-dark shadow-sm h-100 bg-dark text-white">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold text-warning mb-0">{{ $sedangDisewa }}</h2>
                    <span class="text-light small text-uppercase fw-bold">Sedang Disewa</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-success shadow-sm h-100">
                <div class="card-body text-center py-4">
                    <h2 class="fw-bold text-success mb-0">{{ $selesai }}</h2>
                    <span class="text-muted small text-uppercase fw-bold">Selesai Dikembalikan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-7 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom pt-4 pb-2">
                    <h6 class="fw-bold text-dark text-uppercase mb-0">Pesanan Aktif Saat Ini</h6>
                </div>
                <div class="card-body">
                    @if($pesananAktif)
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <h5 class="fw-bold text-dark mb-1">{{ $pesananAktif->costume->name ?? 'Kostum Dihapus' }}</h5>
                                <small class="text-muted">No. Order: #ORD-00{{ $pesananAktif->id }}</small>
                            </div>
                            <div>
                                @if($pesananAktif->status == 'pending')
                                    <span class="badge bg-warning text-dark border border-warning">Menunggu Admin</span>
                                @else
                                    <span class="badge bg-dark text-warning border border-dark">Sedang Disewa</span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="row bg-light rounded p-3 mb-0">
                            <div class="col-6">
                                <small class="text-muted d-block mb-1">Tanggal Pinjam</small>
                                <strong class="text-dark">{{ \Carbon\Carbon::parse($pesananAktif->borrow_date)->format('d M Y') }}</strong>
                            </div>
                            <div class="col-6 text-end">
                                <small class="text-muted d-block mb-1">Tenggat Kembali</small>
                                <strong class="text-danger">{{ \Carbon\Carbon::parse($pesananAktif->return_date)->format('d M Y') }}</strong>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <p class="mb-3">Tidak ada pesanan yang sedang berjalan.</p>
                            <a href="/katalog" class="btn btn-sm btn-outline-dark fw-bold px-4">Mulai Menyewa</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-5 mb-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white border-bottom pt-4 pb-2 d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold text-dark text-uppercase mb-0">Info Pengiriman</h6>
                    <a href="/profil" class="text-primary text-decoration-none small fw-bold">Edit Profil</a>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong class="d-block text-dark fs-5">{{ Auth::user()->name }}</strong>
                        <span class="text-muted small">{{ Auth::user()->email }}</span>
                    </div>
                    
                    <div class="mb-3 border-top pt-3">
                        <small class="text-muted d-block mb-1">No. HP / WhatsApp</small>
                        <span class="text-dark fw-medium">{{ Auth::user()->phone ?? 'Belum diatur' }}</span>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted d-block mb-1">Alamat Lengkap</small>
                        <span class="text-dark fw-medium">{{ Auth::user()->address ?? 'Belum diatur' }}</span>
                    </div>

                    <div class="d-grid mt-auto">
                        <a href="/riwayat" class="btn btn-dark text-warning fw-bold">Lihat Seluruh Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection