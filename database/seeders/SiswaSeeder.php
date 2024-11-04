<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tbl_siswa')->insert([
            [
                'user_id' => 10, // ID user untuk Bayu Pratama
                'nisn' => '0056781234',
                'nama_siswa' => 'Bayu Pratama',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2005-02-15',
                'alamat' => 'Jalan Pramuka No.10',
                'kelas_id' => 3, // ID kelas
            ],
            [
                'user_id' => 11, // ID user untuk Citra Melinda
                'nisn' => '0067894321',
                'nama_siswa' => 'Citra Melinda',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2005-03-25',
                'alamat' => 'Jalan Melati No.5',
                'kelas_id' => 4, // ID kelas
            ],
            [
                'user_id' => 12, // ID user untuk Doni Setiawan
                'nisn' => '0076541234',
                'nama_siswa' => 'Doni Setiawan',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2005-05-10',
                'alamat' => 'Jalan Merdeka No.8',
                'kelas_id' => 5, // ID kelas
            ],
            [
                'user_id' => 13, // ID user untuk Erika Ramadhani
                'nisn' => '0087123456',
                'nama_siswa' => 'Erika Ramadhani',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2005-07-19',
                'alamat' => 'Jalan Anggrek No.7',
                'kelas_id' => 3, // ID kelas
            ],
            [
                'user_id' => 14, // ID user untuk Fajar Hidayat
                'nisn' => '0098912345',
                'nama_siswa' => 'Fajar Hidayat',
                'jenis_kelamin' => 'Laki-Laki',
                'tanggal_lahir' => '2005-09-10',
                'alamat' => 'Jalan Cempaka No.9',
                'kelas_id' => 2, // ID kelas
            ],
            [
                'user_id' => 15, // ID user untuk Gita Salsabila
                'nisn' => '0012345678',
                'nama_siswa' => 'Gita Salsabila',
                'jenis_kelamin' => 'Perempuan',
                'tanggal_lahir' => '2005-11-22',
                'alamat' => 'Jalan Mawar No.3',
                'kelas_id' => 1, // ID kelas
            ],
            // Tambahkan siswa lain sesuai kebutuhan
        ]);
    }
}
