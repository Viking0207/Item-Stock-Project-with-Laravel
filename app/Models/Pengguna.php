<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\user as Authenticatable;

class Pengguna extends Authenticatable  
{
    protected $table = 'pengguna';
    
    protected $fillable = [
        'email',
        'password',
        'role'
    ];

    protected $hidden = [
        'password',
    ];
}
