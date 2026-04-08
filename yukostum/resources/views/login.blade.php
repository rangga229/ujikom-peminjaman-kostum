@extends('layouts.app')

@section('content')
<div class="row justify-content-center align-items-center min-vh-100">
    <div class="col-md-5">
        
        @if($errors->any())
            <div class="alert alert-danger text-center fw-bold shadow-sm">
                ⚠️ {{ $errors->first() }}
            </div>
        @endif

        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-5">
                <div class="text-center mb-4">
                    <img src="{{ asset('images/logo_circle_yukostum.png') }}" alt="Logo Yukostum" width="80" class="rounded-circle mb-3 shadow-sm border border-white">
                    <h3 class="fw-bold text-primary">Masuk ke Sistem</h3>
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
                    
                    <button type="submit" class="btn btn-primary btn-lg w-100 fw-bold rounded-pill">
                        MASUK SEKARANG
                    </button>

                    <p>Belum punya akun? <a href="/register" class="text-primary fw-bold text-decoration-none">Daftar di sini</a></p>
                </form>
                
            </div>
        </div>
    </div>
</div>
@endsection