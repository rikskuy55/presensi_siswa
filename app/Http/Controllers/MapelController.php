<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;

class MapelController extends Controller
{
    // Menampilkan daftar mata pelajaran
    public function index()
    {
        $mapel = MataPelajaran::all();
        return view('admin.data-mapel.index', compact('mapel'));
    }

    // Menampilkan form untuk menambah mata pelajaran
    public function create()
    {
        return view('admin.data-mapel.create');
    }

    // Menyimpan mata pelajaran yang baru ditambahkan
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama_mata_pelajaran' => 'required|string|max:255',
        ]);

        // Simpan data ke dalam tabel
        MataPelajaran::create([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit mata pelajaran
    public function edit($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        return view('admin.data-mapel.edit', compact('mapel'));
    }

    // Mengupdate mata pelajaran yang sudah ada
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mata_pelajaran' => 'required|string|max:255',
        ]);

        $mapel = MataPelajaran::findOrFail($id);
        $mapel->update([
            'nama_mata_pelajaran' => $request->nama_mata_pelajaran,
        ]);

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil diperbarui.');
    }

    // Menghapus mata pelajaran
    public function destroy($id)
    {
        $mapel = MataPelajaran::findOrFail($id);
        $mapel->delete();

        return redirect()->route('mapel.index')->with('success', 'Mata Pelajaran berhasil dihapus.');
    }
}
