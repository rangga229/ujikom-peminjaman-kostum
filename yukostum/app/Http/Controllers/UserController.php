<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    // 1. Tampilkan daftar pengguna & form tambah
    public function index()
    {
        $users = User::all();
        return view('admin.users', compact('users'));
    }

    // 2. Simpan pengguna baru
    public function store(Request $request)
    {
        //  PERUBAHAN: Masukkan ke variabel $newUser agar datanya bisa dibaca untuk Log
        $newUser = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role
        ]);

        //  LOG AKTIVITAS: Rekam penambahan pengguna baru
        \App\Models\ActivityLog::record('Tambah Pengguna', "Menambahkan pengguna baru bernama {$newUser->name} dengan peran '{$newUser->role}'.");

        return back()->with('sukses', 'Akun pengguna baru berhasil ditambahkan.');
    }

    // 3. Tampilkan form edit
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.edit_user', compact('user'));
    }

    // 4. Simpan perubahan akun
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role
        ];

        // Jika form password diisi, berarti Admin ingin mereset password user ini
        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
            $pesanLogTambahan = " dan mereset kata sandi";
        } else {
            $pesanLogTambahan = "";
        }

        $user->update($data);

        //  LOG AKTIVITAS: Rekam perubahan data pengguna
        \App\Models\ActivityLog::record('Edit Pengguna', "Memperbarui data akun milik {$user->name} (Peran: {$user->role}){$pesanLogTambahan}.");

        return redirect('/admin/users')->with('sukses', 'Data akun berhasil diperbarui.');
    }

    // 5. Hapus akun
    public function destroy($id)
    {
        //  PROTEKSI: Cegah Admin menghapus akunnya sendiri yang sedang dipakai!
        if (Auth::id() == $id) {
            return back()->with('error', 'Peringatan: Kamu tidak bisa menghapus akunmu sendiri!');
        }

        $user = User::findOrFail($id);
        
        //  PERUBAHAN: Simpan nama dan role sebelum datanya musnah dari database
        $namaUser = $user->name;
        $roleUser = $user->role;

        $user->delete();

        //  LOG AKTIVITAS: Rekam penghapusan pengguna
        \App\Models\ActivityLog::record('Hapus Pengguna', "Menghapus akun pengguna bernama {$namaUser} (Peran: {$roleUser}) secara permanen.");

        return redirect('/admin/users')->with('sukses', 'Akun berhasil dihapus permanen.');
    }
}