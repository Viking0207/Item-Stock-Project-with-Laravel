<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Form Diskon Barang - Karyawan</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-warning mb-4 shadow">
    <div class="container">
        <span class="navbar-brand fw-bold">
            <i class="fa-solid fa-tags me-2"></i>Diskon Barang
        </span>
        <a href="/Karyawan" class="btn btn-light ms-auto">
            Kembali <i class="fa-solid fa-arrow-right ms-1"></i>
        </a>
    </div>
</nav>

<!-- FORM -->
<div class="container d-flex justify-content-center mb-4">
    <div class="col-md-5">
        <div class="card shadow border-0 p-4">

            <h5 class="text-center fw-bold mb-4">
                <i class="fa-solid fa-percent text-warning me-2"></i>Form Diskon Barang
            </h5>

            <!-- PLU -->
            <div class="mb-3">
                <label class="form-label">Kode PLU</label>
                <input type="number" id="plu" class="form-control"
                       placeholder="Contoh: 461234"
                       onkeydown="return blokSemuaSimbol(event)"
                       onkeyup="cariBarang()">
            </div>

            <!-- NAMA -->
            <div class="mb-3">
                <label class="form-label">Nama Barang</label>
                <input type="text" id="nama_barang" class="form-control" readonly>
            </div>

            <!-- HARGA -->
            <div class="mb-3">
                <label class="form-label">Harga (Rp / pcs)</label>
                <input type="text" id="harga" class="form-control" readonly>
            </div>

            <!-- DISKON -->
            <div class="mb-3">
                <label class="form-label">Diskon (%)</label>
                <input type="number" id="diskon" class="form-control"
                       placeholder="Contoh: 10"
                       oninput="validasiDiskon(); hitung()">
                <small class="text-danger d-none" id="warn-diskon">
                    Diskon tidak boleh lebih dari 100%
                </small>
            </div>

            <!-- HASIL -->
            <div class="mb-3">
                <label class="form-label fw-bold">Harga Setelah Diskon</label>
                <input type="text" id="hasil"
                       class="form-control bg-success text-white fw-bold text-center"
                       readonly>
            </div>

            <div class="d-grid">
                <button class="btn btn-warning text-white" onclick="cetakLabel()">
                    <i class="fa-solid fa-print me-2"></i>Cetak Price Label
                </button>
            </div>

        </div>
    </div>
</div>

<!-- PRINT AREA -->
<div id="print-area" class="d-none">
    <div class="border p-3 text-center mx-auto shadow rounded-3 bg-white">
        <h4 class="fw-bold" id="pl-nama"></h4>
        <h6>Harga Normal</h6>
        <h5 class="text-decoration-line-through text-secondary" id="pl-harga"></h5>
        <h2 class="text-danger fw-bold" id="pl-hasil"></h2>
        <p class="fs-5">Diskon: <span class="fw-bold" id="pl-diskon"></span>%</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
/* ========== FETCH BARANG ========== */
function cariBarang() {
    let plu = document.getElementById('plu').value;
    if (plu.length < 4) return;

    fetch(`/api/diskon/${plu}`)
        .then(res => {
            if (!res.ok) throw new Error();
            return res.json();
        })
        .then(data => {
            document.getElementById('nama_barang').value = data.nama;
            document.getElementById('harga').value =
                data.harga.toLocaleString('id-ID');
            hitung();
        })
        .catch(() => {
            document.getElementById('nama_barang').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('hasil').value = '';
        });
}

/* ========== HITUNG DISKON ========== */
function hitung() {
    let harga = document.getElementById('harga').value.replace(/\./g, '');
    let diskon = document.getElementById('diskon').value;

    let hargaNum = parseInt(harga);
    let diskonNum = parseInt(diskon || 0);

    if (diskonNum > 100) diskonNum = 100;

    if (!isNaN(hargaNum)) {
        let hasil = hargaNum - (hargaNum * diskonNum / 100);
        document.getElementById('hasil').value =
            'Rp ' + Math.floor(hasil).toLocaleString('id-ID');
    }
}

/* ========== VALIDASI ========== */
function validasiDiskon() {
    let input = document.getElementById('diskon');
    let warn = document.getElementById('warn-diskon');

    if (input.value > 100) {
        input.value = 100;
        warn.classList.remove('d-none');
    } else {
        warn.classList.add('d-none');
    }
}

function blokSemuaSimbol(e) {
    if (!e || !e.key) return true;

    const simbolTerlarang = ['e', '+', '-', '.', ','];

    if (simbolTerlarang.includes(e.key.toLowerCase())) {
        e.preventDefault();
        return false;
    }

    return true;
}


/* ========== CETAK ========== */
function cetakLabel() {
    let nama = document.getElementById('nama_barang').value;
    let harga = document.getElementById('harga').value;
    let hasil = document.getElementById('hasil').value;
    let diskon = document.getElementById('diskon').value || 0;

    if (!nama || !harga) {
        Swal.fire({ icon: 'error', text: 'Data belum lengkap!' });
        return;
    }

    document.getElementById('pl-nama').innerText = nama;
    document.getElementById('pl-harga').innerText = 'Rp ' + harga;
    document.getElementById('pl-hasil').innerText = hasil;
    document.getElementById('pl-diskon').innerText = diskon;

    let content = document.getElementById('print-area').innerHTML;
    let w = window.open('', '', 'width=400,height=400');
    w.document.write(`
        <html>
        <head>
            <title>Print</title>
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body onload="window.print()">${content}</body>
        </html>
    `);
    w.document.close();
}
</script>

<style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}
input[type=number] {
    -moz-appearance: textfield;
}
</style>

</body>
</html>
