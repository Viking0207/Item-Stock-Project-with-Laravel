<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DiscountController extends Controller
{
    public function index()
    {
        return view('Karyawan.Discount_page');
    }

    public function cariBarang($plu)
    {
        $map = [
            'tb_makanan'           => 'batch_tb_makanan',
            'tb_minuman'           => 'batch_tb_minuman',
            'tb_bahan_masakan'     => 'batch_tb_bahan_masakan',
            'tb_obat'              => 'batch_tb_obat',
            'tb_kosmetik'          => 'batch_tb_kosmetik',
            'tb_perabotan_rumah'   => 'batch_tb_perabotan_rumah',
            'tb_pembersih'         => 'batch_tb_pembersih',
            'tb_alat_tulis'        => 'batch_tb_alat_tulis',
        ];

        foreach ($map as $tabel => $batchTable) {

            if (!Schema::hasTable($tabel) || !Schema::hasTable($batchTable)) {
                continue;
            }

            $barang = DB::table($tabel)
                ->where('plu_barang', $plu)
                ->first();

            if (!$barang) continue;

            $batch = DB::table($batchTable)
                ->where('plu_barang', $plu)
                ->where('quantity', '>', 0)
                ->orderBy('expired_date', 'asc')
                ->first();

            if (!$batch) {
                return response()->json([
                    'message' => 'Stok batch habis'
                ], 409);
            }

            return response()->json([
                'nama'  => $barang->nama_barang,
                'harga' => (int) $batch->price
            ]);
        }

        return response()->json([
            'message' => 'Barang tidak ditemukan'
        ], 404);
    }
}
