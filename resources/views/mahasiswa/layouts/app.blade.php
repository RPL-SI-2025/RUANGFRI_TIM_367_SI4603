
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <title>Sistem Peminjaman Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/appmahasiswa.css') }}">
    <link href="{{ asset('css/timeslot-styles.css') }}" rel="stylesheet">
    @stack('styles')
</head>
<body class="animated-bg">
    <div class="app-layout">
        @include('mahasiswa.layouts.sidebar')
        
        <!-- Main Content -->
        <div class="main-content">
            @include('mahasiswa.layouts.navbar')
            
            <!-- Content Area -->
            <div class="content-wrapper">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Mobile Sidebar Overlay -->
    <div class="sidebar-overlay d-md-none" id="sidebarOverlay"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.querySelector('.sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function() {
                    if (window.innerWidth <= 768) {
                        sidebar.classList.toggle('show');
                        overlay.classList.toggle('show');
                        document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                    } else {
                        if (sidebar.style.marginLeft === '-280px') {
                            sidebar.style.marginLeft = '0';
                            mainContent.style.marginLeft = '280px';
                            mainContent.style.width = 'calc(100% - 280px)';
                        } else {
                            sidebar.style.marginLeft = '-280px';
                            mainContent.style.marginLeft = '0';
                            mainContent.style.width = '100%';
                        }
                    }
                });
            }
            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                });
            }
            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    document.body.style.overflow = '';
                    sidebar.style.marginLeft = '';
                    mainContent.style.marginLeft = '';
                    mainContent.style.width = '';
                }
            });
        });
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                if (alert.classList.contains('alert-success') || alert.classList.contains('alert-info')) {
                    setTimeout(function() {
                        const bsAlert = new bootstrap.Alert(alert);
                        bsAlert.close();
                    }, 3000);
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>