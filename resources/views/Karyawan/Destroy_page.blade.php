<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pemusnahan Barang</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <style>
        /* Hilangkan arrow pada input number (Bootstrap tetap jalan) */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-danger mb-4 shadow">
    <div class="container">
        <a class="navbar-brand fw-bold"><i class="fa fa-fire me-2"></i>Destroy Barang</a>
        <a href="/Karyawan" class="btn btn-light ms-auto">Kembali <i class="fa fa-arrow-right"></i></a>
    </div>
</nav>

<div class="container d-flex justify-content-center">
    <div class="col-md-6">
        <div class="card shadow border-0 p-4">
            <h5 class="text-center fw-bold mb-4"><i class="fa fa-trash text-danger me-2"></i>Form Pemusnahan</h5>

            <div class="mb-3">
                <label class="form-label">Kode PLU</label>
                <input type="text" id="plu" class="form-control" placeholder="Contoh: 46****" />
            </div>

            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" id="nama" class="form-control" placeholder="Contoh: Chitato" />
            </div>

            <div class="mb-3">
                <label class="form-label">Kuantitas</label>
                <input type="number" id="qty" class="form-control" placeholder="Contoh: 10"
                    onkeydown="return blokSemua(event)" min="1" />
            </div>

            <div class="d-grid gap-2">
                <button class="btn btn-danger" onclick="tambahTabel()">
                    <i class="fa fa-plus me-2"></i>Tambahkan ke Tabel
                </button>
                <button class="btn btn-dark" onclick="printTabel()">
                    <i class="fa fa-print me-2"></i>Cetak Rekap Tabel
                </button>
                <button class="btn btn-success text-white" onclick="cetakBukti()">
                    <i class="fa fa-receipt me-2"></i>Cetak Bukti Pemusnahan
                </button>
            </div>
        </div>

        <!-- TABEL SEMENTARA (RAM) -->
        <div class="card shadow border-0 mt-4 p-3">
            <h6 class="text-center fw-bold text-danger mb-3">Rekap Barang Dimusnahkan (Sementara)</h6>
            <div class="table-responsive">
                <table class="table table-bordered text-center" id="tabelDestroy">
                    <thead class="table-dark">
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Qty</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- PRINT AREA TABEL -->
<div id="print-area" class="d-none"></div>

<!-- PRINT AREA BUKTI -->
<div id="print-bukti" class="d-none">
    <div class="border p-3 text-center" style="width:300px; font-family:Arial;margin:auto">
        <h5 class="fw-bold text-danger"><i class="fa fa-fire me-1"></i>BUKTI PEMUSNAHAN</h5>
        <p class="mb-1">Kode: <span id="b-plu"></span></p>
        <p class="mb-1">Nama: <strong><span id="b-nama"></span></strong></p>
        <p class="mb-1">Kuantitas: <span id="b-qty"></span> pcs</p>
        <hr>
        <p class="small">Tanggal: <span id="b-tgl"></span></p>
        <p class="small text-muted">*bukti ini tidak tersimpan ke database</p>
    </div>
</div>

<script>
    const dataDestroy = []; // ini RAM-nya bro 😎

    function blokSemua(e) {
        const terlarang = ["e", "+", "-", ".", ","];
        if (terlarang.includes(e.key.toLowerCase())) {
            e.preventDefault();
            return false;
        }
    }

    function tambahTabel() {
        const plu = document.getElementById("plu").value.trim();
        const nama = document.getElementById("nama").value.trim();
        const qty = document.getElementById("qty").value;

        const qtyNum = parseInt(qty);
        if (!plu || !nama || isNaN(qtyNum) || qtyNum < 1) {
            Swal.fire("Error!", "Mohon isi semua data dengan benar!", "error");
            return;
        }

        dataDestroy.push({ plu, nama, qty: qtyNum });
        renderTabel();
    }

    function renderTabel() {
        const tbody = document.querySelector("#tabelDestroy tbody");
        tbody.innerHTML = "";

        dataDestroy.forEach((item, index) => {
            tbody.innerHTML += `
            <tr>
                <td>${item.plu}</td>
                <td>${item.nama}</td>
                <td>${item.qty}</td>
                <td><button class="btn btn-sm btn-outline-danger" onclick="hapus(${index})"><i class="fa fa-x"></i></button></td>
            </tr>`;
        });
    }

    function hapus(i) {
        dataDestroy.splice(i, 1);
        renderTabel();
    }

    function printTabel() {
        const area = document.getElementById("print-area");
        area.innerHTML = document.getElementById("tabelDestroy").outerHTML;
        area.classList.remove("d-none");

        const w = window.open("", "", "width=800,height=600");
        w.document.write(area.innerHTML);
        w.document.close();
        w.print();
    }

    function cetakBukti() {
        const plu = document.getElementById("plu").value.trim();
        const nama = document.getElementById("nama").value.trim();
        const qty = document.getElementById("qty").value;
        const qtyNum = parseInt(qty);

        if (!plu || !nama || isNaN(qtyNum) || qtyNum < 1) {
            Swal.fire("Error!", "Data belum lengkap!", "error");
            return;
        }

        const tgl = new Date().toLocaleString('id-ID');
        document.getElementById("b-plu").innerText = plu;
        document.getElementById("b-nama").innerText = nama;
        document.getElementById("b-qty").innerText = qtyNum;
        document.getElementById("b-tgl").innerText = tgl;

        const w = window.open("", "", "width=400,height=400");
        w.document.write(document.getElementById("print-bukti").innerHTML);
        w.document.close();
        w.print();
    }
</script>

</body>
</html>
