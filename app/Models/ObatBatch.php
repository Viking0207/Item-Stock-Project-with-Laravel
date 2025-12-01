<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObatBatch extends Model
{
    protected $table = 'batch_tb_obat';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];
    
    public function Obat()
    {
        return $this->belongsTo (Obat::class);
    }
    
}
