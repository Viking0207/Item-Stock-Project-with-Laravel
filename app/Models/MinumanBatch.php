<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MinumanBatch extends Model
{
    protected $table = 'batch_tb_minuman';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];

    public $timestamps = true;
    
    public function Minuman()
    {
        return $this->belongsTo (Minuman::class);
    }
    
}
