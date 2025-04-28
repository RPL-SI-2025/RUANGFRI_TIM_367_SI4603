<!-- Sidebar -->
<div class="sidebar col-md-3 col-lg-2 d-md-block" style="width: 250px;">
    <div class="sidebar-header">
        <div class="text-center">
            <h5 class="text-white mb-0">SISTEM PEMINJAMAN</h5>
            <div class="text-white-50 small">Fakultas Rekayasa Industri</div>
        </div>
    </div>
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/katalog*') ? 'active' : '' }}"
               href="#katalogSubmenu"
               data-bs-toggle="collapse"
               aria-expanded="{{ request()->is('mahasiswa/katalog*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-book"></i> Katalog
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/katalog*') ? 'show' : '' }}" id="katalogSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/katalog/inventaris*') ? 'active' : '' }}"
                           href="{{ route('mahasiswa.katalog.inventaris.index') }}">
                            <i class="fas fa-tools fa-sm"></i>
                            <span class="ms-2">Katalog Inventaris</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/katalog/ruangan*') ? 'active' : '' }}"
                           href="{{ route('mahasiswa.katalog.ruangan.index') }}">
                            <i class="fas fa-building fa-sm"></i>
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
                    <i class="fas fa-book"></i> Daftar Peminjaman
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/peminjaman*') ? 'show' : '' }}" id="peminjamanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/peminjaman/pinjam_inventaris*') ? 'active' : '' }}"
                           href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}">
                            <i class="fas fa-tools fa-sm"></i>
                            <span class="ms-2">Peminjaman Inventaris</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('mahasiswa/cart*') ? 'active' : '' }}" href="{{ route('mahasiswa.cart.index') }}">
                <i class="fas fa-shopping-basket"></i> Keranjang
                @if(isset($cartCount) && $cartCount > 0)
                <span class="notification-badge">{{ $cartCount }}</span>
                @endif
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link d-flex justify-content-between align-items-center {{ request()->is('mahasiswa/pelaporan*') ? 'active' : '' }}" 
               href="#pelaporanSubmenu" 
               data-bs-toggle="collapse" 
               aria-expanded="{{ request()->is('mahasiswa/pelaporan*') ? 'true' : 'false' }}">
                <div>
                    <i class="fas fa-book"></i> Pelaporan Peminjaman
                </div>
                <i class="fas fa-chevron-down small"></i>
            </a>
            <div class="collapse {{ request()->is('mahasiswa/pelaporan*') ? 'show' : '' }}" id="pelaporanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/pelaporan/lapor_ruangan*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.pelaporan.lapor_ruang.index') }}">
                            <i class="fas fa-tools fa-sm"></i>
                            <span class="ms-2">Pelaporan Ruangan</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="collapse {{ request()->is('mahasiswa/pelaporan*') ? 'show' : '' }}" id="pelaporanSubmenu">
                <ul class="nav flex-column ms-3 mt-1">
                    <li class="nav-item">
                        <a class="nav-link py-2 {{ request()->is('mahasiswa/pelaporan/lapor_inventaris*') ? 'active' : '' }}" 
                           href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}">
                            <i class="fas fa-tools fa-sm"></i>
                            <span class="ms-2">Pelaporan inventaris</span>
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
