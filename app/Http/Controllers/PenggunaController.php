<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class PenggunaController extends Controller
{
    // Menampilkan daftar pengguna
    public function index()
    {
        $users = User::all();
        return view('admin.data-pengguna.index', compact('users'));
    }

    // Menampilkan form pembuatan pengguna baru
    public function create()
    {
        return view('admin.data-pengguna.create');
    }

    // Menyimpan pengguna baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'no_telp' => 'nullable|string|max:15',
            'role' => 'required|in:admin,guru,siswa,kepala_sekolah',
            'is_active' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'is_active' => $request->is_active,
        ];

        // Proses upload foto jika ada
        if ($request->hasFile('foto')) {
            Log::info('Foto di-upload: ' . $request->file('foto')->getClientOriginalName());
            $path = $request->file('foto')->store('uploads/foto', 'public');
            $data['foto'] = $path;
        } else {
            Log::info('Tidak ada foto yang di-upload.');
        }

        User::create($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil ditambahkan!');
    }

    // Menampilkan form edit pengguna
    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('admin.data-pengguna.edit', compact('user'));
    }

    // Memperbarui data pengguna
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:8',
            'no_telp' => 'nullable|string|max:15',
            'role' => 'required|in:admin,guru,siswa,kepala_sekolah',
            'is_active' => 'required|boolean',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'no_telp' => $request->no_telp,
            'is_active' => $request->is_active,
        ];

        // Periksa apakah password diubah
        if ($request->password) {
            $data['password'] = bcrypt($request->password);
        }

        // Periksa apakah ada foto baru yang di-upload
        if ($request->hasFile('foto')) {
            Log::info('Foto di-upload: ' . $request->file('foto')->getClientOriginalName());

            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('uploads/foto', 'public');
            $data['foto'] = $path;
        }

        $user->update($data);

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil diperbarui!');
    }

    // Menghapus pengguna
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // Hapus foto dari storage jika ada
        if ($user->foto && Storage::disk('public')->exists($user->foto)) {
            Storage::disk('public')->delete($user->foto);
        }

        $user->delete();

        return redirect()->route('pengguna.index')->with('success', 'Pengguna berhasil dihapus!');
    }
}
