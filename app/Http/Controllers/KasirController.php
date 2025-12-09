<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KasirController extends Controller
{
    protected $kategoriList = [
        'Makanan' => \App\Models\Makanan::class,
        'Minuman' => \App\Models\Minuman::class,
        'Kosmetik' => \App\Models\Kosmetik::class,
        'BahanMasakan' => \App\Models\Bahan_Masakan::class,
        'AlatTulis' => \App\Models\Alat_Tulis::class,
        'Obat' => \App\Models\Obat::class,
        'Pembersih' => \App\Models\Pembersih::class,
        'LainLain' => \App\Models\Perabotan_Rumah::class
    ];

    protected $batchList = [
        'Makanan' => \App\Models\MakananBatch::class,
        'Minuman' => \App\Models\MinumanBatch::class,
        'Kosmetik' => \App\Models\KosmetikBatch::class,
        'BahanMasakan' => \App\Models\BahanMasakanBatch::class,
        'AlatTulis' => \App\Models\AlatTulisBatch::class,
        'Obat' => \App\Models\ObatBatch::class,
        'Pembersih' => \App\Models\PembersihBatch::class,
        'LainLain' => \App\Models\PerabotanRumahBatch::class
    ];

    // Auto isi PLU
    public function searchPLU(Request $request)
    {
        $plu = trim($request->plu);

        foreach ($this->kategoriList as $kategori => $model) {
            $barang = $model::where('plu_barang', $plu)->first();
            if ($barang) {
                $batchModel = $this->batchList[$kategori];
                $batch = $batchModel::where('barang_id', $barang->id)
                    ->where('quantity', '>', 0)
                    ->orderBy('id', 'asc')
                    ->first();

                if (!$batch) {
                    return response()->json([
                        'status' => 'out_of_stock',
                        'nama_barang' => $barang->nama_barang,
                        'message' => "Stok barang ini habis"
                    ]);
                }

                return response()->json([
                    'status' => 'ok',
                    'kategori' => $kategori,
                    'nama_barang' => $barang->nama_barang,
                    'price_per_pcs' => (int)$batch->price
                ]);
            }
        }

        return response()->json([
            'status' => 'not_found',
            'message' => 'Barang tidak ditemukan'
        ]);
    }

    // Submit transaksi
    public function submit(Request $request)
    {
        $cart = $request->cart;

        if (!$cart || count($cart) === 0) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        DB::beginTransaction();
        try {
            $grandTotal = collect($cart)->sum(fn($i) => $i['harga'] * $i['qty']);
            $transaksiId = DB::table('transaksi')->insertGetId([
                'grand_total' => $grandTotal,
                'created_at' => now()
            ]);

            foreach ($cart as $item) {
                $barang = null;
                $batchModel = null;
                foreach ($this->kategoriList as $kategori => $model) {
                    $b = $model::where('plu_barang', trim($item['plu']))->first();
                    if ($b) {
                        $barang = $b;
                        $batchModel = $this->batchList[$kategori];
                        break;
                    }
                }

                if (!$barang) {
                    throw new \Exception("Barang {$item['nama']} tidak ditemukan");
                }

                if ($barang->total_quantity < $item['qty']) {
                    throw new \Exception("Stok {$barang->nama_barang} tidak cukup");
                }

                $qty = $item['qty'];
                $batches = $batchModel::where('barang_id', $barang->id)
                    ->where('quantity', '>', 0)
                    ->orderBy('id')
                    ->get();

                foreach ($batches as $batch) {
                    if ($qty <= 0) break;

                    $pakai = min($batch->quantity, $qty);
                    $batch->quantity -= $pakai;
                    $batch->save();

                    DB::table('transaksi_detail')->insert([
                        'transaksi_id' => $transaksiId,
                        'plu' => $item['plu'],
                        'nama_barang' => $item['nama'],
                        'harga' => $item['harga'],
                        'qty' => $pakai,
                        'subtotal' => $pakai * $item['harga']
                    ]);

                    $qty -= $pakai;
                }

                $barang->total_quantity -= $item['qty'];
                $barang->save();
            }

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil',
                'transaksi_id' => $transaksiId
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal transaksi: ' . $e->getMessage()
            ], 500);
        }
    }

    // Cetak struk
    public function struk($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->first();
        if (!$transaksi) abort(404);

        $details = DB::table('transaksi_detail')->where('transaksi_id', $id)->get();

        return view('kasir.struk', compact('transaksi', 'details'));
    }

    // Cek stok sisa barang
    public function checkStock(Request $request)
    {
        $plu = $request->plu;
        foreach ($this->kategoriList as $kategori => $model) {
            $barang = $model::where('plu_barang', $plu)->first();
            if ($barang) {
                $batchModel = $this->batchList[$kategori];
                $totalStok = $batchModel::where('barang_id', $barang->id)->sum('quantity');
                return response()->json([
                    'status' => 'ok',
                    'stok' => $totalStok
                ]);
            }
        }

        return response()->json([
            'status' => 'not_found',
            'stok' => 0
        ]);
    }
}
