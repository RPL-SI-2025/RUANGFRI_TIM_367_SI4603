<!-- resources/views/layouts/admin.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
        }
        main {
            margin-left: 16.6%;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand fw-bold d-flex align-items-center" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-speedometer2 me-2"></i> Admin Panel
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
                <span class="navbar-toggler-icon"></span>
            </button>
    
            <div class="collapse navbar-collapse justify-content-end" id="navbarContent">
                <ul class="navbar-nav align-items-center">
                    <li class="nav-item me-3">
                        <span class="nav-link text-white">
                            <i class="bi bi-person-circle me-1"></i> Selamat datang, {{ Auth::user()->nama ?? 'Admin' }}
                        </span>
                    </li>
                    <li class="nav-item">
                        {{-- <a class="nav-link text-white" href="{{ route('logout') }}"> --}}
                            <i class="bi bi-box-arrow-right me-1"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    

<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <nav class="col-md-2 d-none d-md-block bg-light sidebar shadow-sm py-4">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('admin.dashboard') }}"><i class="bi bi-house-door"></i> Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="bi bi-person"></i> Profile</a>
                </li>

                <!-- Manajemen Ruangan -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#ruanganMenu" role="button" aria-expanded="false" aria-controls="ruanganMenu">
                        <i class="bi bi-door-open"></i> Manajemen Ruangan
                    </a>
                    <div class="collapse ms-3" id="ruanganMenu">
                        <ul class="nav flex-column">
                            <li><a class="nav-link" href="{{ route('admin.katalog_ruangan.index') }}" >📁 Data Ruangan</a></li>
                            <li><a class="nav-link"  href="{{ route('admin.pinjam-ruangan.index') }}" >✅ Approval Ruangan</a></li>
                            <li><a class="nav-link"  href="{{ route('admin.lapor_ruangan.index') }}" >📋 Laporan Ruangan</a></li>
                            <li><a class="nav-link" {{-- href="{{ route('riwayat.peminjaman') }}" --}}>🗓️ Riwayat Peminjaman Ruangan</a></li>
                        </ul>
                    </div>
                </li>

                <!-- Manajemen Inventaris -->
                <li class="nav-item">
                    <a class="nav-link" data-bs-toggle="collapse" href="#inventarisMenu" role="button" aria-expanded="false" aria-controls="inventarisMenu">
                        <i class="bi bi-box-seam"></i> Manajemen Inventaris
                    </a>
                    <div class="collapse ms-3" id="inventarisMenu">
                        <ul class="nav flex-column">
                            <li><a class="nav-link" href="{{ route('admin.inventaris.index') }}">📦 Data Inventaris</a></li>
                                <li><a class="nav-link" href="{{ route('admin.pinjam-inventaris.index') }}" >✅ Approval Inventaris</a></li>
                                <li><a class="nav-link" href="{{ route('admin.lapor_inventaris.index') }}"      >📋 Laporan Inventaris</a></li>
                                <li><a class="nav-link" {{-- href="{{ route('riwayat.inventaris') }}"--}}   >🗓️ Riwayat Peminjaman Inventaris</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>

        <!-- Main Content -->
        <main class="col-md-10 ms-sm-auto px-md-4 py-4">
            @yield('content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
