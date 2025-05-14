<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';

    protected $fillable = [
        'nama_inventaris',
        'deskripsi',
        'jumlah',
        'status',
        'gambar_inventaris',
    ];


    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik');
    }


    public function peminjaman()
    {
        return $this->hasMany(PinjamInventaris::class, 'id_inventaris');
    }

}
