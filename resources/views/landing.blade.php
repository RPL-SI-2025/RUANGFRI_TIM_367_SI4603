<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sistem Peminjaman FRI</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    {
      box-sizing: border-box;
    }

    body {
      font-family: 'Inter', sans-serif;
      margin: 0;
      padding: 0;
      background: #fff;
      color: #111827;
    }

    a {
      text-decoration: none;
      color: inherit;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 2rem 1rem;
    }

    .navbar {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 1rem 2rem;
      background: 1e40af ;
      border-bottom: 1px solid #e5e7eb;
      position: sticky;
      top: 0;
      z-index: 100;
    }

    .navbar .logo {
      background: #1e40af;
      color: white;
      padding: 0.3rem 0.8rem;
      border-radius: 6px;
      font-weight: bold;
      font-size: 1.2rem;
    }

    .navbar nav a {
      margin: 0 1rem;
      font-weight: 500;
    }

    .btn-login {
      border: 1px solid #d1d5db;
      border-radius: 6px;
      padding: 0.4rem 1rem;
      font-weight: 600;
      background: white;
      cursor: pointer;
    }

    .hero {
      background: #f9fafb;
      padding: 4rem 2rem;
    }

    .hero-content {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      gap: 2rem;
    }

    .hero-text h1 {
      font-size: 2.2rem;
      margin-bottom: 1rem;
      font-weight: 700;
    }

    .hero-text p {
      margin-bottom: 1.5rem;
      color: #4b5563;
    }

    .btn-primary, .btn-secondary {
      padding: 0.6rem 1.2rem;
      border-radius: 6px;
      font-weight: 600;
      display: inline-block;
      margin-right: 0.8rem;
    }

    .btn-primary {
      background-color: #22c55e;
      color: white;
    }

    .btn-secondary {
      background-color: #1e40af;
      color: white;
    }

    .hero-img {
      max-width: 550px;
    }

    h2 {
      font-size: 1.5rem;
      margin-bottom: 1.2rem;
    }

    .tentang-sistem {
        display: flex;
        gap: 2rem;
        align-items: center;
        flex-wrap: wrap;
    }

    .tentang-sistem p {
        flex: 1;
        max-width: 1000px;
        color: #374151;
        line-height: 1.6;
        text-align: justify;
    }

    .tentang-sistem .room-card {
        flex: 1;
        max-width: 400px;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .tentang-sistem .room-card img {
        width: 100%;
        height: 250px;
        object-fit: cover;
    }

    .tentang-sistem .room-card div {
        padding: 1rem;
        font-size: 1rem;
        text-align: center;
    }

    .room-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
        gap: 2rem;
    }

    .room-card {
        width: 100%;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        background: white;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .room-card img {
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .room-card div {
        padding: 1.5rem;
        font-size: 1rem;
        text-align: center;
    }

    .available {
      color: #22c55e;
      font-weight: bold;
    }

    .inventory-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 1.5rem;
        margin-top: 2rem;
    }
    
    .inventory-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        text-align: center;
        padding: 1rem;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .inventory-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    }
    
    .inventory-card img {
        width: 100%;
        height: 150px;
        object-fit: cover;
        border-radius: 8px;
        margin-bottom: 1rem;
    }
    
    .inventory-card strong {
        font-size: 1.2rem;
        color: #111827;
        display: block;
        margin-bottom: 0.5rem;
    }
    
    .inventory-card p {
        font-size: 1rem;
        color: #475569;
    }

    .btn-view-all {
        display: inline-block;
        margin-top: 1rem;
        text-align: center;
        margin-left: auto;
        margin-right: auto;
    }

    .btn-container {
        text-align: center;
        margin-top: 2rem;
    }

  #gedung {
      background: #ffffff;
      padding: 60px 20px;
      text-align: center;
  }

  #gedung h2 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e40af;
      margin-bottom: 20px;
  }

  #gedung p {
      font-size: 1.1rem;
      color: #475569;
      line-height: 1.6;
      margin-bottom: 40px;
  }

  .gedung-card {
      display: flex;
      flex-direction: row;
      align-items: center;
      background: white;
      border-radius: 20px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
      overflow: hidden;
      max-width: 100%;
      margin: 0 auto;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
      margin-bottom: 30px;
      border: 1.5px solid #000000;
      border-radius: 12px;
      padding: 2px;
  }

  .gedung-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.1);
  }

  .gedung-card img {
      width: 500px;
      height: 350px;
      margin-left: 20px;
      margin-right: 20px;
      margin-top: 20px;
      margin-bottom: 20px;
      object-fit: cover;
      border: 3px solid #e5e7eb;
      border-radius: 12px;
      padding: 2px;
      background: white;
  }

  .gedung-info {
      padding: 2rem;
      text-align: left;
      flex: 1;
  }

  .gedung-info h3 {
      font-size: 1.8rem;
      font-weight: 700;
      color: #1e40af;
      margin-bottom: 10px;
  }

  .gedung-info p {
      font-size: 1.1rem;
      color: #475569;
      line-height: 1.6;
      margin-bottom: 20px;
  }

  .gedung-info hr {
      border: none;
      border-top: 1px solid #e5e7eb;
      margin: 20px 0;
  }

  .gedung-info .btn-gradient {
      background: linear-gradient(135deg, #1e40af, #1e40af);
      color: #fff;
      font-weight: 600;
      padding: 0.8rem 2.5rem;
      border-radius: 50px;
      text-decoration: none;
      font-size: 1.1rem;
      transition: all 0.3s ease;
      display: inline-block;
  }

  .gedung-info .btn-gradient:hover {
      background: linear-gradient(135deg, #0d6efd, #2563eb);
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
  }

  #alur-peminjaman {
      text-align: center;
      padding: 60px 20px;
      background: #f9fafb;
  }

  #alur-peminjaman h2 {
      font-size: 2.5rem;
      font-weight: 800;
      color: #1e40af;
      margin-bottom: 20px;
  }

  #alur-peminjaman p {
      font-size: 1.1rem;
      color: #475569;
      line-height: 1.6;
      margin-bottom: 40px;
  }

  .alur-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 2rem;
  }

  .alur-card {
      background: white;
      border: 1px solid #e5e7eb;
      border-radius: 12px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      padding: 1.5rem;
      text-align: center;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
  }

  .alur-card:hover {
      transform: translateY(-5px);
      box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
  }

  .alur-card img {
      width: 80px;
      height: 80px;
      margin-bottom: 1rem;
  }

  .alur-card h3 {
      font-size: 1.5rem;
      font-weight: 700;
      color: #1e40af;
      margin-bottom: 0.5rem;
  }

  .alur-card p {
      font-size: 1rem;
      color: #475569;
      line-height: 1.6;
  }

  footer {
      background-color: #1e40af; /* Warna latar belakang footer */
      color: #ffffff; /* Warna teks */
      padding: 2rem 1rem;
  }

  footer .container {
      display: flex;
      justify-content: space-between;
      flex-wrap: wrap; /* Agar responsif */
      gap: 2rem; /* Jarak antar kolom */
  }

  footer .footer-section {
      flex: 1; /* Membagi kolom secara merata */
      min-width: 250px; /* Lebar minimum untuk responsivitas */
  }

  footer h5 {
      font-size: 1.2rem;
      font-weight: 700;
      margin-bottom: 1rem;
      color: #fbbf24; /* Warna judul */
  }

  footer p, footer ul {
      font-size: 0.9rem;
      line-height: 1.6;
      margin: 0;
      color: #e5e7eb;
  }

  footer ul {
      list-style: none;
      padding: 0;
  }

  footer ul li {
      margin-bottom: 0.5rem;
  }

  footer ul li a {
      text-decoration: none;
      color: #e5e7eb;
      transition: color 0.3s ease;
  }

  footer ul li a:hover {
      color: #fbbf24; /* Warna hover */
  }

  footer .social-icons a {
      color: #ffffff;
      font-size: 1.2rem;
      transition: color 0.3s ease;
  }

  footer .social-icons a:hover {
      color: #fbbf24; /* Warna hover ikon sosial */
  }

    


    
  </style>
</head>
<body>

  <header class="navbar">
    <div class="logo">RUANGFRI</div>
    <nav>
      <a href="#">Beranda</a>
      <a href="#">Tentang Sistem</a>
      <a href="#">Gedung FRI</a>
      <a href="#">Alur Peminjaman</a>
      <a href="#">Katalog Ruangan</a>
      <a href="#">Katalog Inventaris</a>
      <button class="btn-login">Login</button>
    </nav>
  </header>

  <section class="hero">
    <div class="container hero-content">
      <div class="hero-text">
        <h1>Sistem Peminjaman Fasilitas FRI</h1>
        <p>Akses Mudah untuk Peminjaman Ruangan dan Inventaris FRI</p>
        <a href="#" class="btn-secondary">Lihat Katalog</a>
        <a href="#" class="btn-primary">Ajukan Peminjaman</a>
      </div>
      <img src="{{ asset('storage/task.png') }}" alt="Ilustrasi" class="hero-img" />
    </div>
  </section>

  

  <!-- Section Tentang Sistem -->

  <section class="container">
    <h2>Tentang Sistem</h2>
    <div class="tentang-sistem">
      <p>Sistem Peminjaman Fasilitas FRI adalah platform digital yang dirancang untuk memudahkan mahasiswa dalam mengajukan peminjaman ruangan dan inventaris fakultas. Dengan antarmuka yang sederhana dan alur peminjaman yang jelas, mahasiswa dapat dengan cepat mencari, memilih, dan mengajukan peminjaman sesuai kebutuhan kegiatan seperti seminar, praktikum, rapat organisasi, dan keperluan akademik lainnya.</p>
      <div class="room-card">
        <img src="{{ asset('storage/task.png') }}" alt="Ruang A101"/>
        <div>
          <strong>Ruang A101</strong><br />
          Kapasitas: 30<br />
          <span class="available">Tersedia</span>
        </div>
      </div>
    </div>
  </section>

  <!-- End Section Tentang Sistem -->

 <section id="gedung" class="container">
    <h2>Gedung di FRI</h2>
    <p>Jelajahi berbagai gedung yang tersedia di Fakultas Rekayasa Industri.</p>
    
    <!-- Gedung TULT -->
    <div class="gedung-card">
        <img src="{{ asset('storage/tult.jpg') }}" alt="Gedung TULT" />
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
    <img src="{{ asset('storage/gku.jpg') }}" alt="Gedung B" />
</div>

    <!-- Gedung C -->
    <div class="gedung-card">
        <img src="{{ asset('storage/tult.jpg') }}" alt="Gedung C" />
        <div class="gedung-info">
            <h3>CACUK</h3>
            <p>Gedung Grha Wiyata Cacuk Sudarijanto</p>
            <hr />
            <a href="#" class="btn-gradient">LIHAT RUANGAN</a>
        </div>
    </div>
</section>
<!-- End Section Gedung -->

  <section id="alur-peminjaman" class="container">
    <h2>Alur Peminjaman</h2>
    <p>Ikuti langkah-langkah berikut untuk melakukan peminjaman fasilitas di FRI:</p>
    <div class="alur-grid">
        <div class="alur-card">
            <img src="{{ asset('images/step1.png') }}" alt="Langkah 1" />
            <h3>1. Pilih Fasilitas</h3>
            <p>Cari dan pilih ruangan atau inventaris yang ingin Anda pinjam sesuai kebutuhan.</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('images/step2.png') }}" alt="Langkah 2" />
            <h3>2. Ajukan Peminjaman</h3>
            <p>Isi formulir peminjaman dengan informasi yang diperlukan dan ajukan permohonan.</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('images/step3.png') }}" alt="Langkah 3" />
            <h3>3. Tunggu Persetujuan</h3>
            <p>Permohonan Anda akan diproses oleh admin. Tunggu hingga disetujui.</p>
        </div>
        <div class="alur-card">
            <img src="{{ asset('images/step4.png') }}" alt="Langkah 4" />
            <h3>4. Gunakan Fasilitas</h3>
            <p>Setelah disetujui, gunakan fasilitas sesuai jadwal yang telah ditentukan.</p>
        </div>
    </div>
</section>

  <!-- Section Katalog Ruangan -->
  
<section class="container">
    <h2>Katalog Ruangan</h2>
    <div class="room-grid">
        @foreach($ruangans as $ruangan)
        <div class="room-card">
            <img src="{{ $ruangan->gambar ? asset('storage/katalog_ruangan/' . $ruangan->gambar) : asset('images/default-room.jpg') }}" alt="Ruangan" />
            <div>
                <strong>{{ $ruangan->nama_ruangan }}</strong><br />
                <strong>Kapasitas: {{ $ruangan->kapasitas }} orang</strong><br />
                <span class="{{ $ruangan->status == 'Tersedia' ? 'available' : 'text-danger' }}">
                    {{ $ruangan->status }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</section>

  <!-- End Section Katalog Ruangan -->
  
  <!-- Section Katalog Inventaris -->

<section class="container">
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
    <div class="container">
        <!-- Logo and Address -->
        <div class="footer-section">
            <h5>Fakultas Rekayasa Industri</h5>
            <p>Telkom University Landmark Tower Lt 18 Jl</p>
            <p>Telekomunikasi. 1, Terusan Buahbatu - Bojongsoang,<br>Telkom University, Sukapura, Kec. Dayeuhkolot,<br>Kabupaten Bandung, Jawa Barat 40257, Indonesia</p>
            <p>Telp: +62 812-1482-5873</p>
            <p>Email: sekretariatfri@365.telkomuniversity.ac.id</p>
            <div class="social-icons d-flex gap-3 mt-3">
                <a href="https://www.instagram.com/fri.telkomuniversity?igsh=YnczZzRkN2Fjamlw"><i class="fab fa-instagram"></i></a>
            </div>
        </div>

        <!-- Department Links -->
        <div class="footer-section">
            <h5>Department</h5>
            <ul>
                <li><a href="#">Teknik Industri</a></li>
                <li><a href="#">Sistem Informasi</a></li>
                <li><a href="#">Teknik Logistik</a></li>
                <li><a href="#">Manajemen Rekayasa</a></li>
            </ul>
        </div>

        <!-- Related Links -->
        <div class="footer-section">
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
</footer>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
</body>
</html>
