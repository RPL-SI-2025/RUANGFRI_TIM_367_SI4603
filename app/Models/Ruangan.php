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

    public function jadwals()
    {
        return $this->hasMany(Jadwal::class, 'id_ruangan');
    }
    public function availableJadwals()
    {
        return $this->jadwals()->where('status', 'tersedia');
    }
}
