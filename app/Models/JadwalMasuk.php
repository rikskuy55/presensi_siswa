<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMasuk extends Model
{
    use HasFactory;

    protected $table = 'tbl_jadwal_masuk';

    protected $fillable = [
        'kelas_id',
        'hari',
        'jam_masuk',
        'jam_keluar',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class, 'jadwal_masuk_id');
    }
}
