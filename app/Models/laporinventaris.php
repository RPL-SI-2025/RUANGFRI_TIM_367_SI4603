<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class laporinventaris extends Model
{
    protected $table = 'lapor_inventaris';  
    protected $primaryKey = 'id_lapor_inventaris';

    protected $fillable = [
        'id_logistik',
        'id_mahasiswa',
        'id_pinjam_inventaris',
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
    
    public function peminjaman()
    {
        return $this->belongsTo(PinjamInventaris::class, 'id_pinjam_inventaris');
    }
}