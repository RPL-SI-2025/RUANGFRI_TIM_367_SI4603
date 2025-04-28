<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RuangFRI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background-color: #198754;
            color: white;
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,.75);
        }
        .sidebar .nav-link:hover {
            color: rgba(255,255,255,1);
        }
        .sidebar .nav-link.active {
            color: white;
            font-weight: bold;
        }
        .content {
            padding: 20px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 sidebar p-3">
                <h3 class="text-center">Ruang FRI</h3>
                <hr>
                <ul class="nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#ruanganMenu" role="button" aria-expanded="false" aria-controls="ruanganMenu">
                            <i class="fas fa-door-open me-2"></i> Ruangan
                        </a>
                        <div class="collapse ms-3" id="ruanganMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="#">Katalog</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Peminjaman</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Pelaporan</a></li>
                            </ul>
                        </div>
                    </li>

                    <!-- Menu Inventaris -->
                    <li class="nav-item mt-2">
                        <a class="nav-link" data-bs-toggle="collapse" href="#inventarisMenu" role="button" aria-expanded="false" aria-controls="inventarisMenu">
                            <i class="fas fa-clipboard-list me-2"></i> Inventaris
                        </a>
                        <div class="collapse ms-3" id="inventarisMenu">
                            <ul class="nav flex-column">
                                <li class="nav-item"><a class="nav-link" href="#">Katalog</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Peminjaman</a></li>
                                <li class="nav-item"><a class="nav-link" href="#">Pelaporan</a></li>
                            </ul>
                        </div>
                    </li>

                </ul>
            </div>

            <!-- Content -->
            <div class="col-md-10 content">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
