<!-- Sidebar -->
<div class="sidebar col-md-3 col-lg-2 d-md-block" style="width: 250px;">
    <div class="sidebar-header">
        <div class="text-center">
            <h5 class="text-white mb-0">SISTEM PEMINJAMAN</h5>
            <div class="text-white-50 small">Fakultas Rekayasa Industri</div>
        </div>
    </div>
    <ul class="nav flex-column mt-4">
            <!-- Dashboard Link - Add this first -->
        <li class="nav-item">
            <a class="nav-link {{ request()->is('mahasiswa/dashboard') ? 'active' : '' }}" 
            href="{{ route('mahasiswa.dashboard') }}">
                <i class="fas fa-tachometer-alt"></i>
                <span class="ms-2">Dashboard</span>
            </a>
        </li>
        
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/katalog*') ? 'active' : '' }}" 
               href="#katalogSubmenu" 
               data-bs-toggle="collapse" 
               aria-expanded="{{ request()->is('mahasiswa/katalog*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-th-list"></i> Katalog
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/katalog*') ? 'show' : '' }}" id="katalogSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/katalog/inventaris*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.katalog.inventaris.index') }}">
                            <i class="fas fa-boxes fa-sm"></i>
                            <span class="ms-2">Katalog Inventaris</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="collapse {{ request()->is('mahasiswa/katalog*') ? 'show' : '' }}" id="katalogSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/katalog/ruangan*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.katalog.ruangan.index') }}">
                            <i class="fas fa-door-open fa-sm"></i>
                            <span class="ms-2">Katalog Ruangan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/peminjaman*') ? 'active' : '' }}" 
               href="#peminjamanSubmenu" 
               data-bs-toggle="collapse" 
               aria-expanded="{{ request()->is('mahasiswa/peminjaman*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-clipboard-list"></i> Daftar Peminjaman
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/peminjaman*') ? 'show' : '' }}" id="peminjamanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/peminjaman/pinjam_inventaris*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}">
                            <i class="fas fa-box-open fa-sm"></i>
                            <span class="ms-2">Peminjaman Inventaris</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="collapse {{ request()->is('mahasiswa/peminjaman*') ? 'show' : '' }}" id="peminjamanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/peminjaman/pinjam_ruangan*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}">
                            <i class="fas fa-building fa-sm"></i>
                            <span class="ms-2">Peminjaman Ruangan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/pelaporan*') ? 'active' : '' }}" 
               href="#pelaporanSubmenu" 
               data-bs-toggle="collapse" 
               aria-expanded="{{ request()->is('mahasiswa/pelaporan*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-exclamation-circle"></i> Daftar Pelaporan
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/pelaporan*') ? 'show' : '' }}" id="pelaporanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/pelaporan/lapor_inventaris*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}">
                            <i class="fas fa-toolbox fa-sm"></i>
                            <span class="ms-2">Pelaporan Inventaris</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="collapse {{ request()->is('mahasiswa/pelaporan*') ? 'show' : '' }}" id="pelaporanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/pelaporan/lapor_ruangan*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}">
                            <i class="fas fa-door-closed fa-sm"></i>
                            <span class="ms-2">Pelaporan Ruangan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/cart*') ? 'active' : '' }}" 
               href="#cartSubmenu" 
               data-bs-toggle="collapse" 
               aria-expanded="{{ request()->is('mahasiswa/cart*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-shopping-cart"></i> Keranjang
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/cart*') ? 'show' : '' }}" id="cartSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/cart/keranjang_inventaris*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}">
                            <i class="fas fa-cart-plus fa-sm"></i>
                            <span class="ms-2">Keranjang Inventaris</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="collapse {{ request()->is('mahasiswa/cart*') ? 'show' : '' }}" id="cartSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/cart/keranjang_ruangan*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}">
                            <i class="fas fa-calendar-plus fa-sm"></i>
                            <span class="ms-2">Keranjang Ruangan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/history*') ? 'active' : '' }}" 
            href="#historySubmenu" 
            data-bs-toggle="collapse" 
            aria-expanded="{{ request()->is('mahasiswa/history*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-history"></i> Riwayat Peminjaman
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/history*') ? 'show' : '' }}" id="historySubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/history/history_inventaris*') ? 'active' : '' }}" 
                        href="{{ route('mahasiswa.history.mahasiswa.history.history_inventaris.index') }}">
                            <i class="fas fa-toolbox fa-sm"></i>
                            <span class="ms-2">Riwayat Inventaris</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/history/history_ruangan*') ? 'active' : '' }}" 
                        href="{{ route('mahasiswa.history.mahasiswa.history.history_ruangan.index') }}">
                            <i class="fas fa-door-closed fa-sm"></i>
                            <span class="ms-2">Riwayat Ruangan</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>

        <li class="nav-item mt-3">
            <form action="{{ route('mahasiswa.logout') }}" method="POST" id="logout-form">
                @csrf
                <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit();" class="nav-link text-danger">
                    <i class="fas fa-sign-out-alt"></i> Keluar
                </a>
            </form>
        </li>
    </ul>
</div>