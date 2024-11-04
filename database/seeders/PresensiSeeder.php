<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PresensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_presensi')->insert([
            [
                'siswa_id' => 1, // ID siswa
                'tanggal' => '2024-10-15',
                'jenis_presensi' => 'harian',
                'status' => 'hadir',
                'tepat_waktu' => true,
                'jam_masuk' => '07:00:00',
                'jam_keluar' => '14:00:00',
                'lokasi_masuk' => 'SMKN 1 Cimahi', // Lokasi saat masuk
                'lokasi_keluar' => 'SMKN 1 Cimahi', // Lokasi saat keluar
                'foto_selfie_masuk' => null, // Foto selfie saat masuk
                'foto_selfie_keluar' => null, // Foto selfie saat keluar
                'jadwal_mapel_id' => null, // null karena ini presensi harian
                'jadwal_masuk_id' => 1, // ID jadwal masuk yang sesuai
                'izin_id' => null, // Tidak ada izin
            ],
            [
                'siswa_id' => 2, // ID siswa
                'tanggal' => '2024-10-15',
                'jenis_presensi' => 'pelajaran',
                'status' => 'hadir',
                'tepat_waktu' => true,
                'jam_masuk' => '08:00:00',
                'jam_keluar' => '09:00:00',
                'lokasi_masuk' => 'SMKN 1 Cimahi', // Lokasi saat masuk
                'lokasi_keluar' => 'SMKN 1 Cimahi', // Lokasi saat keluar
                'foto_selfie_masuk' => null, // Foto selfie saat masuk
                'foto_selfie_keluar' => null, // Foto selfie saat keluar
                'jadwal_mapel_id' => 1, // ID jadwal mapel yang sesuai
                'jadwal_masuk_id' => null, // null karena ini presensi pelajaran
                'izin_id' => null, // Tidak ada izin
            ],
            // Tambahkan presensi lain sesuai kebutuhan
        ]);
    }
}
