<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminLogistik extends Model
{
    protected $table = 'admin_logistik';

    protected $fillable = [
        'id_logistik',
        'nama',
        'email',
        'password'
    ];
}
