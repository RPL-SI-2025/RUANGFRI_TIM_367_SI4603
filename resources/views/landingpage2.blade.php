<!-- filepath: resources/views/landing.blade.php -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Inventaris & Ruangan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" >
    <style>

        
    .hero {
        background: linear-gradient(135deg, #2563eb 0%, #0d6efd 100%);
        color: #fff;
        position: relative;
        overflow: hidden;
        padding: 100px 20px; /* Sesuaikan padding untuk responsivitas */
        border-radius: 0 0 50px 50px; /* Kurangi radius untuk tampilan lebih modern */
        box-shadow: 0 10px 30px rgba(13, 110, 253, 0.15);
        text-align: center;
    }

    .hero h1 {
        font-size: 3rem; /* Sesuaikan ukuran font */
        font-weight: 800;
        line-height: 1.2;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.2rem;
        opacity: 0.9;
        max-width: 700px;
        margin: 0 auto 2rem;
    }

    .hero .btn {
        padding: 0.8rem 2rem;
        font-size: 1rem;
        border-radius: 50px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .hero .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.5rem; /* Ukuran font lebih kecil untuk layar kecil */
        }

        .hero p {
            font-size: 1rem;
        }

        .hero {
            padding: 80px 15px; /* Kurangi padding untuk layar kecil */
        }
    }

        @keyframes float {
            from { transform: translateY(0) rotate(0deg); }
            to { transform: translateY(-100%) rotate(10deg); }
        }


        #fitur {
        padding: 60px 20px; /* Tambahkan padding untuk jarak */
        background: #f8f9fa; /* Warna latar belakang yang lembut */
    }

    .feature-card {
        background: #ffffff;
        border-radius: 15px; /* Tambahkan border radius */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
        padding: 30px; /* Tambahkan padding internal */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .feature-card:hover {
        transform: translateY(-10px); /* Efek hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Bayangan lebih besar saat hover */
    }

    .feature-icon {
        width: 80px;
        height: 80px;
        background: linear-gradient(135deg, #e0e7ff 0%, #f0f7ff 100%);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 20px;
        font-size: 2rem;
        color: #2563eb;
    }

    .feature-title {
        font-size: 1.5rem;
        font-weight: 700;
        color: #2563eb;
        margin-bottom: 10px;
    }

    .feature-description {
        font-size: 1rem;
        color: #475569;
        line-height: 1.6;
    }


    .navbar {
        background: rgba(255, 255, 255, 0.95) !important;
        backdrop-filter: blur(10px);
        padding: 1.5rem 1rem; /* Tambahkan padding lebih besar */
    }

    .navbar-brand {
        font-size: 1.8rem; /* Perbesar ukuran font */
        font-weight: 800;
        background: linear-gradient(135deg, #0d6efd, #2563eb);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        margin-right: 2rem; /* Tambahkan jarak dengan menu */
    }

    .navbar-nav {
        gap: 1.5rem; /* Tambahkan jarak antar item menu */
    }

    .nav-item {
        margin: 0 0.5rem; /* Tambahkan margin antar item */
    }

    .nav-link {
        font-size: 1rem; /* Sesuaikan ukuran font */
        font-weight: 500;
        padding: 0.5rem 1rem; /* Tambahkan padding */
        transition: all 0.3s ease;
    }

    .nav-link:hover {
        color: #2563eb; /* Warna hover */
    }

    .nav-btn {
        border-radius: 50px;
        padding: 0.5rem 1.5rem;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-left: 1rem; /* Tambahkan jarak dengan menu lainnya */
    }

    .nav-btn:hover {
        transform: translateY(-2px);
    }

    .btn {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(255, 0, 0, 0.2);
    }

    .btn:active {
        transform: translateY(-1px);
    }

    .btn::after {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: linear-gradient(120deg, transparent, rgba(255,255,255,0.2), transparent);
        transform: translateX(-100%);
    }

    .btn:hover::after {
        animation: btn-shine 1.5s ease;
    }

    .btn-gradient {
        background: linear-gradient(135deg, #2563eb, #0d6efd);
        color: white;
        border: none;
    }

    .btn-gradient:hover {
        background: linear-gradient(135deg, #2563eb, #fedbdb);
        color: 1e3a8a;
        font-weight: bold
        
    }

    @keyframes btn-shine {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(100%);
        }
    }

    /* Specific button styles */
    .btn-outline-primary:hover {
        background: linear-gradient(135deg, #0d6efd, #2563eb);
        border-color: transparent;
    }

    .btn-primary {
        background: linear-gradient(135deg, #0d6efd, #2563eb);
        border: none;
    }

    .btn-primary:hover {
        background: linear-gradient(135deg, #2563eb, #0d6efd);
        border: none;
    }

    /* Navigation link hover effect */
    .nav-link {
        position: relative;
        padding: 0.5rem 1rem;
    }

    .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background: linear-gradient(135deg, #0d6efd, #2563eb);
        transition: all 0.3s ease;
        transform: translateX(-50%);
    }

    .nav-link:hover::after {
        width: 80%;
    }

    #jumlah-ruangan-inventaris {
    padding: 60px 20px; /* Tambahkan padding untuk jarak */
    background: #f8f9fa; /* Warna latar belakang yang lembut */
    }



    .card {
        background: #ffffff;
        border-radius: 15px; /* Tambahkan border radius */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-10px); /* Efek hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Bayangan lebih besar saat hover */
    }

    .card .card-body {
        padding: 20px; /* Tambahkan padding internal */
    }

    .card .card-body h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #475569;
        margin-bottom: 10px;
    }

    .card .card-body h2 {
        font-size: 2.5rem;
        font-weight: 800;
        color: #2563eb;
    }

    .card .card-body i {
        color: #2563eb;
        margin-bottom: 10px;
    }



    footer {
    background: #2563eb; /* Warna latar belakang sesuai tema */
    color: #ffffff; /* Warna teks */
    padding: 60px 20px; /* Tambahkan padding */
    }

    footer h5 {
        font-size: 1.2rem;
        font-weight: 700;
        color: #ffffff; /* Warna teks heading */
        margin-bottom: 20px;
    }

    footer p, footer a {
        font-size: 0.95rem;
        color: #e5e7eb; /* Warna teks */
        line-height: 1.6;
    }

    footer a:hover {
        color: #fbbf24; /* Warna hover link */
        text-decoration: none;
    }

    footer .social-icons a {
        color: #e5e7eb;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    footer .social-icons a:hover {
        color: #fbbf24;
    }

    footer ul {
        padding: 0;
        list-style: none;
    }

    footer ul li {
        margin-bottom: 10px;
    }

    footer ul li a {
        text-decoration: none;
        color: #e5e7eb;
        transition: color 0.3s ease;
    }

    footer ul li a:hover {
        color: #fbbf24;
    }

    #gedung {
        background: #f8f9fa; /* Warna latar belakang yang lembut */
        padding: 60px 20px; /* Tambahkan padding untuk jarak */
    }

    #gedung h2 {
        font-size: 2rem;
        font-weight: 800;
        color: #2563eb; /* Warna heading */
        margin-bottom: 20px;
    }

    #gedung p {
        font-size: 1.1rem;
        color: #475569; /* Warna teks */
        line-height: 1.6;
    }

    .card {
        border-radius: 15px; /* Tambahkan border radius */
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1); /* Tambahkan bayangan */
        overflow: hidden; /* Pastikan gambar tidak keluar dari card */
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px); /* Efek hover */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15); /* Bayangan lebih besar saat hover */
    }

    .card img {
        object-fit: cover;
        min-height: 320px;
        max-height: 400px;
        width: 100%;
    }

    .card h2 {
        font-size: 1.8rem;
        font-weight: 700;
        color: #2563eb; /* Warna heading */
    }

    .card p {
        font-size: 1rem;
        color: #475569; /* Warna teks */
        line-height: 1.6;
    }

    .card a {
        background: linear-gradient(135deg, #2563eb, #0d6efd);
        color: #fff;
        font-weight: 600;
        padding: 0.8rem 2rem;
        border-radius: 50px;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .card a:hover {
        background: linear-gradient(135deg, #0d6efd, #2563eb);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
    }

    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">RUANGFRI</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#hero">Beranda</a>
                </li>
                   <li class="nav-item">
                    <a class="nav-link" href="#tentang">Tentang Kami</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#fitur">Fitur</a>
                </li>
                {{-- <li class="nav-item">
                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login Admin</a>
                </li> --}}
                <li class="nav-item">
                    <a href="{{ route('mahasiswa.login') }}" class="btn btn-primary">Login Mahasiswa</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<section id="hero" class="hero">
    <div class="container">
        <h1 class="mb-3 animate__animated animate__fadeInDown">
            Sistem Peminjaman Inventaris & Ruangan
        </h1>
        <p class="mt-3 mb-4 animate__animated animate__fadeInUp">
            Kelola peminjaman ruangan dan inventaris kampus dengan mudah, cepat, dan terintegrasi.
        </p>
        <a href="{{ route('mahasiswa.register') }}" class="btn btn-light btn-lg shadow animate__animated animate__pulse animate__infinite">
            Daftar Mahasiswa
        </a>
    </div>
</section>

    {{-- Section Tentang Kami --}}
<section id="tentang" class="py-5" style="background: #f8f9fa;">
    <div class="container">
        <div class="about-section text-center p-5 rounded shadow-sm bg-white animate__animated animate__fadeInUp">
            <h4 class="fw-bold mb-3 text-primary">Tentang Kami</h4>
            <p class="fs-5" style="color: #475569">
                <strong>RUANGFRI</strong> adalah platform digital yang dirancang untuk memudahkan pengelolaan peminjaman ruangan dan inventaris di lingkungan kampus. 
                Dengan sistem terintegrasi, proses peminjaman menjadi lebih efisien, transparan, dan terdokumentasi dengan baik.
            </p>
        </div>
    </div>
</section>
    

        {{-- Section Fitur --}}
<section id="fitur" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #2563eb;">Fitur</h2>
            <p class="fs-5" style="color: #475569;">
                Jelajahi fitur-fitur unggulan kami yang dirancang untuk mempermudah pengelolaan ruangan dan inventaris.
            </p>
        </div>
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h5 class="feature-title">Manajemen Ruangan</h5>
                    <p class="feature-description">
                        Mengelola ketersediaan, peminjaman, dan pelaporan ruangan secara real-time.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <h5 class="feature-title">Manajemen Inventaris</h5>
                    <p class="feature-description">
                        Peminjaman inventaris kampus dengan proses approval yang transparan.
                    </p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="feature-card">
                    <div class="feature-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <h5 class="feature-title">Laporan & Statistik</h5>
                    <p class="feature-description">
                        Monitoring aktivitas peminjaman dan pelaporan kerusakan dengan mudah.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

    {{-- Section Jumlah Ruangan & Inventaris --}}
<section id="jumlah-ruangan-inventaris" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold" style="color: #2563eb;">Statistik Ruang Dan Inventaris Fakultas Rekayasa Industri</h2>
            <p class="fs-5" style="color: #475569;">
                Data terkini mengenai jumlah ruangan dan inventaris yang tersedia di Fakultas Rekayasa Industri.
            </p>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow text-center py-4">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-door-open fa-2x" style="color: #2563eb"></i>
                        </div>
                        <h5 class="fw-bold">Total Ruangan</h5>
                        <h2 class="display-5 fw-bold">{{ $totalRuangan ?? '-' }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow text-center py-4">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-boxes fa-2x" style="color: #2563eb"></i>
                        </div>
                        <h5 class="fw-bold">Ruangan Tersedia</h5>
                        <h2 class="display-5 fw-bold">{{ $ruanganTersedia ?? '-' }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow text-center py-4">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-door-open fa-2x" style="color: #2563eb"></i>
                        </div>
                        <h5 class="fw-bold">Total Inventaris</h5>
                        <h2 class="display-5 fw-bold">{{ $totalInventaris ?? '-' }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card border-0 shadow text-center py-4">
                    <div class="card-body">
                        <div class="mb-2">
                            <i class="fas fa-boxes fa-2x" style="color: #2563eb"></i>
                        </div>
                        <h5 class="fw-bold">Inventaris Tersedia</h5>
                        <h2 class="display-5 fw-bold">{{ $inventarisTersedia ?? '-' }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="gedung" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Gedung di FRI</h2>
            <p class="fs-5">
                Jelajahi berbagai gedung yang tersedia di Fakultas Rekayasa Industri.
            </p>
        </div>
    </div>
</section>

<!-- Section Gedung A -->
<section class="container my-5">
    <div class="card border-3 shadow-sm rounded-4">
        <div class="row align-items-center g-5 p-4">
            <div class="col-lg-6">
                <div class="card border-2 rounded-4 shadow-sm h-100 d-flex align-items-center justify-content-center p-2">
                    <img src="{{ asset('storage/tult.jpg') }}" alt="Gedung TULT" class="img-fluid w-100 rounded-4">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-4 pt-4 pt-lg-0">
                    <h2 class="fw-bold mb-4">TULT</h2>
                    <p class="mb-2 fs-5">
                        Gedung Telkom University Landmark Tower (TULT)
                    </p>
                    <hr>
                    <a href="#" class="btn btn-gradient btn-lg rounded-pill px-5 shadow-sm">LIHAT RUANGAN</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Gedung B -->
<section class="container my-5">
    <div class="card border-3 shadow-sm rounded-4">
        <div class="row align-items-center g-5 flex-row-reverse p-4">
            <div class="col-lg-6">
                <div class="card border-2 rounded-4 shadow-sm h-100 d-flex align-items-center justify-content-center p-2">
                    <img src="{{ asset('storage/gku.jpg') }}" alt="Gedung GKU" class="img-fluid w-100 rounded-4">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="pe-lg-4 pt-4 pt-lg-0 text-lg-end text-start">
                    <h2 class="fw-bold mb-4">GKU</h2>
                    <p class="mb-2 fs-5">
                        Gedung Tokong Nanas atau GKU (Gedung Kuliah Umum)
                    </p>
                    <hr>
                    <a href="#" class="btn btn-gradient btn-lg rounded-pill px-5 shadow-sm">LIHAT RUANGAN</a>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Section Gedung C -->
<section class="container my-5">
    <div class="card border-3 shadow-sm rounded-4">
        <div class="row align-items-center g-5 p-4">
            <div class="col-lg-6">
                <div class="card border-2 rounded-4 shadow-sm h-100 d-flex align-items-center justify-content-center p-2">
                    <img src="{{ asset('storage/test.jpg') }}" alt="Gedung CACUK" class="img-fluid w-100 rounded-4">
                </div>
            </div>
            <div class="col-lg-6">
                <div class="ps-lg-4 pt-4 pt-lg-0">
                    <h2 class="fw-bold mb-4">CACUK</h2>
                    <p class="mb-2 fs-5">
                        Gedung Grha Wiyata Cacuk Sudarijanto
                    </p>
                    <hr>
                    <a href="#" class="btn btn-gradient btn-lg rounded-pill px-5 shadow-sm">LIHAT RUANGAN</a>
                </div>
            </div>
        </div>
    </div>
</section>

    

<!-- filepath: c:\Users\ali\Documents\GitHub\RUANGFRI_TIM_367_SI4603\resources\views\landing.blade.php -->
<footer>
    <div class="container">
        <div class="row">
            <!-- Logo and Address -->
            <div class="col-md-4 mb-4">
                <h5>Fakultas Rekayasa Industri</h5>
                <p>Telkom University Landmark Tower Lt 18 Jl</p>
                <p>Telekomunikasi. 1, Terusan Buahbatu - Bojongsoang,<br>Telkom University, Sukapura, Kec. Dayeuhkolot,<br>Kabupaten Bandung, Jawa Barat 40257, Indonesia</p>
                <p>Telp: +62 812-1482-5873</p>
                <p>Email: sekretariatfri@365.telkomuniversity.ac.id</a></p>
                <div class="social-icons d-flex gap-3 mt-3">
                    <a href="https://www.instagram.com/fri.telkomuniversity?igsh=YnczZzRkN2Fjamlw"><i class="fab fa-instagram"></i></a>
                </div>
            </div>

            <!-- Department Links -->
            <div class="col-md-4 mb-4">
                <h5>Department</h5>
                <ul>
                    <li><a href="#">Teknik Industri</a></li>
                    <li><a href="#">Sistem Informasi</a></li>
                    <li><a href="#">Teknik Logistik</a></li>
                    <li><a href="#">Manajemen Rekayasa</a></li>
                </ul>
            </div>

            <!-- Related Links -->
            <div class="col-md-4 mb-4">
                <h5>Related Links</h5>
                <ul>
                    <li><a href="https://telkomuniversity.ac.id/">Telkom University</a></li>
                    <li><a href="https://smb.telkomuniversity.ac.id/">SMB Telkom University</a></li>
                    <li><a href="https://sie.telkomuniversity.ac.id/academic/study-program/s1-teknik-industri/">Teknik Industri</a></li>
                    <li><a href="https://sie.telkomuniversity.ac.id/academic/study-program/s1-sistem-informasi/">Sistem Informasi</a></li>
                    <li><a href="https://sie.telkomuniversity.ac.id/academic/study-program/s1-teknik-logistik/">Teknik Logistik</a></li>
                    <li><a href="https://jakarta.telkomuniversity.ac.id/">Telkom University Kampus Jakarta</a></li>
                    <li><a href="https://surabaya.telkomuniversity.ac.id/">Telkom University Kampus Surabaya</a></li>
                </ul>
            </div>
        </div>
    </div>
</footer>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>