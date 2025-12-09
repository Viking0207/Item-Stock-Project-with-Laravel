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

            <form method="POST" action="{{ route('login.process') }}" id="loginForm" novalidate>
                @csrf

                <!-- Email -->
                <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control rounded-3 @error('email') is-invalid @enderror"
                        placeholder="Masukkan email" value="{{ old('email') }}" required>
                    @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label">Password</label>
                    <input type="password" name="password"
                        class="form-control rounded-3 @error('password') is-invalid @enderror"
                        placeholder="Masukkan password" required>
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100 rounded-3">Login</button>
            </form>

            <div class="text-center mt-2">
                <small class="text-muted">
                    Belum punya akun atau lupa password? 
                    <a href="#" class="text-decoration-none">Hubungi Nomor +628-123-456-789</a>
                </small>
            </div>

        </div>
    </div>

    <script>
        // Validasi sederhana client-side
        const form = document.getElementById('loginForm');

        form.addEventListener('submit', function(e) {
            const email = form.querySelector('[name="email"]').value.trim();
            const password = form.querySelector('[name="password"]').value.trim();

            if (!email || !password) {
                e.preventDefault();
                alert('Email dan Password wajib diisi!');
            }
        });
    </script>
</body>

</html>
