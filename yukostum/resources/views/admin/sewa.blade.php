@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark text-uppercase">Pesanan Masuk</h3>
            <p class="text-muted">Pantau, setujui, dan validasi pengembalian kostum dari pelanggan.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header bg-dark text-warning fw-bold py-3 px-4 fs-5 rounded-top-4 border-0 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div class="d-flex align-items-center gap-2">
                         Daftar Pesanan Sewa
                    </div>
                    <div>
                        <a href="/admin/laporan" target="_blank" class="btn btn-warning text-dark btn-sm fw-bold me-2 rounded-pill px-3 shadow-sm">
                             Cetak Laporan
                        </a>
                        <a href="/admin/kostum" class="btn btn-outline-warning btn-sm fw-bold rounded-pill px-3">
                            ← Kembali ke Gudang
                        </a>
                    </div>
                </div>

                <div class="card-body p-0 table-responsive rounded-bottom-4">
                    @if (session('sukses'))
                        <div class="alert alert-success m-3 fw-bold border-0 shadow-sm rounded-3">
                            ✓ {{ session('sukses') }}
                        </div>
                    @endif
                    
                    @if (session('error'))
                        <div class="alert alert-danger m-3 fw-bold border-0 shadow-sm rounded-3">
                            🚨 {{ session('error') }}
                        </div>
                    @endif

                    <table class="table table-hover mb-0 align-middle text-center border-light">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="py-3 ps-3">No. Order</th>
                                <th class="py-3 text-start">Peminjam</th>
                                <th class="py-3 text-start">Kostum Disewa</th>
                                <th class="py-3">Tanggal Pinjam</th>
                                <th class="py-3">Tanggal Kembali</th>
                                <th class="py-3">Status</th>
                                <th class="py-3 pe-3">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rentals as $sewa)
                                <tr>
                                    <td class="fw-bold text-dark ps-3 border-bottom-0">#ORD-00{{ $sewa->id }}</td>
                                    
                                    <td class="text-start border-bottom-0">
                                        <strong class="text-dark d-block mb-1">{{ $sewa->user->name ?? 'User Dihapus' }}</strong>
                                        <div class="text-muted small lh-sm">
                                            <span>{{ $sewa->user->email ?? '-' }}</span><br>
                                            <span class="text-success fw-bold">{{ $sewa->user->phone ?? 'Belum ada No. HP' }}</span><br>
                                            <span style="font-size: 0.70rem;" class="opacity-75">{{ Str::limit($sewa->user->address ?? 'Alamat tidak diketahui', 30) }}</span>
                                        </div>
                                    </td>
                                    
                                    <td class="text-start border-bottom-0">
                                        <span class="fw-bold text-dark">{{ $sewa->costume->name ?? 'Baju Dihapus' }}</span>
                                    </td>
                                    <td class="border-bottom-0 text-muted small">{{ \Carbon\Carbon::parse($sewa->borrow_date)->format('d M Y') }}</td>
                                    <td class="border-bottom-0 text-muted small">{{ \Carbon\Carbon::parse($sewa->return_date)->format('d M Y') }}</td>
                                    
                                    <td class="border-bottom-0">
                                        @if ($sewa->status == 'pending')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning fw-bold px-2 py-1">Menunggu</span>
                                        @elseif($sewa->status == 'disetujui')
                                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary fw-bold px-2 py-1">Disetujui</span>
                                        @elseif($sewa->status == 'dikembalikan')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-2 py-1">Dikembalikan</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-bold px-2 py-1">Ditolak</span>
                                        @endif
                                    </td>
                                    
                                    <td class="pe-3 border-bottom-0">
                                        @if ($sewa->status == 'pending')
                                            <form action="/admin/sewa/{{ $sewa->id }}" method="POST" class="d-flex gap-2 justify-content-center">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" name="status" value="disetujui" class="btn btn-dark text-warning btn-sm fw-bold rounded-pill px-3 shadow-sm">Setujui</button>
                                                <button type="submit" name="status" value="ditolak" class="btn btn-outline-danger btn-sm fw-bold rounded-pill px-3" onclick="return confirm('Yakin ingin menolak pesanan ini?')">Tolak</button>
                                            </form>

                                        @elseif($sewa->status == 'disetujui')
                                            <button type="button" class="btn btn-warning text-dark btn-sm fw-bold rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalSelesai{{ $sewa->id }}">
                                                ✓ Tandai Selesai
                                            </button>

                                            <div class="modal fade" id="modalSelesai{{ $sewa->id }}" tabindex="-1" aria-labelledby="modalLabel{{ $sewa->id }}" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content text-start border-0 rounded-4 shadow-lg">
                                                        <div class="modal-header bg-dark text-warning border-0 rounded-top-4 py-3">
                                                            <h5 class="modal-title fw-bold" id="modalLabel{{ $sewa->id }}">Validasi Pengembalian</h5>
                                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        
                                                        <form action="/admin/sewa/{{ $sewa->id }}" method="POST" enctype="multipart/form-data">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="status" value="dikembalikan">

                                                            <div class="modal-body p-4">
                                                                <div class="bg-light p-3 rounded-3 mb-4 border border-secondary-subtle">
                                                                    <small class="text-muted d-block text-uppercase fw-bold mb-1">Kostum Disewa</small>
                                                                    <strong class="text-dark fs-5">{{ $sewa->costume->name ?? '-' }}</strong>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold text-muted small text-uppercase">Kondisi Pengembalian</label>
                                                                    <select name="kondisi_kembali" class="form-select bg-light" required>
                                                                        <option value="baik">Aman / Baik (Tanpa Denda)</option>
                                                                        <option value="terlambat">Terlambat</option>
                                                                        <option value="rusak">Rusak</option>
                                                                        <option value="hilang">Hilang</option>
                                                                    </select>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold text-muted small text-uppercase">Nominal Denda (Rp)</label>
                                                                    <input type="number" name="denda" class="form-control bg-light" value="0" min="0" required>
                                                                    <small class="text-muted" style="font-size: 11px;">*Isi 0 jika tidak ada denda.</small>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold text-muted small text-uppercase">Upload Foto Bukti</label>
                                                                    <input type="file" name="bukti_kembali" class="form-control bg-light" accept="image/*" required>
                                                                    <small class="text-muted" style="font-size: 11px;">*Wajib melampirkan foto kostum saat dikembalikan.</small>
                                                                </div>
                                                            </div>

                                                            <div class="modal-footer bg-light border-0 rounded-bottom-4 py-3">
                                                                <button type="button" class="btn btn-outline-secondary fw-bold rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                                                                <button type="submit" class="btn btn-warning text-dark fw-bold rounded-pill px-4 shadow-sm">Simpan & Selesaikan</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                                <tr><td colspan="7" class="p-0 border-bottom border-light"></td></tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-5 bg-light">
                                        <div class="fs-1 mb-3 opacity-25"></div>
                                        <h6 class="fw-bold">Belum ada pesanan yang masuk.</h6>
                                        <p class="small mb-0">Pesanan pelanggan akan muncul di sini.</p>
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