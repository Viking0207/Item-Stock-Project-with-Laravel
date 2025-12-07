<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Kasir UI</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">

    <div class="container py-4">

        <!-- TOMBOL BACK -->
        <div class="d-flex justify-content-end mt-3">
            <a href="javascript:history.back()"
                class="btn btn-outline-primary d-inline-flex align-items-center gap-2 px-3 rounded-3">
                Kembali <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <!-- FORM INPUT -->
        <div class="container d-flex justify-content-center pt-3 pb-5">
            <div class="card shadow-sm p-4 rounded-4" style="width: 1100px;">
                <div class="card-body">
                    <form>
                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">PLU / Kode Barang</label>
                            <input type="text" id="plu" class="form-control form-control-lg"
                                placeholder="Masukkan Kode PLU">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Nama Barang</label>
                            <input type="text" id="nama" class="form-control form-control-lg" readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Harga</label>
                            <input type="number" id="harga" class="form-control form-control-lg" readonly>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-5">Jumlah</label>
                            <input type="number" id="qty" class="form-control form-control-lg">
                        </div>

                        <button type="button" id="btnTambah" class="btn btn-primary btn-lg w-100 rounded-3">
                            <i class="fa-solid fa-plus me-2"></i> Tambah ke Tabel
                        </button>

                    </form>

                </div>
            </div>
        </div>


        <!-- TABEL TRANSAKSI -->
        <div class="card shadow-sm rounded-4">
            <div class="card-body p-4">
                <h5 class="card-title mb-3">Tabel Transaksi</h5>

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
                        <tbody id="tableBody">
                            >

                        </tbody>
                    </table>
                </div>

                <!-- TOTAL BELANJA DUMMY VIEW -->
                <div class="d-flex justify-content-end mt-3">
                    <h6 class="fw-bold">Grand Total: <span class="text-success" id="grandTotal">Rp 19.000</span></h6>
                </div>
            </div>
        </div>

        <!-- Tombol Proses Terima Barang -->
        <div class="d-flex justify-content-end mt-4 gap-3">
            <button type="button"
                class="btn btn-warning rounded-3 px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-receipt"></i> Cetak Struk
            </button>

            <button type="button"
                class="btn btn-success rounded-3 px-4 py-2 d-inline-flex align-items-center gap-2 shadow-sm">
                <i class="fa-solid fa-check"></i> Bayar Pesanan
            </button>
        </div>

    </div>

</body>

<script>
    let cart = [];
    let hargaAsli = 0;

    const plu = document.getElementById('plu');
    const nama = document.getElementById('nama');
    const harga = document.getElementById('harga');
    const qty = document.getElementById('qty');
    const table = document.getElementById('tableBody');
    const totalEl = document.getElementById('grandTotal');
    const btnAdd = document.getElementById('btnTambah');

    /* === AUTO FILL DARI PLU === */
    plu.addEventListener('keyup', function() {
        if (plu.value.length < 2) return;

        fetch(`/kasir/search?plu=${plu.value}`)
            .then(res => {
                if (!res.ok) {
                    throw new Error('Response error');
                }
                return res.json();
            })
            .then(d => {
                nama.value = d.nama_barang ?? '';

                // simpan harga asli (number)
                hargaAsli = Number(d.price_per_pcs);

                // tampilkan harga versi UI (tanpa .00)
                harga.value = hargaAsli.toLocaleString('id-ID');
            })
            .catch(() => {
                nama.value = '';
                harga.value = '';
            });
    });

    /* === TAMBAH KE TABEL === */
    btnAdd.addEventListener('click', function() {
        if (!plu.value || !qty.value) {
            alert('Lengkapi data');
            return;
        }

        cart.push({
            plu: plu.value,
            nama: nama.value,
            harga: hargaAsli,
            qty: Number(qty.value)
        });


        renderTable();

        plu.value = nama.value = harga.value = qty.value = '';
        hargaAsli = 0;

    });

    /* === RENDER TABEL === */
    function renderTable() {
        table.innerHTML = '';
        let grand = 0;

        cart.forEach((item, i) => {
            const total = item.harga * item.qty;
            grand += total;

            table.innerHTML += `
        <tr>
            <td>${i+1}</td>
            <td>${item.plu}</td>
            <td>${item.nama}</td>
            <td>Rp ${item.harga.toLocaleString()}</td>
            <td>${item.qty}</td>
            <td>Rp ${total.toLocaleString()}</td>
            <td>
                <button class="btn btn-danger btn-sm" onclick="hapus(${i})">
                    Hapus
                </button>
            </td>
        </tr>
        `;
        });

        totalEl.innerText = `Rp ${grand.toLocaleString()}`;
    }

    function hapus(index) {
        cart.splice(index, 1);
        renderTable();
    }
</script>


</html>
