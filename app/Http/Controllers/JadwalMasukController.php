<?php

namespace App\Http\Controllers;

use App\Models\JadwalMasuk;
use App\Models\Kelas;
use Illuminate\Http\Request;

class JadwalMasukController extends Controller
{
    public function index()
    {
        $jadwalMasuks = JadwalMasuk::with('kelas', 'presensi')->get();
        return view('admin.jadwal-masuk.index', compact('jadwalMasuks'));
    }

    public function create()
    {
        // Ambil data kelas dari model Kelas untuk dropdown
        $kelas = Kelas::all(); // Pastikan model Kelas sudah ada
        return view('admin.jadwal-masuk.create', compact('kelas'));
    }
    

    public function store(Request $request)
    {
        $request->validate([
            'kelas_id' => 'required',
            'hari' => 'required|string',
            'jam_masuk' => 'required|date_format:H:i',
            'jam_keluar' => 'required|date_format:H:i|after:jam_masuk',
        ]);

        JadwalMasuk::create($request->all());

        return redirect()->route('jadwal-masuk.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwalMasuk = JadwalMasuk::findOrFail($id); // Find the individual JadwalMasuk by its id
        $kelas = Kelas::all(); // Pastikan model Kelas sudah ada
        return view('admin.jadwal-masuk.edit', compact('jadwalMasuk', 'kelas')); // Hapus 'kelas' jika tidak digunakan
    }
    
    public function update(Request $request, $id)
    {
        $jadwalMasuk = JadwalMasuk::findOrFail($id);
    
        $request->validate([
            'kelas_id' => 'required',
            'hari' => 'required|string',
            'jam_masuk' => 'required',
            'jam_keluar' => 'required|after:jam_masuk',
        ]);
    
        // Memperbarui data jadwal mapel
        $jadwalMasuk->update($request->all());
    
        return redirect()->route('jadwal-masuk.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwalMasuk = JadwalMasuk::findOrFail($id);
        $jadwalMasuk->delete();

        return response()->json(['message' => 'Jadwal berhasil dihapus']);
    }
}
