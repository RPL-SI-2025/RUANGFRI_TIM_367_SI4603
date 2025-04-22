<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_mahasiswa',
        'id_logistik',
        'datetime',
        'deskripsi',
        'oleh',
        'kepada',
        'foto_awal',
        'foto_akhir',
    ];
}
