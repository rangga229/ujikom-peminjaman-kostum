@extends('layouts.app')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="fw-bold text-primary"> Manajemen Pengguna</h2>
        <p class="text-muted">Kelola akun Admin, Petugas, dan Pelanggan di sistem Yukostum.</p>
    </div>
</div>

@if(session('sukses'))
    <div class="alert alert-success fw-bold">{{ session('sukses') }}</div>
@endif
@if(session('error'))
    <div class="alert alert-danger fw-bold">{{ session('error') }}</div>
@endif

<div class="row">
    <div class="col-md-8 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white fw-bold">
                Daftar Akun Terdaftar
            </div>
            <div class="card-body p-0 table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="px-3">No</th>
                            <th>Nama Lengkap</th>
                            <th>Email</th>
                            <th>Peran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $index => $u)
                        <tr>
                            <td class="px-3">{{ $index + 1 }}</td>
                            <td class="fw-bold">{{ $u->name }}</td>
                            <td>{{ $u->email }}</td>
                            <td>
                                @if($u->role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($u->role == 'petugas')
                                    <span class="badge bg-info text-dark">Petugas</span>
                                @else
                                    <span class="badge bg-success">Pelanggan</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="/admin/users/{{ $u->id }}/edit" class="btn btn-sm btn-outline-primary"> Edit</a>
                                
                                <form action="/admin/users/{{ $u->id }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akun {{ $u->name }} permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" {{ Auth::id() == $u->id ? 'disabled' : '' }}> Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white fw-bold">
                 Tambah Pengguna Baru
            </div>
            <div class="card-body">
                <form action="/admin/users" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Alamat Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" required minlength="6">
                    </div>
                    
                    <div class="mb-4">
                        <label class="form-label fw-bold">Hak Akses (Role)</label>
                        <select name="role" class="form-select" required>
                            <option value="pelanggan">Pelanggan</option>
                            <option value="petugas">Petugas Gudang</option>
                            <option value="admin">Admin / Pemilik</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100 fw-bold">SIMPAN AKUN</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection