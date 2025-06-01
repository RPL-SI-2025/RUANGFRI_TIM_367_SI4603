
<!-- Top Navbar -->
<nav class="top-navbar d-flex justify-content-between align-items-center sticky-top">
    <div class="d-flex align-items-center">
        <button class="btn text-secondary border-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <div class="ms-3 d-none d-md-block">
            <h5 class="mb-0 text-primary fw-semibold">{{ $pageTitle }}</h5>
            <small class="text-muted">Selamat datang, {{ Session::get('mahasiswa_name') }}</small>
        </div>
    </div>
    
    <div class="d-flex align-items-center">

        <div class="position-relative me-3">
            <a href="#" class="btn btn-light rounded-circle position-relative" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Notifikasi">
                <i class="fas fa-bell"></i>
                @if(isset($notificationCount) && $notificationCount > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    {{ $notificationCount }}
                    <span class="visually-hidden">notifikasi</span>
                </span>
                @endif
            </a>
        </div>
        
        <div class="user-dropdown dropdown">
            <a class="dropdown-toggle d-flex align-items-center text-decoration-none" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar-simple">{{ substr(Session::get('mahasiswa_name') ?? 'MA', 0, 2) }}</div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0 dropdown-simple" aria-labelledby="userDropdown" style="width: 250px;">
                <li>
                    <div class="dropdown-item-text dropdown-profile">
                        <div class="d-flex align-items-center mb-2">
                            <div class="user-avatar-simple me-3" style="width: 48px; height: 48px;">
                                {{ substr(Session::get('mahasiswa_name') ?? 'MA', 0, 2) }}
                            </div>
                            <div>
                                <div class="fw-bold text-dark">{{ Session::get('mahasiswa_name') }}</div>
                                <div class="small text-muted">{{ Session::get('mahasiswa_nim') }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item py-2 dropdown-item-simple" href="{{ route('mahasiswa.profile.edit') }}"><i class="fas fa-user-circle me-2 text-primary"></i> Profil Saya</a></li>
                <li><a class="dropdown-item py-2 dropdown-item-simple" href="#"><i class="fas fa-cog me-2 text-primary"></i> Pengaturan</a></li>
                <li><a class="dropdown-item py-2 dropdown-item-simple" href="#"><i class="fas fa-question-circle me-2 text-primary"></i> Bantuan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('mahasiswa.logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2 dropdown-item-simple">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>
<style>
.sidebar-toggle {
    background: none;
    border: none;
    color: var(--primary-dark);
    font-size: 1.25rem;
    padding: 0.5rem;
    border-radius: 6px;
    transition: all var(--transition-fast);
}

.sidebar-toggle:hover {
    background: rgba(44, 62, 80, 0.1);
    color: var(--accent-blue);
}

  
.user-avatar-simple {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    background: #1e293b;   
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 700;
    font-size: 1rem;
    text-shadow: none;
    border: 2px solid rgba(30, 41, 59, 0.1);
    transition: all 0.3s ease;
    box-shadow: 0 2px 8px rgba(30, 41, 59, 0.15);
}

.user-avatar-simple:hover {
    transform: scale(1.05);
    box-shadow: 0 4px 12px rgba(30, 41, 59, 0.25);
}

  
.dropdown-simple {
    background: #ffffff !important;
    border: 1px solid #e9ecef;
    border-radius: 12px;
    padding: 0.75rem;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1) !important;
    margin-top: 0.5rem;
}

  
.dropdown-item-simple {
    color: #333 !important;
    border-radius: 8px;
    margin: 0.2rem 0;
    padding: 0.75rem 1rem;
    transition: all 0.3s ease;
    border: 1px solid transparent;
    background: transparent;
}

.dropdown-item-simple:hover {
    background: #f8f9fa !important;
    color: #333 !important;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    transform: translateY(-1px);
}

.dropdown-item-simple.text-danger {
    color: #dc3545 !important;
}

.dropdown-item-simple.text-danger:hover {
    background: rgba(220, 53, 69, 0.05) !important;
    color: #dc3545 !important;
}

  
.dropdown-profile {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 1rem;
    margin-bottom: 0.5rem;
}

.dropdown-profile .text-dark {
    color: #333 !important;
}

  
.dropdown-divider {
    border-color: #e9ecef;
    margin: 0.5rem 0;
}

  
.dropdown-item-simple .text-primary {
    color: #1e293b !important;
}
</style>