<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alat_tulis extends Model
{
    protected $table = 'tb_alat_tulis';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(AlatTulisBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(AlatTulisBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
