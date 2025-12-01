<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Obat extends Model
{
    protected $table = 'tb_Obat';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(ObatBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(ObatBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
