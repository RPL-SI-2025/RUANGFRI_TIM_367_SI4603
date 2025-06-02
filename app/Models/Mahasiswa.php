<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Mahasiswa extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'email',
        'tempat_lahir',
        'tanggal_lahir',
        'no_telepon',
        'wa',
        'alamat',
        'angkatan',
        'tujuan',
        'instansi',
        'profile_photo',
        'ktm',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relationships
    public function pinjamRuangan()
    {
        return $this->hasMany(PinjamRuangan::class, 'id_mahasiswa');
    }

    public function pinjamInventaris()
    {
        return $this->hasMany(PinjamInventaris::class, 'id_mahasiswa');
    }

    // Relasi ke status peminjaman
    public function statusPeminjaman()
    {
        return $this->hasMany(StatusPeminjaman::class, 'id_mahasiswa');
    }

    // Relasi ke laporan ruangan
    public function laporanRuangan()
    {
        return $this->hasMany(LaporanRuangan::class, 'id_mahasiswa');
    }

    // Relasi ke lapor inventaris
    public function laporInventaris()
    {
        return $this->hasMany(LaporInventaris::class, 'id_mahasiswa');
    }
}
