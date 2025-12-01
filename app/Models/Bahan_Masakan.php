<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bahan_Masakan extends Model
{
    protected $table = 'tb_bahan_masakan';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(BahanMasakanBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(BahanMasakanBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
