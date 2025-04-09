<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pelaporan extends Model
{
    protected $fillable = ['oleh', 'kepada', 'tanggal', 'waktu'];

}
