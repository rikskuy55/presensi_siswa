<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory;

    protected $table = 'tbl_mata_pelajaran';

    protected $fillable = [
        'nama_mata_pelajaran',
    ];

    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function jadwalMapel()
    {
        return $this->hasMany(JadwalMapel::class);
    }
}
