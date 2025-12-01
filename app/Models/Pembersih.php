<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembersih extends Model
{
    protected $table = 'tb_pembersih';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(PembersihBatch::class);
    }

    public function activeBatches()
    {
        return $this->hasMany(PembersihBatch::class)
                    ->where('quantity', '>', 0);    
    }   
}
