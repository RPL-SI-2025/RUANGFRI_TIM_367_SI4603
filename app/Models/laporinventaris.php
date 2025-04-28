<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporInventaris extends Model  // Gunakan PascalCase
{
    protected $table = 'lapor_inventaris';  // Nama tabel tetap menggunakan snake_case
    protected $primaryKey = 'id_lapor_inventaris';

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

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik');
    }
}

