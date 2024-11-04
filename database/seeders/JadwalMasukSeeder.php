<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalMasukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_jadwal_masuk')->insert([
            [
                'kelas_id' => 1, // ID kelas
                'hari' => 'Senin',
                'jam_masuk' => '07:00:00',
                'jam_keluar' => '14:00:00',
            ],
            [
                'kelas_id' => 1, // ID kelas
                'hari' => 'Selasa',
                'jam_masuk' => '07:00:00',
                'jam_keluar' => '14:00:00',
            ],
            // Tambahkan jadwal masuk lain sesuai kebutuhan
        ]);
    }
}
