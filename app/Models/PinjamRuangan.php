<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PinjamRuangan extends Model
{
    //
    protected $table = 'pinjam_ruangan';
    protected $primaryKey = 'id_pinjam_ruangan';

    protected $fillable = [
        'id_ruangan',
        'id_mahasiswa',
        'id_jadwal',
        'id_logistik',
        'tanggal_pengajuan',
        'tanggal_mulai',
        'tanggal_selesai',
        'waktu_selesai',
        'waktu_mulai',
        'file_scan',
        'note'
    ];
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id');
    }
    public function jadwal()
    {
        return $this->belongsTo(JadwalRuangan::class, 'id_jadwal', 'id');
    }
    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik', 'id');
    }
}
