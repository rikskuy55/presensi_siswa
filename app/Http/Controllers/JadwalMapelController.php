<?php

namespace App\Http\Controllers;

use App\Models\JadwalMapel;
use App\Models\Kelas;
use App\Models\GuruMapel;
use Illuminate\Http\Request;

class JadwalMapelController extends Controller
{
    public function index()
    {
        $jadwalMapels = JadwalMapel::with('kelas', 'guruMapel')->get();
        return view('admin.jadwal-mapel.index', compact('jadwalMapels'));
    }

    public function create()
    {
        $guruMapels = GuruMapel::with('guru', 'mataPelajaran', 'kelas')->get();
        return view('admin.jadwal-mapel.create', compact('guruMapels'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_mapel_id' => 'required|exists:tbl_guru_mapel,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        JadwalMapel::create($request->all());

        return redirect()->route('jadwal-mapel.index')->with('success', 'Jadwal berhasil ditambahkan');
    }

    public function edit($id)
    {
        $jadwalMapel = JadwalMapel::findOrFail($id);
        $guruMapels = GuruMapel::with('guru', 'mataPelajaran', 'kelas')->get();
        return view('admin.jadwal-mapel.edit', compact('jadwalMapel', 'guruMapels')); // Hapus 'kelas' jika tidak digunakan
    }
    
    public function update(Request $request, $id)
    {
        $jadwalMapel = JadwalMapel::findOrFail($id);
    
        $request->validate([
            'guru_mapel_id' => 'required|exists:tbl_guru_mapel,id',
            'hari' => 'required|string',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
        ]);
    
        // Memperbarui data jadwal mapel
        $jadwalMapel->update($request->all());
    
        return redirect()->route('jadwal-mapel.index')->with('success', 'Jadwal berhasil diperbarui');
    }

    public function destroy($id)
    {
        $jadwalMapel = JadwalMapel::findOrFail($id);
        $jadwalMapel->delete();

        return redirect()->route('jadwal-mapel.index')->with('success', 'Jadwal berhasil dihapus');
    }
}
