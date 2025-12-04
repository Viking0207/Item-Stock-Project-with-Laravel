<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Stock;

class Kategori extends Model
{
    protected $table = 'tb_kategori';

    protected $fillable = [
        'nama_kategori', // contoh: Minuman, Snack
        'kode_awal',     // contoh: 46, 43, 44, dst (2 digit PLU)
    ];

    // 1 kategori bisa punya banyak stock barang
    public function stocks(): HasMany
    {
        return $this->hasMany(Stock::class, 'kategori_id');
    }
}
