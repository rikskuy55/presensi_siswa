<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Presensi;
use App\Models\MataPelajaran;
use App\Models\Kelas;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
// use PDF;

class LaporanMapelController extends Controller
{
    public function index()
    {
        // Mendapatkan data guru yang sedang login
        $guru = Auth::user()->guru;

        // Mendapatkan daftar kelas yang diajarkan oleh guru ini
        $kelas = Kelas::whereIn('id', $guru->mapel()->pluck('kelas_id'))->get();

        // Mendapatkan daftar mapel yang diajarkan oleh guru ini
        $mapel = MataPelajaran::whereIn('id', $guru->mapel()->pluck('mapel_id'))->get();

        // Mendefinisikan nama bulan
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        
        // Mendapatkan daftar tahun (5 tahun terakhir)
        $tahun = range(Carbon::now()->year, Carbon::now()->year - 5);

        return view('guru.laporan-mapel.index', compact('namabulan', 'kelas', 'mapel', 'tahun'));
    }

    public function printPdf(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'kelas_id' => 'required',
            'nisn' => 'required',
            'mapel_id' => 'required',
        ]);

        // Mendapatkan nama bulan untuk ditampilkan
        $namabulan = ["", "JANUARI", "FEBRUARI", "MARET", "APRIL", "MEI", "JUNI", "JULI", "AGUSTUS", "SEPTEMBER", "OKTOBER", "NOVEMBER", "DESEMBER"];

        // Mendapatkan data siswa, kelas, dan mapel yang dipilih
        $siswa = Siswa::where('nisn', $request->nisn)->firstOrFail();
        $kelas = Kelas::findOrFail($request->kelas_id);
        $mapel = MataPelajaran::findOrFail($request->mapel_id);

        // Mendapatkan presensi berdasarkan bulan, tahun, kelas, dan mapel yang dipilih
        $presensi = Presensi::where('siswa_id', $siswa->id)
            ->where('mapel_id', $mapel->id)
            ->whereMonth('tanggal', $request->bulan)
            ->whereYear('tanggal', $request->tahun)
            ->orderBy('tanggal', 'asc')
            ->get();

        $data = [
            'siswa' => $siswa,
            'presensi' => $presensi,
            'namabulan' => $namabulan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun,
            'kelas' => $kelas,
            'mapel' => $mapel,
        ];

        // Generate PDF
        $pdf = Pdf::loadView('guru.laporan-mapel.pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->stream("Laporan_Absensi_{$siswa->nama_siswa}_{$namabulan[$request->bulan]}_{$request->tahun}.pdf");
    }
}
