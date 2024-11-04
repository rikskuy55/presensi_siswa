<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuruMapel extends Model
{
    use HasFactory;

    protected $table = 'tbl_guru_mapel';

    protected $fillable = [
        'guru_id',
        'mapel_id',
        'kelas_id',
    ];

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mapel_id'); // Ensure the foreign key is correct
    }    

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function jadwalMapel()
    {
        return $this->hasMany(JadwalMapel::class, 'guru_mapel_id');
    }
}
