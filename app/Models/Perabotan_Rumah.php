<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Perabotan_Rumah extends Model
{
    protected $table = 'tb_perabotan_rumah';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(PerabotanRumahBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(PerabotanRumahBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
