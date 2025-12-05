<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerabotanRumahBatch extends Model
{
    protected $table = 'batch_tb_perabotan_rumah';

    protected $fillable = [
        'barang_id',
        'plu_barang',
        'expired_date',
        'price',
        'quantity',
    ];

    public $timestamps = true;
    
    public function Perabotan_Rumah()
    {
        return $this->belongsTo (Perabotan_Rumah::class);
    }
    
}
