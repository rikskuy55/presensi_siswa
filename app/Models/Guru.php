<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    protected $table = 'tbl_guru';

    protected $fillable = [
        'user_id',
        'nip',
        'nama_guru',
        'jenis_kelamin',
        'tanggal_lahir',
        'alamat',
        'foto',
        'spesialisasi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kelas()
    {
        return $this->hasMany(Kelas::class, 'wali_kelas_id');
    }

    public function guruMapel()
    {
        return $this->hasMany(GuruMapel::class);
    }

    public function izin()
    {
        return $this->hasMany(Izin::class);
    }

    public function kelasWali()
    {
        return $this->hasOne(Kelas::class, 'wali_kelas_id');  // Relasi dengan kelas sebagai wali
    }

    public function mapel()
    {
        return $this->hasManyThrough(
            MataPelajaran::class,  // Model target
            GuruMapel::class,      // Model penghubung
            'guru_id',             // Foreign key di tabel GuruMapel yang menghubungkan ke Guru
            'id',                  // Primary key di tabel MataPelajaran
            'id',                  // Primary key di tabel Guru
            'mapel_id'             // Foreign key di tabel GuruMapel yang menghubungkan ke MataPelajaran
        );
    }

    public function kelasMengajar()
    {
        return $this->hasManyThrough(
            Kelas::class,
            GuruMapel::class,
            'guru_id',        // Foreign key di GuruMapel yang mengarah ke Guru
            'id',             // Primary key di Kelas
            'id',             // Primary key di Guru
            'kelas_id'        // Foreign key di GuruMapel yang mengarah ke Kelas
        );
    }
}
