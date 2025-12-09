<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Pengguna extends Authenticatable
{
    protected $table = 'pengguna';

    protected $fillable = [
        'email',
        'password',
        'role'
    ];

    // protected $hidden = [
    //     'password',
    // ];
}
