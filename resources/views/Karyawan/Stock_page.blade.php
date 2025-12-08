<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cek Stok Barang</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <!-- SweetAlert2 (supaya Swal tersedia) -->
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}

    <!-- (Opsional) Font Awesome jika mau ikon tampil, bisa di-aktifkan -->
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" /> -->
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-dark bg-success mb-4 shadow-lg">
        <div class="container">
            <span class="navbar-brand fw-bold">
                <i class="fa fa-warehouse me-2"></i>Cek Stok Barang
            </span>
            <a href="/Karyawan" class="btn btn-light ms-auto">
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
                    <input type="text" id="plu" class="form-control" placeholder="Contoh: 461234" />
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
                <h6 class="text-center fw-bold text-success mb-3">Daftar Barang</h6>
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

                {{-- <div class="d-grid">
                    <button class="btn btn-dark" onclick="printHasil()">
                        <i class="fa fa-print me-2"></i>Cetak Rekap Hasil
                    </button>
                </div> --}}
            </div>

            {{-- <!-- Info biar kebayang -->
            <p class="text-center text-muted mt-3">Data rekomendasi ini hanya sementara (RAM Only)</p> --}}

        </div>
    </div>

    <script>

        // Perbaikan: koma yang hilang sebelumnya menyebabkan parse error
        const kategoriPrefix = {
            "43": "Makanan",
            "44": "Bahan Masakan",
            "46": "Minuman",
            "47": "Kosmetik",
            "58": "Perabotan Rumah",
            "59": "Barang Kebersihan",
            "61": "Alat Tulis Kerja",
            "63": "Obat-obatan"
        };

        function cekStok() {
    const plu = document.getElementById("plu").value.trim();
    if (!plu) return;

    fetch(`/cek-stok/${plu}`)
        .then(res => res.json())
        .then(res => {

            // kategori
            document.getElementById("kategori").innerText = res.kategori;

            const body = document.getElementById("hasilBody");
            body.innerHTML = "";

            if (res.data.length === 0) {
                body.innerHTML = `
                    <tr><td colspan="5">Data tidak ditemukan</td></tr>
                `;
                return;
            }

            // ✅ forEach KE ARRAY
            res.data.forEach((item, i) => {
                body.innerHTML += `
                    <tr>
                        <td>${i + 1}</td>
                        <td>${item.plu}</td>
                        <td>${item.nama_barang}</td>
                        <td>${res.kategori}</td>
                        <td>${item.stok}</td>
                    </tr>
                `;
            });
        })
        .catch(err => {
            console.error(err);
            alert("Gagal ambil data");
        });
    }

    </script>

</body>

</html>
