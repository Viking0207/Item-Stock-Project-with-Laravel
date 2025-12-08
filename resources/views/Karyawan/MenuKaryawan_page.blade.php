<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Karyawan</title>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4 shadow" 
        style="background: linear-gradient(90deg, #0d6efd, #6610f2);">
        <div class="container">
            <a class="navbar-brand fw-bold">
                <i class="fa fa-user-tie me-2"></i>Dashboard Karyawan
            </a>

            <!-- Tombol Back -->
            <a href="/Home" class="btn btn-light ms-auto">
                Kembali <i class="fa fa-arrow-right ms-2"></i> 
            </a>
        </div>
    </nav>

    <!-- Menu -->
    <div class="container">
        <div class="row g-4 justify-content-center">

            <!-- Penerimaan Barang -->
            <div class="col-md-3" data-aos="fade-up" data-aos-duration="800">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-boxes-stacked fa-3x text-primary mb-3"></i>
                        <h6 class="fw-bold">Penerimaan Barang</h6>
                        <a href="/terima" class="btn btn-primary mt-2">
                            Buka Menu <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Cek Stok Barang -->
            <div class="col-md-3" data-aos="zoom-in" data-aos-duration="800">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-warehouse fa-3x text-success mb-3"></i>
                        <h6 class="fw-bold">Cek Stok Barang</h6>
                        <a href="/Stok" class="btn btn-success mt-2">
                            Buka Menu <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Pemusnahan Barang -->
            <div class="col-md-3" data-aos="fade-down" data-aos-duration="800">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-trash-can fa-3x text-danger mb-3"></i>
                        <h6 class="fw-bold">Pemusnahan Barang</h6>
                        <a href="/destroy" class="btn btn-danger mt-2">
                            Buka Menu <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Diskon Barang -->
            <div class="col-md-3" data-aos="flip-left" data-aos-duration="800">
                <div class="card shadow border-0">
                    <div class="card-body text-center p-4">
                        <i class="fa fa-tags fa-3x text-warning mb-3"></i>
                        <h6 class="fw-bold">Diskon Barang</h6>
                        <a href="/Diskon" class="btn btn-warning mt-2 text-white">
                            Buka Menu <i class="fa fa-arrow-right ms-2"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        .card {
            transition: 0.3s ease-in-out;
            cursor: pointer;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 25px rgba(0, 123, 255, 0.4) !important;
        }

        .card i {
            animation: glow 1.5s infinite alternate;
        }

        @keyframes glow {
            0% { filter: brightness(100%); }
            100% { filter: brightness(150%); }
        }

        .btn {
            transition: 0.2s;
        }

        .btn:hover {
            letter-spacing: 1px;
        }
    </style>

</body>

</html>
