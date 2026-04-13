@extends('layouts.app')

@section('content')
<style>
    :root {
        --yukostum-golden: #F9A602;
    }
    
    .text-golden {
        color: var(--yukostum-golden) !important;
    }
    
    .btn-golden {
        background-color: var(--yukostum-golden) !important;
        border-color: var(--yukostum-golden) !important;
        color: #121212 !important; /* Teks hitam agar kontras */
    }
    
    .btn-golden:hover {
        background-color: #E69502 !important;
        border-color: #E69502 !important;
    }
    
    .link-golden {
        color: var(--yukostum-golden) !important;
        text-decoration: none;
    }
    
    .link-golden:hover {
        text-decoration: underline;
    }
    
    .logo-thumbnail {
        border: 4px solid var(--yukostum-golden);
        box-shadow: 0 4px 8px rgba(249, 166, 2, 0.3);
    }
</style>

<div class="row justify-content-center align-items-center min-vh-100 py-5">
    
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
        <img src="{{ asset('images/logo_yukostum_large.jpg.jpeg') }}" alt="Logo Yukostum Besar" class="img-fluid" style="max-height: 80vh; object-fit: contain;">
    </div>

    <div class="col-md-6 col-lg-5 d-flex justify-content-center">
        
        <div class="card shadow-lg border-0 rounded-4 w-100 overflow-hidden">
            
            <div class="card-body p-4 p-md-5 bg-white">
                
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo_circle_yukostum.png') }}" alt="Logo Yukostum" width="100" class="rounded-circle mb-3 logo-thumbnail">
                    <h3 class="fw-bold text-golden mb-1">Daftar Yukostum</h3>
                    <p class="text-muted small">Buat akun untuk mulai menyewa kostum impianmu.</p>
                </div>

                <form action="/register" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label fw-bold text-muted small text-uppercase">Nama Lengkap</label>
                        <input type="text" name="name" id="name" class="form-control form-control-lg bg-light border-0" placeholder="Masukkan nama lengkap" value="{{ old('name') }}" required autofocus>
                        @error('name')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-bold text-muted small text-uppercase">Alamat Email</label>
                        <input type="email" name="email" id="email" class="form-control form-control-lg bg-light border-0" placeholder="contoh@email.com" value="{{ old('email') }}" required>
                        @error('email')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label fw-bold text-muted small text-uppercase">Nomor WhatsApp / HP</label>
                        <input type="number" name="phone" id="phone" class="form-control form-control-lg bg-light border-0" placeholder="Contoh: 081234567890" value="{{ old('phone') }}" required>
                        @error('phone')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="address" class="form-label fw-bold text-muted small text-uppercase">Alamat Lengkap Pengiriman</label>
                        <textarea name="address" id="address" class="form-control form-control-lg bg-light border-0" rows="3" placeholder="Masukkan nama jalan, RT/RW, desa, kecamatan..." required>{{ old('address') }}</textarea>
                        @error('address')
                            <small class="text-danger fw-bold">{{ $message }}</small>
                        @enderror
                    </div>

                    <hr class="text-muted opacity-25 my-4">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label fw-bold text-muted small text-uppercase">Kata Sandi</label>
                            <input type="password" name="password" id="password" class="form-control form-control-lg bg-light border-0" placeholder="Minimal 8 karakter" required>
                            @error('password')
                                <small class="text-danger fw-bold">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="password_confirmation" class="form-label fw-bold text-muted small text-uppercase">Ulangi Sandi</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control form-control-lg bg-light border-0" placeholder="Ketik ulang sandi" required>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-golden btn-lg w-100 fw-bold shadow-sm rounded-pill py-3">
                        BUAT AKUN SEKARANG
                    </button>
                </form>

                <div class="text-center mt-4">
                    <p class="text-muted small mb-0">Sudah punya akun? 
                        <a href="/login" class="link-golden fw-bold">Masuk di sini</a>
                    </p>
                </div>

            </div>
        </div>
        
    </div>
</div>
@endsection