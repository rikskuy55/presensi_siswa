<?php

namespace App\Services;

use App\Models\Presensi;
use App\Models\Siswa;
use App\Models\Izin;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class PresensiGenerate
{
    public function updateAlpaStatus()
    {
        $today = Carbon::now()->format('Y-m-d');
        $currentDayInggris = Carbon::now()->format('l'); // Nama hari dalam bahasa Inggris
        $currentTime = Carbon::now()->format('H:i:s'); // Waktu sekarang

        // Konversi nama hari ke bahasa Indonesia
        $currentDay = $this->convertHariToIndonesian($currentDayInggris);

        // Ambil semua siswa
        $siswas = Siswa::all();
        Log::info('Jumlah siswa yang diproses: ' . $siswas->count());

        foreach ($siswas as $siswa) {
            Log::info("Memproses siswa ID: {$siswa->id} - Nama: {$siswa->nama}");

            // Cek presensi harian
            $presensiHarian = Presensi::where('siswa_id', $siswa->id)
                ->whereDate('tanggal', $today)
                ->where('jenis_presensi', 'harian')
                ->first();

            // Cek izin siswa untuk hari ini
            $izinHarian = Izin::where('siswa_id', $siswa->id)
                ->whereDate('tanggal_izin', $today)
                ->where('status', 'disetujui')
                ->exists();

            // Jika tidak ada presensi harian dan izin, siswa dianggap alpa (harian)
            if (!$presensiHarian && !$izinHarian) {
                Presensi::create([
                    'siswa_id' => $siswa->id,
                    'tanggal' => $today,
                    'jenis_presensi' => 'harian',
                    'status' => 'alpa',
                    'tepat_waktu' => false,
                ]);
                Log::info("Siswa ID: {$siswa->id} tidak hadir harian, status di-update menjadi alpa.");
            } else {
                Log::info("Siswa ID: {$siswa->id} telah melakukan presensi harian atau memiliki izin.");
            }

            // Ambil jadwal mapel untuk kelas siswa saat ini
            $jadwalMapels = DB::table('tbl_jadwal_mapel as jm')
                ->join('tbl_guru_mapel as gm', 'jm.guru_mapel_id', '=', 'gm.id')
                ->join('tbl_mata_pelajaran as mp', 'gm.mapel_id', '=', 'mp.id')
                ->join('tbl_kelas as k', 'gm.kelas_id', '=', 'k.id')
                ->select(
                    'jm.id as jadwal_id',
                    'jm.hari',
                    'jm.jam_mulai',
                    'jm.jam_selesai',
                    'mp.nama_mata_pelajaran',
                    'mp.id as mapel_id',
                    'k.nama_kelas'
                )
                ->where('k.id', $siswa->kelas_id)
                ->where('jm.hari', $currentDay) // Gunakan hari yang dikonversi ke bahasa Indonesia
                ->where('jm.jam_mulai', '<=', $currentTime)
                ->where('jm.jam_selesai', '>=', $currentTime)
                ->get();

            Log::info("Jumlah jadwal mapel yang ditemukan untuk siswa ID: {$siswa->id}: " . $jadwalMapels->count());

            foreach ($jadwalMapels as $jadwalMapel) {
                $presensiPelajaran = Presensi::where('siswa_id', $siswa->id)
                    ->whereDate('tanggal', $today)
                    ->where('jenis_presensi', 'pelajaran')
                    ->where('jadwal_mapel_id', $jadwalMapel->jadwal_id)
                    ->first();

                // Cek izin siswa untuk pelajaran tertentu
                $izinPelajaran = Izin::where('siswa_id', $siswa->id)
                    ->whereDate('tanggal_izin', $today)
                    ->where('status', 'disetujui')
                    ->where('mapel_id', $jadwalMapel->mapel_id)
                    ->exists();

                // Jika tidak ada presensi pelajaran dan juga tidak ada izin, siswa dianggap alpa (pelajaran)
                if (!$presensiPelajaran && !$izinPelajaran) {
                    Presensi::create([
                        'siswa_id' => $siswa->id,
                        'tanggal' => $today,
                        'jenis_presensi' => 'pelajaran',
                        'status' => 'alpa',
                        'tepat_waktu' => false,
                        'jadwal_mapel_id' => $jadwalMapel->jadwal_id,
                    ]);
                    Log::info("Siswa ID: {$siswa->id} tidak hadir di pelajaran mapel ID: {$jadwalMapel->mapel_id}, status di-update menjadi alpa.");
                } else {
                    Log::info("Siswa ID: {$siswa->id} telah melakukan presensi pelajaran atau memiliki izin.");
                }
            }
        }

        return 'Status alpa diperbarui untuk semua siswa yang tidak melakukan presensi harian dan/atau pelajaran.';
    }

    private function convertHariToIndonesian($hariInggris)
    {
        $hariIndo = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        return $hariIndo[$hariInggris] ?? null; // Mengembalikan null jika hari tidak ditemukan
    }
}
