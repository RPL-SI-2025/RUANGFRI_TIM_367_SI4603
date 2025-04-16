<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mahasiswa extends Model
{
    //protected $table = 'mahasiswa';
protected $primaryKey = 'id';
protected $fillable = [
    'name',
    'email',
    'phone',
    'address'
];


}
