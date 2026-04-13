@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
                <div>
                    <h3 class="fw-bold text-dark text-uppercase mb-0">Pengaturan Profil</h3>
                    <p class="text-muted mb-0 small">Perbarui data diri dan alamat pengiriman Anda.</p>
                </div>
                <a href="/dashboard" class="btn btn-outline-dark fw-bold shadow-sm rounded-pill px-4">
                    ← Kembali ke Dashboard
                </a>
            </div>

            @if(session('sukses'))
                <div class="alert alert-success fw-bold shadow-sm border-0 rounded-3">
                    ✓ {{ session('sukses') }}
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-dark text-white p-4 border-0">
                    <div class="d-flex align-items-center">
                        <div class="bg-warning text-dark rounded-circle d-flex justify-content-center align-items-center me-4 shadow-lg border border-dark" style="width: 75px; height: 75px; font-size: 2rem; font-weight: 800;">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h4 class="fw-bold text-warning mb-1">{{ $user->name }}</h4>
                            <p class="mb-0 text-white-50"><span class="badge bg-secondary bg-opacity-50 fw-normal rounded-pill px-3">{{ $user->email }}</span></p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5 bg-white">
                    <form action="/profil" method="POST">
                        @csrf
                        @method('PUT')

                        <h6 class="fw-bold text-dark mb-3 border-bottom pb-2 text-uppercase">Informasi Pribadi</h6>
                        
                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nama Lengkap</label>
                            <input type="text" name="name" class="form-control bg-light border-0 px-3 py-2" value="{{ old('name', $user->name) }}" required>
                            @error('name') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Alamat Email <span class="text-danger fw-normal">*Tidak dapat diubah</span></label>
                            <input type="email" class="form-control bg-light border-0 px-3 py-2 text-muted" value="{{ $user->email }}" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold text-muted small text-uppercase">Nomor HP / WhatsApp</label>
                            <input type="number" name="phone" class="form-control bg-light border-0 px-3 py-2" value="{{ old('phone', $user->phone) }}" required>
                            @error('phone') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold text-muted small text-uppercase">Alamat Lengkap Pengiriman</label>
                            <textarea name="address" class="form-control bg-light border-0 px-3 py-2" rows="3" required>{{ old('address', $user->address) }}</textarea>
                            @error('address') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                        </div>

                        <h6 class="fw-bold text-dark mb-3 border-bottom pb-2 mt-5 text-uppercase">Ubah Kata Sandi <span class="text-muted fs-6 fw-normal text-capitalize">(Opsional)</span></h6>
                        <div class="alert alert-warning border-0 rounded-3 bg-opacity-10 text-warning-emphasis small mb-4">
                             Kosongkan bagian ini jika Anda tidak ingin mengubah kata sandi saat ini.
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold text-muted small text-uppercase">Kata Sandi Baru</label>
                                <input type="password" name="password" class="form-control bg-light border-0 px-3 py-2" placeholder="Minimal 8 karakter">
                                @error('password') <small class="text-danger fw-bold">{{ $message }}</small> @enderror
                            </div>
                            <div class="col-md-6 mb-4">
                                <label class="form-label fw-bold text-muted small text-uppercase">Konfirmasi Sandi Baru</label>
                                <input type="password" name="password_confirmation" class="form-control bg-light border-0 px-3 py-2" placeholder="Ketik ulang sandi baru">
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-warning text-dark btn-lg fw-bold rounded-pill shadow-sm py-3">
                                 Simpan Perubahan Profil
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection