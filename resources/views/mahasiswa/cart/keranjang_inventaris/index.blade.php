
@extends('mahasiswa.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/show_peminjaman.css') }}">
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-9">
            <!-- Enhanced Header Card -->
            <div class="card border-0 shadow-lg mb-4 header-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fa fa-shopping-basket"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Keranjang Peminjaman Inventaris</h4>
                                <p class="text-white-50 mb-0">Kelola inventaris yang akan dipinjam sebelum diajukan</p>
                            </div>
                        </div>
                        <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" 
                           class="btn btn-outline-light btn-floating">
                            <i class="fa fa-plus me-2"></i>Tambah Inventaris
                        </a>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show border-0 shadow-lg alert-futuristic mb-4" role="alert">
                    <div class="alert-bg"></div>
                    <div class="d-flex align-items-center position-relative">
                        <div class="alert-icon-wrapper me-3">
                            <div class="alert-icon-bg bg-success">
                                <i class="fa fa-check"></i>
                            </div>
                            <div class="alert-icon-pulse"></div>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Berhasil!</div>
                            <div class="alert-message">{{ session('success') }}</div>
                        </div>
                        <button type="button" class="btn-close btn-close-futuristic" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show border-0 shadow-lg alert-futuristic mb-4" role="alert">
                    <div class="alert-bg alert-bg-danger"></div>
                    <div class="d-flex align-items-center position-relative">
                        <div class="alert-icon-wrapper me-3">
                            <div class="alert-icon-bg bg-danger">
                                <i class="fa fa-exclamation-triangle"></i>
                            </div>
                            <div class="alert-icon-pulse"></div>
                        </div>
                        <div class="alert-content">
                            <div class="alert-title">Error!</div>
                            <div class="alert-message">{{ session('error') }}</div>
                        </div>
                        <button type="button" class="btn-close btn-close-futuristic" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if(count($cartItems) > 0)
                <!-- Cart Items Section -->
                <div class="section-card mb-4">
                    <div class="section-header">
                        <div class="section-icon">
                            <i class="fa fa-box"></i>
                        </div>
                        <div>
                            <h5 class="section-title">Daftar Inventaris di Keranjang</h5>
                            <p class="section-subtitle">{{ count($cartItems) }} inventaris siap untuk diajukan</p>
                        </div>
                    </div>
                    
                    <div class="section-content">
                        <!-- Modern Table View -->
                        <div class="table-responsive mb-4">
                            <table class="table table-hover table-modern">
                                <thead>
                                    <tr>
                                        <th class="border-0">No</th>
                                        <th class="border-0">Nama Inventaris</th>
                                        <th class="border-0">Jumlah</th>
                                        <th class="border-0">Stok Tersedia</th>
                                        <th class="border-0 text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $id => $item)
                                        <tr class="cart-item-row">
                                            <td>
                                                <div class="number-circle-small">{{ $loop->iteration }}</div>
                                            </td>
                                            <td>
                                                <div class="room-info-compact">
                                                    <h6 class="mb-1">{{ $item['nama_inventaris'] }}</h6>
                                                    <small class="text-muted">
                                                        <i class="fa fa-box me-1"></i>Inventaris
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <form action="{{ route('mahasiswa.cart.keranjang_inventaris.update', $id) }}" method="POST" class="d-flex align-items-center">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="input-group input-group-sm quantity-group">
                                                        <input type="number" name="jumlah" value="{{ $item['jumlah'] }}" 
                                                            min="1" max="{{ $item['stok_tersedia'] }}" class="form-control" 
                                                            aria-label="Quantity">
                                                        <button type="submit" class="btn btn-outline-primary">
                                                            <i class="fa fa-refresh"></i>
                                                        </button>

                                                    </div>
                                                    
                                                </form>

                                            </td>
                                            <td>
                                                <span class="location-badge">
                                                    <i class="fa fa-cubes me-1"></i>{{ $item['stok_tersedia'] }} unit
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="action-buttons-compact d-flex justify-content-center gap-1">
                                                    <form action="{{ route('mahasiswa.cart.keranjang_inventaris.remove', $id) }}" 
                                                          method="POST" 
                                                          class="d-inline"
                                                          onsubmit="return confirm('Yakin ingin menghapus item ini?')">
                                                        @csrf
                                                        <button type="submit" 
                                                                class="btn btn-outline-danger btn-sm btn-action"
                                                                data-bs-toggle="tooltip" 
                                                                title="Hapus dari Keranjang">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Action Section -->
                <div class="action-section">
                    <div class="action-buttons">
                        <form action="{{ route('mahasiswa.cart.keranjang_inventaris.clear') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" 
                                    class="btn btn-outline-secondary btn-lg" 
                                    onclick="return confirm('Yakin ingin mengosongkan keranjang?')">
                                <i class="fa fa-trash me-2"></i>Kosongkan Keranjang
                            </button>
                        </form>
                        
                        <form action="{{ route('mahasiswa.cart.keranjang_inventaris.checkout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="fa fa-check-circle me-2"></i>Proses Peminjaman
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Empty State -->
                <div class="section-card">
                    <div class="section-content">
                        <div class="empty-state text-center py-5">
                            <div class="py-4">
                                <div class="mb-4">
                                    <i class="fa fa-shopping-basket display-1 text-muted opacity-50"></i>
                                </div>
                                <h4 class="text-muted mb-3 fw-bold">Keranjang Inventaris Kosong</h4>
                                <p class="text-muted mb-4 lead">
                                    Mulai tambahkan inventaris ke keranjang untuk melakukan peminjaman
                                </p>
                                <div class="empty-state-actions">
                                    <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" 
                                       class="btn btn-primary rounded-pill px-4 py-2 shadow-sm">
                                        <i class="fa fa-plus me-2"></i>Pilih Inventaris
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

@push('styles')
<style>

.cart-item-row {
    transition: all 0.3s ease;
}

.cart-item-row:hover {
    background-color: rgba(0, 123, 255, 0.05);
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.action-buttons-compact .btn-action {
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 6px;
    transition: all 0.3s ease;
}

.action-buttons-compact .btn-action:hover {
    transform: translateY(-1px);
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.quantity-group {
    width: 140px;
}

.quantity-group-card {
    width: 120px;
}

.cart-inventaris-card {
    transition: all 0.3s ease;
    border: 1px solid #e9ecef;
}

.cart-inventaris-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    border-color: #007bff;
}

.card-actions {
    display: flex;
    gap: 0.25rem;
}

.btn-xs {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
    line-height: 1;
    border-radius: 0.25rem;
}


.alert-futuristic {
    border-radius: 12px;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
}

.alert-bg {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(40, 167, 69, 0.1), rgba(40, 167, 69, 0.05));
    border-radius: 12px;
}

.alert-bg-danger {
    background: linear-gradient(135deg, rgba(220, 53, 69, 0.1), rgba(220, 53, 69, 0.05));
}

.alert-icon-wrapper {
    position: relative;
}

.alert-icon-bg {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-size: 1.1rem;
}

.alert-icon-pulse {
    position: absolute;
    top: 0;
    left: 0;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background: rgba(40, 167, 69, 0.3);
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        transform: scale(1);
        opacity: 1;
    }
    50% {
        transform: scale(1.1);
        opacity: 0.7;
    }
    100% {
        transform: scale(1.2);
        opacity: 0;
    }
}

.alert-content {
    flex: 1;
}

.alert-title {
    font-weight: 600;
    font-size: 1rem;
    margin-bottom: 0.25rem;
}

.alert-message {
    font-size: 0.9rem;
    opacity: 0.9;
}

.btn-close-futuristic {
    background: none;
    border: none;
    opacity: 0.7;
    transition: all 0.3s ease;
}

.btn-close-futuristic:hover {
    opacity: 1;
    transform: scale(1.1);
}


.empty-state {
    padding: 60px 20px;
}

.empty-state .display-1 {
    font-size: 4rem;
}


.table-hover tbody tr:hover {
    background-color: rgba(0, 123, 255, 0.05) !important;
}


.tooltip {
    font-size: 0.875rem;
}

.tooltip-inner {
    background-color: #1f2937;
    border-radius: 6px;
    padding: 8px 12px;
}


@media (max-width: 768px) {
    .room-card-detailed {
        margin-bottom: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
    
    .card-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .quantity-group,
    .quantity-group-card {
        width: 100px;
    }
    
    .detail-value .input-group {
        width: 100%;
    }
}


.form-control[type="number"] {
    text-align: center;
}

.input-group-sm .form-control {
    font-size: 0.875rem;
}

.number-circle-small {
    width: 30px;
    height: 30px;
    border-radius: 50%;
    background: linear-gradient(135deg, #007bff, #0056b3);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 0.875rem;
    box-shadow: 0 2px 8px rgba(0, 123, 255, 0.3);
}

.location-badge {
    background: rgba(108, 117, 125, 0.1);
    color: #6c757d;
    padding: 0.375rem 0.75rem;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    border: 1px solid rgba(108, 117, 125, 0.2);
}

.detail-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.detail-row:last-child {
    border-bottom: none;
}

.detail-label {
    font-weight: 500;
    color: #6c757d;
    font-size: 0.875rem;
}

.detail-value {
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}


.detail-value .input-group {
    width: 120px;
}

.detail-value .form-control {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}

.detail-value .btn {
    font-size: 0.8rem;
    padding: 0.25rem 0.5rem;
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
   
    const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
   
    const cartRows = document.querySelectorAll('.cart-item-row');
    cartRows.forEach(row => {
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
            this.style.transition = 'all 0.3s ease';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

   
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const submitBtn = this.querySelector('button[type="submit"]');
            if (submitBtn && !submitBtn.disabled) {
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '<i class="fa fa-spinner fa-spin me-2"></i>Memproses...';
                submitBtn.disabled = true;
                
   
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 3000);
            }
        });
    });

   
    const observeElements = document.querySelectorAll('.section-card, .room-card-detailed');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });

    observeElements.forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'all 0.6s ease';
        observer.observe(el);
    });
    
   
    document.querySelectorAll('.quantity-group input, .quantity-group-card input').forEach(input => {
        input.addEventListener('focus', function() {
            this.select();
        });
    });
});
</script>
@endpush
@endsection