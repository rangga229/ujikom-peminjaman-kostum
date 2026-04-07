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
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Enkripsi password
            'role' => $request->role
        ]);

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
        }

        $user->update($data);

        return redirect('/admin/users')->with('sukses', 'Data akun berhasil diperbarui.');
    }

    // 5. Hapus akun
    public function destroy($id)
    {
        // 🚨 PROTEKSI: Cegah Admin menghapus akunnya sendiri yang sedang dipakai!
        if (Auth::id() == $id) {
            return back()->with('error', 'Peringatan: Kamu tidak bisa menghapus akunmu sendiri!');
        }

        $user = User::findOrFail($id);
        $user->delete();

        return redirect('/admin/users')->with('sukses', 'Akun berhasil dihapus permanen.');
    }
}