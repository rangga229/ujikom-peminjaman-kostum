@extends('layouts.app')

@section('content')
<div class="row justify-content-center mt-4">
    <div class="col-md-6">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-warning text-dark fw-bold fs-5">
                 Edit Data Pengguna
            </div>
            <div class="card-body p-4">
                
                <form action="/admin/users/{{ $user->id }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-danger">Reset Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Kosongkan jika tidak ingin mengubah password lama">
                        <small class="form-text text-muted">Hanya isi jika ingin mengganti kata sandi akun ini.</small>
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Hak Akses (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="pelanggan" {{ $user->role == 'pelanggan' ? 'selected' : '' }}>Pelanggan</option>
                            <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas Gudang</option>
                            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin / Pemilik</option>
                        </select>
                    </div>
                    
                    <div class="d-flex gap-2 mt-4">
                        <a href="/admin/users" class="btn btn-secondary w-50 fw-bold">BATAL</a>
                        <button type="submit" class="btn btn-warning w-50 fw-bold text-dark">SIMPAN PERUBAHAN</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection