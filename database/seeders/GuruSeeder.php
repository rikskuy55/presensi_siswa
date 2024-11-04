<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_guru')->insert([
            [
                'user_id' => 6, // ID user untuk Andi Saputra
                'nip' => '1980010123456789',
                'nama_guru' => 'Andi Saputra',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '1980-01-01',
                'alamat' => 'Jalan Merdeka No.12',
                'spesialisasi' => 'Matematika',
            ],
            [
                'user_id' => 7, // ID user untuk Dewi Kartika
                'nip' => '1990050812345678',
                'nama_guru' => 'Dewi Kartika',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1990-05-08',
                'alamat' => 'Jalan Melati No.3',
                'spesialisasi' => 'Bahasa Indonesia',
            ],
            [
                'user_id' => 8, // ID user untuk Ahmad Fauzan
                'nip' => '1985111212345678',
                'nama_guru' => 'Ahmad Fauzan',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '1985-11-12',
                'alamat' => 'Jalan Cempaka No.8',
                'spesialisasi' => 'Fisika',
            ],
            [
                'user_id' => 9, // ID user untuk Rini Yulianti
                'nip' => '1978090912345678',
                'nama_guru' => 'Rini Yulianti',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '1978-09-09',
                'alamat' => 'Jalan Anggrek No.5',
                'spesialisasi' => 'Kimia',
            ],
            // Tambahkan guru lain sesuai kebutuhan
        ]);
    }
}
