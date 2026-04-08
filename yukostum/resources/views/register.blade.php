@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 80vh;">
    <div class="col-md-7 col-lg-5">
        
        <div class="card shadow-lg border-0 rounded-4 overflow-hidden mt-4">
            
            <div class="card-header bg-primary text-white text-center py-4 border-0">
                <h3 class="fw-bold mb-0"> Daftar Yukostum</h3>
                <p class="mb-0 text-white-50 small">Buat akun untuk mulai menyewa kostum impianmu.</p>
            </div>

            <div class="card-body p-4 p-md-5 bg-white">
                <form action="/register" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold text-muted small">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg bg-light border-0" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-muted small">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg bg-light border-0" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold text-muted small">Nomor WhatsApp / HP</label>
                        <input type="number" name="phone" id="phone" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required>
                        @error('phone')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold text-muted small">Alamat Lengkap Pengiriman</label>
                        <textarea name="address" id="address" class="form-control form-control-lg bg-light border-0" rows="3" placeholder="Masukkan nama jalan, RT/RW, desa, kecamatan..." required>{{ old('address') }}</textarea>
                        @error('address')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr class="text-muted my-4">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-bold text-muted small">Kata Sandi</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg bg-light border-0" placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <small class="text-danger fw-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-bold text-muted small">Ulangi Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg bg-light border-0" placeholder="Ketik ulang sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm rounded-3 py-3">
                         Buat Akun Sekarang
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Sudah punya akun? 
                        <a href="/login" class="text-primary fw-bold text-decoration-none">Masuk di sini</a>
                    </p>
                </div>

            </div>
        </div>
        
    </div>
</div>
@endsection