<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JadwalMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_jadwal_mapel')->insert([
            [
                'guru_mapel_id' => 1, // ID guru mapel
                'hari' => 'Senin',
                'jam_mulai' => '07:00:00',
                'jam_selesai' => '08:30:00',
            ],
            [
                'guru_mapel_id' => 2, // ID guru mapel
                'hari' => 'Senin',
                'jam_mulai' => '08:30:00',
                'jam_selesai' => '10:00:00',
            ],
            // Tambahkan jadwal mapel lain sesuai kebutuhan
        ]);
    }
}
