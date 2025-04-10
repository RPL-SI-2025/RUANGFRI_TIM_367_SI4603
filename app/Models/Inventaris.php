<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris'; // pastikan tabel
    protected $primaryKey = 'id_inventaris'; // inilah solusinya

    // Jika kamu tidak pakai kolom 'id' default
    public $incrementing = true;
    protected $keyType = 'int';
}
