<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    public function index()
    {
        $siswas = Siswa::with('kelas')->get();
        return view('admin.data-siswa.index', compact('siswas'));
    }

    public function create()
    {
        $kelas = Kelas::all(); // Ambil data kelas dari model Kelas
        $users = User::where('role', 'siswa')->get(); // Ambil hanya pengguna dengan role siswa
        return view('admin.data-siswa.create', compact('kelas', 'users')); // Sertakan $users di sini
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'nisn' => 'required|unique:tbl_siswa,nisn',
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kelas_id' => 'required|exists:tbl_kelas,id',
        ]);

        $siswa = new Siswa();
        $siswa->user_id = $request->user_id; // Mengisi user_id
        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->alamat = $request->alamat;

        $user = User::find($request->user_id);

        if ($user->siswa()->exists()) {
            return redirect()->back()->withErrors(['user_id' => 'Pengguna ini sudah terdaftar sebagai siswa.']);
        }

        if ($request->hasFile('foto')) {
            $siswa->foto = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->kelas_id = $request->kelas_id;
        $siswa->save();

        return redirect()->route('data-siswa.index')->with('success', 'Siswa berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $siswa = Siswa::findOrFail($id); // Find siswa by ID or fail
        $users = User::where('role', 'siswa')->get();
        $kelas = Kelas::all(); // Get all classes
        return view('admin.data-siswa.edit', compact('siswa', 'kelas', 'users')); // Pass siswa and kelas to the view
    }


    public function update(Request $request, $id)
    {
        // Mencari siswa berdasarkan ID
        $siswa = Siswa::findOrFail($id);
    
        $request->validate([
            'nisn' => 'required|unique:tbl_siswa,nisn,' . $siswa->id, // Mengabaikan NISN siswa yang sedang diupdate
            'nama_siswa' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kelas_id' => 'required|exists:tbl_kelas,id',
        ]);

        $siswa->nisn = $request->nisn;
        $siswa->nama_siswa = $request->nama_siswa;
        $siswa->jenis_kelamin = $request->jenis_kelamin;
        $siswa->tanggal_lahir = $request->tanggal_lahir;
        $siswa->alamat = $request->alamat;

        if ($request->hasFile('foto')) {
            if ($siswa->foto) {
                Storage::disk('public')->delete($siswa->foto);
            }
            $siswa->foto = $request->file('foto')->store('foto-siswa', 'public');
        }

        $siswa->kelas_id = $request->kelas_id;
        $siswa->save();

        return redirect()->route('data-siswa.index')->with('success', 'Siswa berhasil diperbarui!');
    }
    
    public function destroy($id)
    {
        // Cari siswa berdasarkan ID
        $siswa = Siswa::findOrFail($id);
    
        // Hapus foto jika ada
        if ($siswa->foto) {
            Storage::disk('public')->delete($siswa->foto);
        }
    
        // Hapus siswa dari database
        $siswa->delete();
    
        return redirect()->route('data-siswa.index')->with('success', 'Siswa berhasil dihapus!');
    }    

    public function profile()
    {
        return view('siswa.profile.index');
    }

    public function editProfile()
    {
        $user = Auth::user(); // atau auth()->user();
        return view('siswa.profile.edit', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        // Validasi inputan
        $request->validate([
            'username' => 'required|string|max:255|unique:users,username,' . $user->id,
            'no_telp' => 'nullable|string|max:15',
            'password' => 'nullable|string|min:8',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update data user
        $user->username = $request->username;
        $user->no_telp = $request->no_telp;

        // Update password jika diisi
        if ($request->filled('password')) {
            $user->password = bcrypt($request->password);
        }

        // Update foto jika ada file yang diupload
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::disk('public')->exists($user->foto)) {
                Storage::disk('public')->delete($user->foto);
            }

            // Simpan foto baru
            $path = $request->file('foto')->store('uploads/foto', 'public');
            $data['foto'] = $path;
        }

        // Simpan perubahan user
        $user->update($data);
        
        return back()->with('success', 'Profil berhasil diperbarui!');
    }
    
}
