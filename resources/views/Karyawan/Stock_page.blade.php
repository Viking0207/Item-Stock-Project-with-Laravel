<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cek Stok Barang</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Cleave.js buat format angka (kalau kamu mau nanti saat pakai input rupiah, siap diaktifin) -->
    <!-- NOTE: sekarang gak dipakai dulu sesuai statement kamu -->

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-light">

<!-- Navbar -->
<nav class="navbar navbar-dark bg-success mb-4 shadow-lg">
    <div class="container">
        <span class="navbar-brand fw-bold">
            <i class="fa fa-warehouse me-2"></i>Cek Stok Barang
        </span>
        <a href="/Karyawan  " class="btn btn-light ms-auto">
            Kembali <i class="fa fa-arrow-right ms-2"></i>
        </a>
    </div>
</nav>

<!-- Main -->
<div class="container d-flex justify-content-center">
    <div class="col-md-7">

        <!-- Form Input -->
        <div class="card shadow border-0 p-4">
            <h5 class="text-center fw-bold text-success mb-3">
                <i class="fa fa-search me-2"></i>Masukkan Kode Barang
            </h5>

            <div class="input-group mb-3">
                <input type="text" id="plu" class="form-control" placeholder="Contoh: 461234">
                <button class="btn btn-success" onclick="cekStok()">
                    <i class="fa fa-magnifying-glass"></i> Cek
                </button>
            </div>

            <div class="text-center">
                <span class="fw-bold">Kategori:</span>
                <span id="kategori" class="badge bg-success fs-6 p-2">-</span>
            </div>
        </div>

        <!-- Hasil Rekomendasi (RAM) -->
        <div class="card shadow border-0 bg-white mt-4 p-3">
            <h6 class="text-center fw-bold text-success mb-3">Daftar Barang Serupa</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-hover text-center align-middle">
                    <thead class="table-success">
                        <tr>
                            <th>#</th>
                            <th>Kode PLU</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Stok</th>
                        </tr>
                    </thead>
                    <tbody id="hasilBody"></tbody>
                </table>
            </div>

            <div class="d-grid">
                <button class="btn btn-dark" onclick="printHasil()">
                    <i class="fa fa-print me-2"></i>Cetak Rekap Hasil
                </button>
            </div>
        </div>

        {{-- <!-- Info biar kebayang -->
        <p class="text-center text-muted mt-3">Data rekomendasi ini hanya sementara (RAM Only)</p> --}}

    </div>
</div>

<script>

    // Simulasi data barang dari RAM
    const databaseRam = [
        { kode: "461234", nama: "Chitato", kategori: "Makanan", stok: 120 },
        { kode: "468999", nama: "Lays", kategori: "Makanan", stok: 87 },
        { kode: "461111", nama: "Oreo", kategori: "Makanan", stok: 200 },
        { kode: "470123", nama: "Aqua", kategori: "Minuman", stok: 500 },
        { kode: "470987", nama: "Sprite", kategori: "Minuman", stok: 220 },
        { kode: "480123", nama: "Kaos Distro", kategori: "Fashion", stok: 90 },
        { kode: "490100", nama: "Kabel Charger", kategori: "Elektronik", stok: 300 }
    ];

    const kategoriPrefix = {
        "43": "Makanan",
        "44": "Bahan Masakan",
        "46": "Minuman",
        "47": "Kosmetik"
        "58": "Perabotan Rumah"
        "59": "Barang Kebersihan"
        "61": "Alat Tulis Kerja"
        "63 ": "Obat-obatan"

    };

    function cekStok() {
        const plu = document.getElementById("plu").value.trim();

        // Deteksi kategori dari 2 digit awal
        const awalan = plu.substring(0, 2);
        document.getElementById("kategori").innerText = kategoriPrefix[awalan] || "Tidak diketahui";

        // Cari barang yang mirip dengan prefix yang sama
        const rekomendasi = databaseRam.filter(b => b.kode.startsWith(awalan));

        // Urutkan: yang paling akurat ke paling atas
        // Cek apakah ada yang sama persis, kalau ada prioritaskan atas sendiri
        const sorted = rekomendasi.sort((a, b) => {
            if (a.kode === plu) return -1;
            if (b.kode === plu) return 1;
            return 0;
        });

        // Render ke tabel
        const body = document.getElementById("hasilBody");
        body.innerHTML = "";

        if (sorted.length === 0) {
            body.innerHTML = `<tr>
                <td colspan="5">Tidak ada barang dengan awalan kode ${awalan}</td>
            </tr>`;
            return;
        }

        sorted.forEach((b, i) => {
            body.innerHTML += `<tr>
                <td>${i + 1}</td>
                <td>${b.kode}</td>
                <td>${b.nama}</td>
                <td>${b.kategori}</td>
                <td>${b.stok}</td>
            </tr>`;
        });

        // Notif berhasil
        Swal.fire({
            icon: "success",
            title: "Pencarian Selesai",
            text: `Menampilkan barang dengan awalan ${awalan}`,
        });
    }

    function printHasil() {
        const table = document.querySelector("table").outerHTML;
        const w = window.open("", "", "width=800,height=600");
        w.document.write("<h5 class='text-center mb-3'>Rekap Hasil Cek Stok</h5>" + table);
        w.document.close();
        w.print();
    }

</script>

</body>
</html>
