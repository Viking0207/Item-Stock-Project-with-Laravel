<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        $plu = $request->plu;

        // Cari di semua kategori (contoh hanya Makanan dulu)
        $barang = Makanan::where('plu_barang', $plu)->first();

        if (!$barang) {
            return response()->json(['error' => 'Barang tidak ditemukan'], 404);
        }

        // Ambil batch aktif (stok > 0) terbaru
        $batch = $barang->activeBatches()->orderBy('id', 'desc')->first();

        if (!$batch) {
            return response()->json(['error' => 'Stok habis'], 400);
        }

        return response()->json([
            'id' => $barang->id,
            'nama_barang' => $barang->nama_barang,
            'price_per_pcs' => $batch->price,
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

    /**
     * Cetak struk
     */
    public function printReceipt()
    {
        $cart = Session::get('kasir_cart', []);
        // Bisa return view atau PDF
        return view('kasir.struk', compact('cart'));
    }
}
