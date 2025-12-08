<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Makanan;
use App\Models\MakananBatch;
use Illuminate\Support\Facades\DB;

class MakananDestroyController extends Controller
{
    public function index()
    {
        return view('Karyawan.destroy_page'); // Sesuaikan nama blade
    }

    // Fungsi untuk auto-fill data PLU
    public function getDataByPLU($plu)
    {
        $makanan = Makanan::where('plu_barang', $plu)->first();

        if ($makanan) {
            return response()->json([
                'success' => true,
                'nama_barang' => $makanan->nama_barang,
            ]);
        }

        return response()->json([
            'success' => false,
            'nama_barang' => '',
        ]);
    }

    // Fungsi submit destroy
    public function destroy(Request $request)
    {
        $items = $request->input('items'); // Array dari RAM JS [{plu, qty}]

        DB::transaction(function () use ($items) {
            foreach ($items as $item) {
                $plu = $item['plu'];
                $qtyToDestroy = $item['qty'];

                $makanan = Makanan::where('plu_barang', $plu)->first();
                if (!$makanan) continue;

                // Kurangi batch (FIFO / expired terdekat)
                $batches = $makanan->batches()
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

                // Update total_quantity di tb_makanan
                $totalRemaining = $makanan->batches()->sum('quantity');
                $makanan->total_quantity = $totalRemaining;
                $makanan->save();
            }
        });

        return response()->json([
            'success' => true,
            'message' => 'Stok berhasil dikurangi sesuai pemusnahan.'
        ]);
    }

    public function getStockByPLU($plu)
    {
        $makanan = Makanan::where('plu_barang', $plu)->first();
        if ($makanan) {
            return response()->json([
                'success' => true,
                'total_quantity' => $makanan->total_quantity
            ]);
        }
        return response()->json([
            'success' => false,
            'total_quantity' => 0
        ]);
    }
}
