<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporinventaris extends Model
{
    protected $table = 'laporinventaris';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_logistik',
        'id_mahasiswa',
        'datetime',
        'foto_awal',
        'foto_akhir',
        'deskripsi',
        'oleh',
        'kepada'
    ];

    // Relasi ke Mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    // Relasi ke AdminLogistik
    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik');
    }
}


