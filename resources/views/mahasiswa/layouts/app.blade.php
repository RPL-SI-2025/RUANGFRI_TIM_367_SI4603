<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Peminjaman Inventaris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3763eb;
            --secondary-color: #6c757d;
            --light-bg: #f8f9fa;
            --dark-bg: #2d3748;
        }
        
        body {
            background-color: #f5f7fa;
            font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }
        
        .sidebar {
            background-color: var(--dark-bg);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            padding: 0;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }
        
        .sidebar-header {
            padding: 1.5rem 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar .nav-link {
            color: rgba(255,255,255,0.75);
            border-radius: 0;
            padding: 0.75rem 1.5rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            transition: all 0.3s;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(55, 99, 235, 0.2);
            color: #fff;
            border-left: 4px solid var(--primary-color);
        }
        
        .sidebar .fa, .sidebar .fas {
            width: 24px;
            margin-right: 10px;
            text-align: center;
        }
        
        /* Navbar Styles */
        .main-content {
            margin-left: 250px;
            transition: all 0.3s;
        }
        
        .top-navbar {
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 0.75rem 1.5rem;
            height: 70px;
        }
        
        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color);
        }
        
        .user-dropdown .dropdown-toggle {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
            font-weight: 500;
        }
        
        .user-dropdown .dropdown-toggle::after {
            display: none;
        }
        
        .user-avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background-color: var(--primary-color);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 8px;
        }
        
        .content-wrapper {
            padding: 2rem;
            min-height: calc(100vh - 70px);
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            transition: transform 0.2s;
        }
        
        .card:hover {
            transform: translateY(-5px);
        }
        
        .card-header {
            background-color: #fff;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 1.25rem 1.5rem;
            font-weight: 700;
        }
        
        .btn {
            border-radius: 50rem;
            padding: 0.5rem 1.5rem;
            font-weight: 500;
            transition: all 0.3s;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            box-shadow: 0 2px 6px rgba(55, 99, 235, 0.3);
        }
        
        .btn-primary:hover {
            background-color: #2854e0;
            border-color: #2854e0;
            transform: translateY(-1px);
        }
        
        .stat-card .icon {
            background-color: rgba(55, 99, 235, 0.1);
            color: var(--primary-color);
            border-radius: 10px;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }
        
        .action-card {
            text-align: center;
            padding: 2rem;
        }
        
        .action-card .icon {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            color: var(--primary-color);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #dc3545;
            color: white;
            font-size: 0.7rem;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>
    @include('mahasiswa.layouts.sidebar')
    
    <!-- Main Content -->
    <div class="main-content">
        @include('mahasiswa.layouts.navbar')
        
        <!-- Content Area -->
        <div class="content-wrapper">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            
            if (sidebar.style.marginLeft === '-250px') {
                sidebar.style.marginLeft = '0';
                mainContent.style.marginLeft = '250px';
            } else {
                sidebar.style.marginLeft = '-250px';
                mainContent.style.marginLeft = '0';
            }
        });
        
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });
    </script>
</body>
</html>