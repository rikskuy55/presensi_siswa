<?php

namespace App\Http\Controllers;

use App\Models\Presensi;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Check the user's role and return the appropriate view
        if (auth::user()->role == 'admin') {
            // Mendapatkan tanggal hari ini
            $today = Carbon::now()->format('Y-m-d');

            // Menghitung jumlah siswa hadir, izin, sakit, dan terlambat
            $jumlahHadir = Presensi::where('tanggal', $today)
                ->where('status', 'hadir')
                ->count();

            $jumlahIzin = Presensi::where('tanggal', $today)
                ->where('status', 'izin')
                ->count();

            $jumlahSakit = Presensi::where('tanggal', $today)
                ->where('status', 'sakit')
                ->count();

            $jumlahTerlambat = Presensi::where('tanggal', $today)
                ->where('status', 'alpa')
                ->where('tepat_waktu', false) // anggap terlambat berarti tidak tepat waktu
                ->count();

            return view('admin.dashboard', compact('jumlahHadir', 'jumlahIzin', 'jumlahSakit', 'jumlahTerlambat'));
        } elseif (auth::user()->role == 'guru') {
            // Mendapatkan tanggal hari ini
            $today = Carbon::now()->format('Y-m-d');

            // Menghitung jumlah siswa hadir, izin, sakit, dan terlambat
            $jumlahHadir = Presensi::where('tanggal', $today)
                ->where('status', 'hadir')
                ->count();

            $jumlahIzin = Presensi::where('tanggal', $today)
                ->where('status', 'izin')
                ->count();

            $jumlahSakit = Presensi::where('tanggal', $today)
                ->where('status', 'sakit')
                ->count();

            $jumlahTerlambat = Presensi::where('tanggal', $today)
                ->where('status', 'alpa')
                ->where('tepat_waktu', false) // anggap terlambat berarti tidak tepat waktu
                ->count();

            return view('guru.dashboard', compact('jumlahHadir', 'jumlahIzin', 'jumlahSakit', 'jumlahTerlambat'));
        } elseif (auth::user()->role == 'siswa') {
            // Ambil pengguna yang terautentikasi
            $user = Auth::user();

            // Ambil data siswa yang sesuai dengan user yang terautentikasi
            $siswa = Siswa::where('user_id', $user->id)->first(); // Ambil siswa berdasarkan user_id

            if (!$siswa) {
                abort(404, 'Siswa not found.');
            }

            // Ambil data presensi hari ini berdasarkan siswa_id
            $hariini = date("Y-m-d"); // Format tanggal untuk disesuaikan dengan database
            $presensihariini = DB::table('tbl_presensi')
                ->where('siswa_id', $siswa->id) // Ganti dengan siswa_id
                ->where('tanggal', $hariini)
                ->where('jenis_presensi', 'harian') // Filter berdasarkan jenis presensi
                ->first();

            // Ambil histori presensi bulan ini
            $historibulanini = $siswa->presensi()
                ->select('tanggal', 'jenis_presensi', 'status') // Pastikan data ini dipilih
                ->whereYear('tanggal', date('Y'))
                ->whereMonth('tanggal', date('m'))
                ->orderBy('tanggal', 'asc')
                ->get();

            // Ambil hari ini dalam bahasa Indonesia
            $hariInggris = date("l"); // Ambil nama hari dalam bahasa Inggris
            $hari = $this->convertHariToIndonesian($hariInggris); // Konversi ke bahasa Indonesia

            // Ambil data jadwal mapel dari database dan filter berdasarkan hari
            $jadwalMapel = DB::table('tbl_jadwal_mapel as jm')
                ->join('tbl_guru_mapel as gm', 'jm.guru_mapel_id', '=', 'gm.id')
                ->join('tbl_mata_pelajaran as mp', 'gm.mapel_id', '=', 'mp.id')
                ->join('tbl_kelas as k', 'gm.kelas_id', '=', 'k.id')
                ->select(
                    'jm.hari',
                    'jm.jam_mulai',
                    'jm.jam_selesai',
                    'mp.nama_mata_pelajaran',
                    'mp.id as mapel_id', // ID mata pelajaran
                    'k.nama_kelas'
                )
                ->where('k.id', $siswa->kelas_id)
                ->where('jm.hari', $hari) // Tambahkan kondisi untuk memfilter berdasarkan hari
                ->orderBy('jm.jam_mulai', 'asc')
                ->get();


            // dd($jadwalMapel); // Menampilkan data jadwalMapel

            return view('siswa.dashboard', compact('presensihariini', 'historibulanini', 'jadwalMapel'));
        } elseif (auth::user()->role == 'kepala_sekolah') {
            return view('kepsek.dashboard');
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    private function convertHariToIndonesian($dayInEnglish)
    {
        $days = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $days[$dayInEnglish] ?? $dayInEnglish;
    }


    public function getColor($name)
    {
        $hash = md5($name);
        return sprintf('#%s', substr($hash, 0, 6)); // Ambil 6 karakter pertama dari hash sebagai warna
    }
}
