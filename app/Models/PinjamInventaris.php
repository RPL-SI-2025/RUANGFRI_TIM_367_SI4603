<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PinjamInventaris extends Model
{
    use HasFactory;
    
    protected $table = 'pinjam_inventaris';
    protected $primaryKey = 'id_pimjam_inventaris';
    
    protected $fillable = [
        'id_inventaris', 
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
        switch($this->status) {
            case 0:
                return 'Menunggu Persetujuan';
            case 1:
                return 'Disetujui';
            case 2:
                return 'Ditolak';
            case 3:
                return 'Selesai';
            default:
                return 'Unknown';
        }
    }
}