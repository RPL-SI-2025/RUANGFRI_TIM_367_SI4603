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

    public function pelaporan()
    {
        return $this->hasMany(Pelaporan::class, 'id_mahasiswa');
    }
}

