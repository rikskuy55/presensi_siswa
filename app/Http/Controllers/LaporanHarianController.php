<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Presensi;
use App\Models\Siswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LaporanHarianController extends Controller
{
    public function index()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelasWali;

        if (!$kelas) {
            return redirect('/dashboard')->with('error', 'Anda bukan wali kelas.');
        }

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $siswa = $kelas->siswa;
        $tahun = range(Carbon::now()->year, Carbon::now()->year - 5);

        return view('guru.laporan-harian.index', compact('namabulan', 'kelas', 'siswa', 'tahun'));
    }

    public function printPdf(Request $request)
    {
        $request->validate([
            'bulan' => 'required',
            'tahun' => 'required',
            'nisn' => 'required'
        ]);

        $namabulan = [
            "",
            "JANUARI",
            "FEBRUARI",
            "MARET",
            "APRIL",
            "MEI",
            "JUNI",
            "JULI",
            "AGUSTUS",
            "SEPTEMBER",
            "OKTOBER",
            "NOVEMBER",
            "DESEMBER"
        ];

        $siswa = Siswa::where('nisn', $request->nisn)->firstOrFail();

        // Fetch presensi and order by 'tanggal' in ascending order
        $presensi = $siswa->presensi()
            ->whereMonth('tanggal', $request->bulan)
            ->whereYear('tanggal', $request->tahun)
            ->orderBy('tanggal', 'asc')  // Sorting by 'tanggal' in ascending order
            ->get();

        $data = [
            'siswa' => $siswa,
            'presensi' => $presensi,
            'namabulan' => $namabulan,
            'bulan' => $request->bulan,
            'tahun' => $request->tahun
        ];

        // Load view with PDF and set paper size to A4
        $pdf = Pdf::loadView('guru.laporan-harian.pdf', $data)->setPaper('a4', 'landscape');

        // Stream PDF to browser
        return $pdf->stream("Laporan_Absensi_{$siswa->nama_siswa}_{$namabulan[$request->bulan]}_{$request->tahun}.pdf");
    }

    public function monitoring()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelasWali; // Ambil data kelas yang diampu oleh guru tersebut

        if (!$kelas) {
            return redirect('dashboard')->with('error', 'Anda bukan wali kelas.');
        }

        return view('guru.monitoring.harian', compact('kelas'));
    }

    public function getDailyAttendance(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date'
        ]);

        $guru = Auth::user()->guru;
        $kelas = $guru->kelasWali;

        if (!$kelas) {
            return response()->json(['error' => 'Anda bukan wali kelas untuk kelas manapun.'], 403);
        }

        // Ambil semua siswa dalam kelas yang diampu oleh guru, urutkan berdasarkan nama siswa dari A-Z
        $siswa = $kelas->siswa()->where(function ($query) use ($request) {
            // Filter by search query if provided
            if ($request->search) {
                $query->where('nama_siswa', 'LIKE', '%' . $request->search . '%')
                    ->orWhere('nisn', 'LIKE', '%' . $request->search . '%');
            }
        })
            ->with(['presensi' => function ($query) use ($request) {
                // Hanya ambil presensi pada tanggal tertentu
                $query->where('tanggal', $request->tanggal)->where('jenis_presensi', 'harian');
            }])
            ->orderBy('nama_siswa', 'asc')
            ->get();

        // Format data agar sesuai kebutuhan tampilan
        $attendanceData = $siswa->map(function ($siswa) use ($request) {
            $presensi = $siswa->presensi->first(); // Ambil presensi pertama untuk tanggal tersebut (bisa null)

            return [
                'siswa_id' => $siswa->id,
                'nisn' => $siswa->nisn,
                'nama_siswa' => $siswa->nama_siswa,
                'tanggal' => $request->tanggal,
                'status' => $presensi->status ?? 'Belum Absen',
                'jam_masuk' => $presensi ? ($presensi->jam_masuk ?? '-') : '-',
                'lokasi_masuk' => $presensi->lokasi_masuk ?? '-',
                'foto_selfie_masuk' => $presensi->foto_selfie_masuk ?? null,
                'tepat_waktu' => $presensi->tepat_waktu ?? false,
                'keterangan' => $presensi && $presensi->status !== 'Belum Absen' ? $presensi->status : '-',
            ];
        });

        return response()->json($attendanceData);
    }

    public function monitoringPelajaran()
    {
        $guru = Auth::user()->guru;

        // Fetch unique classes that the teacher teaches
        $kelas = $guru->kelasMengajar()->distinct()->get();

        // Pass only unique classes to avoid duplicates in Blade
        return view('guru.monitoring.pelajaran', compact('kelas'));
    }

    public function getSubjectAttendance(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'kelas_id' => 'required|exists:tbl_kelas,id',
            'mapel_id' => 'required|exists:tbl_mata_pelajaran,id',
        ]);

        $guru = Auth::user()->guru;

        // Ensure the selected class and subject are valid for the logged-in teacher
        $kelas = $guru->kelasMengajar()->find($request->kelas_id);
        $validMapel = $kelas && $kelas->mataPelajaranTerkait($guru->id)->pluck('mata_pelajaran_id')->contains($request->mapel_id);

        if (!$kelas || !$validMapel) {
            return response()->json(['error' => 'Anda tidak mengajar kelas atau mata pelajaran ini.'], 403);
        }

        // Find `jadwal_mapel_id` that corresponds to the selected class, subject, and teacher
        $jadwalMapel = DB::table('tbl_jadwal_mapel')
            ->join('tbl_guru_mapel', 'tbl_jadwal_mapel.guru_mapel_id', '=', 'tbl_guru_mapel.id')
            ->where('tbl_guru_mapel.kelas_id', $request->kelas_id)
            ->where('tbl_guru_mapel.mapel_id', $request->mapel_id)
            ->where('tbl_guru_mapel.guru_id', $guru->id)
            ->value('tbl_jadwal_mapel.id');

        if (!$jadwalMapel) {
            return response()->json(['error' => 'Jadwal tidak ditemukan untuk guru, mata pelajaran, dan kelas ini.'], 404);
        }

        // Fetch presensi data based on `jadwal_mapel_id`
        $presensi = Presensi::where('tanggal', $request->tanggal)
            ->where('jadwal_mapel_id', $jadwalMapel)
            ->where('jenis_presensi', 'pelajaran')
            ->get();

        Log::info('Data presensi yang ditemukan:', [
            'tanggal' => $request->tanggal,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'presensi_records' => $presensi->toArray(),
        ]);

        // Get all students in the selected class
        $siswa = Siswa::where('kelas_id', $request->kelas_id)->get();

        // Merge student data with their presensi records
        $attendanceData = $siswa->map(function ($siswa) use ($presensi, $request) {
            $presensiData = $presensi->firstWhere('siswa_id', $siswa->id);

            return [
                'siswa_id' => $siswa->id,
                'nisn' => $siswa->nisn,
                'nama_siswa' => $siswa->nama_siswa,
                'tanggal' => $presensiData ? $presensiData->tanggal : $request->tanggal,
                'status' => $presensiData ? $presensiData->status : 'Belum Absen',
                'jam_masuk' => $presensiData ? ($presensiData->jam_masuk ?? '-') : '-',
                'lokasi_masuk' => $presensiData->lokasi_masuk ?? '-',
                'foto_selfie_masuk' => $presensiData->foto_selfie_masuk ?? null,
                'tepat_waktu' => $presensiData->tepat_waktu ?? false,
                'keterangan' => $presensiData ? $presensiData->status : '-',
            ];
        });

        Log::info('getSubjectAttendance Request', [
            'tanggal' => $request->tanggal,
            'kelas_id' => $request->kelas_id,
            'mapel_id' => $request->mapel_id,
            'guru_id' => $guru->id,
        ]);
        Log::info('Attendance Data:', $attendanceData->toArray());

        return response()->json($attendanceData);
    }

    public function getMataPelajaran(Request $request)
    {
        $request->validate(['kelas_id' => 'required|exists:tbl_kelas,id']);
        $kelas = Kelas::find($request->kelas_id);
        $guru = Auth::user()->guru;

        if (!$kelas) {
            return response()->json(['error' => 'Kelas tidak ditemukan.'], 404);
        }

        // Mengambil mata pelajaran yang hanya diajar oleh guru yang login
        $mataPelajaran = $kelas->mataPelajaranTerkait($guru->id)->get();
        Log::info('Available mapel_id:', $mataPelajaran->pluck('mata_pelajaran_id')->toArray());

        return response()->json($mataPelajaran);
    }

    public function laporanKelas()
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelasWali;

        if (!$kelas) {
            return redirect('/dashboard')->with('error', 'Anda bukan wali kelas.');
        }

        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
        $tahun = range(Carbon::now()->year, Carbon::now()->year - 5);

        return view('guru.laporan-harian.kelas', compact('namabulan', 'kelas', 'tahun'));
    }

    public function printKelasPdf(Request $request)
    {
        $guru = Auth::user()->guru;
        $kelas = $guru->kelasWali;

        if (!$kelas) {
            return redirect('/dashboard')->with('error', 'Anda bukan wali kelas.');
        }

        $request->validate([
            'periode' => 'required',
        ]);

        // Konfigurasi filter berdasarkan periode
        $query = DB::table('tbl_presensi')->whereIn('siswa_id', $kelas->siswa->pluck('id'));

        if ($request->periode === 'per_bulan') {
            $request->validate([
                'bulan' => 'required',
                'tahun' => 'required',
            ]);
            $query->whereMonth('tanggal', $request->bulan)
                ->whereYear('tanggal', $request->tahun);
            $periode = "Bulan " . $request->bulan . " Tahun " . $request->tahun;
        } elseif ($request->periode === 'per_tanggal') {
            $request->validate([
                'tanggal' => 'required|date',
            ]);
            $query->whereDate('tanggal', $request->tanggal);
            $periode = "Tanggal " . \Carbon\Carbon::parse($request->tanggal)->format('d-m-Y');
        } elseif ($request->periode === 'rentang_tanggal') {
            $request->validate([
                'tanggal_mulai' => 'required|date',
                'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            ]);
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_selesai]);
            $periode = "Dari " . \Carbon\Carbon::parse($request->tanggal_mulai)->format('d-m-Y') .
                " Sampai " . \Carbon\Carbon::parse($request->tanggal_selesai)->format('d-m-Y');
        }

        $presensi = $query->orderBy('tanggal', 'asc')->get()->groupBy('siswa_id');
        $namabulan = ["", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        $data = [
            'kelas' => $kelas,
            'siswa' => $kelas->siswa,
            'presensi' => $presensi,
            'periode' => $periode,
            'namabulan' => $namabulan,
        ];

        $pdf = Pdf::loadView('guru.laporan-harian.kelas-pdf', $data)->setPaper('a4', 'landscape');
        return $pdf->stream("Laporan_Absensi_Kelas_{$kelas->nama_kelas}_{$periode}.pdf");
    }
}
