<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistem Peminjaman FRI</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/style.css') }}">
  <style>
  
  </style>

</head>


<body>

  <header class="navbar">
      <div class="logo">RUANGFRI</div>
      <button class="hamburger" onclick="toggleMenu()">☰</button>
      <nav class="responsive">
        <a href="#hero">Beranda</a>
        <a href="#tentang-sistem">Tentang Sistem</a>
        <a href="#gedung">Gedung FRI</a>
        <a href="#alur-peminjaman">Alur Peminjaman</a>
        <a href="#ruangan">Katalog Ruangan</a>
        <a href="#inventaris">Katalog Inventaris</a>
         <a href="{{ route('mahasiswa.login') }}"> <button class="btn-login">Login</button> </a> 
      </nav>
  </header>

  <section id="hero" class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <h1>Sistem Peminjaman Fasilitas FRI</h1>
        <p>Akses Mudah untuk Peminjaman Ruangan dan Inventaris FRI</p>
        <a href="#" class="btn-secondary" style="background-color:#2ecc71">Selengkapnya</a>
      </div>
      <img src="{{ asset('storage/webaset/hero.png') }}" alt="Ilustrasi" class="hero-img" />
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
        <i class="fas fa-building fa-2x" style="color: #1e40af "></i> <!-- Ikon untuk Total Ruangan -->
        <h3>Total Ruangan</h3>
        <p>{{ $totalRuangan }}</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-door-open fa-2x" style="color: #1e40af "></i> <!-- Ikon untuk Ruangan Tersedia -->
        <h3>Ruangan Tersedia</h3>
        <p>{{ $ruanganTersedia }}</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-boxes fa-2x" style="color: #1e40af "></i> <!-- Ikon untuk Total Inventaris -->
        <h3>Total Inventaris</h3>
        <p>{{ $totalInventaris }}</p>
    </div>
    <div class="stat-card">
        <i class="fas fa-check-circle fa-2x" style="color: #1e40af "></i> <!-- Ikon untuk Inventaris Tersedia -->
        <h3>Inventaris Tersedia</h3>
        <p>{{ $inventarisTersedia }}</p>
    </div>
    </div>
</div>
</section>

  <!-- End Section Tentang Sistem -->

 <section id="gedung" class="gedung">
    <h2>Gedung di FRI</h2>
    <p>Jelajahi berbagai gedung yang tersedia di Fakultas Rekayasa Industri.</p>
    
    <!-- Gedung TULT -->
  <div class="gedung-card">
    <img src="{{ asset('storage/webaset/tult.jpg') }}" alt="Gedung TULT" />
    <div class="gedung-info">
      <h3>TULT</h3>
      <p>Gedung Telkom University Landmark Tower (TULT)</p>
      <hr />
      <a href="#" class="btn-gradient">LIHAT RUANGAN</a>
    </div>
  </div>

    <!-- Gedung B -->
<div class="gedung-card reverse">
    <div class="gedung-info">
        <h3>GKU</h3>
        <p>Gedung Tokong Nanas atau GKU (Gedung Kuliah Umum)</p>
        <hr />
        <a href="#" class="btn-gradient">LIHAT RUANGAN</a>
    </div>
    <img src="{{ asset('storage/webaset/gku.jpg') }}" alt="Gedung B" />
</div>

    <!-- Gedung C -->
    <div class="gedung-card">
        <img src="{{ asset('storage/webaset/tult.jpg') }}" alt="Gedung C" />
        <div class="gedung-info">
            <h3>CACUK</h3>
            <p>Gedung Grha Wiyata Cacuk Sudarijanto</p>
            <hr />
            <a href="#" class="btn-gradient">LIHAT RUANGAN</a>
        </div>
    </div>
</section>
<!-- End Section Gedung -->

<!-- Section Alur Peminjaman -->

  <section id="alur-peminjaman" class="container">
    <h2>Alur Peminjaman</h2>
    <p>Ikuti langkah-langkah berikut untuk melakukan peminjaman fasilitas di FRI:</p>
    <div class="alur-grid">
        <div class="alur-card">
            <img src="{{ asset('storage/webaset/login.jpg') }}" alt="Langkah 1" />
            <h3>1. Login Kedalam Website</h3>
            <p>Silahkan Login Terlebih Dahulu ke dalam website</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('storage/webaset/memilih.jpg') }}" alt="Langkah 2" />
            <h3>2. Pilih Ruangan/Inventaris</h3>
            <p>Cari dan pilih ruangan atau inventaris yang ingin Anda pinjam sesuai kebutuhan.</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('storage/webaset/formulir.jpg') }}" alt="Langkah 3" />
            <h3>3. Ajukan Peminjaman</h3>
            <p>Isi formulir peminjaman dengan informasi yang diperlukan dan ajukan permohonan.</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('storage/webaset/persetujuan.jpg') }}" alt="Langkah 4" />
            <h3>4. Tunggu Persetujuan</h3>
            <p>Permohonan Anda akan diproses oleh admin. Tunggu hingga disetujui.</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('storage/webaset/gunakan.jpg') }}" alt="Langkah 5" />
            <h3>5. Gunakan Fasilitas</h3>
            <p>Setelah disetujui, gunakan fasilitas sesuai jadwal yang telah ditentukan.</p>
        </div>
    </div>
</section>


  
<!-- Section Katalog Ruangan -->
<section id="ruangan" class="room-container">
    <h2>Katalog Ruangan</h2>
    <div class="room-grid">
        @foreach($ruangans as $ruangan)
        <div class="room-card">
            <img src="{{ $ruangan->gambar ? asset('storage/katalog_ruangan/' . $ruangan->gambar) : asset('images/default-room.jpg') }}" alt="{{ $ruangan->nama_ruangan }}" />
            <strong>{{ $ruangan->nama_ruangan }}</strong>
            <p>Kapasitas: {{ $ruangan->kapasitas }} orang</p>
            <p class="{{ $ruangan->status == 'Tersedia' ? 'available' : 'text-danger' }}">
                {{ $ruangan->status }}
            </p>
        </div>
        @endforeach
    </div>
</section>
<!-- End Section Katalog Ruangan -->


  
  <!-- Section Katalog Inventaris -->

<section id="inventaris" class="inventory-container">
    <h2>Katalog Inventaris</h2>
    <div class="inventory-grid">
        @foreach($inventaris as $item)
        <div class="inventory-card">
            <img src="{{ $item->gambar_inventaris ? asset('storage/katalog_inventaris/' . $item->gambar_inventaris) : asset('images/default-image.png') }}" alt="{{ $item->nama_inventaris }}" />
            <strong>{{ $item->nama_inventaris }}</strong>
            <p>Jumlah tersedia: {{ $item->jumlah }}</p>
        </div>
        @endforeach
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

        <script>
      function toggleMenu() {
        const nav = document.querySelector('.navbar nav');
        nav.classList.toggle('show');
      }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
