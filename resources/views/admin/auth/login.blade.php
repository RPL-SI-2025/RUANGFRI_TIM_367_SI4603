<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | RUANGFRI</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-light">
    <div class="container d-flex justify-content-center align-items-center min-vh-100 py-4">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body p-4 p-md-5">
                    <div class="text-center mb-4">
                        <div class="mb-2">
                            <i class="fas fa-cog fa-2x text-primary"></i>
                        </div>
                        <h4 class="fw-bold mb-1">Login Admin</h4>
                        <p class="text-muted mb-0">Masuk untuk mengakses dashboard admin</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Periksa kembali email/password Anda.
                        </div>
                    @endif

                    <form action="{{ route('admin.login.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">Email</label>
                            <input id="email" type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   name="email" value="{{ old('email') }}"
                                   required autofocus autocomplete="email">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="admin_password" class="form-label fw-semibold">Password</label>
                            <div class="input-group">
                                <input id="admin_password" type="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       name="password" required autocomplete="current-password">
                                <button class="btn btn-outline-secondary" type="button" data-password-toggle="admin_password" aria-label="Toggle password visibility">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </form>

                    <div class="mt-4 text-center">
                        <a href="{{ route('landing') }}" class="text-decoration-none small">
                            <i class="fas fa-arrow-left me-1"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.querySelectorAll('[data-password-toggle]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-password-toggle');
                const input = document.getElementById(targetId);
                const icon = btn.querySelector('i');

                if (!input) return;
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                if (icon) {
                    icon.classList.toggle('fa-eye', !isPassword);
                    icon.classList.toggle('fa-eye-slash', isPassword);
                }
            });
        });
    </script>
</body>
</html>
