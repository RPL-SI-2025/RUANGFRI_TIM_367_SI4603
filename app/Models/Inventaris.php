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
        'kategori_id',
        'deskripsi',
        'jumlah',
        'status',
        'gambar_inventaris',
        'id_logistik'
    ];


    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik');
    }

    public function kategori()
    {
        return $this->belongsTo(KategoriInventaris::class, 'kategori_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(PinjamInventaris::class, 'id_inventaris');
    }

     public function laporan()
    {
        return $this->hasMany(LaporInventaris::class, 'id_inventaris');
    }

}
