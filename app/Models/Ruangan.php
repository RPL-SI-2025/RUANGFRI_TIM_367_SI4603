<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';


    protected $fillable = [
        'id_logistik',
        'nama_ruangan',
        'kapasitas',
        'fasilitas',
        'lokasi',
        'status',
        'gambar'
    ];
}
