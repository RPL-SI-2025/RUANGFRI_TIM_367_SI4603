
<!-- Sidebar -->
<link rel="stylesheet" href="{{ asset('css/edit_peminjaman.css') }}">
<nav class="sidebar" id="sidebar">
    <div class="sidebar-header">
        <a href="{{ route('admin.dashboard') }}" class="logo">
            <div class="logo-icon">
                <i class="fas fa-cog"></i>
            </div>
            <div class="logo-text">RUANGFRI</div>
        </a>
    </div>

    <div class="sidebar-nav">
        <!-- Main Navigation -->
        <div class="nav-section">
            <div class="nav-section-title">Main</div>
            <div class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <div class="nav-icon">
                        <i class="fas fa-tachometer-alt"></i>
                    </div>
                    <span class="nav-text">Dashboard</span>
                </a>
            </div>
        </div>

        <!-- Room Management -->
        <div class="nav-section">
            <div class="nav-section-title">Room Management</div>
            <div class="nav-item">
                <a href="#ruanganMenu" class="nav-link" data-bs-toggle="collapse" 
                aria-expanded="{{ request()->is('admin/katalog_ruangan*') || request()->is('admin/pinjam-ruangan*') || request()->is('admin/lapor_ruangan*') || request()->is('admin/jadwal_ruangan*') || request()->is('admin/history_ruangan*') ? 'true' : 'false' }}">
                    <div class="nav-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <span class="nav-text">Manajemen Ruangan</span>
                    <i class="fas fa-chevron-down nav-arrow"></i>
                </a>
                <div class="collapse submenu {{ request()->is('admin/katalog_ruangan*') || request()->is('admin/pinjam-ruangan*') || request()->is('admin/lapor_ruangan*') || request()->is('admin/jadwal_ruangan*') || request()->is('admin/history_ruangan*') ? 'show' : '' }}" id="ruanganMenu">
                    <a href="{{ route('admin.katalog_ruangan.index') }}" class="nav-link {{ request()->routeIs('admin.katalog_ruangan.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-door-open"></i>
                        </div>
                        <span class="nav-text">Data Ruangan</span>
                    </a>
                    <a href="{{ route('admin.jadwal.index') }}" class="nav-link {{ request()->routeIs('admin.jadwal.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-calendar-alt"></i>
                        </div>
                        <span class="nav-text">Data Jadwal Ruangan</span>
                    </a>
                    <a href="{{ route('admin.pinjam-ruangan.index') }}" class="nav-link {{ request()->routeIs('admin.pinjam-ruangan.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-check-circle"></i>
                        </div>
                        <span class="nav-text">Approval Ruangan</span>
                    </a>
                    <a href="{{ route('admin.history_ruangan.index')}}" class="nav-link {{ request()->routeIs('admin.history_ruangan.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-history"></i>
                        </div>
                        <span class="nav-text">History Peminjaman Ruangan</span>
                    </a>
                    <a href="{{ route('admin.lapor_ruangan.index') }}" class="nav-link {{ request()->routeIs('admin.lapor_ruangan.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <span class="nav-text">Laporan Ruangan</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Inventory Management -->
        <div class="nav-section">
            <div class="nav-section-title">Inventory</div>
            <div class="nav-item">
                <a href="#inventarisMenu" class="nav-link" data-bs-toggle="collapse"
                aria-expanded="{{ request()->is('admin/inventaris*') || request()->is('admin/pinjam-inventaris*') || request()->is('admin/lapor_inventaris*') || request()->is('admin/jadwal_inventaris*') || request()->is('admin/history_inventaris*') ? 'true' : 'false' }}">
                    <div class="nav-icon">
                        <i class="fas fa-boxes"></i>
                    </div>
                    <span class="nav-text">Manajemen Inventaris</span>
                    <i class="fas fa-chevron-down nav-arrow"></i>
                </a>
                <div class="collapse submenu {{ request()->is('admin/inventaris*') || request()->is('admin/pinjam-inventaris*') || request()->is('admin/lapor_inventaris*') || request()->is('admin/jadwal_inventaris*') || request()->is('admin/history_inventaris*') ? 'show' : '' }}" id="inventarisMenu">
                    <a href="{{ route('admin.inventaris.index') }}" class="nav-link {{ request()->routeIs('admin.inventaris.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-cube"></i>
                        </div>
                        <span class="nav-text">Data Inventaris</span>
                    </a>
                    <a href="#" class="nav-link {{ request()->routeIs('admin.jadwal_inventaris.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <span class="nav-text">Data Jadwal Inventaris</span>
                    </a>
                    <a href="{{ route('admin.pinjam-inventaris.index') }}" class="nav-link {{ request()->routeIs('admin.pinjam-inventaris.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-clipboard-check"></i>
                        </div>
                        <span class="nav-text">Approval Inventaris</span>
                    </a>
                    <a href="{{ route('admin.history_inventaris.index') }}" class="nav-link {{ request()->routeIs('admin.history_inventaris.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-clock"></i>
                        </div>
                        <span class="nav-text">History Peminjaman Inventaris</span>
                    </a>
                    <a href="{{ route('admin.lapor_inventaris.index') }}" class="nav-link {{ request()->routeIs('admin.lapor_inventaris.*') ? 'active' : '' }}">
                        <div class="nav-icon">
                            <i class="fas fa-file-alt"></i>
                        </div>
                        <span class="nav-text">Laporan Inventaris</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- System -->
        <div class="nav-section">
            <div class="nav-section-title">System</div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <div class="nav-icon">
                        <i class="fas fa-chart-bar"></i>
                    </div>
                    <span class="nav-text">Reports</span>
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <div class="nav-icon">
                        <i class="fas fa-cog"></i>
                    </div>
                    <span class="nav-text">Settings</span>
                </a>
            </div>
        </div>
    </div>
</nav>