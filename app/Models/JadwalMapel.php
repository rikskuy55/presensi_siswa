<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalMapel extends Model
{
    use HasFactory;

    protected $table = 'tbl_jadwal_mapel';

    protected $fillable = [
        'guru_mapel_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
    ];

    public function kelas()
    {
        return $this->hasOneThrough(Kelas::class, GuruMapel::class, 'id', 'id', 'guru_mapel_id', 'kelas_id');
    }

    public function guruMapel()
    {
        return $this->belongsTo(GuruMapel::class, 'guru_mapel_id');
    }

    public function izin()
    {
        return $this->hasMany(Izin::class, 'jadwal_mapel_id');
    }
}
