<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    protected $fillable = [
        'id_logistik',
        'nama_inventaris',
        'deskripsi',
        'jumlah',
        'status',
    ];

    // Relasi ke AdminLogistik
    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik');
    }

    // Relasi ke pinjam_inventaris
    public function peminjaman()
    {
        return $this->hasMany(PinjamInventaris::class, 'id_inventaris');
    }

    // Relasi ke laporan inventaris
    // public function laporan()
    // {
    //     return $this->hasMany(LaporInventaris::class, 'id_inventaris');
    // }
}
