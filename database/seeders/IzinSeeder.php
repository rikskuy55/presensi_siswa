<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IzinSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_izin')->insert([
            [
                'siswa_id' => 1, // ID siswa
                'guru_id' => 1,  // ID guru
                'tanggal_izin' => '2025-01-01',
                'jenis_izin' => 'sakit',  // Menggunakan enum dari skema
                'keterangan' => 'Demam tinggi',
                'foto_bukti' => null,  // Bisa diisi jika ada foto bukti
                'status' => 'disetujui', // Status izin
            ],
            [
                'siswa_id' => 2, // ID siswa lain
                'guru_id' => 2,  // ID guru lain
                'tanggal_izin' => '2025-02-02',
                'jenis_izin' => 'izin',
                'keterangan' => 'urusan keluarga',
                'foto_bukti' => null,
                'status' => 'menunggu', // Masih menunggu persetujuan
            ],
            // Tambahkan izin lain sesuai kebutuhan
        ]);
    }
}
