<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Receiving UI</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <div class="container py-4">

        <!-- TOMBOL BACK -->
        <div class="d-flex justify-content-end mt-3">
            <a href="/Karyawan" class="btn btn-outline-primary d-inline-flex align-items-center gap-2 px-3 rounded-3">
                Kembali <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- FORM INPUT -->
        <div class="container d-flex justify-content-center pt-3 pb-4">
            <div class="card shadow-sm p-4 rounded-4" style="width: 1100px;">
                <div class="card-body">
                    <form action="{{ route('receiving.store') }}" method="POST" id="stockForm">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">PLU / Kode Barang</label>
                            <input type="text" id="plu" class="form-control form form-control-lg rounded-3"
                                placeholder="Masukkan PLU atau kode barang">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Nama Barang</label>
                            <input type="text" id="nama" class="form-control form-control-lg rounded-3"
                                placeholder="Masukkan nama barang">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Tanggal Expired</label>
                            <input type="date" id="expired" class="form-control form-control-lg rounded-3">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Harga Barang Per-pcs</label>
                            <input type="text" id="harga" class="form-control form-control-lg rounded-3"
                                placeholder="Masukkan harga barang" oninput="formatRupiah(this)">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-5">Kuantitas</label>
                            <input type="number" id="qty" class="form-control form-control-lg rounded-3"
                                placeholder="Masukan quantity">
                        </div>

                        <button type="button" onclick="addStock()" class="btn btn-primary btn-lg w-100 rounded-3">
                            <i class="fa-solid fa-plus me-2"></i> Input data stock
                        </button>

                    </form>

                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end mb-4 gap-3">
            <button type="submit" onclick="cetakBukti()"
                class="btn btn-warning rounded-3 px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-receipt"></i> Cetak Bukti Terima
            </button>
        </div>

        <!-- TABEL TRANSAKSI -->
        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">Tabel List Barang</h5>

                <div class="table-responsive">
                    <table class="table table-bordered align-middle text-center">
                        <thead class="table-primary">
                            <tr>
                                <th>No</th>
                                <th>Kode PLU</th>
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="stockTableBody">
                            @foreach ($stocks->groupBy('kategori.nama_kategori') as $kategori => $items)
                                <!-- Header group kategori -->
                                <tr class="table-info">
                                    <td colspan="7" class="fw-bold text-start ps-3">{{ $kategori }}</td>
                                </tr>

                                <!-- List barang dalam kategori tersebut -->
                                @foreach ($items as $i => $data)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td>{{ $data->plu_barang }}</td>
                                        <td>{{ $data->nama_barang }}</td>
                                        <td>Rp {{ number_format($data->harga_terakhir, 0, ',', '.') }}</td>
                                        <td>{{ $data->total_quantity }}</td>
                                        <td>Rp
                                            {{ number_format($data->harga_terakhir * $data->total_quantity, 0, ',', '.') }}
                                        </td>
                                        <td>
                                            <form action="/receiving/{{ $data->id }}" method="POST"
                                                onsubmit="return confirm('Yakin hapus?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm rounded-3">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @endforeach

                            <!-- Grand Total semu di UI -->
                            <tr class="table-success">
                                <td colspan="5" class="fw-bold text-center">Grand Total</td>
                                <td class="fw-bold" id="grandTotal">Rp
                                    {{ number_format($stocks->sum(fn($s) => $s->harga_terakhir * $s->total_quantity), 0, ',', '.') }}
                                </td>
                                <td>-</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
        </div>

        <!-- Tombol Proses Terima Barang -->
        <div class="d-flex justify-content-end mt-4 gap-3">
            <button type="submit" onclick="submitKeDB()"
                class="btn btn-success rounded-3 px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-check"></i> Konfirmasi data stock
            </button>
        </div>
    </div>

</body>

<style>
    /* background card jadi lebih soft biar gak monoton */
    .card {
        background-color: #fefefe;
    }

    /* header tabel jangan biru → jadi grey elegan */
    .table-primary {
        background-color: #e9ecef !important;
        color: #212529;
    }

    /* tombol biru jangan semua, kita tone down dikit */
    .btn-primary {
        background-color: #4a90e2;
        border-color: #4a90e2;
    }

    /* hover tombol primary */
    .btn-primary:hover {
        background-color: #357abd;
        border-color: #357abd;
    }

    /* tombol warning dicampur oren biar fresh */
    .btn-warning {
        background-color: #ff9800;
        border-color: #ff9800;
        color: #fff;
    }

    .btn-warning:hover {
        background-color: #e68900;
        border-color: #e68900;
        color: #fff;
    }

    /* tombol success kita bikin hijau vibrant, bukan default bootstrap */
    .btn-success {
        background-color: #2ecc71;
        border-color: #2ecc71;
    }

    .btn-success:hover {
        background-color: #27ae60;
        border-color: #27ae60;
    }

    /* tombol outline primary gak usah biru terang, kita redupkan dikit */
    .btn-outline-primary {
        border-color: #4a90e2;
        color: #4a90e2;
    }

    .btn-outline-primary:hover {
        background-color: #4a90e2;
        color: #fff;
    }

    /* tombol delete gak merah ngejreng, jadi merah soft gradient */
    .btn-danger {
        background: linear-gradient(45deg, #ff6b6b, #ee5253);
        border: none;
    }

    .btn-danger:hover {
        background: linear-gradient(45deg, #ee5253, #d63031);
    }
</style>

<script>
    function formatRupiah(el) {
        let val = el.value.replace(/[^0-9]/g, ""); // hanya angka
        if (val) {
            val = Number(val).toLocaleString("id-ID"); // format ribuan
            el.value = "Rp " + val;
        } else {
            el.value = "";
        }
    }

    let tempStocks = [] // << simpan sementara di browser

    function addStock() {
        let plu = document.getElementById('plu').value.trim()
        let nama = document.getElementById('nama').value.trim()
        let expired = document.getElementById('expired').value
        let harga = document.getElementById('harga').value.replace(/[^0-9]/g, "")
        let qty = document.getElementById('qty').value

        if (!plu || !nama || !expired || !harga || !qty) {
            alert("Isi semua data dulu lee!")
            return
        }

        tempStocks.push({
            plu,
            nama,
            expired,
            harga,
            qty
        })
        renderTable()
        document.getElementById('stockForm').reset()
    }

    function renderTable() {
        let body = document.getElementById('stockTableBody')
        body.innerHTML = ""
        let grand = 0

        tempStocks.forEach((item, i) => {
            let total = item.harga * item.qty
            grand += total

            body.innerHTML += `
        <tr>
            <td>${i+1}</td>
            <td>${item.plu}</td>
            <td>${item.nama}</td>
            <td>Rp ${Number(item.harga).toLocaleString("id-ID")}</td>
            <td>${item.qty}</td>
            <td>Rp ${Number(total).toLocaleString("id-ID")}</td>
            <td><button class="btn btn-danger btn-sm" onclick="hapus(${i})">Hapus</button></td>
        </tr>`
        })

        document.getElementById('grandTotal').innerText = "Rp " + Number(grand).toLocaleString("id-ID")
    }

    function hapus(i) {
        tempStocks.splice(i, 1)
        renderTable()
    }

    // Konfirmasi ke DB
    async function submitKeDB() {
        if (tempStocks.length === 0) {
            alert("Data kosong lee!")
            return
        }

        let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let res = await fetch("/terima", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": token
            },
            body: JSON.stringify({
                stocks: tempStocks
            })
        })

        let harga = document.getElementById('harga').value.replace(/[^0-9]/g, "")

        let data = await res.json();
        console.log(data);


        if (data.success) {
            alert("Berhasil tersimpan ke database cuy!")
            tempStocks = []
            renderTable()
            window.location.reload()
        } else {
            alert("Gagal masuk database cuk!")
        }
    }

    // Fungsi cetak 
    function cetakBukti() {
        alert("Masih Maintanance nih bro!")
    }
</script>

</html>
