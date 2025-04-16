<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable; // <== kalau admin ini bisa login
use Illuminate\Notifications\Notifiable;


class AdminLogistik extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'admin_logistik';

    protected $fillable = [
        'nama',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
