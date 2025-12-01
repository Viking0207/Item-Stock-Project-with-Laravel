<!DOCTYPE html>
<html lang="id">

<head>
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <!-- Tombol Logout / Kembali di Pojok Atas Kanan -->
    <a href="/" class="btn btn-outline-danger btn-lg rounded-3 d-inline-flex align-items-center gap-2 shadow-sm"
        style="position: absolute; top: 20px; right: 20px; z-index: 999;">
        Logout <i class="fa-solid fa-right-from-bracket"></i>
    </a>


    <div class="container text-center">
        <div data-aos="fade-down" data-aos-duration="700">
            <h1 class="fw-bold mb-2 display-5">Pilih Menu</h1>
            <p class="text-secondary mb-5">Silakan pilih akses sistem yang ingin digunakan</p>
        </div>

        <div class="row justify-content-center g-4">

            <!-- Menu Karyawan -->
            <div class="col-12 col-md-4" data-aos="zoom-in" data-aos-delay="200">
                <a href="/Karyawan" class="text-decoration-none">
                    <div class="card menu-card border-0 shadow rounded-4 p-3">
                        <div class="card-body">
                            <div class="icon-box bg-info bg-opacity-10 text-info mx-auto">
                                <i class="fa-solid fa-user-tie"></i>
                            </div>
                            <h4 class="fw-semibold mt-4">Karyawan</h4>
                            <p class="text-muted">Kelola data karyawan</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Menu Kasir -->
            <div class="col-12 col-md-4" data-aos="zoom-in" data-aos-delay="350">
                <a href="/Kasir" class="text-decoration-none">
                    <div class="card menu-card border-0 shadow rounded-4 p-3">
                        <div class="card-body">
                            <div class="icon-box bg-warning bg-opacity-10 text-warning mx-auto">
                                <i class="fa-solid fa-cash-register"></i>
                            </div>
                            <h4 class="fw-semibold mt-4">Kasir</h4>
                            <p class="text-muted">Akses sistem kasir</p>
                        </div>
                    </div>
                </a>
            </div>

        </div>
    </div>

    <style>
        .menu-card {
            background: #ffffff;
            transition: 0.3s ease-in-out;
        }

        .menu-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1) !important;
        }

        .icon-box {
            width: 95px;
            height: 95px;
            border-radius: 22px;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 45px;
            transition: 0.3s;
        }

        .menu-card:hover .icon-box {
            transform: scale(1.15);
        }

        h1 {
            background: linear-gradient(45deg, #4f46e5, #2563eb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>

    <script>
        AOS.init({
            once: true,
            easing: 'ease-out-cubic'
        });
    </script>

</body>

</html>
