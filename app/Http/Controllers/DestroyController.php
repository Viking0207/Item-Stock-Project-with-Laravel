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

    // Ambil data nama barang berdasarkan PLU
    public function getDataByPLU($plu)
    {
        $tables = $this->getAllModels();
        foreach ($tables as $table) {
            $item = $table['model']::where('plu_barang', $plu)->first();
            if ($item) {
                return response()->json([
                    'success' => true,
                    'nama_barang' => $item->nama_barang,
                    'kategori' => $table['name']
                ]);
            }
        }

        return response()->json(['success' => false, 'nama_barang' => '']);
    }

    // Ambil total stock berdasarkan PLU
    public function getStockByPLU($plu)
    {
        $tables = $this->getAllModels();
        foreach ($tables as $table) {
            $item = $table['model']::where('plu_barang', $plu)->first();
            if ($item) {
                return response()->json([
                    'success' => true,
                    'total_quantity' => $item->total_quantity,
                    'kategori' => $table['name']
                ]);
            }
        }

        return response()->json(['success' => false, 'total_quantity' => 0]);
    }

    // Submit destroy
    public function destroy(Request $request)
    {
        $items = $request->input('items'); // [{plu, qty}]
        if (!$items || !is_array($items)) {
            return response()->json([
                'success' => false,
                'message' => 'Data items tidak valid'
            ]);
        }

        DB::transaction(function() use ($items) {
            $tables = $this->getAllModels();

            foreach ($items as $item) {
                $plu = $item['plu'];
                $qtyToDestroy = $item['qty'];

                // Cari model dan batch
                $model = null;
                $batchClass = null;
                foreach ($tables as $t) {
                    $tmp = $t['model']::where('plu_barang', $plu)->first();
                    if ($tmp) {
                        $model = $tmp;
                        $batchClass = $t['batch'];
                        break;
                    }
                }

                if (!$model || !$batchClass) continue;

                // Ambil semua batch yang quantity > 0, urut FEFO
                $batches = $model->batches()
                    ->where('quantity', '>', 0)
                    ->orderBy('expired_date', 'asc')
                    ->get();

                foreach ($batches as $batch) {
                    if ($qtyToDestroy <= 0) break;

                    if ($batch->quantity >= $qtyToDestroy) {
                        $batch->quantity -= $qtyToDestroy;
                        $batch->save();
                        $qtyToDestroy = 0;
                    } else {
                        $qtyToDestroy -= $batch->quantity;
                        $batch->quantity = 0;
                        $batch->save();
                    }
                }

                // Update total_quantity di tabel utama
                $model->total_quantity = $model->batches()->sum('quantity');
                $model->save();
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil dikurangi sesuai pemusnahan'
        ]);
    }

    // Helper: daftar semua model utama dan batch
    private function getAllModels()
    {
        return [
            ['name'=>'makanan', 'model'=>Makanan::class, 'batch'=>MakananBatch::class],
            ['name'=>'bahan_masakan', 'model'=>Bahan_Masakan::class, 'batch'=>BahanMasakanBatch::class],
            ['name'=>'minuman', 'model'=>Minuman::class, 'batch'=>MinumanBatch::class],
            ['name'=>'kosmetik', 'model'=>Kosmetik::class, 'batch'=>KosmetikBatch::class],
            ['name'=>'perabotan_rumah', 'model'=>Perabotan_Rumah::class, 'batch'=>PerabotanRumahBatch::class],
            ['name'=>'pembersih', 'model'=>Pembersih::class, 'batch'=>PembersihBatch::class],
            ['name'=>'alat_tulis', 'model'=>Alat_Tulis::class, 'batch'=>AlatTulisBatch::class],
            ['name'=>'obat', 'model'=>Obat::class, 'batch'=>ObatBatch::class],
        ];
    }
}
