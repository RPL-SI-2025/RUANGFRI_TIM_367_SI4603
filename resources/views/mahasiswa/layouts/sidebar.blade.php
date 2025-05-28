
<div class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <div class="brand-container">
            <div class="brand-icon">
                <i class="fas fa-book"></i>
            </div>
            <div class="brand-info">
                <h5 class="brand-title">SISTEM PEMINJAMAN</h5>
                <span class="brand-subtitle">Fakultas Rekayasa Industri</span>
            </div>
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <ul class="nav-list">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('mahasiswa/dashboard*') ? 'active' : '' }}" 
                   href="{{ route('mahasiswa.dashboard') }}">
                    <div class="nav-icon">
                        <i class="fas fa-home"></i>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>

            <!-- Katalog Menu -->
            <li class="nav-item has-submenu">
                <a class="nav-link submenu-toggle {{ request()->is('mahasiswa/katalog*') ? 'active' : '' }}" 
                   href="#katalogSubmenu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->is('mahasiswa/katalog*') ? 'true' : 'false' }}">
                    <div class="nav-icon">
                        <i class="fas fa-th-list"></i>
                    </div>
                    <span class="nav-text">Katalog</span>
                    <div class="nav-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </a>
                <div class="collapse {{ request()->is('mahasiswa/katalog*') ? 'show' : '' }}" id="katalogSubmenu">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/katalog/inventaris*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.katalog.inventaris.index') }}">
                                <i class="fas fa-boxes"></i>
                                <span>Katalog Inventaris</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/katalog/ruangan*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.katalog.ruangan.index') }}">
                                <i class="fas fa-door-open"></i>
                                <span>Katalog Ruangan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Peminjaman Menu -->
            <li class="nav-item has-submenu">
                <a class="nav-link submenu-toggle {{ request()->is('mahasiswa/peminjaman*') ? 'active' : '' }}" 
                   href="#peminjamanSubmenu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->is('mahasiswa/peminjaman*') ? 'true' : 'false' }}">
                    <div class="nav-icon">
                        <i class="fas fa-clipboard-list"></i>
                    </div>
                    <span class="nav-text">Peminjaman</span>
                    <div class="nav-badge">
                        <span class="badge">3</span>
                    </div>
                    <div class="nav-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </a>
                <div class="collapse {{ request()->is('mahasiswa/peminjaman*') ? 'show' : '' }}" id="peminjamanSubmenu">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/peminjaman/pinjam_inventaris*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.peminjaman.pinjam-inventaris.index') }}">
                                <i class="fas fa-box-open"></i>
                                <span>Peminjaman Inventaris</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/peminjaman/pinjam_ruangan*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.peminjaman.pinjam-ruangan.index') }}">
                                <i class="fas fa-building"></i>
                                <span>Peminjaman Ruangan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Pelaporan Menu -->
            <li class="nav-item has-submenu">
                <a class="nav-link submenu-toggle {{ request()->is('mahasiswa/pelaporan*') ? 'active' : '' }}" 
                   href="#pelaporanSubmenu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->is('mahasiswa/pelaporan*') ? 'true' : 'false' }}">
                    <div class="nav-icon">
                        <i class="fas fa-flag"></i>
                    </div>
                    <span class="nav-text">Pelaporan</span>
                    <div class="nav-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </a>
                <div class="collapse {{ request()->is('mahasiswa/pelaporan*') ? 'show' : '' }}" id="pelaporanSubmenu">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/pelaporan/lapor_inventaris*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.pelaporan.lapor_inventaris.index') }}">
                                <i class="fas fa-toolbox"></i>
                                <span>Laporan Inventaris</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/pelaporan/lapor_ruangan*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.pelaporan.lapor_ruangan.index') }}">
                                <i class="fas fa-door-closed"></i>
                                <span>Laporan Ruangan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Keranjang Menu -->
            <li class="nav-item has-submenu">
                <a class="nav-link submenu-toggle {{ request()->is('mahasiswa/cart*') ? 'active' : '' }}" 
                   href="#cartSubmenu" 
                   data-bs-toggle="collapse" 
                   aria-expanded="{{ request()->is('mahasiswa/cart*') ? 'true' : 'false' }}">
                    <div class="nav-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <span class="nav-text">Keranjang</span>
                    <div class="nav-badge">
                        <span class="badge cart-badge">2</span>
                    </div>
                    <div class="nav-arrow">
                        <i class="fas fa-chevron-down"></i>
                    </div>
                </a>
                <div class="collapse {{ request()->is('mahasiswa/cart*') ? 'show' : '' }}" id="cartSubmenu">
                    <ul class="submenu">
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/cart/keranjang_inventaris*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}">
                                <i class="fas fa-cart-plus"></i>
                                <span>Keranjang Inventaris</span>
                            </a>
                        </li>
                        <li class="submenu-item">
                            <a class="submenu-link {{ request()->is('mahasiswa/cart/keranjang_ruangan*') ? 'active' : '' }}" 
                               href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}">
                                <i class="fas fa-calendar-plus"></i>
                                <span>Keranjang Ruangan</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <!-- Riwayat -->
            <li class="nav-item">
                <a class="nav-link {{ request()->is('mahasiswa/history*') ? 'active' : '' }}" 
                   href="{{ route('mahasiswa.history.index') }}">
                    <div class="nav-icon">
                        <i class="fas fa-history"></i>
                    </div>
                    <span class="nav-text">Riwayat</span>
                </a>
            </li>

            <!-- Quick Action -->
            <li class="nav-item quick-action">
                <a class="nav-link action-btn" href="{{ route('mahasiswa.katalog.inventaris.index') }}">
                    <div class="nav-icon">
                        <i class="fas fa-plus"></i>
                    </div>
                    <span class="nav-text">Peminjaman Baru</span>
                </a>
            </li>
        </ul>

        <!-- Sidebar Footer -->
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">
                    <i class="fas fa-user"></i>
                </div>
                <div class="user-details">
                    <span class="user-name">{{ Session::get('mahasiswa_nama') ?? 'Mahasiswa' }}</span>
                    <span class="user-nim">{{ Session::get('mahasiswa_nim') ?? '12345678' }}</span>
                </div>
            </div>
            
            <form action="{{ route('mahasiswa.logout') }}" method="POST" id="logout-form">
                @csrf
                <button type="submit" class="logout-btn" onclick="return confirm('Yakin ingin keluar?')">
                    <i class="fas fa-sign-out-alt"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </nav>
</div>

<!-- Sidebar Overlay for Mobile -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<style>
:root {
    --sidebar-width: 280px;
    --sidebar-collapsed-width: 70px;
    
    /* Color Palette - Non-green theme */
    --primary-dark: #2c3e50;
    --primary-light: #34495e;
    --secondary-dark: #1a252f;
    --accent-blue: #3498db;
    --accent-red: #e74c3c;
    --accent-orange: #f39c12;
    --text-light: #ecf0f1;
    --text-muted: #bdc3c7;
    --text-dark: #2c3e50;
    --border-color: #34495e;
    --shadow-light: rgba(44, 62, 80, 0.1);
    --shadow-medium: rgba(44, 62, 80, 0.15);
    --shadow-dark: rgba(44, 62, 80, 0.25);
    
    /* Transitions */
    --transition-fast: 0.2s ease;
    --transition-medium: 0.3s ease;
    --transition-slow: 0.4s ease;
}

/* Sidebar Container */
.sidebar {
    position: fixed;
    top: 0;
    left: 0;
    width: var(--sidebar-width);
    height: 100vh;
    background: linear-gradient(180deg, var(--primary-dark) 0%, var(--secondary-dark) 100%);
    backdrop-filter: blur(10px);
    border-right: 1px solid var(--border-color);
    box-shadow: 4px 0 20px var(--shadow-medium);
    z-index: 1000;
    transition: transform var(--transition-medium);
    overflow-y: auto;
    overflow-x: hidden;
}

.sidebar::-webkit-scrollbar {
    width: 4px;
}

.sidebar::-webkit-scrollbar-track {
    background: transparent;
}

.sidebar::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 2px;
}

/* Sidebar Header */
.sidebar-header {
    padding: 1.5rem;
    border-bottom: 1px solid var(--border-color);
    background: rgba(255, 255, 255, 0.05);
}

.brand-container {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.brand-icon {
    width: 40px;
    height: 40px;
    background: linear-gradient(135deg, var(--accent-blue), var(--accent-orange));
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.125rem;
    box-shadow: 0 4px 12px rgba(52, 152, 219, 0.3);
    flex-shrink: 0;
}

.brand-info {
    flex: 1;
    min-width: 0;
}

.brand-title {
    font-size: 0.875rem;
    font-weight: 700;
    color: var(--text-light);
    margin: 0;
    line-height: 1.2;
    letter-spacing: 0.5px;
}

.brand-subtitle {
    font-size: 0.75rem;
    color: var(--text-muted);
    font-weight: 400;
    line-height: 1.2;
}

/* Navigation */
.sidebar-nav {
    padding: 1rem 0;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.nav-list {
    list-style: none;
    padding: 0;
    margin: 0;
    flex: 1;
}

/* Nav Items */
.nav-item {
    margin-bottom: 0.25rem;
    position: relative;
}

.nav-link {
    display: flex;
    align-items: center;
    padding: 0.875rem 1.5rem;
    color: var(--text-muted);
    text-decoration: none;
    transition: all var(--transition-fast);
    border-radius: 0 25px 25px 0;
    margin-right: 1rem;
    position: relative;
    overflow: hidden;
}

.nav-link::before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    width: 3px;
    background: var(--accent-blue);
    transform: scaleY(0);
    transition: transform var(--transition-fast);
}

.nav-link:hover,
.nav-link.active {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
    transform: translateX(5px);
}

.nav-link:hover::before,
.nav-link.active::before {
    transform: scaleY(1);
}

.nav-link.active {
    background: linear-gradient(135deg, rgba(52, 152, 219, 0.2), rgba(243, 156, 18, 0.1));
    color: var(--text-light);
    box-shadow: 0 4px 12px var(--shadow-light);
}

/* Nav Icon */
.nav-icon {
    width: 20px;
    height: 20px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    flex-shrink: 0;
    font-size: 0.875rem;
}

/* Nav Text */
.nav-text {
    font-size: 0.875rem;
    font-weight: 500;
    flex: 1;
    min-width: 0;
}

/* Nav Arrow */
.nav-arrow {
    margin-left: auto;
    transition: transform var(--transition-fast);
    font-size: 0.75rem;
}

.submenu-toggle[aria-expanded="true"] .nav-arrow {
    transform: rotate(180deg);
}

/* Nav Badge */
.nav-badge {
    margin-left: auto;
    margin-right: 0.5rem;
}

.badge {
    background: var(--accent-red);
    color: white;
    font-size: 0.625rem;
    font-weight: 600;
    padding: 0.125rem 0.375rem;
    border-radius: 10px;
    min-width: 18px;
    height: 18px;
    display: flex;
    align-items: center;
    justify-content: center;
    animation: pulse 2s infinite;
}

.cart-badge {
    background: var(--accent-orange);
}

@keyframes pulse {
    0%, 100% { transform: scale(1); }
    50% { transform: scale(1.1); }
}

/* Submenu */
.submenu {
    list-style: none;
    padding: 0.5rem 0;
    margin: 0;
    background: rgba(0, 0, 0, 0.1);
    border-radius: 0 15px 15px 0;
    margin-right: 1rem;
}

.submenu-item {
    margin-bottom: 0.125rem;
}

.submenu-link {
    display: flex;
    align-items: center;
    padding: 0.625rem 2.5rem;
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.8125rem;
    transition: all var(--transition-fast);
    border-radius: 0 20px 20px 0;
    position: relative;
}

.submenu-link i {
    width: 16px;
    margin-right: 0.625rem;
    font-size: 0.75rem;
}

.submenu-link:hover,
.submenu-link.active {
    background: rgba(255, 255, 255, 0.08);
    color: var(--text-light);
    transform: translateX(8px);
}

.submenu-link.active {
    background: rgba(52, 152, 219, 0.15);
    color: var(--accent-blue);
}

/* Quick Action Button */
.quick-action {
    margin-top: 1rem;
    padding: 0 1rem;
}

.action-btn {
    background: linear-gradient(135deg, var(--accent-blue), var(--accent-orange));
    color: white !important;
    border-radius: 12px !important;
    margin-right: 0 !important;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    transform: none !important;
}

.action-btn:hover {
    background: linear-gradient(135deg, #2980b9, #e67e22);
    transform: translateY(-2px) !important;
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
}

.action-btn::before {
    display: none;
}

/* Sidebar Footer */
.sidebar-footer {
    margin-top: auto;
    padding: 1rem 1.5rem;
    border-top: 1px solid var(--border-color);
    background: rgba(0, 0, 0, 0.1);
}

.user-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin-bottom: 1rem;
    padding: 0.75rem;
    background: rgba(255, 255, 255, 0.05);
    border-radius: 10px;
}

.user-avatar {
    width: 36px;
    height: 36px;
    background: var(--accent-blue);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 0.875rem;
    flex-shrink: 0;
}

.user-details {
    flex: 1;
    min-width: 0;
}

.user-name {
    display: block;
    color: var(--text-light);
    font-size: 0.8125rem;
    font-weight: 600;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
}

.user-nim {
    display: block;
    color: var(--text-muted);
    font-size: 0.75rem;
    line-height: 1.2;
}

.logout-btn {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem;
    background: transparent;
    border: 1px solid var(--accent-red);
    color: var(--accent-red);
    border-radius: 8px;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    transition: all var(--transition-fast);
}

.logout-btn:hover {
    background: var(--accent-red);
    color: white;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
}

/* Mobile Responsive */
.sidebar-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(4px);
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: all var(--transition-medium);
}

.sidebar-overlay.active {
    opacity: 1;
    visibility: visible;
}

@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        width: min(var(--sidebar-width), 85vw);
    }
    
    .sidebar.active {
        transform: translateX(0);
    }
    
    .brand-title {
        font-size: 0.8125rem;
    }
    
    .brand-subtitle {
        font-size: 0.6875rem;
    }
}

@media (max-width: 480px) {
    .sidebar {
        width: 100vw;
    }
    
    .nav-link {
        padding: 1rem 1.25rem;
    }
    
    .submenu-link {
        padding: 0.75rem 2.25rem;
    }
}

/* Focus States for Accessibility */
.nav-link:focus,
.submenu-link:focus,
.logout-btn:focus {
    outline: 2px solid var(--accent-blue);
    outline-offset: 2px;
}

/* High Contrast Mode Support */
@media (prefers-contrast: high) {
    .sidebar {
        border-right: 2px solid var(--text-light);
    }
    
    .nav-link.active {
        background: var(--accent-blue);
        color: white;
    }
}

/* Reduced Motion Support */
@media (prefers-reduced-motion: reduce) {
    .sidebar,
    .nav-link,
    .submenu-link,
    .nav-arrow,
    .logout-btn {
        transition: none;
    }
    
    .badge {
        animation: none;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle functionality
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const sidebarToggle = document.getElementById('sidebarToggle'); // Add this button to your navbar
    
    // Toggle sidebar on mobile
    function toggleSidebar() {
        sidebar.classList.toggle('active');
        sidebarOverlay.classList.toggle('active');
        document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
    }
    
    // Close sidebar when clicking overlay
    if (sidebarOverlay) {
        sidebarOverlay.addEventListener('click', function() {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        });
    }
    
    // Close sidebar on escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
    
    // Handle submenu arrows
    const submenuToggles = document.querySelectorAll('.submenu-toggle');
    submenuToggles.forEach(toggle => {
        toggle.addEventListener('click', function(e) {
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
            }
        });
    });
    
    // Auto-close sidebar on mobile when clicking nav links
    const navLinks = document.querySelectorAll('.nav-link:not(.submenu-toggle), .submenu-link');
    navLinks.forEach(link => {
        link.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                setTimeout(() => {
                    sidebar.classList.remove('active');
                    sidebarOverlay.classList.remove('active');
                    document.body.style.overflow = '';
                }, 150);
            }
        });
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        if (window.innerWidth > 768) {
            sidebar.classList.remove('active');
            sidebarOverlay.classList.remove('active');
            document.body.style.overflow = '';
        }
    });
});
</script>