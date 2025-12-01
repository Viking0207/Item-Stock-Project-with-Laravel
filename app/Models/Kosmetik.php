<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kosmetik extends Model
{
    protected $table = 'tb_kosmetik';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(KosmetikBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(KosmetikBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
