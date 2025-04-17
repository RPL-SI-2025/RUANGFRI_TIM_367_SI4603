<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Authenticatable
{

    use HasFactory, Notifiable;

    protected $table = 'mahasiswa';

    protected $fillable = [
        'nim',
        'nama_mahasiswa',
        'email',
        'password',
    ];

    protected $hidden = ['password'];

    // Relasi ke pinjam ruangan
    public function pinjamRuangan()
    {
        return $this->hasMany(PinjamRuangan::class, 'id_mahasiswa');
    }

    // Relasi ke pinjam inventaris
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

    //protected $table = 'mahasiswa';?
// protected $primaryKey = 'id';
// protected $fillable = [
//     'name',
//     'email',
//     'phone',
//     'address'
// ];



?>
