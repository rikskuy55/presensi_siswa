<?php

namespace App\Http\Controllers;

use App\Models\Izin;
use App\Models\Guru;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Carbon\Carbon;

class IzinController extends Controller
{
    public function izin()
    {
        // Ambil siswa terkait dengan user yang sedang login
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();

        // Ambil data izin siswa
        $izins = Izin::where('siswa_id', $siswa->id)->get();

        return view('siswa.izin.index', compact('izins'));
    }

    public function showIzinForm()
    {
        return view('siswa.izin.form');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'tanggal_izin' => 'required|date_format:d/m/Y',
            'jenis_izin' => 'required|string',
            'keterangan' => 'required|string',
            'foto_bukti' => 'nullable|image|max:2048',
        ]);

        // Konversi tanggal
        $tanggal_izin = Carbon::createFromFormat('d/m/Y', $request->tanggal_izin)->format('Y-m-d');

        // Ambil data siswa berdasarkan user yang sedang login
        $siswa = Siswa::where('user_id', auth()->user()->id)->first();
        if (!$siswa) {
            return redirect()->back()->withErrors(['siswa_id' => 'Siswa tidak ditemukan.']);
        }

        // Ambil wali kelas berdasarkan kelas siswa
        $wali_kelas = $siswa->kelas->waliKelas;

        // Upload foto bukti jika ada
        $foto_bukti = $request->hasFile('foto_bukti')
            ? $request->file('foto_bukti')->store('bukti_izin', 'public')
            : null;

        // Simpan izin ke database
        Izin::create([
            'siswa_id' => $siswa->id,
            'guru_id' => $wali_kelas->id, // Guru yang bertindak sebagai wali kelas
            'tanggal_izin' => $tanggal_izin,
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'foto_bukti' => $foto_bukti,
            'status' => 'menunggu',
        ]);

        return redirect()->route('izin.index')->with('success', 'Izin telah diajukan dan menunggu persetujuan.');
    }

    public function showApproveIzin()
    {
        // Ambil guru yang sedang login
        $guru = Guru::where('user_id', auth()->user()->id)->first();

        // Ambil izin yang diajukan siswa di kelas yang diampu oleh guru ini sebagai wali kelas
        $izins = Izin::where('guru_id', $guru->id)->where('status', 'menunggu')->get();

        return view('guru.kelola-izin.index', compact('izins'));
    }

    public function approve($id)
    {
        $izin = Izin::findOrFail($id);

        // Pastikan hanya wali kelas yang bisa menyetujui izin
        if ($izin->guru_id != auth()->user()->guru->id) {
            return redirect()->route('izin.approve-view')->withErrors('Anda tidak memiliki akses untuk menyetujui izin ini.');
        }

        $izin->update(['status' => 'disetujui']);

        return redirect()->route('izin.approve-view')->with('success', 'Izin berhasil disetujui.');
    }

    public function reject($id)
    {
        $izin = Izin::findOrFail($id);

        // Pastikan hanya wali kelas yang bisa menolak izin
        if ($izin->guru_id != auth()->user()->guru->id) {
            return redirect()->route('izin.approve-view')->withErrors('Anda tidak memiliki akses untuk menolak izin ini.');
        }

        $izin->update(['status' => 'ditolak']);

        return redirect()->route('izin.approve-view')->with('success', 'Izin berhasil ditolak.');
    }

    public function edit($id)
    {
        $izin = Izin::findOrFail($id);

        // Pastikan izin milik siswa yang sedang login
        if ($izin->siswa_id != auth()->user()->siswa->id) {
            return redirect()->route('izin.index')->withErrors('Anda tidak memiliki izin untuk mengedit data ini.');
        }

        return view('siswa.izin.edit', compact('izin'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tanggal_izin' => 'required|date_format:d/m/Y',
            'jenis_izin' => 'required|string',
            'keterangan' => 'required|string',
            'foto_bukti' => 'nullable|image|max:2048',
        ]);

        $tanggal_izin = Carbon::createFromFormat('d/m/Y', $request->tanggal_izin)->format('Y-m-d');

        $izin = Izin::findOrFail($id);

        // Pastikan izin masih berstatus menunggu dan milik siswa yang sedang login
        if ($izin->siswa_id != auth()->user()->siswa->id || $izin->status != 'menunggu') {
            return redirect()->route('izin.index')->withErrors('Izin tidak bisa diubah.');
        }

        $izin->update([
            'tanggal_izin' => $tanggal_izin,
            'jenis_izin' => $request->jenis_izin,
            'keterangan' => $request->keterangan,
            'foto_bukti' => $request->hasFile('foto_bukti') ? $request->file('foto_bukti')->store('bukti_izin', 'public') : $izin->foto_bukti,
        ]);

        return redirect()->route('izin.index')->with('success', 'Izin berhasil diupdate.');
    }

    public function destroy($id)
    {
        $izin = Izin::findOrFail($id);

        // Pastikan izin masih berstatus menunggu dan milik siswa yang sedang login
        if ($izin->siswa_id != auth()->user()->siswa->id || $izin->status != 'menunggu') {
            return redirect()->route('izin.index')->withErrors('Izin tidak bisa dihapus.');
        }

        $izin->delete();

        return redirect()->route('izin.index')->with('success', 'Izin berhasil dihapus.');
    }
}
