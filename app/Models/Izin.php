<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;

    protected $table = 'tbl_izin';

    protected $fillable = [
        'siswa_id',
        'guru_id',
        'tanggal_izin',
        'jenis_izin',
        'keterangan',
        'foto_bukti',
        'status',
        'jadwal_mapel_id', // Tambahkan jadwal_mapel_id di sini
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function jadwalMapel()
    {
        return $this->belongsTo(JadwalMapel::class, 'jadwal_mapel_id');
    }
}
