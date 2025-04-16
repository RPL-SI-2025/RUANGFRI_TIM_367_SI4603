<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusPeminjaman extends Model
{
    use HasFactory;

    protected $table = 'status_peminjaman';

    protected $fillable = [
        'id_pinjam_ruangan',
        'id_pinjam_inventaris',
        'id_mahasiswa',
        'id_logistik',
        'jenis_peminjaman',
        'status_approval',
        'tanggal_dikirim',
        'tanggal_diapprove',
    ];

    // Relasi ke mahasiswa
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa');
    }

    // Relasi ke admin logistik
    public function logistik()
    {
        return $this->belongsTo(AdminLogistik::class, 'id_logistik');
    }

    // Relasi ke pinjam ruangan
    public function pinjamRuangan()
    {
        return $this->belongsTo(PinjamRuangan::class, 'id_pinjam_ruangan');
    }

    // Relasi ke pinjam inventaris
    public function pinjamInventaris()
    {
        return $this->belongsTo(PinjamInventaris::class, 'id_pinjam_inventaris');
    }
}
