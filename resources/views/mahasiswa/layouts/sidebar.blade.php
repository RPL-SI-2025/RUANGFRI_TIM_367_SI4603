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
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link">
                <i class="fas fa-box-open"></i> Daftar Peminjaman
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->is('mahasiswa/cart*') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                <i class="fas fa-shopping-basket"></i> Keranjang
                @if(isset($cartCount) && $cartCount > 0)
                <span class="notification-badge">{{ $cartCount }}</span>
                @endif
            </a>
        </li>

        <li class="nav-item mt-3">
            <a class="nav-link text-danger">
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            <form id="logout-form">
                @csrf
            </form>
        </li>
    </ul>
</div>