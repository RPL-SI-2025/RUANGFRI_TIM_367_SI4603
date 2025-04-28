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
                <div class="user-avatar">{{ substr(Session::get('mahasiswa_name') ?? 'MA', 0, 2) }}</div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end shadow border-0" aria-labelledby="userDropdown" style="width: 250px;">
                <li>
                    <div class="dropdown-item-text">
                        <div class="d-flex align-items-center mb-2">
                            <div class="user-avatar me-3" style="width: 48px; height: 48px;">
                                {{ substr(Session::get('mahasiswa_name') ?? 'MA', 0, 2) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ Session::get('mahasiswa_name') }}</div>
                                <div class="small text-muted">{{ Session::get('mahasiswa_nim') }}</div>
                            </div>
                        </div>
                    </div>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-user-circle me-2 text-primary"></i> Profil Saya</a></li>
                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-cog me-2 text-primary"></i> Pengaturan</a></li>
                <li><a class="dropdown-item py-2" href="#"><i class="fas fa-question-circle me-2 text-primary"></i> Bantuan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <form action="{{ route('mahasiswa.logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger py-2">
                            <i class="fas fa-sign-out-alt me-2"></i> Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>