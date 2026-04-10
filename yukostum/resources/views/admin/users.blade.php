@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h3 class="fw-bold text-dark text-uppercase">Manajemen Pengguna</h3>
        <p class="text-muted">Kelola akun Admin, Petugas Gudang, dan Pelanggan di sistem Yukostum.</p>
    </div>
</div>

@if(session('sukses'))
    <div class="alert alert-success fw-bold border-0 shadow-sm rounded-3">
        ✓ {{ session('sukses') }}
    </div>
@endif
@if(session('error'))
    <div class="alert alert-danger fw-bold border-0 shadow-sm rounded-3">
        🚨 {{ session('error') }}
    </div>
@endif

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-white text-dark border-bottom pt-4 pb-3 px-4 rounded-top-4 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-uppercase"> Daftar Akun Terdaftar</h5>
            </div>
            <div class="card-body p-0 table-responsive rounded-bottom-4">
                <table class="table table-hover mb-0 align-middle border-light">
                    <thead class="table-light text-muted small text-uppercase">
                        <tr>
                            <th class="px-4 py-3">No</th>
                            <th class="py-3">Nama Lengkap</th>
                            <th class="py-3">Email</th>
                            <th class="py-3 text-center">Peran</th>
                            <th class="py-3 text-end pe-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td class="px-4 py-3 border-bottom-0 text-muted">{{ $index + 1 }}</td>
                            <td class="py-3 border-bottom-0 fw-bold text-dark">{{ $u->name }}</td>
                            <td class="py-3 border-bottom-0 text-muted">{{ $u->email }}</td>
                            <td class="py-3 border-bottom-0 text-center">
                                @if($u->role == 'admin')
                                    <span class="badge bg-danger bg-opacity-10 text-danger border border-danger fw-bold px-3 py-1 rounded-pill">Admin</span>
                                @elseif($u->role == 'petugas')
                                    <span class="badge bg-warning bg-opacity-10 text-warning border border-warning fw-bold px-3 py-1 rounded-pill">Petugas</span>
                                @else
                                    <span class="badge bg-success bg-opacity-10 text-success border border-success fw-bold px-3 py-1 rounded-pill">Pelanggan</span>
                                @endif
                            </td>
                            <td class="py-3 border-bottom-0 text-end pe-4">
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="/admin/users/{{ $u->id }}/edit" class="btn btn-sm btn-warning text-dark fw-bold px-3 rounded-pill shadow-sm">
                                        Edit
                                    </a>
                                    
                                    <form action="/admin/users/{{ $u->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akun {{ $u->name }} permanen?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger fw-bold px-3 rounded-pill shadow-sm" {{ Auth::id() == $u->id ? 'disabled' : '' }}>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <tr><td colspan="5" class="p-0 border-bottom border-light"></td></tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4 mb-4">
        <div class="card shadow-sm border-0 rounded-4 h-100">
            <div class="card-header bg-dark text-warning fw-bold py-3 px-4 fs-5 rounded-top-4 border-0 d-flex align-items-center gap-2">
                 Tambah Pengguna Baru
            </div>
            <div class="card-body p-4 bg-white rounded-bottom-4">
                <form action="/admin/users" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control bg-light" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Alamat Email</label>
                        <input type="email" name="email" class="form-control bg-light" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold text-muted small text-uppercase">Password</label>
                        <input type="password" name="password" class="form-control bg-light" required minlength="6">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold text-muted small text-uppercase">Hak Akses (Role)</label>
                        <select name="role" class="form-select bg-light border-warning" required>
                            <option value="pelanggan">Pelanggan</option>
                            <option value="petugas">Petugas Gudang</option>
                            <option value="admin">Admin / Pemilik</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-warning text-dark w-100 fw-bold py-3 rounded-pill shadow-sm fs-6">
                         SIMPAN AKUN
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection