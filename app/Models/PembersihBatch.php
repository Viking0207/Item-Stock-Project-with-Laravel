<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PembersihBatch extends Model
{
    protected $table = 'batch_tb_pembersih';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];

    public $timestamps = true;
    
    public function Pembersih()
    {
        return $this->belongsTo (Pembersih::class);
    }
    
}
