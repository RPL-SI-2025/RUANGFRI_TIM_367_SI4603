
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

    <!-- Include Sidebar -->
    @include('admin.layouts.sidebar')

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