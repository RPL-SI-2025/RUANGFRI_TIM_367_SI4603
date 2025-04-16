<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    protected $primaryKey = 'id_lapor_ruangan';

    protected $fillable = [
    'id_mahasiswa',
    'id_logistik',
    'datetime',
    'foto_awal',
    'foto_akhir',
    'deskripsi',
    'oleh',
    'kepada'
    ];
}
