<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Makanan extends Model
{
    protected $table = 'tb_makanan';

    protected $fillable = [
        'plu_barang',
        'nama_barang',
        'total_quantity',
        'harga_terakhir'
    ];

    public function batches()
    {
        return $this->hasMany(MakananBatch::class, 'barang_id', 'id');
    }

    public function activeBatches()
    {
        return $this->hasMany(MakananBatch::class, 'barang_id', 'id')
                    ->where('quantity', '>', 0);
    }
}
