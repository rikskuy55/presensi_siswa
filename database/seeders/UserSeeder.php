<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Andi Saputra',
                'username' => 'andi_saputra',
                'email' => 'andi_saputra@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'no_telp' => '082134567890',
            ],
            [
                'name' => 'Dewi Kartika',
                'username' => 'dewi_kartika',
                'email' => 'dewi_kartika@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'no_telp' => '081245678902',
            ],
            [
                'name' => 'Ahmad Fauzan',
                'username' => 'ahmad_fauzan',
                'email' => 'ahmad_fauzan@gmail.com',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'no_telp' => '085678901234',
            ],
            [
                'name' => 'Rini Yulianti',
                'username' => 'rini_yulianti',
                'email' => 'rini_yulianti@example.com',
                'password' => bcrypt('password'),
                'role' => 'guru',
                'is_active' => true,
                'no_telp' => '085712345678',
            ],
            [
                'name' => 'Bayu Pratama',
                'username' => 'bayu_pratama',
                'email' => 'bayu_pratama@example.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'is_active' => true,
                'no_telp' => '081234567890',
            ],
            [
                'name' => 'Citra Melinda',
                'username' => 'citra_melinda',
                'email' => 'citra_melinda@example.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'is_active' => true,
                'no_telp' => '085612345678',
            ],
            [
                'name' => 'Doni Setiawan',
                'username' => 'doni_setiawan',
                'email' => 'doni_setiawan@example.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'is_active' => true,
                'no_telp' => '085234567891',
            ],
            [
                'name' => 'Erika Ramadhani',
                'username' => 'erika_ramadhani',
                'email' => 'erika_ramadhani@example.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'is_active' => true,
                'no_telp' => '085345678902',
            ],
            [
                'name' => 'Fajar Hidayat',
                'username' => 'fajar_hidayat',
                'email' => 'fajar_hidayat@example.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'is_active' => true,
                'no_telp' => '081356789012',
            ],
            [
                'name' => 'Gita Salsabila',
                'username' => 'gita_salsabila',
                'email' => 'gita_salsabila@example.com',
                'password' => bcrypt('password'),
                'role' => 'siswa',
                'is_active' => true,
                'no_telp' => '085467890123',
            ],
        ]);
    }
}
