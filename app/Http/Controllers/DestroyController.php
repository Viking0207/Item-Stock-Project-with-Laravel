<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Models utama & batch
use App\Models\Makanan;
use App\Models\MakananBatch;
use App\Models\Bahan_Masakan;
use App\Models\BahanMasakanBatch;
use App\Models\Minuman;
use App\Models\MinumanBatch;
use App\Models\Kosmetik;
use App\Models\KosmetikBatch;
use App\Models\Perabotan_Rumah;
use App\Models\PerabotanRumahBatch;
use App\Models\Pembersih;
use App\Models\PembersihBatch;
use App\Models\Alat_Tulis;
use App\Models\AlatTulisBatch;
use App\Models\Obat;
use App\Models\ObatBatch;

class DestroyController extends Controller
{
    public function index()
    {
        return view('Karyawan.destroy_page');
    }

    public function getDataByPLU($plu)
    {
        $tables = [
            Makanan::class,
            Bahan_Masakan::class,
            Minuman::class,
            Kosmetik::class,
            Perabotan_Rumah::class,
            Pembersih::class,
            Alat_Tulis::class,
            Obat::class
        ];

        foreach ($tables as $table) {
            $item = $table::where('plu_barang', $plu)->first();
            if ($item) {
                return response()->json([
                    'success' => true,
                    'nama_barang' => $item->nama_barang,
                    'kategori' => strtolower(class_basename($table)) // optional, biar tau kategorinya
                ]);
            }
        }

        return response()->json(['success' => false, 'nama_barang' => '']);
    }

    public function getStockByPLU($plu)
    {
        $tables = [
            Makanan::class,
            Bahan_Masakan::class,
            Minuman::class,
            Kosmetik::class,
            Perabotan_Rumah::class,
            Pembersih::class,
            Alat_Tulis::class,
            Obat::class
        ];

        foreach ($tables as $table) {
            $item = $table::where('plu_barang', $plu)->first();
            if ($item) {
                return response()->json([
                    'success' => true,
                    'total_quantity' => $item->total_quantity,
                    'kategori' => strtolower(class_basename($table))
                ]);
            }
        }

        return response()->json(['success' => false, 'total_quantity' => 0]);
    }

    public function destroy(Request $request)
    {
        $items = $request->input('items'); // array [{plu, qty}]

        if (!$items || !is_array($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Data items tidak valid'
            ]);
        }

        // Proses pengurangan stok
        foreach ($items as $item) {
            $plu = $item['plu'];
            $qty = $item['qty'];

            $barang = Makanan::where('plu_barang', $plu)->first(); // contoh Makanan, sesuaikan model
            if (!$barang) continue;

            $barang->total_quantity -= $qty;
            if ($barang->total_quantity < 0) $barang->total_quantity = 0;
            $barang->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil dikurangi sesuai pemusnahan'
        ]);
    }


    private function getModel($kategori)
    {
        $map = [
            'makanan' => Makanan::class,
            'bahan_masakan' => Bahan_Masakan::class,
            'minuman' => Minuman::class,
            'kosmetik' => Kosmetik::class,
            'perabotan_rumah' => Perabotan_Rumah::class,
            'pembersih' => Pembersih::class,
            'alat_tulis' => Alat_Tulis::class,
            'obat' => Obat::class
        ];
        return $map[strtolower($kategori)] ?? null;
    }

    private function getBatchModel($kategori)
    {
        $map = [
            'makanan' => MakananBatch::class,
            'bahan_masakan' => BahanMasakanBatch::class,
            'minuman' => MinumanBatch::class,
            'kosmetik' => KosmetikBatch::class,
            'perabotan_rumah' => PerabotanRumahBatch::class,
            'pembersih' => PembersihBatch::class,
            'alat_tulis' => AlatTulisBatch::class,
            'obat' => ObatBatch::class
        ];
        return $map[strtolower($kategori)] ?? null;
    }
}
