@extends('layouts.app')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-dark text-white fw-bold d-flex justify-content-between align-items-center py-3">
                    <span class="fs-5">🛍️ Riwayat Sewa Saya</span>
                    <a href="/katalog" class="btn btn-primary btn-sm fw-bold">Sewa Baju Lain</a>
                </div>

                <div class="card-body p-0 table-responsive">
                    <table class="table table-hover mb-0 align-middle text-center">
                        <thead class="table-light">
                            <tr>
                                <th>No. Order</th>
                                <th>Kostum Disewa</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status Pesanan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $sewa)
                                <tr>
                                    <td class="fw-bold text-muted">#ORD-00{{ $sewa->id }}</td>
                                    <td class="text-start">
                                        <span
                                            class="fw-bold text-primary">{{ $sewa->costume->name ?? 'Baju Dihapus' }}</span>
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($sewa->borrow_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sewa->return_date)->format('d M Y') }}</td>
                                    <td>
                                        @if ($sewa->status == 'pending')
                                            <span class="badge bg-warning text-dark px-3 py-2">Menunggu Persetujuan</span>
                                        @elseif($sewa->status == 'disetujui')
                                            <span class="badge bg-primary px-3 py-2">Disetujui</span>
                                        @elseif($sewa->status == 'dikembalikan' || $sewa->status == 'selesai')
                                            <span class="badge bg-success px-3 py-2">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger px-3 py-2">Pesanan Ditolak</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-5">
                                        <h5>Belum ada riwayat sewa.</h5>
                                        <p>Yuk, lihat-lihat katalog kostum kami!</p>
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
