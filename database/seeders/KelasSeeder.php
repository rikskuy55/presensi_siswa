<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KelasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_kelas')->insert([
            [
                'nama_kelas' => 'XI TKJ A',
                'jurusan' => 'Teknik Komputer dan Jaringan',
                'wali_kelas_id' => 3, // ID guru wali kelas
            ],
            [
                'nama_kelas' => 'XII MM B',
                'jurusan' => 'Multimedia',
                'wali_kelas_id' => 4, // ID guru wali kelas
            ],
            [
                'nama_kelas' => 'X RPL A',
                'jurusan' => 'Rekayasa Perangkat Lunak',
                'wali_kelas_id' => 5, // ID guru wali kelas
            ],
            // Tambahkan kelas lain sesuai kebutuhan
        ]);
    }
}
