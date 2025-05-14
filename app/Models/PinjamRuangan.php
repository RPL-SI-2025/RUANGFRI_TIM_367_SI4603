<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamRuangan extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam_ruangan';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_ruangan', 
        'id_mahasiswa', 
        'tanggal_pengajuan', 
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'tujuan_peminjaman',
        'file_scan',
        'status',
        'catatan'
    ];
    
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan', 'id');
    }
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id');
    }
    

    public function laporan()
    {
        return $this->hasOne(Pelaporan::class, 'id_peminjaman', 'id');
    }
    

    public function getStatusTextAttribute()
    {
        return match($this->status) {
            0 => 'Menunggu Persetujuan',
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Selesai',
            4 => 'Dibatalkan',
            default => 'Unknown'
        };
    }
}