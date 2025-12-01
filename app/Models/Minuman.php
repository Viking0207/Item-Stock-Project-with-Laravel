<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Minuman extends Model
{
    protected $table = 'tb_minuman';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(MinumanBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(MinumanBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
