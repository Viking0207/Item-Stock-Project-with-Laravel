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
            <a class="navbar-brand fw-bold" href="#">
                <i class="fa-solid fa-tags me-2"></i>Diskon Barang
            </a>
            <a href="/Karyawan" class="btn btn-light ms-auto">
                Kembali <i class="fa-solid fa-arrow-right me-1"></i>
            </a>
        </div>
    </nav>

    <!-- FORM -->
    <div class="container d-flex justify-content-center mb-4">
        <div class="col-md-5">
            <div class="card shadow border-0 p-4">

                <h5 class="text-center fw-bold mb-4">
                    <i class="fa-solid fa-percent text-warning me-2"></i> Form Diskon Barang
                </h5>

                <div class="mb-3">
                    <label class="form-label">Kode PLU</label>
                    <input type="number" id="nama" class="form-control" placeholder="Contoh: 46****" onkeydown="return blokSemuaSimbol(event)">
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" id="nama" class="form-control" placeholder="Contoh: Chitato">
                </div>

                <div class="mb-3">
                    <label class="form-label">Harga (Rp / pcs)</label>
                    <input type="text" id="harga" class="form-control" placeholder="Contoh: 5000"
                        oninput="formatHarga(); hitung()">
                    <small class="text-muted">Ketik harga, otomatis diformat per 3 digit</small>
                </div>

                <div class="mb-3">
                    <label class="form-label">Diskon (%)</label>
                    <input type="number" id="diskon" class="form-control" placeholder="Contoh: 10"
                        oninput="validasiDiskon(); hitung()">
                    <small class="text-danger d-none" id="warn-diskon">Diskon tidak boleh lebih dari 100%</small>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-bold">Harga Setelah Diskon</label>
                    <input type="text" id="hasil" class="form-control bg-success text-white fw-bold text-center"
                        readonly>
                </div>

                <div class="d-grid gap-2">
                    {{-- <button class="btn btn-primary" onclick="simpan()">
                        <i class="fa-solid fa-floppy-disk me-2"></i>Simpan Diskon
                    </button> --}}

                    <button class="btn btn-warning text-white" onclick="cetakLabel()">
                        <i class="fa-solid fa-print me-2"></i>Cetak Price Label
                    </button>
                </div>

            </div>
        </div>
    </div>

    <!-- TEMPLATE PRINT -->
    <div id="print-area" class="d-none">
        <div class="border p-3 text-center mx-auto mt-3 shadow-sm rounded-3 bg-white">
            <h4 class="fw-bold" id="pl-nama"></h4>
            <h6>Harga Normal:</h6>
            <h5 class="text-decoration-line-through text-secondary" id="pl-harga"></h5>
            <h2 class="text-danger fw-bold" id="pl-hasil"></h2>
            <p class="fs-5">Diskon: <span class="fw-bold" id="pl-diskon"></span>%</p>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ✅ FORMAT HARGA TANPA CLEAVE
        function formatHarga() {
            let input = document.getElementById("harga");
            let value = input.value.replace(/\D/g, ""); // ambil angka doang
            if (!value) {
                input.value = "";
                return;
            }
            input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        function hitung() {
            let harga = document.getElementById("harga").value.replace(/\./g, "");
            let diskon = document.getElementById("diskon").value;

            let hargaNum = parseInt(harga);
            let diskonNum = parseInt(diskon);

            if (diskonNum > 100) diskonNum = 100; // hard limit

            if (!isNaN(hargaNum)) {
                let h = hargaNum - (hargaNum * (diskonNum / 100 || 0));
                document.getElementById("hasil").value = "Rp " + Math.floor(h).toLocaleString("id-ID");
            } else {
                document.getElementById("hasil").value = "";
            }
        }

        function simpan() {
            Swal.fire({
                icon: "success",
                title: "Berhasil!",
                text: "Diskon berhasil disimpan!",
                confirmButtonText: "OK"
            });
        }

        function validasiDiskon() {
            let input = document.getElementById("diskon");
            let warn = document.getElementById("warn-diskon");

            if (input.value > 100) {
                input.value = 100;
                warn.classList.remove("d-none");
            } else {
                warn.classList.add("d-none");
            }
        }


        function cetakLabel() {
            let nama = document.getElementById("nama").value;
            let harga = parseInt(document.getElementById("harga").value.replace(/\./g, ""));
            let diskon = parseInt(document.getElementById("diskon").value);
            let hasil = document.getElementById("hasil").value;

            if (!nama || isNaN(harga)) {
                Swal.fire({
                    icon: "error",
                    text: "Isi data dulu sebelum print!"
                });
                return;
            }

            document.getElementById("pl-nama").innerText = nama;
            document.getElementById("pl-harga").innerText = "Rp " + harga.toLocaleString("id-ID");
            document.getElementById("pl-hasil").innerText = hasil;
            document.getElementById("pl-diskon").innerText = diskon || 0;

            let printHTML = document.getElementById("print-area").innerHTML;

            let win = window.open("", "", "width=400,height=400");
            win.document.write(`
                <html>
                <head>
                    <title>Print Label</title>
                    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
                </head>
                <body onload="window.print()" class="p-3">${printHTML}</body>
                </html>
            `);
            win.document.close();
        }
    </script>

</body>

<script>
    function blokSemuaSimbol(e) {
        const simbolTerlarang = ['e', '+', '-', '.', ','];
        if (simbolTerlarang.includes(e.key.toLowerCase())) {
            e.preventDefault();
            return false;
        }
    }
</script>

<style>
    /* Hilangkan spinner di Chrome, Edge, Safari */
    input[type=number]::-webkit-outer-spin-button,
    input[type=number]::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    /* Hilangkan spinner di Firefox */
    input[type=number] {
        -moz-appearance: textfield;
    }
</style>


</html>
