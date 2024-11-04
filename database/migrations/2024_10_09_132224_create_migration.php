<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {

        // Tabel tbl_mata_pelajaran dapat dibuat setelah tabel users
        Schema::create('tbl_mata_pelajaran', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mata_pelajaran');
            $table->timestamps();
        });

        // Tabel tbl_guru tergantung pada tabel users
        Schema::create('tbl_guru', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nip')->unique();
            $table->string('nama_guru');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->string('foto')->nullable();
            $table->string('spesialisasi')->nullable();
            $table->timestamps();
        });

        // Tabel tbl_kelas tergantung pada tabel tbl_guru
        Schema::create('tbl_kelas', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kelas');
            $table->string('jurusan');
            $table->foreignId('wali_kelas_id')->constrained('tbl_guru');
            $table->timestamps();
        });

        // Tabel tbl_siswa tergantung pada tabel users dan tbl_kelas
        Schema::create('tbl_siswa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('nisn')->unique();
            $table->string('nama_siswa');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->date('tanggal_lahir');
            $table->string('alamat');
            $table->foreignId('kelas_id')->constrained('tbl_kelas');
            $table->string('foto')->nullable();
            $table->timestamps();
        });

        // Tabel tbl_guru_mapel tergantung pada tabel tbl_guru, tbl_mata_pelajaran, dan tbl_kelas
        Schema::create('tbl_guru_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('tbl_guru');
            $table->foreignId('mapel_id')->constrained('tbl_mata_pelajaran');
            $table->foreignId('kelas_id')->constrained('tbl_kelas');
            $table->timestamps();
        });

        // Tabel tbl_jadwal_masuk
        Schema::create('tbl_jadwal_masuk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kelas_id')->constrained('tbl_kelas'); // Kelas yang memiliki jadwal masuk
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']); // Hanya kolom hari
            $table->time('jam_masuk')->nullable(); // Jam masuk
            $table->time('jam_keluar')->nullable(); // Jam keluar
            $table->timestamps();
        });

        // Tabel tbl_jadwal_mapel tergantung pada tbl_kelas dan tbl_guru_mapel
        Schema::create('tbl_jadwal_mapel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_mapel_id')->constrained('tbl_guru_mapel');
            $table->enum('hari', ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat']);
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });

        // Tabel tbl_izin tergantung pada tabel tbl_siswa dan tbl_guru
        Schema::create('tbl_izin', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('tbl_siswa');
            $table->foreignId('guru_id')->constrained('tbl_guru');
            $table->date('tanggal_izin'); // Kolom baru untuk mencatat tanggal izin
            $table->enum('jenis_izin', ['sakit', 'izin', 'lainnya']);
            $table->text('keterangan');
            $table->string('foto_bukti')->nullable();
            $table->enum('status', ['menunggu', 'disetujui', 'ditolak']);
            $table->timestamps();
        });

        // Tabel tbl_presensi tergantung pada tabel tbl_siswa, tbl_mata_pelajaran, tbl_jadwal_mapel, dan tbl_izin
        Schema::create('tbl_presensi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('siswa_id')->constrained('tbl_siswa');
            $table->date('tanggal');
            $table->enum('jenis_presensi', ['harian', 'pelajaran']);
            $table->enum('status', ['hadir', 'izin', 'sakit', 'alpa']);
            $table->boolean('tepat_waktu');
            $table->time('jam_masuk')->nullable();
            $table->time('jam_keluar')->nullable();
            $table->foreignId('mapel_id')->nullable()->constrained('tbl_mata_pelajaran');
            $table->string('lokasi_masuk')->nullable(); // Lokasi saat masuk
            $table->string('lokasi_keluar')->nullable(); // Lokasi saat keluar
            $table->longText('foto_selfie_masuk')->nullable(); // Foto selfie saat masuk
            $table->longText('foto_selfie_keluar')->nullable(); // Foto selfie saat keluar
            $table->foreignId('jadwal_mapel_id')->nullable()->constrained('tbl_jadwal_mapel');
            $table->foreignId('jadwal_masuk_id')->nullable()->constrained('tbl_jadwal_masuk'); 
            $table->foreignId('izin_id')->nullable()->constrained('tbl_izin'); 
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('tbl_izin');
        Schema::dropIfExists('tbl_presensi');
        Schema::dropIfExists('tbl_jadwal_mapel');
        Schema::dropIfExists('tbl_jadwal_masuk');
        Schema::dropIfExists('tbl_mata_pelajaran');
        Schema::dropIfExists('tbl_siswa');
        Schema::dropIfExists('tbl_guru');
        Schema::dropIfExists('tbl_kelas');
    }
};
