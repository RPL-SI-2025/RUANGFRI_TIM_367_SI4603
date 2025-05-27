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
    protected $primaryKey = 'id';
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




    public function pinjamInventaris()
    {
        return $this->hasMany(PinjamInventaris::class, 'id_mahasiswa');
    }



    public function laporInventaris()
    {
        return $this->hasMany(LaporInventaris::class, 'id_mahasiswa');
    }
}


?>
