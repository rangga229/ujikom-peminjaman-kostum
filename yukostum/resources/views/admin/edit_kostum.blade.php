@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold">
                ✏️ Edit Kostum: {{ $costume->name }}
            </div>
            <div class="card-body">
                <form action="/admin/kostum/{{ $costume->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label">Nama Kostum</label>
                        <input type="text" name="name" class="form-control" value="{{ $costume->name }}" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Tipe Baju</label>
                            <select name="type" class="form-select" required>
                                <option value="Cosplay" {{ $costume->type == 'Cosplay' ? 'selected' : '' }}>Cosplay</option>
                                <option value="Acara Sekolah" {{ $costume->type == 'Acara Sekolah' ? 'selected' : '' }}>Acara Sekolah</option>
                                <option value="Pentas Tari" {{ $costume->type == 'Pentas Tari' ? 'selected' : '' }}>Pentas Tari</option>
                                <option value="Pernikahan" {{ $costume->type == 'Pernikahan' ? 'selected' : '' }}>Pernikahan</option>
                                <option value="Pesta Umum" {{ $costume->type == 'Pesta Umum' ? 'selected' : '' }}>Pesta Umum</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Ukuran</label>
                            <select name="size" class="form-select" required>
                                <option value="S" {{ $costume->size == 'S' ? 'selected' : '' }}>S (Small)</option>
                                <option value="M" {{ $costume->size == 'M' ? 'selected' : '' }}>M (Medium)</option>
                                <option value="L" {{ $costume->size == 'L' ? 'selected' : '' }}>L (Large)</option>
                                <option value="XL" {{ $costume->size == 'XL' ? 'selected' : '' }}>XL (Extra Large)</option>
                                <option value="All Size" {{ $costume->size == 'All Size' ? 'selected' : '' }}>All Size</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Warna</label>
                            <input type="text" name="color" class="form-control" value="{{ $costume->color }}" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Bahan</label>
                            <input type="text" name="material" class="form-control" value="{{ $costume->material }}">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Negara Asal Produksi</label>
                        <input type="text" name="origin" class="form-control" value="{{ $costume->origin }}">
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Stok (Pcs)</label>
                            <input type="number" name="stock" class="form-control" value="{{ $costume->stock }}" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label class="form-label">Kondisi</label>
                            <select name="condition" class="form-select" required>
                                <option value="baik" {{ $costume->condition == 'baik' ? 'selected' : '' }}>Baik</option>
                                <option value="diperbaiki" {{ $costume->condition == 'diperbaiki' ? 'selected' : '' }}>Diperbaiki</option>
                                <option value="rusak" {{ $costume->condition == 'rusak' ? 'selected' : '' }}>Rusak</option>
                            </select>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <a href="/admin/kostum" class="btn btn-secondary w-50 fw-bold py-2">BATAL</a>
                        <button type="submit" class="btn btn-warning w-50 fw-bold py-2">SIMPAN PERUBAHAN</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection