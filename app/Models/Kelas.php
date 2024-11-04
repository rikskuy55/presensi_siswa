<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'tbl_kelas';

    protected $fillable = [
        'nama_kelas',
        'jurusan',
        'wali_kelas_id',
    ];

    public function guruWaliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');
    }

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id');  // Daftar siswa di kelas ini
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class);
    }

    public function jadwalMasuk()
    {
        return $this->hasMany(JadwalMasuk::class);
    }

    public function jadwalMapel()
    {
        return $this->hasMany(JadwalMapel::class);
    }

    public function waliKelas()
    {
        return $this->belongsTo(Guru::class, 'wali_kelas_id');  // Wali kelas untuk kelas ini
    }

    // Tambahkan relasi mataPelajaran untuk mengakses mata pelajaran yang diajar di kelas ini
    public function mataPelajaran()
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            GuruMapel::class,
            'kelas_id',       // Foreign key di GuruMapel yang mengarah ke Kelas
            'id',             // Primary key di MataPelajaran
            'id',             // Primary key di Kelas
            'mapel_id'        // Foreign key di GuruMapel yang mengarah ke MataPelajaran
        )->select([
            'tbl_mata_pelajaran.id as mata_pelajaran_id',   // Alias untuk menghindari ambiguitas
            'tbl_mata_pelajaran.nama_mata_pelajaran',
            'tbl_guru_mapel.kelas_id as laravel_through_key'
        ]);
    }

    public function mataPelajaranTerkait($guruId)
    {
        return $this->hasManyThrough(
            MataPelajaran::class,
            GuruMapel::class,
            'kelas_id',       // Foreign key di GuruMapel yang mengarah ke Kelas
            'id',             // Primary key di MataPelajaran
            'id',             // Primary key di Kelas
            'mapel_id'        // Foreign key di GuruMapel yang mengarah ke MataPelajaran
        )->where('guru_id', $guruId)
            ->select([
                'tbl_mata_pelajaran.id as mata_pelajaran_id',
                'tbl_mata_pelajaran.nama_mata_pelajaran',
                'tbl_guru_mapel.kelas_id as laravel_through_key'
            ]);
    }
}
