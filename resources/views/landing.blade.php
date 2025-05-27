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
  .logo {
        color: #27ae60;
        border: none;
    }

    .navbar a {
        transition: transform 0.3s, color 0.3s;
    }

    .navbar a:hover {
        transform: scale(1.1);
        color: #27ae60;
        font: bold;
    }

    .btn-login {
        background-color: transparent;
        border: 2px solid #27ae60;
        color: #27ae60;=
        transition: background-color 0.3s, color 0.3s;
    }

    .btn-login:hover {
        background-color: #27ae60;
        color: white;
        font-weight: bold;
    }

    .btn-secondary {
    border-radius: 25px;
        transition: background-color 0.3s;/
    }

    .btn-secondary:hover {
        transform: scale(1.1);
        background-color: #27ae60;
    }
    .tentang-sistem-container {
        margin: 0 70px;
    }

    .stat-card {
        transition: background-color 0.3s;
    }

    .stat-card:hover {
        background-color: rgba(39, 174, 96, 0.1);
        transform: scale(1.05);
    }
    .room-container h2,
    .inventory-container h2 {
        color: #27ae60;
        font-weight: bold;
    }

    .room-card p.available {
        color: #27ae60;
    }

    .alur-card {
        transition: background-color 0.3s, transform 0.3s; /* Efek transisi */
    }

    .alur-card:hover {
        background-color: rgba(39, 174, 96, 0.1); /* Warna lebih gelap saat hover */
        transform: scale(1.05); /* Zoom saat hover */
    }

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

  <!-- End Section Tentang Sistem -->

 <section id="gedung" class="gedung">
    <h2>Gedung FRI</h2>
    <p>Jelajahi berbagai gedung yang tersedia di Fakultas Rekayasa Industri.</p>

    <!-- Gedung TULT -->
  <div class="gedung-card">
    <img src="{{ asset('storage/webaset/tult.jpg') }}" alt="Gedung TULT" />
    <div class="gedung-info">
      <h3>Telkom University Landmark Tower (TULT)</h3>
      <p>Telkom University Landmark Tower, disingkat TULT, adalah gedung tertinggi di lingkungan kampus Telkom University.
        Gedung ini memiliki 19 lantai dan menjadi salah satu landmark utama di kawasan kampus.
        TULT difungsikan sebagai pusat administrasi, ruang pertemuan, serta fasilitas pendukung kegiatan akademik dan non-akademik.
        Dengan desain modern dan menjulang tinggi, TULT menjadi ikon visual yang mudah dikenali di kawasan Telkom University</p>
      <hr />
      <a href="#" class="btn-gradient">Lihat Ruangan</a>
    </div>
  </div>

    <!-- Gedung B -->
<div class="gedung-card reverse">
    <div class="gedung-info">
        <h3>Gedung Kuliah Umum (Tokong Nanas)</h3>
        <p>Gedung Kuliah Umum yang dikenal dengan sebutan Tokong Nanas adalah gedung kuliah umum 10 lantai yang juga menjadi
            salah satu ikon Telkom University. Nama "Tokong Nanas" berasal dari bentuk atapnya yang menyerupai buah nanas.
            Gedung ini digunakan untuk berbagai aktivitas perkuliahan dan seminar, serta menjadi salah satu pusat kegiatan mahasiswa di kampus.
            Secara resmi, gedung ini tercatat sebagai KU3 dalam daftar gedung Telkom University</p>
        <hr />
        <a href="#" class="btn-gradient">Lihat Ruangan</a>
    </div>
    <img src="{{ asset('storage/webaset/gku.jpg') }}" alt="Gedung B" />
</div>

    <!-- Gedung C -->
    <div class="gedung-card">
        <img src="{{ asset('storage/webaset/cacuk.png') }}" alt="Gedung C" />
        <div class="gedung-info">
            <h3>Gedung B Cacuk (Grha Wiyata Cacuk Sudarijanto-B)</h3>
            <p>Gedung B Cacuk, secara resmi bernama Grha Wiyata Cacuk Sudarijanto-B, merupakan salah satu gedung kuliah umum di Telkom University.
                Gedung ini digunakan sebagai fasilitas utama untuk perkuliahan berbagai program studi dan menjadi bagian dari kompleks gedung kuliah umum
                yang dinamai untuk menghormati tokoh penting dalam sejarah Telkom University, yaitu Cacuk Sudarijanto.
                Gedung ini sering disebut juga sebagai KU2.</p>
            <hr />
            <a href="#" class="btn-gradient">Lihat Ruangan</a>
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
                <a href="mailto:sekretariatfri@365.telkomuniversity.ac.id"><i class="fas fa-envelope"></i></a>
                <a href="https://www.youtube.com/@fri.telkomuniversity"><i class="fab fa-youtube"></i></a>
                <a href="https://www.linkedin.com/school/school-of-industrial-engineering-telkom-university-bandung/?originalSubdomain=id"><i class="fab fa-linkedin"></i></a>
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
