<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalRuangan extends Model
{
    //
    protected $table = "jadwal_ruangan";
    protected $primaryKey = "id";
    protected $fillable = [
        'id_ruangan',
        'tanggal_pengajuan',
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'file_scan',
        'status',
    ];
}
