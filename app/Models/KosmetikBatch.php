<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KosmetikBatch extends Model
{
    protected $table = 'batch_tb_kosmetik';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];
    
    public function Kosmetik()
    {
        return $this->belongsTo (Kosmetik::class);
    }
    
}
