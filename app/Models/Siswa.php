<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'tbl_siswa';

    protected $fillable = [
        'user_id',
        'nisn',
        'nama_siswa',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'kelas_id',
        'foto',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id'); // Assumes `kelas_id` is the foreign key in `tbl_siswa`
    }

    public function izin()
    {
        return $this->hasMany(Izin::class);
    }

    public function presensi()
    {
        return $this->hasMany(Presensi::class);
    }

    public function presensiHarian()
    {
        return $this->hasMany(Presensi::class)->where('jenis_presensi', 'harian');
    }
}
