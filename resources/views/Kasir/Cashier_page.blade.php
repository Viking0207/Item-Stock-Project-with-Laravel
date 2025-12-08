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
                                placeholder="Masukkan PLU produk, misal: 461234">
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


                        </tbody>
                    </table>
                </div>

                <!-- TOTAL BELANJA DUMMY VIEW -->
                <div class="d-flex justify-content-end mt-3">
                    <h6 class="fw-bold">Harga Total: <span class="text-success" id="grandTotal">Rp </span></h6>
                </div>
            </div>
        </div>

        <!-- Tombol Proses Terima Barang -->
        <div class="d-flex justify-content-end mt-4 gap-3">
            <button type="button" id="btnBayar"
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

    // Auto-fill
    plu.addEventListener('keyup', () => {
        const kode = plu.value.trim();
        if (kode.length < 2) return;

        fetch(`/kasir/search?plu=${kode}`)
            .then(res => res.json())
            .then(d => {
                if (d.status === 'ok') {
                    nama.value = d.nama_barang;
                    harga.value = d.price_per_pcs;
                    hargaAsli = Number(d.price_per_pcs);
                } else {
                    nama.value = '';
                    harga.value = '';
                    hargaAsli = 0;
                    if (d.message) alert(d.message);
                }
            })
            .catch(() => {
                nama.value = '';
                harga.value = '';
                hargaAsli = 0;
            });
    });

    // Tambah ke tabel
    document.getElementById('btnTambah').addEventListener('click', () => {
        if (!plu.value || !qty.value || hargaAsli <= 0) {
            alert('Data belum valid');
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

    // Render tabel
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
                <td>${item.harga.toLocaleString()}</td>
                <td>${item.qty}</td>
                <td>${total.toLocaleString()}</td>
                <td><button class="btn btn-danger btn-sm" onclick="hapus(${i})">Hapus</button></td>
            </tr>
        `;
        });
        totalEl.innerText = grand.toLocaleString();
    }

    function hapus(index) {
        cart.splice(index, 1);
        renderTable();
    }

    // Bayar
    document.getElementById('btnBayar').addEventListener('click', () => {
        if (cart.length === 0) {
            alert('Keranjang kosong');
            return;
        }

        fetch('/kasir/submit', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    cart
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.transaksi_id) {
                    alert(res.message);
                    window.open(`/kasir/struk/${res.transaksi_id}`, '_blank');
                    cart = [];
                    renderTable();
                } else {
                    alert(res.message);
                }
            })
            .catch(() => {
                alert('Gagal memproses transaksi');
            });
    });
</script>



</html>
