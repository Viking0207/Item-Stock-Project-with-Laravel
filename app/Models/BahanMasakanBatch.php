<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BahanMasakanBatch extends Model
{
    protected $table = 'batch_tb_bahan_masakan';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];

    public $timestamps = true;
    
    public function Bahan_Masakan()
    {
        return $this->belongsTo (Bahan_Masakan::class);
    }
    
}
