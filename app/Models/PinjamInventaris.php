<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamInventaris extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam_inventaris';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'id_inventaris', 
        'jumlah_pinjam',
        'id_mahasiswa', 
        'tanggal_pengajuan', 
        'tanggal_selesai',
        'waktu_mulai',
        'waktu_selesai',
        'file_scan',
        'status'
    ];
    
    public function inventaris()
    {
        return $this->belongsTo(Inventaris::class, 'id_inventaris', 'id');
    }
    
    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'id_mahasiswa', 'id');
    }
    
    // Helper untuk status
    public function getStatusTextAttribute()
    {
        return match($this->status) {
            0 => 'Menunggu Persetujuan',
            1 => 'Disetujui',
            2 => 'Ditolak',
            3 => 'Selesai',
            default => 'Unknown'
        };
    }
}