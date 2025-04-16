<!-- Top Navbar -->
<nav class="top-navbar d-flex justify-content-between align-items-center sticky-top">
    <div>
        <button class="btn" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    
    <div class="d-flex">
        <div class="position-relative me-4">
            <a  class="btn btn-link text-secondary position-relative">
                <i class="fas fa-bell fa-lg"></i>
                @if(isset($notificationCount) && $notificationCount > 0)
                <span class="notification-badge">{{ $notificationCount }}</span>
                @endif
            </a>
        </div>
        
        <div class="user-dropdown dropdown">
            <a class="dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="user-avatar">{{ substr(Auth::user()->name ?? 'MA', 0, 2) }}</div>
                <div>
                    <div class="fw-bold">{{ Auth::user()->name ?? 'Mahasiswa' }}</div>
                    <div class="small text-muted">{{ Auth::user()->nim ?? '20220123456' }}</div>
                </div>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                <li><a class="dropdown-item" ><i class="fas fa-user me-2"></i> Profil</a></li>
                <li><a class="dropdown-item" ><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                <li><hr class="dropdown-divider"></li>
                <li>
                    <a class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>