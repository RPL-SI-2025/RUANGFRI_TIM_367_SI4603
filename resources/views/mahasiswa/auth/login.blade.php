<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk | Daftar - RUANGFRI</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom CSS -->
    <link href="{{ asset('css/single-auth.css') }}" rel="stylesheet">
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
    <!-- Background Elements -->
    <div class="auth-background">
        <div class="bg-circle circle-1"></div>
        <div class="bg-circle circle-2"></div>
        <div class="bg-circle circle-3"></div>
    </div>

    <!-- Main Container -->
    <div class="auth-container">
        <!-- Back to Home -->
        <div class="back-home">
            <a href="{{ route('landing') }}" class="btn-back">
                <i class="fas fa-arrow-left"></i>
                <span>Kembali ke Beranda</span>
            </a>
        </div>

        <!-- Auth Card -->
        <div class="auth-card">
            <!-- Brand Header -->
            <div class="auth-header">
                <div class="brand-logo">
                    <i class="fas fa-leaf"></i>
                </div>
                <h1 class="brand-name">RUANGFRI</h1>
                <p class="brand-subtitle">Sistem Peminjaman Fasilitas FRI</p>
            </div>

            <!-- Tab Navigation -->
            <div class="auth-tabs">
                <button class="tab-btn active" data-tab="login">
                    <i class="fas fa-sign-in-alt"></i>
                    <span>Masuk</span>
                </button>
                <button class="tab-btn" data-tab="register">
                    <i class="fas fa-user-plus"></i>
                    <span>Daftar</span>
                </button>
            </div>

            <!-- Forms Container -->
            <div class="forms-container">
                <!-- Login Form -->
                <div class="auth-form active" id="login-form">
                    <div class="form-header">
                        <h2>Selamat Datang Kembali</h2>
                        <p>Masuk ke akun Anda untuk mengakses sistem</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            {{ session('error') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.login.submit') }}" id="loginForm">
                        @csrf
                        
                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="login-email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email Address
                            </label>
                            <div class="input-wrapper">
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="login-email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       placeholder="Masukkan alamat email Anda">
                                <span class="input-focus"></span>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="login-password" class="form-label">
                                <i class="fas fa-lock"></i>
                                Password
                            </label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="login-password" 
                                       name="password" 
                                       required 
                                       placeholder="Masukkan password Anda">
                                <button type="button" class="password-toggle" onclick="togglePassword('login-password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <span class="input-focus"></span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Remember & Forgot -->
                        <div class="form-options">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                                <label class="form-check-label" for="remember">
                                    Ingat saya
                                </label>
                            </div>
                            <a href="#" class="forgot-link" onclick="alert('Fitur lupa password akan segera tersedia!')">
                                Lupa password?
                            </a>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit" id="loginBtn">
                            <span class="btn-text">
                                <i class="fas fa-sign-in-alt"></i>
                                Masuk ke Akun
                            </span>
                            <div class="btn-loading">
                                <div class="spinner"></div>
                                Memproses...
                            </div>
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <!-- Social Login -->
                        <button type="button" class="btn-social">
                            <i class="fab fa-google"></i>
                            Masuk dengan Google
                        </button>
                    </form>
                </div>

                <!-- Register Form -->
                <div class="auth-form" id="register-form">
                    <div class="form-header">
                        <h2>Bergabung dengan RUANGFRI</h2>
                        <p>Daftar untuk mengakses sistem peminjaman fasilitas</p>
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle"></i>
                            <strong>Terjadi kesalahan:</strong>
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('mahasiswa.register.submit') }}" id="registerForm">
                        @csrf

                        <!-- NIM Field -->
                        <div class="form-group">
                            <label for="nim" class="form-label">
                                <i class="fas fa-id-card"></i>
                                Nomor Induk Mahasiswa (NIM)
                            </label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       class="form-control @error('nim') is-invalid @enderror" 
                                       id="nim" 
                                       name="nim" 
                                       value="{{ old('nim') }}" 
                                       required 
                                       placeholder="Masukkan NIM Anda">
                                <span class="input-focus"></span>
                            </div>
                            @error('nim')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Nama Field -->
                        <div class="form-group">
                            <label for="nama_mahasiswa" class="form-label">
                                <i class="fas fa-user"></i>
                                Nama Lengkap
                            </label>
                            <div class="input-wrapper">
                                <input type="text" 
                                       class="form-control @error('nama_mahasiswa') is-invalid @enderror" 
                                       id="nama_mahasiswa" 
                                       name="nama_mahasiswa" 
                                       value="{{ old('nama_mahasiswa') }}" 
                                       required 
                                       placeholder="Masukkan nama lengkap Anda">
                                <span class="input-focus"></span>
                            </div>
                            @error('nama_mahasiswa')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email Field -->
                        <div class="form-group">
                            <label for="register-email" class="form-label">
                                <i class="fas fa-envelope"></i>
                                Email Address
                            </label>
                            <div class="input-wrapper">
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="register-email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       required 
                                       placeholder="Masukkan alamat email Anda">
                                <span class="input-focus"></span>
                            </div>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Password Field -->
                        <div class="form-group">
                            <label for="register-password" class="form-label">
                                <i class="fas fa-lock"></i>
                                Password
                            </label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="register-password" 
                                       name="password" 
                                       required 
                                       placeholder="Buat password yang kuat">
                                <button type="button" class="password-toggle" onclick="togglePassword('register-password')">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <span class="input-focus"></span>
                            </div>
                            <div class="password-strength">
                                <div class="strength-bar">
                                    <div class="strength-fill" id="strengthBar"></div>
                                </div>
                                <span class="strength-text" id="strengthText">Masukkan password</span>
                            </div>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
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

                        <!-- Confirm Password Field -->
                        <div class="form-group">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-check-circle"></i>
                                Konfirmasi Password
                            </label>
                            <div class="input-wrapper">
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       required 
                                       placeholder="Ulangi password Anda">
                                <span class="input-focus"></span>
                            </div>
                            <div class="password-match" id="passwordMatch"></div>
                        </div>
                    <div class="mb-4">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock me-2"></i>Password
                        </label>
                        <input type="password" class="form-control" id="password" name="password"
                               required placeholder="Masukkan password Anda">
                    </div>

                        <!-- Terms & Conditions -->
                        <div class="form-check mb-4">
                            <input type="checkbox" class="form-check-input" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Saya setuju dengan <a href="#" class="terms-link">Syarat & Ketentuan</a> 
                                dan <a href="#" class="terms-link">Kebijakan Privasi</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit" class="btn-submit" id="registerBtn">
                            <span class="btn-text">
                                <i class="fas fa-user-plus"></i>
                                Daftar Sekarang
                            </span>
                            <div class="btn-loading">
                                <div class="spinner"></div>
                                Memproses...
                            </div>
                        </button>

                        <!-- Divider -->
                        <div class="divider">
                            <span>atau</span>
                        </div>

                        <!-- Social Register -->
                        <button type="button" class="btn-social">
                            <i class="fab fa-google"></i>
                            Daftar dengan Google
                        </button>
                    </form>
                </div>
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

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('js/single-auth.js') }}"></script>
</body>
</html>
