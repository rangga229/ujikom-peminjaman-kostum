@extends('layouts.app')

@section('content')
<div class="container py-4">
    
    <div class="row mb-4">
        <div class="col-12">
            <div class="p-4 bg-primary text-white rounded-4 shadow-sm d-flex justify-content-between align-items-center">
                <div>
                    <h2 class="fw-bold mb-1">Halo, {{ Auth::user()->name }}! 👋</h2>
                    <p class="mb-0 opacity-75">Selamat datang di ruang ganti pribadimu. Yuk cek status sewaanmu hari ini.</p>
                </div>
                <div class="d-none d-md-block">
                    <a href="/katalog" class="btn btn-light text-primary fw-bold btn-lg shadow-sm">🛍️ Sewa Baju Baru</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4 text-center">
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 bg-white py-3">
                <h1 class="display-5 fw-bold text-warning mb-0">{{ $menunggu }}</h1>
                <p class="text-muted fw-bold mb-0">⏳ Menunggu Persetujuan</p>
            </div>
        </div>
        <div class="col-md-4 mb-3 mb-md-0">
            <div class="card border-0 shadow-sm rounded-4 bg-white py-3">
                <h1 class="display-5 fw-bold text-primary mb-0">{{ $sedangDisewa }}</h1>
                <p class="text-muted fw-bold mb-0">🏃 Sedang Disewa</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white py-3">
                <h1 class="display-5 fw-bold text-success mb-0">{{ $selesai }}</h1>
                <p class="text-muted fw-bold mb-0">✅ Selesai / Dikembalikan</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0">🚨 Pesanan Aktif Anda</h5>
                </div>
                <div class="card-body p-4">
                    @if($pesananAktif)
                        <div class="border rounded-4 p-4 bg-light">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <h5 class="fw-bold text-primary">{{ $pesananAktif->costume->name ?? 'Kostum Dihapus' }}</h5>
                                    <p class="text-muted mb-2">No. Order: <strong>#ORD-00{{ $pesananAktif->id }}</strong></p>
                                    
                                    <ul class="list-unstyled mb-0">
                                        <li class="mb-1">📅 <strong>Tgl Pinjam:</strong> {{ \Carbon\Carbon::parse($pesananAktif->borrow_date)->format('d M Y') }}</li>
                                        <li class="mb-1 text-danger">⚠️ <strong>Tenggat Kembali:</strong> {{ \Carbon\Carbon::parse($pesananAktif->return_date)->format('d M Y') }}</li>
                                        <li class="mt-2">
                                            Status: 
                                            @if($pesananAktif->status == 'pending')
                                                <span class="badge bg-warning text-dark px-3 py-2">Menunggu Persetujuan Admin</span>
                                            @else
                                                <span class="badge bg-primary px-3 py-2">Sedang Disewa - Jangan Sampai Telat!</span>
                                            @endif
                                        </li>
                                    </ul>
                                </div>
                                <div class="col-md-4 text-center mt-3 mt-md-0">
                                    <div class="display-1">🎭</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <h1 class="display-4 mb-3">📭</h1>
                            <h5>Belum ada pesanan aktif saat ini.</h5>
                            <p>Kostum impianmu sedang menunggu di lemari!</p>
                            <a href="/katalog" class="btn btn-primary fw-bold mt-2">Mulai Menyewa</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white border-0 pt-4 pb-0 px-4">
                    <h5 class="fw-bold text-dark mb-0">📍 Data Pengiriman Saya</h5>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-primary text-white rounded-circle d-flex justify-content-center align-items-center me-3" style="width: 50px; height: 50px; font-size: 1.5rem; font-weight: bold;">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <h6 class="fw-bold mb-0">{{ Auth::user()->name }}</h6>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                    
                    <hr>

                    <div class="mb-3">
                        <small class="text-muted fw-bold d-block">📞 Nomor HP / WhatsApp</small>
                        <span class="fs-6">{{ Auth::user()->phone ?? 'Belum diatur' }}</span>
                    </div>

                    <div class="mb-4">
                        <small class="text-muted fw-bold d-block">🏠 Alamat Lengkap</small>
                        <span class="fs-6">{{ Auth::user()->address ?? 'Belum diatur' }}</span>
                    </div>

                    <div class="d-grid gap-2">
                        <button class="btn btn-outline-secondary fw-bold" disabled>⚙️ Edit Profil (Segera Hadir)</button>
                        <a href="/riwayat" class="btn btn-outline-primary fw-bold">📜 Lihat Semua Riwayat</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection