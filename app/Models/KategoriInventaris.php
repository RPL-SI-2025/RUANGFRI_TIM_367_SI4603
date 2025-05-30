<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriInventaris extends Model
{
    use HasFactory;

    protected $table = 'kategori_inventaris';

    protected $fillable = [
        'nama_kategori',
        'deskripsi_kategori'
    ];

    public function inventaris()
    {
        return $this->hasMany(Inventaris::class, 'kategori_id');
    }
}