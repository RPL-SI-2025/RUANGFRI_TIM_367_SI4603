<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi Mahasiswa - RuangFri</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <div class="container register-container">
        <div class="card">
            <div class="card-header">
                <div class="text-center mb-3">
                    <i class="fas fa-user-plus fa-3x register-icon"></i>
                </div>
                <h3 class="mb-2">Registrasi Mahasiswa</h3>
                <p class="text-muted">Daftar untuk mengakses sistem peminjaman inventaris</p>
            </div>

            <div class="card-body p-4">
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('mahasiswa.register.submit') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="nim" class="form-label">
                            <span class="icon-input"><i class="fas fa-id-card"></i></span>NIM
                        </label>
                        <input id="nim" type="text" class="form-control @error('nim') is-invalid @enderror" 
                            name="nim" value="{{ old('nim') }}" required autocomplete="nim" autofocus
                            placeholder="Masukkan Nomor Induk Mahasiswa">
                        @error('nim')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="nama_mahasiswa" class="form-label">
                            <span class="icon-input"><i class="fas fa-user"></i></span>Nama Lengkap
                        </label>
                        <input id="nama_mahasiswa" type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" 
                            name="nama_mahasiswa" value="{{ old('nama_mahasiswa') }}" required autocomplete="nama_mahasiswa"
                            placeholder="Masukkan nama lengkap Anda">
                        @error('nama_mahasiswa')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <span class="icon-input"><i class="fas fa-envelope"></i></span>Email
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" 
                            name="email" value="{{ old('email') }}" required autocomplete="email"
                            placeholder="Masukkan alamat email Anda">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">
                            <span class="icon-input"><i class="fas fa-lock"></i></span>Password
                        </label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" 
                            name="password" required autocomplete="new-password"
                            placeholder="Buat password Anda">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="password-confirm" class="form-label">
                            <span class="icon-input"><i class="fas fa-check-circle"></i></span>Konfirmasi Password
                        </label>
                        <input id="password-confirm" type="password" class="form-control" 
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="Ulangi password Anda">
                    </div>

                    <div class="d-grid gap-2 mb-3">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Daftar Sekarang
                        </button>
                    </div>
                </form>
            </div>
            
            <div class="card-footer text-center">
                <p class="mb-0">Sudah punya akun? 
                    <a href="{{ route('mahasiswa.login') }}" class="login-link">
                        <i class="fas fa-sign-in-alt me-1"></i>Login disini
                    </a>
                </p>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>