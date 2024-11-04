<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    public function index()
    {
        // Mendapatkan semua data kelas
        $kelass = Kelas::with('guruWaliKelas')->get();

        // Menampilkan halaman index kelas
        return view('admin.data-kelas.index', compact('kelass'));
    }

    public function create()
    {
        // Mendapatkan data guru yang bisa menjadi wali kelas
        $gurus = Guru::all();

        // Menampilkan form tambah kelas
        return view('admin.data-kelas.create', compact('gurus'));
    }

    public function store(Request $request)
    {
        // Validasi data inputan
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'wali_kelas_id' => 'required|exists:tbl_guru,id',
        ]);

        // Menyimpan data kelas baru
        Kelas::create($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('data-kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    public function edit($id)
    {
        // Mendapatkan data kelas yang akan diedit
        $kelas = Kelas::findOrFail($id);
        // Mendapatkan data guru untuk pilihan wali kelas
        $gurus = Guru::all();

        // Menampilkan form edit kelas
        return view('admin.data-kelas.edit', compact('kelas', 'gurus'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data inputan
        $validatedData = $request->validate([
            'nama_kelas' => 'required|string|max:255',
            'jurusan' => 'required|string|max:255',
            'wali_kelas_id' => 'required|exists:tbl_guru,id',
        ]);

        // Mencari kelas yang akan diupdate
        $kelas = Kelas::findOrFail($id);

        // Melakukan update data kelas
        $kelas->update($validatedData);

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('data-kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    public function destroy($id)
    {
        // Mencari kelas yang akan dihapus
        $kelas = Kelas::findOrFail($id);

        // Menghapus data kelas
        $kelas->delete();

        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('data-kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
