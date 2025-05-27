<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Mahasiswa - RuangFri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    <style>
        body {
            background-image: url('{{ asset('storage/webaset/background.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-opacity: 0.8;
        }
        .card-header h3 {
            color: #2ecc71;
        }
        .btn-primary {
            background-color: #2ecc71;
            border-color: #2ecc71;
        }
        .btn-primary:hover {
            background-color: #27ae60;
            border-color: #27ae60;
        }
        .register-link {
            color: #2ecc71;
        }
        .register-link:hover {
            color: #27ae60;
        }
        .btn {
            border-radius: 25px;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <div class="card">
            <div class="card-header">
                <h3 class="mb-2"><i class="fas fa-user-graduate me-2"></i>Login Mahasiswa</h3>
                <p class="text-muted mb-2">Masuk ke akun untuk akses sistem peminjaman</p>
            </div>
            <div class="card-body p-4">
                @if(session('error'))
                    <div class="alert alert-danger">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.login.submit') }}">
                    @csrf
                    <div class="mb-4">
                        <label for="email" class="form-label">
                            <i class="fas fa-envelope me-2"></i>Email
                        </label>
                        <input type="email" class="form-control" id="email" name="email"
                            value="{{ old('email') }}" required autofocus
                            placeholder="Masukkan email Anda">
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password"
                               required placeholder="Masukkan password Anda">
                    </div>

                    <div class="mb-4 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">Ingat saya</label>
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Masuk
                        </button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <p class="mb-0">Belum punya akun?
                    <a href="{{ route('mahasiswa.register') }}" class="register-link">
                        <i class="fas fa-user-plus me-1"></i>Daftar sekarang
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
