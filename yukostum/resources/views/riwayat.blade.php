@extends('layouts.app')

@section('content')
    <div class="row justify-content-center mb-3">
        <div class="col-md-10">
            <h3 class="fw-bold text-dark text-uppercase">Riwayat Sewa Saya</h3>
            <p class="text-muted">Pantau status pesanan dan riwayat penyewaan kostum Anda di Yukostum.</p>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-warning fw-bold py-3 px-4 fs-5 rounded-top-4 border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                         Daftar Transaksi
                    </div>
                    <a href="/katalog" class="btn btn-warning text-dark btn-sm fw-bold rounded-pill px-4 shadow-sm">
                         Sewa Baju Lain
                    </a>
                </div>

                <div class="card-body p-0 table-responsive rounded-bottom-4">
                    <table class="table table-hover mb-0 align-middle text-center border-light">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="py-3 ps-4 text-start">No. Order</th>
                                <th class="py-3 text-start">Kostum Disewa</th>
                                <th class="py-3">Tanggal Pinjam</th>
                                <th class="py-3">Tanggal Kembali</th>
                                <th class="py-3 pe-4">Status Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $sewa)
                                <tr>
                                    <td class="fw-bold text-muted ps-4 text-start border-bottom-0">#ORD-00{{ $sewa->id }}</td>
                                    
                                    <td class="text-start border-bottom-0">
                                        <span class="fw-bold text-dark fs-6">{{ $sewa->costume->name ?? 'Baju Dihapus' }}</span>
                                    </td>
                                    
                                    <td class="border-bottom-0 text-muted small">
                                        {{ \Carbon\Carbon::parse($sewa->borrow_date)->format('d M Y') }}
                                    </td>
                                    
                                    <td class="border-bottom-0 text-muted small">
                                        {{ \Carbon\Carbon::parse($sewa->return_date)->format('d M Y') }}
                                    </td>
                                    
                                    <td class="pe-4 border-bottom-0">
                                        @if ($sewa->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning fw-bold px-3 py-2 rounded-pill">Menunggu Persetujuan</span>
                                        @elseif($sewa->status == 'disetujui')
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-bold px-3 py-2 rounded-pill">Disetujui</span>
                                        @elseif($sewa->status == 'dikembalikan' || $sewa->status == 'selesai')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-2 rounded-pill">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-bold px-3 py-2 rounded-pill">Pesanan Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr><td colspan="5" class="p-0 border-bottom border-light"></td></tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5 bg-light">
                                        <div class="fs-1 mb-3 opacity-25"></div>
                                        <h5 class="fw-bold text-dark">Belum ada riwayat sewa.</h5>
                                        <p class="small mb-0">Yuk, lihat-lihat katalog kostum kami!</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection