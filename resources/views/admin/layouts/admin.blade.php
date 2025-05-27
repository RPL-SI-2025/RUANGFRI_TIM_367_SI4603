
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Animation Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.css" rel="stylesheet">

    <link href="{{ asset('css/appadmin.css') }}" rel="stylesheet">

</head>
<body>
    <!-- Page Loader -->
    <div class="page-loader" id="pageLoader">
        <div class="loader"></div>
    </div>

    <!-- Sidebar Overlay for Mobile -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
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
                        <a href="#" class="nav-link {{ request()->routeIs('admin.history_ruangan.*') ? 'active' : '' }}">
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
                        <a href="{{ route('admin.historymahasiswa.history.history_inventaris.index') }}" class="nav-link {{ request()->routeIs('admin.history_inventaris.*') ? 'active' : '' }}">
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

    <!-- Main Header -->
    <header class="main-header" id="mainHeader">
        <div class="header-left">
            <button class="sidebar-toggle" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <h1>@yield('page-title', 'Dashboard')</h1>
        </div>
        <div class="header-right">
            <button class="notification-btn" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifications">
                <i class="fas fa-bell"></i>
                <span class="notification-badge">3</span>
            </button>
            <div class="user-profile dropdown" data-bs-toggle="dropdown">
                <div class="user-avatar">
                    {{ substr(Auth::user()->nama ?? 'A', 0, 2) }}
                </div>
                <div class="user-info d-none d-sm-block">
                    <h6>{{ Auth::user()->nama ?? 'Admin' }}</h6>
                    <small>Administrator</small>
                </div>
                <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-user me-2"></i> Profile
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fas fa-cog me-2"></i> Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item text-danger" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="main-content" id="mainContent">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/aos@2.3.4/dist/aos.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            AOS.init({
                duration: 600,
                easing: 'ease-in-out',
                once: true
            });


            const pageLoader = document.getElementById('pageLoader');
            setTimeout(() => {
                pageLoader.style.opacity = '0';
                setTimeout(() => {
                    pageLoader.style.display = 'none';
                }, 500);
            }, 1000);


            const sidebar = document.getElementById('sidebar');
            const mainHeader = document.getElementById('mainHeader');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');


            function toggleSidebar() {
                if (window.innerWidth <= 768) {

                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                } else {

                    sidebar.classList.toggle('collapsed');
                    mainHeader.classList.toggle('collapsed');
                    mainContent.classList.toggle('collapsed');
                }
            }


            function closeMobileSidebar() {
                sidebar.classList.remove('show');
                sidebarOverlay.classList.remove('show');
                document.body.style.overflow = '';
            }


            sidebarToggle.addEventListener('click', toggleSidebar);
            sidebarOverlay.addEventListener('click', closeMobileSidebar);


            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    closeMobileSidebar();
                }
            });


            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });


            document.querySelectorAll('[data-bs-toggle="collapse"]').forEach(function(element) {
                element.addEventListener('click', function() {
                    const arrow = this.querySelector('.nav-arrow');
                    if (arrow) {
                        setTimeout(() => {
                            const target = document.querySelector(this.getAttribute('href'));
                            if (target && target.classList.contains('show')) {
                                arrow.style.transform = 'rotate(180deg)';
                            } else {
                                arrow.style.transform = 'rotate(0deg)';
                            }
                        }, 50);
                    }
                });
            });


            const animatedElements = document.querySelectorAll('.main-content > *');
            animatedElements.forEach((el, index) => {
                el.classList.add('fade-in-up');
                el.style.animationDelay = `${index * 0.1}s`;
            });


            sidebar.addEventListener('wheel', function(e) {
                e.preventDefault();
                this.scrollTop += e.deltaY;
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
