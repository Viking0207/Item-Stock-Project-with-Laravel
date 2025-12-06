<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CekStokController extends Controller
{
    public function cek($plu)
    {
        try {
            $prefix = substr($plu, 0, 2);

            $map = [
                '43' => ['Makanan', 'tb_makanan'],
                '44' => ['Bahan Masakan', 'tb_bahan_masakan'],
                '46' => ['Minuman', 'tb_minuman'],
                '47' => ['Kosmetik', 'tb_kosmetik'],
                '58' => ['Perabotan Rumah', 'tb_perabotan_rumah'],
                '59' => ['Barang Kebersihan', 'tb_pembersih'],
                '61' => ['Alat Tulis Kerja', 'tb_alat_tulis'],
                '63' => ['Obat-obatan', 'tb_obat'],
            ];

            if (!isset($map[$prefix])) {
                return response()->json([
                    'kategori' => 'Tidak diketahui',
                    'data' => []
                ]);
            }

            [$kategori, $tabel] = $map[$prefix];

            $data = DB::table($tabel)
                ->where('plu_barang', 'like', $prefix . '%')
                ->orderByRaw("plu_barang = ? DESC", [$plu])
                ->get([
                    'plu_barang as plu',
                    'nama_barang',
                    'total_quantity as stok'
                ]);

            return response()->json([
                'kategori' => $kategori,
                'data' => $data
            ]);

        } catch (\Throwable $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
