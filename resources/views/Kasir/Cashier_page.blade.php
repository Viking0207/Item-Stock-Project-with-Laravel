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
                            <input type="text" class="form-control form form-control-lg rounded-3"
                                placeholder="Masukkan PLU atau kode barang">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Nama Barang</label>
                            <input type="text" class="form-control form-control-lg rounded-3" placeholder="Masukkan nama barang">
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold fs-5">Harga</label>
                            <input type="number" class="form-control form-control-lg rounded-3" placeholder="Masukkan harga barang">
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-semibold fs-5">Jumlah</label>
                            <input type="number" class="form-control form-control-lg rounded-3" placeholder="Masukan quantity">
                        </div>

                        <button type="button" class="btn btn-primary btn-lg w-100 rounded-3">
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
                                <th>Nama Barang</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Total</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Dummy data contoh tampilan -->
                            <tr>
                                <td>1</td>
                                <td>Aqua</td>
                                <td>Rp 5.000</td>
                                <td>2</td>
                                <td>Rp 10.000</td>
                                <td>
                                    <button class="btn btn-danger btn-sm rounded-3">Hapus</button>
                                </td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Indomie</td>
                                <td>Rp 3.000</td>
                                <td>3</td>
                                <td>Rp 9.000</td>
                                <td>
                                    <button class="btn btn-danger btn-sm rounded-3">Hapus</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- TOTAL BELANJA DUMMY VIEW -->
                <div class="d-flex justify-content-end mt-3">
                    <h6 class="fw-bold">Grand Total: <span class="text-success">Rp 19.000</span></h6>
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

</html>
