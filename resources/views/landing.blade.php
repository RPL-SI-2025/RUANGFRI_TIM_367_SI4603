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
  </section>

  

  <!-- Section Tentang Sistem -->

  <section id="tentang-sistem" class="tentang-sistem-container">
    <h2>Tentang Website</h2>
    Sistem Peminjaman Fasilitas FRI adalah platform digital terpadu yang dirancang untuk memudahkan mahasiswa dan sivitas akademika dalam mengakses dan mengelola peminjaman ruangan dan inventaris di lingkungan Fakultas Rekayasa Industri, Telkom University.

Melalui sistem ini, pengguna dapat:

Melihat katalog ruangan dan inventaris yang tersedia secara real-time.

Mengajukan peminjaman secara cepat, transparan, dan terdokumentasi.

Memantau status pengajuan serta riwayat peminjaman dengan mudah.

Dengan antarmuka yang intuitif dan ramah pengguna, sistem ini mendukung proses peminjaman yang lebih efisien, akuntabel, dan terdigitalisasi, sejalan dengan visi digitalisasi layanan akademik FRI.</p>
    <div class="tentang-sistem">
        <div class="stat-card">
        <i class="fas fa-building fa-2x" style="color: #27ae60 "></i> <!-- Ikon untuk Total Ruangan -->
        <h3>Total Ruangan</h3>
        <p>{{ $totalRuangan }}</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-door-open fa-2x" style="color: #27ae60 "></i> <!-- Ikon untuk Ruangan Tersedia -->
        <h3>Ruangan Tersedia</h3>
        <p>{{ $ruanganTersedia }}</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-boxes fa-2x" style="color: #27ae60 "></i> <!-- Ikon untuk Total Inventaris -->
        <h3>Total Inventaris</h3>
        <p>{{ $totalInventaris }}</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-check-circle fa-2x" style="color: #27ae60 "></i> <!-- Ikon untuk Inventaris Tersedia -->
        <h3>Inventaris Tersedia</h3>
        <p>{{ $inventarisTersedia }}</p>
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
    <section id="process" class="process-section">
        <div class="container">
            <div class="row">
                <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="section-title">Alur Peminjaman</h2>
                    <p class="section-subtitle">Ikuti langkah-langkah sederhana untuk melakukan peminjaman fasilitas</p>
                </div>
            </div>
            
            <div class="row g-4 mt-4">
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                    <div class="process-card">
                        <div class="process-number">1</div>
                        <img src="{{ asset('storage/webaset/login.jpg') }}" alt="Login">
                        <h5>Login</h5>
                        <p>Masuk ke dalam sistem</p>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                    <div class="process-card">
                        <div class="process-number">2</div>
                        <img src="{{ asset('storage/webaset/memilih.jpg') }}" alt="Pilih">
                        <h5>Pilih</h5>
                        <p>Pilih ruangan atau inventaris</p>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                    <div class="process-card">
                        <div class="process-number">3</div>
                        <img src="{{ asset('storage/webaset/formulir.jpg') }}" alt="Formulir">
                        <h5>Ajukan</h5>
                        <p>Isi formulir peminjaman</p>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="400">
                    <div class="process-card">
                        <div class="process-number">4</div>
                        <img src="{{ asset('storage/webaset/persetujuan.jpg') }}" alt="Persetujuan">
                        <h5>Tunggu</h5>
                        <p>Menunggu persetujuan admin</p>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-4 col-6" data-aos="fade-up" data-aos-duration="600" data-aos-delay="500">
                    <div class="process-card">
                        <div class="process-number">5</div>
                        <img src="{{ asset('storage/webaset/gunakan.jpg') }}" alt="Gunakan">
                        <h5>Gunakan</h5>
                        <p>Gunakan fasilitas sesuai jadwal</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Catalog Section -->
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
                @foreach($ruangans as $index => $ruangan)
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
            </div>
            
            <!-- Inventory Catalog -->
            <div class="row mb-5">
                <div class="col-12" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="section-title">Katalog Inventaris</h2>
                    <p class="section-subtitle">Berbagai inventaris yang tersedia untuk mendukung kegiatan Anda</p>
                </div>
            </div>
            
            <div class="row g-4">
                @foreach($inventaris as $index => $item)
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
            </div>
        </div>
    </section>

  <!-- End Section Katalog Inventaris -->

<footer>
    <div class="footer-container">
        <div class="footer-section">
            <h5>Fakultas Rekayasa Industri</h5>
            <p>
                Telkom University Landmark Tower Lt 18 Jl Telekomunikasi No. 1, Bojongsoang<br>
                Bandung 40257, Indonesia<br>
                Telp: +62 812-1482-5873<br>
                Email: sekretariatfri@365.telkomuniversity.ac.id
            </p>
            <div class="social-icons">
                <a href="https://www.instagram.com/fri.telkomuniversity?igsh=YnczZzRkN2Fjamlw"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <div class="footer-section">
            <h5>Department</h5>
            <ul>
                <li>Teknik Industri</li>
                <li>Sistem Informasi</li>
                <li>Teknik Logistik</li>
                <li>Manajemen Rekayasa</li>
            </ul>
        </div>
        <div class="footer-section">
            <h5>Related Links</h5>
            <ul>
                <li><a href="#">Telkom University</a></li>
                <li><a href="#">SMB Telkom University</a></li>
                <li><a href="#">Teknik Industri</a></li>
                <li><a href="#">Sistem Informasi</a></li>
                <li><a href="#">Teknik Logistik</a></li>
                <li><a href="#">Telkom University Kampus Jakarta</a></li>
                <li><a href="#">Telkom University Kampus Surabaya</a></li>
            </ul>
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
