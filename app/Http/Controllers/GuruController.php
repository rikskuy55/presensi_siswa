<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\User; // Tambahkan ini untuk menggunakan model User
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class GuruController extends Controller
{
    // Menampilkan daftar guru
    public function index()
    {
        $gurus = Guru::all();
        return view('admin.data-guru.index', compact('gurus'));
    }

    // Menampilkan form untuk menambah guru
    public function create()
    {
        $users = User::where('role', 'guru')->get();
        return view('admin.data-guru.create', compact('users')); // Kirimkan data pengguna ke view
    }

    // Menyimpan data guru baru
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:255|unique:tbl_guru,nip', 
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'spesialisasi' => 'nullable|string|max:255',
        ]);

        $user = User::find($request->user_id);

        // Check if the user is already a teacher
        if ($user->guru()->exists()) {
            return redirect()->back()->withErrors(['user_id' => 'Pengguna ini sudah terdaftar sebagai guru.']);
        }

        $guru = new Guru($request->all());

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            $guru->foto = $request->file('foto')->store('guru', 'public');
        }

        $guru->save();

        return redirect()->route('data-guru.index')->with('success', 'Guru berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit guru
    public function edit($id)
    {
        $guru = Guru::find($id);
        if (!$guru) {
            Log::warning("Guru with ID {$id} not found.");
            return redirect()->route('data-guru.index')->withErrors('Guru not found.');
        }
        
        $users = User::where('role', 'guru')->get();
        return view('admin.data-guru.edit', compact('guru', 'users'));
    }
    

    // Mengupdate data guru
    public function update(Request $request, $id)
    {
        // Mencari guru berdasarkan ID
        $guru = Guru::findOrFail($id);
    
        Log::info('Update Request ID:', ['guru_id' => $guru->id]);

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nip' => 'required|string|max:255|unique:tbl_guru,nip,' . $guru->id, // Mengabaikan NIP guru yang sedang diupdate
            'nama_guru' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required|string|max:255',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'spesialisasi' => 'nullable|string|max:255',
        ]);

        $user = User::find($request->user_id);

        // Check if the user is already a teacher and not the one being edited
        if ($user->guru()->exists() && $user->id !== $guru->user_id) {
            return redirect()->back()->withErrors(['user_id' => 'Pengguna ini sudah terdaftar sebagai guru.']);
        }

        $guru->update($request->all());

        // Simpan foto jika ada
        if ($request->hasFile('foto')) {
            if ($guru->foto) {
                Storage::disk('public')->delete($guru->foto);
            }
            $guru->foto = $request->file('foto')->store('guru', 'public');
        }

        $guru->save();

        return redirect()->route('data-guru.index')->with('success', 'Guru berhasil diperbarui.');
    }

    // Menghapus guru
    public function destroy($id)
    {
        // Mencari guru berdasarkan ID
        $guru = Guru::findOrFail($id);
    
        // Hapus foto jika ada
        if ($guru->foto) {
            Storage::disk('public')->delete($guru->foto);
        }
    
        // Hapus kelas yang merujuk ke guru ini
        $guru->kelas()->delete();
    
        // Hapus guru dari database
        $guru->delete();
    
        return redirect()->route('data-guru.index')->with('success', 'Guru berhasil dihapus.');
    }    
}
