<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

// Import SEMUA kategori
use App\Models\Alat_Tulis;
use App\Models\AlatTulisBatch;
use App\Models\Bahan_Masakan;
use App\Models\BahanMasakanBatch;
use App\Models\Kosmetik;
use App\Models\KosmetikBatch;
use App\Models\Makanan;
use App\Models\MakananBatch;
use App\Models\Minuman;
use App\Models\MinumanBatch;
use App\Models\Obat;
use App\Models\ObatBatch;
use App\Models\Pembersih;
use App\Models\PembersihBatch;
use App\Models\Perabotan_Rumah;
use App\Models\PerabotanRumahBatch;

use App\Models\Stock;

class ReceivingController extends Controller
{
    // ========================
    // 1. TAMPILKAN HALAMAN
    // ========================
    public function index()
    {
        $stocks = Stock::orderBy('id')->get();
        return view('Karyawan.Receiving_page', compact('stocks'));
    }

    // ========================
    // 2. TAMBAH / UPDATE STOK
    // ========================
    public function addItem(Request $request)
    {
        try {
            Log::info('ADD ITEM REQUEST', $request->all());

            // Validasi input
            $request->validate([
                'plu_barang'  => 'required|string',
                'nama_barang' => 'required|string',
                'qty'         => 'required|numeric|min:1',
                'harga'       => 'required|numeric|min:0'
            ]);

            // Cek apakah PLU sudah ada di stock
            $existing = Stock::where('plu_barang', $request->plu_barang)->first();

            if ($existing) {
                // Update qty + harga terakhir
                $existing->total_quantity += (int) $request->qty;
                $existing->harga_terakhir  = (int) $request->harga;
                $existing->save();
            } else {
                // Buat item baru
                Stock::create([
                    'plu_barang'     => $request->plu_barang,
                    'nama_barang'    => $request->nama_barang,
                    'total_quantity' => (int) $request->qty,
                    'harga_terakhir' => (int) $request->harga,
                    'kategori_id'    => 1,
                    'tanggal_expired' => $request->tanggal_expired ?? null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Stock berhasil diperbarui.'
            ]);
        } catch (\Throwable $e) {
            Log::error('ADD ITEM ERROR: ' . $e->getMessage(), ['line' => $e->getLine()]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
                'line'   => $e->getLine()
            ], 500);
        }
    }


    // =============================
    // 3. CONFIRM → MASUK KATEGORI
    // =============================
    public function confirmAll()
    {
        $stocks = Stock::all();

        try {

            foreach ($stocks as $item) {

                $kodeAwal = substr($item->plu_barang, 0, 2);
                $harga    = (int) $item->harga_terakhir;
                $qty      = (int) $item->total_quantity;
                $expired  = $item->tanggal_expired;

                switch ($kodeAwal) {

                    // ===================== 46 = MINUMAN =====================
                    case '46':
                        $master = Minuman::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        MinumanBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 44 = BAHAN MASAKAN =====================
                    case '44':
                        $master = Bahan_Masakan::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        BahanMasakanBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 43 = MAKANAN =====================
                    case '43':
                        $master = Makanan::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        MakananBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 47 = KOSMETIK =====================
                    case '47':
                        $master = Kosmetik::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        KosmetikBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 63 = OBAT =====================
                    case '63':
                        $master = Obat::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        ObatBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 59 = PEMBERSIH =====================
                    case '59':
                        $master = Pembersih::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        PembersihBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 58 = PERABOTAN RUMAH =====================
                    case '58':
                        $master = Perabotan_Rumah::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        PerabotanRumahBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    // ===================== 61 = ALAT TULIS KERJA =====================
                    case '61':
                        $master = Alat_Tulis::firstOrCreate(
                            ['plu_barang' => $item->plu_barang],
                            ['nama_barang' => $item->nama_barang]
                        );

                        $master->total_quantity += $qty;
                        $master->harga_terakhir = $harga;
                        $master->save();

                        AlatTulisBatch::create([
                            'barang_id'    => $master->id,
                            'plu_barang'   => $item->plu_barang,
                            'expired_date' => $expired,
                            'price'        => $harga,
                            'quantity'     => $qty
                        ]);
                        break;

                    default:
                        // PLU tidak diketahui, skip
                        break;
                }
            }

            // Hapus semua stock setelah dipindahkan
            Stock::truncate();

            return response()->json([
                'success' => true,
                'message' => 'Semua stock berhasil dimasukkan ke kategori masing-masing!'
            ]);
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'line'    => $e->getLine()
            ]);
        }
    }


    // ========================
    // 4. HAPUS SATU DATA STOK
    // ========================
    public function destroy($id)
    {
        try {
            $data = Stock::findOrFail($id); // ambil data stock dari DB
            $data->delete(); // hapus dari DB

            return redirect()->back()->with('success', "Stok {$data->plu_barang} berhasil dihapus!");
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', "Gagal menghapus stok: " . $e->getMessage());
        }
    }
}
