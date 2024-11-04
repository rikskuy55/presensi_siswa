<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruMapelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_guru_mapel')->insert([
            [
                'guru_id' => 3, // ID guru untuk Andi Saputra
                'mapel_id' => 6, // ID mata pelajaran Matematika
                'kelas_id' => 1, // ID kelas XI TKJ A
            ],
            [
                'guru_id' => 4, // ID guru untuk Dewi Kartika
                'mapel_id' => 12, // ID mata pelajaran Bahasa Indonesia
                'kelas_id' => 2, // ID kelas XII MM B
            ],
            [
                'guru_id' => 5, // ID guru untuk Ahmad Fauzan
                'mapel_id' => 7, // ID mata pelajaran Fisika
                'kelas_id' => 3, // ID kelas X RPL A
            ],
            [
                'guru_id' => 6, // ID guru untuk Rini Yulianti
                'mapel_id' => 8, // ID mata pelajaran Kimia
                'kelas_id' => 1, // ID kelas XI TKJ A
            ],
            [
                'guru_id' => 2, // ID guru untuk Guru Baru
                'mapel_id' => 3, // ID mata pelajaran Pemrograman Grafis
                'kelas_id' => 3, // ID kelas X RPL A
            ],
            // Tambahkan guru mapel lain sesuai kebutuhan
        ]);
    }
}
