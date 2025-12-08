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
                    <input type="text" id="plu" class="form-control" placeholder="Contoh: 461234" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Nama Barang</label>
                    <input type="text" id="nama" class="form-control" />
                </div>

                <div class="mb-3">
                    <label class="form-label">Kuantitas</label>
                    <input type="number" id="qty" class="form-control" onkeydown="return blokSemua(event)"
                        min="1" />
                </div>

                <div class="d-grid gap-2">
                    <button class="btn btn-danger" onclick="tambahTabel()">
                        <i class="fa fa-plus me-2"></i>Add Data
                    </button>
                    <button class="btn btn-dark" onclick="printTabel()">
                        <i class="fa fa-print me-2"></i>Cetak Rekap Tabel
                    </button>
                </div>
            </div>

            <!-- TABEL SEMENTARA (RAM) -->
            <div class="card shadow border-0 mt-4 p-3">
                <h6 class="text-center fw-bold text-danger mb-3">Tabel Destroy Barang</h6>
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

            <div class="d-flex justify-content-end mt-3 mb-5">
                <button class="btn btn-primary" onclick="submitDestroy()">
                    <i class="fa fa-check me-2"></i>Submit
                </button>
            </div>

        </div>
    </div>

    <!-- PRINT AREA TABEL -->
    <div id="print-area" class="d-none"></div>

</body>

<script>
    const dataDestroy = []; // ini RAM-nya bro 😎

    function blokSemua(e) {
        const terlarang = ["e", "+", "-", ".", ","];
        if (terlarang.includes(e.key.toLowerCase())) {
            e.preventDefault();
            return false;
        }
    }

    // Fungsi render tabel
    function renderTabel() {
        const tbody = document.querySelector("#tabelDestroy tbody");
        tbody.innerHTML = "";

        dataDestroy.forEach((item, index) => {
            tbody.innerHTML += `
            <tr>
                <td>${item.plu}</td>
                <td>${item.nama}</td>
                <td>${item.qty}</td>
                <td>
                    <button class="btn btn-sm btn-outline-danger" onclick="hapus(${index})">
                        <i class="fa fa-x"></i>
                    </button>
                </td>
            </tr>`;
        });
    }


    function tambahTabel() {
        const plu = document.getElementById("plu").value.trim();
        const nama = document.getElementById("nama").value.trim();
        const qty = parseInt(document.getElementById("qty").value);

        if (!plu || !nama || isNaN(qty) || qty < 1) {
            Swal.fire("Error!", "Mohon isi semua data dengan benar!", "error");
            return;
        }

        // Ambil stok terbaru dari server
        fetch(`/destroy/get-stock/${plu}`)
            .then(res => res.json())
            .then(data => {
                const stokTersisa = data.total_quantity; // total_quantity di tb_makanan
                if (stokTersisa <= 0) {
                    Swal.fire("Error!", "Stok barang sudah habis!", "error");
                    return;
                } else if (qty > stokTersisa) {
                    Swal.fire("Error!", `Stok barang tidak mencukupi! Sisa stok: ${stokTersisa}`, "error");
                    return;
                }

                // Jika lolos validasi, push ke RAM
                dataDestroy.push({
                    plu,
                    nama,
                    qty
                });
                renderTabel();
            });
    }


    function hapus(i) {
        dataDestroy.splice(i, 1);
        renderTabel();
    }

    function printTabel() {
        if (dataDestroy.length === 0) {
            Swal.fire("Info", "Tidak ada data untuk dicetak!", "info");
            return;
        }

        // Buat baris tabel dari dataDestroy
        let rows = "";
        let no = 1;
        let totalQty = 0;
        dataDestroy.forEach(item => {
            rows += `
            <tr>
                <td>${no++}</td>
                <td>${item.plu}</td>
                <td>${item.nama}</td>
                <td>${item.qty}</td>
            </tr>`;
            totalQty += item.qty;
        });

        // Buka window baru untuk print
        const printWindow = window.open("", "", "width=900,height=600");
        printWindow.document.write(`
        <html>
        <head>
            <title>Rekap Destroy Barang</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
            <style>
                body { padding: 30px; font-family: Arial, sans-serif; }
                h4 { margin-bottom: 20px; }
                table { font-size: 14px; }
                .total-row { font-weight: bold; background-color: #d1e7dd; }
            </style>
        </head>
        <body onload="window.print()">

            <h4 class="text-center fw-bold text-danger">REKAP DESTROY BARANG</h4>
            <p class="text-center text-muted">Tanggal: ${new Date().toLocaleString('id-ID')}</p>

            <table class="table table-bordered table-striped text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>No</th>
                        <th>PLU</th>
                        <th>Nama Barang</th>
                        <th>Qty</th>
                    </tr>
                </thead>
                <tbody>
                    ${rows}
                    <tr class="total-row">
                        <td colspan="3" class="text-end">TOTAL KUANTITAS</td>
                        <td>${totalQty}</td>
                    </tr>
                </tbody>
            </table>

        </body>
        </html>
    `);
        printWindow.document.close();
    }


    // Auto-fill nama_barang berdasarkan PLU
    document.getElementById('plu').addEventListener('input', function() {
        const plu = this.value.trim();
        if (!plu) return;

        fetch(`/destroy/get-data/${plu}`)
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    document.getElementById('nama').value = data.nama_barang;
                } else {
                    document.getElementById('nama').value = '';
                }
            });
    });

    // Submit destroy (mengosongkan tabel RAM setelah submit)
    function submitDestroy() {
        if (dataDestroy.length === 0) {
            Swal.fire("Error!", "Tidak ada barang untuk dimusnahkan!", "error");
            return;
        }

        fetch("{{ route('destroy.submit') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    items: dataDestroy
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire("Sukses!", data.message, "success");
                    dataDestroy.length = 0; // Kosongkan tabel RAM
                    renderTabel(); // Refresh tabel
                } else {
                    Swal.fire("Error!", "Terjadi kesalahan saat submit!", "error");
                }
            });
    }
</script>

</html>
