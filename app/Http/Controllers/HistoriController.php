<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoriController extends Controller
{
    public function showHistori()
    {
        // Ambil pengguna yang terautentikasi
        $user = Auth::user();

        // Ambil data siswa yang sesuai dengan user yang terautentikasi
        $siswa = Siswa::where('user_id', $user->id)->first();

        if (!$siswa) {
            abort(404, 'Siswa tidak ditemukan.');
        }

        // Data untuk dropdown bulan dan tahun
        $namabulan = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
        ];
        $tahunmulai = 2020;
        $tahunsekarang = date('Y');

        return view('siswa.histori', compact('namabulan', 'tahunmulai', 'tahunsekarang'));
    }

    public function getHistori(Request $request)
    {
        // Validasi input bulan dan tahun
        $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:' . date('Y'),
        ]);
    
        // Ambil pengguna yang terautentikasi
        $user = Auth::user();
        $siswa = Siswa::where('user_id', $user->id)->first();
    
        if (!$siswa) {
            return response()->json(['error' => 'Siswa tidak ditemukan.'], 404);
        }
    
        // Ambil histori presensi berdasarkan bulan dan tahun yang dipilih
        $historipresensi = $siswa->presensi()
            ->select('tanggal', 'jenis_presensi', 'status')
            ->whereYear('tanggal', $request->tahun)
            ->whereMonth('tanggal', $request->bulan)
            ->orderBy('tanggal', 'asc')
            ->get();
    
        // Kembalikan JSON response
        return response()->json($historipresensi);
    }
}
