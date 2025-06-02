<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    use HasFactory;

    protected $table = 'pelaporans';
    protected $primaryKey = 'id_lapor_ruangan';

    protected $fillable = [
        'id_logistik',
        'id_mahasiswa',
        'id_ruangan', 
        'id_pinjam_ruangan',
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
    public function ruangan()
    {
        return $this->belongsTo(\App\Models\Ruangan::class, 'id_ruangan');
    }
    public function peminjaman()
    {
        return $this->belongsTo(PinjamRuangan::class, 'id_pinjam_ruangan');
    }
}