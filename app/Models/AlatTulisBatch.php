<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatTulisBatch extends Model
{
    protected $table = 'batch_tb_alat_tulis';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];
    
    public function Alat_tulis()
    {
        return $this->belongsTo (Alat_tulis::class);
    }
    
}
