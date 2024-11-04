<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'tbl_presensi';

    protected $fillable = [
        'siswa_id',
        'tanggal',
        'jenis_presensi',
        'status',
        'tepat_waktu',
        'jam_masuk',
        'jam_keluar',
        'mapel_id',
        'lokasi',
        'foto_selfie',
        'jadwal_mapel_id',
        'jadwal_masuk_id', // Ditambahkan ke fillable
        'izin_id',
    ];

    // Relasi ke tabel siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi ke tabel mata pelajaran (jika presensi terkait pelajaran)
    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id');
    }

    // Relasi ke tabel jadwal pelajaran (jika presensi terkait jadwal pelajaran)
    public function jadwalMapel()
    {
        return $this->belongsTo(JadwalMapel::class, 'jadwal_mapel_id');
    }

    // Relasi ke tabel izin (jika presensi terkait dengan izin)
    public function izin()
    {
        return $this->belongsTo(Izin::class);
    }

    // Relasi ke tabel jadwal masuk (jika presensi terkait dengan presensi harian masuk/pulang)
    public function jadwalMasuk()
    {
        return $this->belongsTo(JadwalMasuk::class, 'jadwal_masuk_id');
    }
}
