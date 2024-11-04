<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MataPelajaranSeeder extends Seeder
{
    public function run()
    {
        DB::table('tbl_mata_pelajaran')->insert([
            ['nama_mata_pelajaran' => 'Informatika'],
            ['nama_mata_pelajaran' => 'Pemrograman Web'],
            ['nama_mata_pelajaran' => 'Pemrograman Grafis'],
            ['nama_mata_pelajaran' => 'Pemrograman Perangkat Bergerak'],
            ['nama_mata_pelajaran' => 'Basis Data'],
            ['nama_mata_pelajaran' => 'Matematika'],
            ['nama_mata_pelajaran' => 'Pendidikan Agama Islam'],
            ['nama_mata_pelajaran' => 'Bahasa Inggris'],
            ['nama_mata_pelajaran' => 'Pendidikan Pancasila dan Kewarganegaraan'],
            ['nama_mata_pelajaran' => 'Projek Kreatif dan Kewirausahaan'],
            ['nama_mata_pelajaran' => 'Bahasa Sunda'],
            ['nama_mata_pelajaran' => 'Bahasa Indonesia'],
            ['nama_mata_pelajaran' => 'Desain Grafis'],
            // Tambahkan mata pelajaran lain sesuai kebutuhan
        ]);
    }
}
