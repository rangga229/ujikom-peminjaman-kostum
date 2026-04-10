@extends('layouts.app')

@section('content')
    <div class="row mb-4">
        <div class="col-12">
            <h3 class="fw-bold text-dark text-uppercase">Kelola Kostum</h3>
            <p class="text-muted">Tambahkan koleksi terbaru atau perbarui data kostum yang sudah ada di etalase Yukostum.</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-dark text-warning fw-bold py-3 fs-5 rounded-top-4 border-0 d-flex align-items-center gap-2">
                     Tambah Kostum Baru
                </div>
                <div class="card-body p-4 bg-white rounded-bottom-4">
                    @if (session('sukses'))
                        <div class="alert alert-success border-0 shadow-sm fw-bold rounded-3">
                            ✓ {{ session('sukses') }}
                        </div>
                    @endif

                    <form action="/admin/kostum" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Foto Kostum</label>
                            <input type="file" name="images[]" class="form-control bg-light" accept="images/*" multiple>
                            <div class="form-text small">Format: JPG, PNG. Ukuran ideal kotak.</div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nama Kostum</label>
                            <input type="text" name="name" class="form-control bg-light"
                                placeholder="Contoh: Gaun Kebaya Modern" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Tipe Baju</label>
                                <select name="type" class="form-select bg-light" required>
                                    <option value="Cosplay">Cosplay</option>
                                    <option value="Acara Sekolah">Acara Sekolah</option>
                                    <option value="Pentas Tari">Pentas Tari</option>
                                    <option value="Pernikahan">Pernikahan</option>
                                    <option value="Pesta Umum">Pesta Umum</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Ukuran</label>
                                <select name="size" class="form-select bg-light" required>
                                    <option value="S">S (Small)</option>
                                    <option value="M">M (Medium)</option>
                                    <option value="L">L (Large)</option>
                                    <option value="XL">XL (Extra Large)</option>
                                    <option value="All Size">All Size</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Warna</label>
                                <input type="text" name="color" class="form-control bg-light" placeholder="Contoh: Merah, Putih"
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Bahan</label>
                                <input type="text" name="material" class="form-control bg-light"
                                    placeholder="Contoh: Katun, Polyester">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Negara Asal Produksi</label>
                            <input type="text" name="origin" class="form-control bg-light"
                                placeholder="Contoh: Made in Indonesia">
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-5 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-muted small text-uppercase">Stok (Pcs)</label>
                                <input type="number" name="stock" class="form-control bg-light" value="1" min="1"
                                    required>
                            </div>

                            <div class="col-md-7 mb-3 mb-md-0">
                                <label class="form-label fw-bold text-muted small text-uppercase">Harga Sewa / Hari (Rp)</label>
                                <input type="number" name="price" class="form-control bg-light" placeholder="Contoh: 50000"
                                    required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Kondisi Awal</label>
                            <select name="condition" class="form-select bg-light border-warning" required>
                                <option value="baik">Baik (Siap Sewa)</option>
                                <option value="diperbaiki">Diperbaiki (Tidak Siap)</option>
                                <option value="rusak">Rusak (Tidak Siap)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-warning text-dark w-100 fw-bold py-3 rounded-pill shadow-sm fs-6">
                             SIMPAN KOSTUM
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card shadow-sm border-0 rounded-4 h-100">
                <div class="card-header bg-white text-dark border-bottom pt-4 pb-3 px-4 rounded-top-4 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-uppercase"> Daftar Kostum Tersedia</h5>
                </div>
                <div class="card-body p-0 table-responsive rounded-bottom-4">
                    <table class="table table-hover mb-0 align-middle border-light">
                        <thead class="table-light text-muted small text-uppercase">
                            <tr>
                                <th class="ps-4 py-3">Nama & Tipe</th>
                                <th class="py-3">Detail Spesifikasi</th>
                                <th class="py-3 text-center">Stok & Kondisi</th>
                                <th class="pe-4 py-3 text-end">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($costumes as $kostum)
                                <tr>
                                    <td class="ps-4 py-3 border-bottom-0">
                                        <span class="fw-bold text-dark fs-6">{{ $kostum->name }}</span><br>
                                        <span class="badge bg-dark text-warning fw-medium mt-1">{{ $kostum->type }}</span>
                                    </td>
                                    <td class="py-3 border-bottom-0">
                                        <div class="text-muted small">
                                            <strong class="text-dark">{{ $kostum->size }}</strong> | {{ $kostum->color }} <br>
                                            <span class="opacity-75">{{ $kostum->material ?: '-' }}</span>
                                        </div>
                                    </td>
                                    <td class="py-3 text-center border-bottom-0">
                                        <strong class="d-block text-dark mb-1">{{ $kostum->stock }} Pcs</strong>
                                        
                                        @if ($kostum->condition == 'baik')
                                            <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-2 py-1">Baik</span>
                                        @elseif($kostum->condition == 'diperbaiki')
                                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning fw-bold px-2 py-1">Diperbaiki</span>
                                        @else
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-bold px-2 py-1">Rusak</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 py-3 text-end border-bottom-0">
                                        <div class="d-flex justify-content-end gap-2">
                                            <a href="/admin/kostum/{{ $kostum->id }}/edit"
                                                class="btn btn-warning text-dark btn-sm fw-bold px-3 rounded-pill shadow-sm">
                                                Edit
                                            </a>

                                            <form action="/admin/kostum/{{ $kostum->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger btn-sm fw-bold px-3 rounded-pill shadow-sm"
                                                    onclick="return confirm('Yakin ingin menghapus kostum {{ $kostum->name }} ini?')">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <tr><td colspan="4" class="p-0 border-bottom border-light"></td></tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-5 bg-light">
                                        <div class="fs-1 mb-3 opacity-25"></div>
                                        <h6 class="fw-bold">Belum ada kostum yang ditambahkan.</h6>
                                        <p class="small mb-0">Gunakan formulir di samping untuk menambah koleksi baru.</p>
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