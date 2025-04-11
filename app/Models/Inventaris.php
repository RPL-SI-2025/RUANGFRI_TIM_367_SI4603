<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris';
    protected $primaryKey = 'id'; 
    protected $fillable = [
        'id_logistik',
        'nama_inventaris',
        'deskripsi',
        'jumlah',
        'status'
    ];
}
