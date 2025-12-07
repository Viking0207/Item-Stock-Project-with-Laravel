<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

// Import semua kategori
use App\Models\Makanan;
use App\Models\MakananBatch;
// Tambahkan kategori lain sesuai kebutuhan, misal Minuman, Snack, dll

class KasirController extends Controller
{
    /**
     * Auto-fill barang berdasarkan PLU
     */
    public function searchPLU(Request $request)
    {
        $plu = trim($request->plu);

        // 1. Cari barang dari PLU
        $barang = Makanan::where('plu_barang', $plu)->first();

        if (!$barang) {
            return response()->json([
                'status' => 'not_found',
                'message' => 'Barang tidak ditemukan'
            ]);
        }

        // 2. Ambil BATCH barang ini SAJA yang masih ada stok
        $batch = MakananBatch::where('barang_id', $barang->id)
            ->where('quantity', '>', 0)
            ->orderBy('id', 'asc') // FIFO
            ->first();

        if (!$batch) {
            return response()->json([
                'status' => 'out_of_stock',
                'nama_barang' => $barang->nama_barang,
                'message' => 'Stok barang ini habis'
            ]);
        }

        // 3. KIRIM DATA VALID
        return response()->json([
            'status' => 'ok',
            'nama_barang' => $barang->nama_barang,
            'price_per_pcs' => (int) $batch->price // harga PER PCS
        ]);
    }



    /**
     * Tambah item ke session kasir
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|integer',
            'nama_barang' => 'required|string',
            'price' => 'required|numeric',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = Session::get('kasir_cart', []);

        // Jika barang sudah ada di cart, jumlah ditambahkan
        $found = false;
        foreach ($cart as &$item) {
            if ($item['barang_id'] == $request->barang_id) {
                $item['quantity'] += $request->quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = [
                'barang_id' => $request->barang_id,
                'nama_barang' => $request->nama_barang,
                'price' => $request->price,
                'quantity' => $request->quantity,
            ];
        }

        Session::put('kasir_cart', $cart);

        return response()->json(['cart' => $cart]);
    }

    /**
     * Ambil data cart sementara
     */
    public function getCart()
    {
        $cart = Session::get('kasir_cart', []);
        return response()->json(['cart' => $cart]);
    }

    /**
     * Checkout & bayar pesanan
     */
    public function checkout()
    {
        $cart = Session::get('kasir_cart', []);

        if (empty($cart)) {
            return response()->json(['error' => 'Cart kosong'], 400);
        }

        foreach ($cart as $item) {
            $barang = Makanan::find($item['barang_id']);

            if (!$barang) continue;

            $qtyToReduce = $item['quantity'];

            // Kurangi stok batch secara FIFO (batch pertama diambil dulu)
            $batches = $barang->activeBatches()->orderBy('id', 'asc')->get();

            foreach ($batches as $batch) {
                if ($qtyToReduce <= 0) break;

                if ($batch->quantity >= $qtyToReduce) {
                    $batch->quantity -= $qtyToReduce;
                    $batch->save();
                    $qtyToReduce = 0;
                } else {
                    $qtyToReduce -= $batch->quantity;
                    $batch->quantity = 0;
                    $batch->save();
                }
            }
        }

        // Bersihkan cart setelah checkout
        Session::forget('kasir_cart');

        return response()->json(['success' => true, 'message' => 'Transaksi berhasil']);
    }


    public function submit(Request $request)
    {
        $cart = $request->cart;

        if (!$cart || count($cart) == 0) {
            return response()->json(['message' => 'Keranjang kosong'], 400);
        }

        DB::beginTransaction();

        try {
            $transaksiId = DB::table('transaksi')->insertGetId([
                'grand_total' => collect($cart)->sum(fn($i) => $i['harga'] * $i['qty']),
                'created_at' => now()
            ]);

            foreach ($cart as $item) {

                $barang = Makanan::where('plu_barang', trim($item['plu']))
                    ->lockForUpdate()
                    ->firstOrFail();

                if ($barang->total_quantity < $item['qty']) {
                    throw new \Exception("Stok {$barang->nama_barang} tidak cukup");
                }

                $qty = $item['qty'];

                $batches = MakananBatch::where('barang_id', $barang->id)
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

                // ✅ INI YANG KAMU LUPA
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
                'message' => 'Gagal transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Cetak struk
     */
    public function struk($id)
    {
        $transaksi = DB::table('transaksi')->where('id', $id)->first();
        $details = DB::table('transaksi_detail')->where('transaksi_id', $id)->get();

        return view('kasir.struk', compact('transaksi', 'details'));
    }
}
