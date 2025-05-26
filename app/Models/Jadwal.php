<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jadwal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_ruangan',
        'id_pinjam_ruangan',
        'tanggal',
        'jam_mulai',
        'jam_selesai',
        'status'
    ];

    /**
     * Get the ruangan that owns the jadwal.
     */
    public function ruangan()
    {
        return $this->belongsTo(Ruangan::class, 'id_ruangan');
    }

    /**
     * Get the pinjam ruangan record associated with the jadwal.
     */
    public function pinjamRuangan()
    {
        return $this->belongsTo(PinjamRuangan::class, 'id_pinjam_ruangan');
    }
    
    /**
     * Scope a query to only include available jadwals.
     */
    public function scopeTersedia($query)
    {
        return $query->where('status', 'tersedia');
    }
    
    /**
     * Scope a query to only include processing jadwals.
     */
    public function scopeProses($query)
    {
        return $query->where('status', 'proses');
    }
    
    /**
     * Scope a query to only include booked jadwals.
     */
    public function scopeBooked($query)
    {
        return $query->where('status', 'booked');
    }
    
    /**
     * Scope a query to filter by date range.
     */
    public function scopeDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('tanggal', [$startDate, $endDate]);
    }
}