<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $tables = [
            'tb_alat_tulis',
            'tb_makanan',
            'tb_minuman',
            'tb_bahan_masakan',
            'tb_obat',
            'tb_kosmetik',
            'tb_perabotan_rumah',
            'tb_pembersih',
        ];

        foreach ($tables as $tabel) {

            if (!Schema::hasTable($tabel)) continue;

            if (
                !Schema::hasColumn($tabel, 'id') ||
                !Schema::hasColumn($tabel, 'plu_barang') ||
                !Schema::hasColumn($tabel, 'nama_barang')
            ) continue;

            $barang = DB::table($tabel)
                ->where('plu_barang', $plu)
                ->first();

            if (!$barang) continue;

            // ✅ AMBIL DARI BATCH (PER PCS)
            $batch = DB::table('batch_tb_makanan')
                ->where('plu_barang', $plu)
                ->where('quantity', '>', 0)
                ->orderBy('expired_date', 'asc')
                ->first();

            if (!$batch) {
                return response()->json([
                    'message' => 'Batch kosong / belum tersedia'
                ], 409);
            }

            return response()->json([
                'nama'  => $barang->nama_barang,
                'harga' => (int) $batch->price, // ✅ PER PCS
            ]);
        }

        return response()->json([
            'message' => 'Barang tidak ditemukan'
        ], 404);
    }
}
