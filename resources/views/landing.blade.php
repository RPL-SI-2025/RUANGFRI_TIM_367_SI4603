<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RUANGFRI - Sistem Peminjaman Fasilitas FRI</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- AOS Animation -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">
    
    <!-- Custom CSS -->
     <link href="{{ asset('css/landingPage.css') }}" rel="stylesheet">
     
</head>

<body>
    <!-- Loading Overlay -->
    <div class="loading-overlay" id="loadingOverlay">
        <div class="loading-spinner"></div>
    </div>

    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom" id="navbar">
        <div class="container">
            <a class="navbar-brand" href="#hero">RUANGFRI</a>
            
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#hero">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Tentang Sistem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#buildings">Gedung FRI</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#process">Alur Peminjaman</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#catalog">Katalog</a>
                    </li>
                </ul>
                
                <a href="{{ route('mahasiswa.login') }}" class="btn-login">
                    <i class="fas fa-sign-in-alt me-2"></i>Login
                </a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="hero" class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <div class="hero-content">
                        <h1>Sistem Peminjaman <span class="highlight">Fasilitas FRI</span></h1>
                        <p>Platform digital terpadu untuk akses mudah peminjaman ruangan dan inventaris di Fakultas Rekayasa Industri, Telkom University</p>
                        
                        <div class="hero-buttons">
                            <a href="#about" class="btn btn-primary-custom">
                                <i class="fas fa-rocket me-2"></i>Mulai Sekarang
                            </a>
                            <a href="#process" class="btn btn-outline-custom">
                                <i class="fas fa-play me-2"></i>Pelajari Lebih
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                    <div class="hero-image text-center">
                        <img src="{{ asset('storage/webaset/hero.png') }}" alt="Hero Illustration" class="img-fluid">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="stat-card">
                        <i class="fas fa-building icon"></i>
                        <h3>{{ $totalRuangan }}</h3>
                        <p>Total Ruangan</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <div class="stat-card">
                        <i class="fas fa-door-open icon"></i>
                        <h3>{{ $ruanganTersedia }}</h3>
                        <p>Ruangan Tersedia</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                    <div class="stat-card">
                        <i class="fas fa-boxes icon"></i>
                        <h3>{{ $totalInventaris }}</h3>
                        <p>Total Inventaris</p>
                    </div>
                </div>
                
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                    <div class="stat-card">
                        <i class="fas fa-check-circle icon"></i>
                        <h3>{{ $inventarisTersedia }}</h3>
                        <p>Inventaris Tersedia</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="about-section">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="section-title">Tentang Sistem</h2>
                    <p class="section-subtitle">Platform digital terpadu yang memudahkan pengelolaan peminjaman fasilitas FRI</p>
                </div>
            </div>
            
            <div class="row g-4 mt-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="feature-card">
                        <div class="icon">
                            <i class="fas fa-eye"></i>
                        </div>
                        <h4>Real-time Monitoring</h4>
                        <p>Lihat katalog ruangan dan inventaris yang tersedia secara real-time dengan update status terkini</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <div class="feature-card">
                        <div class="icon">
                            <i class="fas fa-rocket"></i>
                        </div>
                        <h4>Peminjaman Cepat</h4>
                        <p>Proses pengajuan peminjaman yang cepat, transparan, dan terdokumentasi dengan baik</p>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                    <div class="feature-card">
                        <div class="icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <h4>Riwayat Lengkap</h4>
                        <p>Pantau status pengajuan dan akses riwayat peminjaman dengan mudah dan terorganisir</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Buildings Section -->
    <section id="buildings" class="buildings-section">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="section-title">Gedung di FRI</h2>
                    <p class="section-subtitle">Jelajahi berbagai gedung yang tersedia di Fakultas Rekayasa Industri</p>
                </div>
            </div>
            
            <div class="row g-4 mt-4">
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="building-card">
                        <img src="{{ asset('storage/webaset/tult.jpg') }}" alt="TULT">
                        <div class="building-card-body">
                            <h5>TULT</h5>
                            <p>Gedung Telkom University Landmark Tower (TULT)</p>
                            <a href="#catalog" class="btn-view">
                                <i class="fas fa-eye me-2"></i>Lihat Ruangan
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <div class="building-card">
                        <img src="{{ asset('storage/webaset/gku.jpg') }}" alt="GKU">
                        <div class="building-card-body">
                            <h5>GKU</h5>
                            <p>Gedung Tokong Nanas atau GKU (Gedung Kuliah Umum)</p>
                            <a href="#catalog" class="btn-view">
                                <i class="fas fa-eye me-2"></i>Lihat Ruangan
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                    <div class="building-card">
                        <img src="{{ asset('storage/webaset/tult.jpg') }}" alt="CACUK">
                        <div class="building-card-body">
                            <h5>CACUK</h5>
                            <p>Gedung Grha Wiyata Cacuk Sudarijanto</p>
                            <a href="#catalog" class="btn-view">
                                <i class="fas fa-eye me-2"></i>Lihat Ruangan
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
        <!-- Process Section -->
    <section id="process" class="process-section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="section-title">Alur Peminjaman</h2>
                    <p class="section-subtitle">Ikuti langkah-langkah sederhana untuk melakukan peminjaman fasilitas</p>
                </div>
            </div>
            
            <div class="row g-4 mt-4 justify-content-center">
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="process-card">
                        <div class="process-icon">
                            <div class="process-number">1</div>
                            <img src="{{ asset('storage/webaset/login.jpg') }}" alt="Login" class="img-fluid">
                        </div>
                        <div class="process-content">
                            <h5>Login</h5>
                            <p>Masuk ke dalam sistem menggunakan akun mahasiswa</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <div class="process-card">
                        <div class="process-icon">
                            <div class="process-number">2</div>
                            <img src="{{ asset('storage/webaset/memilih.jpg') }}" alt="Pilih" class="img-fluid">
                        </div>
                        <div class="process-content">
                            <h5>Pilih</h5>
                            <p>Pilih ruangan atau inventaris yang tersedia</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                    <div class="process-card">
                        <div class="process-icon">
                            <div class="process-number">3</div>
                            <img src="{{ asset('storage/webaset/formulir.jpg') }}" alt="Formulir" class="img-fluid">
                        </div>
                        <div class="process-content">
                            <h5>Ajukan</h5>
                            <p>Isi formulir peminjaman dengan lengkap</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                    <div class="process-card">
                        <div class="process-icon">
                            <div class="process-number">4</div>
                            <img src="{{ asset('storage/webaset/persetujuan.jpg') }}" alt="Persetujuan" class="img-fluid">
                        </div>
                        <div class="process-content">
                            <h5>Tunggu</h5>
                            <p>Menunggu persetujuan dari admin FRI</p>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                    <div class="process-card">
                        <div class="process-icon">
                            <div class="process-number">5</div>
                            <img src="{{ asset('storage/webaset/gunakan.jpg') }}" alt="Gunakan" class="img-fluid">
                        </div>
                        <div class="process-content">
                            <h5>Gunakan</h5>
                            <p>Gunakan fasilitas sesuai jadwal yang disetujui</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="catalog" class="catalog-section">
    <div class="container">
        <!-- Room Catalog -->
        <div class="row mb-5">
            <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                <h2 class="section-title">Katalog Ruangan</h2>
                <p class="section-subtitle">Temukan ruangan yang sesuai dengan kebutuhan Anda</p>
            </div>
        </div>
        
        <div class="row g-4 mb-5">
            @foreach($ruangans->take(3) as $index => $ruangan)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="catalog-card">
                    <img src="{{ $ruangan->gambar ? asset('storage/katalog_ruangan/' . $ruangan->gambar) : asset('images/default-room.jpg') }}" alt="{{ $ruangan->nama_ruangan }}">
                    <div class="catalog-card-body">
                        <h6>{{ $ruangan->nama_ruangan }}</h6>
                        <p><i class="fas fa-users me-2"></i>Kapasitas: {{ $ruangan->kapasitas }} orang</p>
                        <span class="status-badge {{ $ruangan->status == 'Tersedia' ? 'status-available' : 'status-unavailable' }}">
                            {{ $ruangan->status }}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            @if($ruangans->count() > 3)
            <div class="col-12 text-center mt-4">
                <a href="{{ route('mahasiswa.login') }}" class="btn btn-primary-custom">
                    <i class="fas fa-eye me-2"></i>Lihat Semua Ruangan
                </a>
            </div>
            @endif
        </div>
            
        <!-- Inventory Catalog -->
        <div class="row mb-5">
            <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                <h2 class="section-title">Katalog Inventaris</h2>
                <p class="section-subtitle">Berbagai inventaris yang tersedia untuk mendukung kegiatan Anda</p>
            </div>
        </div>
        
        <div class="row g-4">
            @foreach($inventaris->take(3) as $index => $item)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="{{ ($index + 1) * 100 }}">
                <div class="catalog-card">
                    <img src="{{ $item->gambar_inventaris ? asset('storage/katalog_inventaris/' . $item->gambar_inventaris) : asset('images/default-image.png') }}" alt="{{ $item->nama_inventaris }}">
                    <div class="catalog-card-body">
                        <h6>{{ $item->nama_inventaris }}</h6>
                        <p><i class="fas fa-box me-2"></i>Jumlah tersedia: {{ $item->jumlah }}</p>
                        <span class="status-badge status-available">
                            Tersedia
                        </span>
                    </div>
                </div>
            </div>
            @endforeach

            @if($inventaris->count() > 3)
            <div class="col-12 text-center mt-4">
                <a href="{{ route('mahasiswa.login') }}" class="btn btn-primary-custom">
                    <i class="fas fa-eye me-2"></i>Lihat Semua Inventaris
                </a>
            </div>
            @endif
        </div>
    </div>
</section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4 col-md-6">
                    <h5>Fakultas Rekayasa Industri</h5>
                    <p>
                        Telkom University Landmark Tower Lt 18<br>
                        Jl Telekomunikasi No. 1, Bojongsoang<br>
                        Bandung 40257, Indonesia<br><br>
                        <i class="fas fa-phone me-2"></i>+62 812-1482-5873<br>
                        <i class="fas fa-envelope me-2"></i>sekretariatfri@365.telkomuniversity.ac.id
                    </p>
                    <div class="social-icons">
                        <a href="https://www.instagram.com/fri.telkomuniversity" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-6">
                    <h5>Department</h5>
                    <ul>
                        <li>Teknik Industri</li>
                        <li>Sistem Informasi</li>
                        <li>Teknik Logistik</li>
                        <li>Manajemen Rekayasa</li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>Related Links</h5>
                    <ul>
                        <li><a href="#">Telkom University</a></li>
                        <li><a href="#">SMB Telkom University</a></li>
                        <li><a href="#">Teknik Industri</a></li>
                        <li><a href="#">Sistem Informasi</a></li>
                        <li><a href="#">Teknik Logistik</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-3 col-md-6">
                    <h5>Campus</h5>
                    <ul>
                        <li><a href="#">Telkom University Bandung</a></li>
                        <li><a href="#">Telkom University Jakarta</a></li>
                        <li><a href="#">Telkom University Surabaya</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 RUANGFRI - Fakultas Rekayasa Industri, Telkom University. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- AOS Animation -->
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <!-- Custom JS -->
    <script>
        
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            offset: 100
        });

        
        window.addEventListener('load', function() {
            const loadingOverlay = document.getElementById('loadingOverlay');
            setTimeout(() => {
                loadingOverlay.style.opacity = '0';
                setTimeout(() => {
                    loadingOverlay.style.display = 'none';
                }, 500);
            }, 1000);
        });

        
        const navbar = document.getElementById('navbar');
        
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        
        window.addEventListener('scroll', function() {
            const scrolled = window.pageYOffset;
            const parallaxElements = document.querySelectorAll('.hero-section');
            
            parallaxElements.forEach(element => {
                const speed = 0.5;
                element.style.transform = `translateY(${scrolled * speed}px)`;
            });
        });

        
        function animateCounters() {
            const counters = document.querySelectorAll('.stat-card h3');
            
            counters.forEach(counter => {
                const target = +counter.innerText;
                const increment = target / 100;
                let current = 0;
                
                const updateCounter = () => {
                    if (current < target) {
                        current += increment;
                        counter.innerText = Math.ceil(current);
                        setTimeout(updateCounter, 20);
                    } else {
                        counter.innerText = target;
                    }
                };
                
                updateCounter();
            });
        }

        
        const statsSection = document.querySelector('.stats-section');
        const observerOptions = {
            threshold: 0.5,
            rootMargin: '0px 0px -100px 0px'
        };

        const statsObserver = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    statsObserver.unobserve(entry.target);
                }
            });
        }, observerOptions);

        if (statsSection) {
            statsObserver.observe(statsSection);
        }
    </script>

</body>
</html>