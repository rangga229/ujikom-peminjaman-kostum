@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-5 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold">
                ➕ Tambah Kostum Baru
            </div>
            <div class="card-body">
                @if(session('sukses'))
                    <div class="alert alert-success">{{ session('sukses') }}</div>
                @endif

                <form action="/admin/kostum" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Kostum</label>
                        <input type="text" name="name" class="form-control" placeholder="Contoh: Gaun Kebaya Modern" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Baju</label>
                            <select name="type" class="form-select" required>
                                <option value="Cosplay">Cosplay</option>
                                <option value="Acara Sekolah">Acara Sekolah</option>
                                <option value="Pentas Tari">Pentas Tari</option>
                                <option value="Pernikahan">Pernikahan</option>
                                <option value="Pesta Umum">Pesta Umum</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ukuran</label>
                            <select name="size" class="form-select" required>
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
                            <label class="form-label">Warna</label>
                            <input type="text" name="color" class="form-control" placeholder="Contoh: Merah, Putih" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bahan</label>
                            <input type="text" name="material" class="form-control" placeholder="Contoh: Katun, Polyester">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Negara Asal Produksi</label>
                        <input type="text" name="origin" class="form-control" placeholder="Contoh: Made in Indonesia">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Stok (Pcs)</label>
                            <input type="number" name="stock" class="form-control" value="1" min="1" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Kondisi</label>
                            <select name="condition" class="form-select" required>
                                <option value="baik">Baik</option>
                                <option value="diperbaiki">Diperbaiki</option>
                                <option value="rusak">Rusak</option>
                            </select>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-success w-100 fw-bold py-2">SIMPAN KOSTUM</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-md-7">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                📦 Daftar Kostum Tersedia
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Nama & Tipe</th>
                            <th>Detail</th>
                            <th>Stok</th>
                            <th>Kondisi</th>
                            <th>Aksi</th> </tr>
                    </thead>
                    <tbody>
                        @forelse($costumes as $kostum)
                        <tr>
                            <td>
                                <span class="fw-bold text-primary">{{ $kostum->name }}</span><br>
                                <small class="text-muted">{{ $kostum->type }}</small>
                            </td>
                            <td>
                                <small>
                                    📏 {{ $kostum->size }} | 🎨 {{ $kostum->color }} <br>
                                    🧵 {{ $kostum->material ?: '-' }} 
                                </small>
                            </td>
                            <td>{{ $kostum->stock }} Pcs</td>
                            <td>
                                @if($kostum->condition == 'baik')
                                    <span class="badge bg-success">Baik</span>
                                @elseif($kostum->condition == 'diperbaiki')
                                    <span class="badge bg-warning text-dark">Diperbaiki</span>
                                @else
                                    <span class="badge bg-danger">Rusak</span>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex gap-1">
                                    <a href="/admin/kostum/{{ $kostum->id }}/edit" class="btn btn-warning btn-sm fw-bold">Edit</a>
                                    
                                    <form action="/admin/kostum/{{ $kostum->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Yakin ingin menghapus kostum {{ $kostum->name }} ini?')">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">Belum ada kostum yang ditambahkan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection