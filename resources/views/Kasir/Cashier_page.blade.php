<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Kasir UI</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light">

<div class="container py-4">

    <!-- FORM INPUT -->
    <div class="card shadow-sm mb-4 rounded-4">
        <div class="card-body p-4">
            <h5 class="card-title mb-3">Form Kasir</h5>

            <form>
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label">Nama Barang</label>
                        <input type="text" class="form-control rounded-3" placeholder="Masukan nama barang">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Harga</label>
                        <input type="number" class="form-control rounded-3" placeholder="Masukan harga">
                    </div>

                    <div class="col-md-2">
                        <label class="form-label">Jumlah</label>
                        <input type="number" class="form-control rounded-3" placeholder="Qty">
                    </div>

                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-primary w-100 rounded-3">
                            Tambah ke Tabel
                        </button>
                    </div>
                </div>
            </form>
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

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
