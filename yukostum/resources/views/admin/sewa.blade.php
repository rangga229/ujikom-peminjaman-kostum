@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-bold d-flex justify-content-between align-items-center">
    <span>📋 Laporan Pesanan Sewa Masuk</span>
    <div>
        <a href="/admin/laporan" target="_blank" class="btn btn-warning btn-sm fw-bold me-2 text-dark">🖨️ Cetak Laporan</a>
        <a href="/admin/kostum" class="btn btn-light btn-sm fw-bold">← Kembali ke Gudang</a>
    </div>
</div>

                <div class="card-body p-0 table-responsive">
                    @if (session('sukses'))
                        <div class="alert alert-success m-3 fw-bold">🎉 {{ session('sukses') }}</div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger m-3 fw-bold">🚨 {{ session('error') }}</div>
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
                                        <small class="text-success fw-bold">📞 {{ $sewa->user->phone ?? 'Belum ada No. HP' }}</small><br>
                                        <small class="text-muted" style="font-size: 0.75rem;">📍 {{ Str::limit($sewa->user->address ?? 'Alamat tidak diketahui', 30) }}</small>
                                    </td>
                                    
                                    <td class="text-start text-primary fw-bold">{{ $sewa->costume->name ?? 'Baju Dihapus' }}</td>
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
                                        @if ($sewa->status == 'pending')
                                            <form action="/admin/sewa/{{ $sewa->id }}" method="POST" class="d-flex gap-1 justify-content-center">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status" value="disetujui" class="btn btn-primary btn-sm fw-bold">Setujui</button>
                                                <button type="submit" name="status" value="ditolak" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Yakin ingin menolak pesanan ini?')">Tolak</button>
                                            </form>

                                        @elseif($sewa->status == 'disetujui')
                                            <button type="button" class="btn btn-success btn-sm fw-bold" data-bs-toggle="modal" data-bs-target="#modalSelesai{{ $sewa->id }}">
                                                Tandai Selesai
                                            </button>

                                            <div class="modal fade" id="modalSelesai{{ $sewa->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $sewa->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content text-start">
                                                        <div class="modal-header bg-success text-white">
                                                            <h5 class="modal-title fw-bold" id="modalLabel{{ $sewa->id }}">Validasi Pengembalian Baju</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <form action="/admin/sewa/{{ $sewa->id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="dikembalikan">

                                                            <div class="modal-body p-4">
                                                                <p class="mb-4">Kostum: <strong class="text-primary">{{ $sewa->costume->name ?? '-' }}</strong></p>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Kondisi Pengembalian</label>
                                                                    <select name="kondisi_kembali" class="form-select" required>
                                                                        <option value="baik">Aman / Baik (Tanpa Denda)</option>
                                                                        <option value="terlambat">Terlambat</option>
                                                                        <option value="rusak">Rusak</option>
                                                                        <option value="hilang">Hilang</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Nominal Denda (Rp)</label>
                                                                    <input type="number" name="denda" class="form-control" value="0" min="0" required>
                                                                    <small class="text-muted">*Isi 0 jika tidak ada denda.</small>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Upload Foto Bukti</label>
                                                                    <input type="file" name="bukti_kembali" class="form-control" accept="image/*" required>
                                                                    <small class="text-muted">*Wajib melampirkan foto kostum yang dikembalikan.</small>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer bg-light">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-success fw-bold">Simpan & Selesaikan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">Belum ada pesanan yang masuk.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection