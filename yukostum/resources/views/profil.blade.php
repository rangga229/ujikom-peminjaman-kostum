@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3 class="fw-bold text-dark mb-0">⚙️ Pengaturan Profil</h3>
                <a href="/dashboard" class="btn btn-light fw-bold shadow-sm">← Kembali ke Dashboard</a>
            </div>

            @if(session('sukses'))
                <div class="alert alert-success fw-bold shadow-sm">
                    ✅ {{ session('sukses') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-primary text-white p-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-white text-primary rounded-circle d-flex justify-content-center align-items-center me-3 shadow" style="width: 70px; height: 70px; font-size: 2rem; font-weight: bold;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0">{{ $user->name }}</h4>
                            <p class="mb-0 text-white-50">{{ $user->email }}</p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <form action="/profil" method="POST">
                        @csrf
                        @method('PUT')

                        <h5 class="fw-bold mb-3 border-bottom pb-2">Informasi Pribadi</h5>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light" value="{{ old('name', $user->name) }}" required>
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Alamat Email (Tidak dapat diubah)</label>
                            <input type="email" class="form-control bg-light text-muted" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small">Nomor HP / WhatsApp</label>
                            <input type="number" name="phone" class="form-control bg-light" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small">Alamat Lengkap Pengiriman</label>
                            <textarea name="address" class="form-control bg-light" rows="3" required>{{ old('address', $user->address) }}</textarea>
                            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <h5 class="fw-bold mb-3 border-bottom pb-2 mt-5">Ubah Kata Sandi <span class="text-muted fs-6 fw-normal">(Opsional)</span></h5>
                        <p class="small text-muted mb-3">Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi.</p>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-control bg-light" placeholder="Minimal 8 karakter">
                                @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small">Konfirmasi Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light" placeholder="Ketik ulang sandi baru">
                            </div>
                        </div>

                        <div class="d-grid mt-2">
                            <button type="submit" class="btn btn-primary btn-lg fw-bold rounded-3 shadow-sm">
                                💾 Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection