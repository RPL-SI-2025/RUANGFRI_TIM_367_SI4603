<!-- Sidebar -->
<div class="sidebar col-md-3 col-lg-2 d-md-block" style="width: 250px;">
    <div class="sidebar-header">
        <div class="text-center">
            <h5 class="text-white mb-0">SISTEM INVENTARIS</h5>
            <div class="text-white-50 small">Universitas Example</div>
        </div>
    </div>
    
    <ul class="nav flex-column mt-4">
        <li class="nav-item">
            <a class="nav-link {{ request()->is('mahasiswa/inventaris*') ? 'active' : '' }}" href="{{ route('mahasiswa.inventaris.index') }}">
                <i class="fas fa-box-open"></i> Katalog Inventaris
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
            <a class="nav-link text-danger" >
                <i class="fas fa-sign-out-alt"></i> Keluar
            </a>
            <form id="logout-form" >
                @csrf
            </form>
        </li>
    </ul>
</div>