<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>
<body class="bg-light d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-sm p-4 rounded-4" style="width: 350px;">
    <div class="card-body">

        <h5 class="text-center mb-4 fw-bold">Selamat Datang 👋</h5>

        <form>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control rounded-3" placeholder="Masukkan email">
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <input type="password" class="form-control rounded-3" placeholder="Masukkan password">
            </div>

            <button type="button" class="btn btn-primary w-100 rounded-3">Login</button>
        </form>

        <div class="text-center mt-2">
            <small class="text-muted">Belum punya akun atau Lupa password? <a href="#" class="text-decoration-none">Hubungi Nomor +628-123-456-789</a></small>
        </div>

    </div>
</div>
</body>
</html>
