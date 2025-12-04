<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// 16 model domain receiving
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

use App\Models\Kategori;
use App\Models\Stock;

class ReceivingController extends Controller
{
    public function index()
    {
        $stocks = Stock::with('kategori')->orderBy('id')->get();
        return view('Karyawan.Receiving_page', compact('stocks'));
    }

    public function store(Request $request)
    {
        // ✅ PROSES DATA DARI RAM SEMENTARA (SAAT KLIK KONFIRMASI)
        if ($request->has('stocks')) {
            try {
                foreach ($request->stocks as $item) {

                    $kodeAwal = substr((string)$item['plu'], 0, 2);
                    $kategori = Kategori::where('kode_awal', $kodeAwal)->first();

                    if (!$kategori) {
                        return response()->json([
                            'success' => false,
                            'message' => "Kategori untuk PLU $kodeAwal tidak ditemukan!"
                        ]);
                    }

                    $stock = Stock::where('plu_barang', $item['plu'])->first();
                    $harga = (int)$item['harga'];
                    $qty   = $item['qty'];
                    $expired = $item['expired'];

                    if ($stock) {
                        $stock->increment('total_quantity', $qty);
                        $stock->update(['harga_terakhir' => $harga]);
                    } else {
                        $stock = Stock::create([
                            $stock = Stock::create([
                                'plu_barang'      => $item['plu'],
                                'nama_barang'     => $item['nama'],
                                'tanggal_expired' => $expired,
                                'harga_terakhir'  => $harga,
                                'total_quantity'  => $qty,
                                'kategori_id'     => $kategori->id
                            ])

                        ]);
                    }

                    // ✅ ROUTING MASUK KE DOMAIN MODEL + BATCH
                    switch ($kodeAwal) {
                        case '46':
                            $batch = MinumanBatch::create([
                                'minuman_id' => $stock->id,
                                'kode_batch' => 'MIN-' . time(),
                                'tanggal_terima' => now()
                            ]);
                            Minuman::create([
                                'plu' => $item['plu'],
                                'nama_barang' => $item['nama'],
                                'harga_per_pcs' => $harga,
                                'kuantitas' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '44':
                            $batch = BahanMasakanBatch::create([
                                'bahan_masakan_id' => $stock->id,
                                'kode_batch' => 'BM-' . time(),
                                'tanggal_input' => now()
                            ]);
                            Bahan_Masakan::create([
                                'plu' => $item['plu'],
                                'nama_barang' => $item['nama'],
                                'harga_per_pcs' => $harga,
                                'qty_masuk' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '43':
                            $batch = MakananBatch::create([
                                'makanan_id' => $stock->id,
                                'kode_batch' => 'SNK-' . time(),
                                'tanggal_expired' => $expired
                            ]);
                            Makanan::create([
                                'kode_barang' => $item['plu'],
                                'nama_barang' => $item['nama'],
                                'harga' => $harga,
                                'jumlah_masuk' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '47':
                            $batch = KosmetikBatch::create([
                                'kosmetik_id' => $stock->id,
                                'kode_batch' => 'KOS-' . time(),
                                'tanggal_masuk' => now()
                            ]);
                            Kosmetik::create([
                                'plu' => $item['plu'],
                                'nama_kosmetik' => $item['nama'],
                                'harga_per_item' => $harga,
                                'stok_masuk' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '63':
                            $batch = ObatBatch::create([
                                'obat_id' => $stock->id,
                                'batch_number' => 'OBT-' . time(),
                                'received_at' => now()
                            ]);
                            Obat::create([
                                'plu' => $item['plu'],
                                'nama_obat' => $item['nama'],
                                'harga_per_butir' => $harga,
                                'jumlah_diterima' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '61':
                            $batch = AlatTulisBatch::create([
                                'alat_tulis_id' => $stock->id,
                                'kode_batch' => 'AT-' . time(),
                                'created_at' => now()
                            ]);
                            Alat_Tulis::create([
                                'plu' => $item['plu'],
                                'nama_item' => $item['nama'],
                                'harga_satuan' => $harga,
                                'stok_diterima' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '59':
                            $batch = PembersihBatch::create([
                                'pembersih_id' => $stock->id,
                                'kode_batch' => 'PB-' . time(),
                                'diterima_pada' => now()
                            ]);
                            Pembersih::create([
                                'plu' => $item['plu'],
                                'nama_barang' => $item['nama'],
                                'harga_per_pcs' => $harga,
                                'jumlah_stok_masuk' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;

                        case '58':
                            $batch = PerabotanRumahBatch::create([
                                'perabotan_rumah_id' => $stock->id,
                                'batch_kode' => 'PR-' . time(),
                                'tanggal_diterima' => now()
                            ]);
                            Perabotan_Rumah::create([
                                'kode_barang' => $item['plu'],
                                'nama_barang' => $item['nama'],
                                'harga_unit' => $harga,
                                'jumlah_barang_masuk' => $qty,
                                'batch_id' => $batch->id
                            ]);
                            break;
                    }
                }

                // ✅ Setelah loop kelar baru balikin JSON biar button fetch lu jalan
                return response()->json([
                    'success' => true,
                    'message' => "Data RAM berhasil disimpan ke database!"
                ]);
            } catch (\Throwable $e) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }


            // ✅ Kalau submit selain Konfirmasi (misal orang POST manual di form)
            // return back()->with('error', "Format request tidak valid!");
        }
    }

    public function destroy($id)
    {
        $data = Stock::findOrFail($id);
        $data->delete();
        return back()->with('success', "Stok PLU {$data->plu_barang} berhasil dihapus!");
    }
}
