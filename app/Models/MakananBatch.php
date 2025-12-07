<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MakananBatch extends Model
{
    protected $table = 'batch_tb_makanan';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];

    public $timestamps = true;

    public function makanan()
    {
        return $this->belongsTo(Makanan::class, 'barang_id', 'id');
    }
}
