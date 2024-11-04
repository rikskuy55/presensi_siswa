<?php

namespace App\Http\Controllers;

use App\Models\GuruMapel;
use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Illuminate\Http\Request;

class GuruMapelController extends Controller
{
    public function index()
    {
        $guruMapels = GuruMapel::with(['guru', 'mataPelajaran', 'kelas'])->get();
        // dd($guruMapels); // This will show you all data and relationships
        return view('admin.guru-mapel.index', compact('guruMapels'));
    }
    

    public function create()
    {
        $gurus = Guru::all();
        $mapels = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('admin.guru-mapel.create', compact('gurus', 'mapels', 'kelas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
        ]);

        GuruMapel::create($request->all());
        return redirect()->route('guru-mapel.index')->with('success', 'Data berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $guruMapel = GuruMapel::find($id);
        $gurus = Guru::all();
        $mapels = MataPelajaran::all();
        $kelas = Kelas::all();
        return view('admin.guru-mapel.edit', compact('guruMapel', 'gurus', 'mapels', 'kelas'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'guru_id' => 'required',
            'mapel_id' => 'required',
            'kelas_id' => 'required',
        ]);

        $guruMapel = GuruMapel::find($id);
        $guruMapel->update($request->all());

        return redirect()->route('guru-mapel.index')->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $guruMapel = GuruMapel::find($id);
        $guruMapel->delete();
        return redirect()->route('guru-mapel.index')->with('success', 'Data berhasil dihapus.');
    }
}
