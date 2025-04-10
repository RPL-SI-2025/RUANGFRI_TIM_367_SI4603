<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruangan extends Model
{
    protected $table = 'ruangan';

    protected $fillable = [
        'nama_ruangan',
        'kapasitas',
        'fasilitas',
        'lokasi',
        'status',
        'gambar'
    ];
}
