@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
                    <span>📋 Laporan Pesanan Sewa Masuk</span>
                    <a href="/admin/kostum" class="btn btn-light btn-sm fw-bold">← Kembali ke Gudang</a>
                </div>

                <div class="card-body p-0 table-responsive">
                    @if (session('sukses'))
                        <div class="alert alert-success m-3 fw-bold">🎉 {{ session('sukses') }}</div>
                    @endif

                    <table class="table table-striped table-hover mb-0 align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>No. Order</th>
                                <th>Peminjam</th>
                                <th>Kostum Disewa</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $sewa)
                                <tr>
                                    <td class="fw-bold">#ORD-00{{ $sewa->id }}</td>
                                    <td class="text-start">
                                        <strong>{{ $sewa->user->name ?? 'User Dihapus' }}</strong><br>
                                        <small class="text-muted">✉️ {{ $sewa->user->email ?? '-' }}</small><br>
                                        <small class="text-success fw-bold">📞
                                            {{ $sewa->user->phone ?? 'Belum ada No. HP' }}</small><br>
                                        <small class="text-muted" style="font-size: 0.75rem;">📍
                                            {{ Str::limit($sewa->user->address, 30) ?? 'Alamat tidak diketahui' }}</small>
                                    </td>
                                    <td class="text-start text-primary fw-bold">{{ $sewa->costume->name ?? 'Baju Dihapus' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($sewa->borrow_date)->format('d M Y') }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sewa->return_date)->format('d M Y') }}</td>
                                    <td>
                                        @if ($sewa->status == 'pending')
                                            <span class="badge bg-warning text-dark fs-6">Menunggu</span>
                                        @elseif($sewa->status == 'disetujui')
                                            <span class="badge bg-primary fs-6">Disetujui</span>
                                        @elseif($sewa->status == 'dikembalikan')
                                            <span class="badge bg-success fs-6">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger fs-6">Ditolak</span>
                                        @endif
                                    </td>
                                    <td>
                                        <form action="/admin/sewa/{{ $sewa->id }}" method="POST"
                                            class="d-flex gap-1 justify-content-center">
                                            @csrf
                                            @method('PUT')

                                            @if ($sewa->status == 'pending')
                                                <button type="submit" name="status" value="disetujui"
                                                    class="btn btn-primary btn-sm fw-bold">Setujui</button>
                                                <button type="submit" name="status" value="ditolak"
                                                    class="btn btn-danger btn-sm fw-bold"
                                                    onclick="return confirm('Yakin ingin menolak pesanan ini?')">Tolak</button>
                                            @elseif($sewa->status == 'disetujui')
                                                <button type="submit" name="status" value="dikembalikan"
                                                    class="btn btn-success btn-sm fw-bold">Tandai Selesai</button>
                                            @endif
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan yang masuk.
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