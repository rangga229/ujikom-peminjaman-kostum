@extends('layouts.app')

@section('content')
<style>
    /* Definisi warna emas/kuning Yukostum dari logo besar */
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
        background-color: #E69502 !important; /* Emas sedikit lebih gelap untuk hover */
        border-color: #E69502 !important;
    }
    
    .link-golden {
        color: var(--yukostum-golden) !important;
        text-decoration: none;
    }
    
    .link-golden:hover {
        text-decoration: underline;
    }
    
    /* Bayangan dan batas warna emas untuk gambar kecil di dalam kartu */
    .logo-thumbnail {
        border: 4px solid var(--yukostum-golden);
        box-shadow: 0 4px 8px rgba(249, 166, 2, 0.3);
    }
</style>

<div class="row justify-content-center align-items-center min-vh-100">
    
    <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
        <img src="{{ asset('images/logo_yukostum_large.jpg.jpeg') }}" alt="Logo Yukostum Besar" class="img-fluid" style="max-height: 100%; object-fit: contain;">
    </div>
    
    <div class="col-md-6 col-lg-5 d-flex justify-content-center">
        
        @if($errors->any())
            <div class="alert alert-danger text-center fw-bold shadow-sm">
                 {{ $errors->first() }}
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4 w-100">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo_circle_yukostum.png') }}" alt="Logo Yukostum" width="120" class="rounded-circle mb-3 logo-thumbnail">
                    <h3 class="fw-bold text-golden">Masuk ke Sistem</h3>
                    <p class="text-muted">Silakan masukkan email dan kata sandi Anda</p>
                </div>
                
                <form action="/login" method="POST">
                    @csrf
                    
                    <div class="mb-3 text-start">
                        <label class="form-label fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control form-control-lg bg-light" placeholder="contoh@email.com" required autofocus>
                    </div>
                    
                    <div class="mb-4 text-start">
                        <label class="form-label fw-bold">Kata Sandi</label>
                        <input type="password" name="password" class="form-control form-control-lg bg-light" placeholder="******" required>
                    </div>
                    
                    <button type="submit" class="btn btn-golden btn-lg w-100 fw-bold rounded-pill mb-4">
                        MASUK SEKARANG
                    </button>

                    <div class="text-center mt-3">
                        <p class="text-muted mb-0">Belum punya akun? <a href="/register" class="link-golden fw-bold">Daftar di sini</a></p>
                    </div>
                    
                    <div class="text-center mt-4">
                        <h6 class="fw-bold text-muted mb-1">Yukostum</h6>
                        <p class="mb-0 text-muted small">&copy; 2026 Sistem Penyewaan Kostum Terpercaya.</p>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection