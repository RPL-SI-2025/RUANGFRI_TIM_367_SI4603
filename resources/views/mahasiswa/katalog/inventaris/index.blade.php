@extends('mahasiswa.layouts.app')

@section('content')
<!-- Load CSS khusus catalog -->
<link rel="stylesheet" href="{{ asset('css/catalog-style.css') }}">

<div class="catalog-container">
    <div class="container py-4">
        <!-- Header Section -->
        <div class="catalog-header">
            <div class="d-flex justify-content-between align-items-start mb-4">
                <div>
                    <h1 class="catalog-title">
                        <i class="fa fa-boxes catalog-title-icon"></i>
                        Katalog Inventaris
                    </h1>
                    <p class="catalog-subtitle">Jelajahi koleksi inventaris yang tersedia untuk dipinjam</p>
                </div>
                <div class="d-flex align-items-center gap-3">
                    <div class="catalog-stats">
                        <i class="fa fa-list"></i>
                        <span>{{ $inventaris->count() }} Item Tersedia</span>
                    </div>
                    <a href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}" 
                       class="catalog-cart-button">
                        <i class="fa fa-shopping-basket"></i>
                        Keranjang
                        @if(session()->has('cart') && count(session('cart')) > 0)
                            <span class="catalog-cart-badge">{{ count(session('cart')) }}</span>
                        @endif
                    </a>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="catalog-filters">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="catalog-search-container">
                            <i class="fa fa-search catalog-search-icon"></i>
                            <input type="text" 
                                   class="catalog-search-input" 
                                   placeholder="Cari inventaris berdasarkan nama atau deskripsi..."
                                   id="catalogSearchInput"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-7 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end align-items-center gap-3">
                            <!-- Category Filter -->
                            <select class="catalog-filter-select" id="catalogCategoryFilter">
                                <option value="">Semua Kategori</option>
                                @foreach($kategoris as $kategori)
                                    <option value="{{ $kategori->nama_kategori }}">{{ $kategori->nama_kategori }}</option>
                                @endforeach
                            </select>
                            
                            <!-- Status Filter -->
                            <select class="catalog-filter-select" id="catalogStatusFilter">
                                <option value="">Semua Status</option>
                                <option value="Tersedia">Tersedia</option>
                                <option value="Tidak Tersedia">Tidak Tersedia</option>
                            </select>
                            
                            <span class="catalog-results-count">
                                <i class="fa fa-filter"></i>
                                <span id="resultsCount">{{ $inventaris->count() }}</span> dari {{ $inventaris->count() }} item
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
            <div class="catalog-alert catalog-alert-success" role="alert" id="successAlert">
                <i class="fa fa-check-circle"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        
        @if(session('error'))
            <div class="catalog-alert catalog-alert-error" role="alert" id="errorAlert">
                <i class="fa fa-exclamation-circle"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Catalog Grid -->
        @if($inventaris->count() > 0)
            <div class="catalog-grid" id="catalogGrid">
                @foreach($inventaris as $item)
                <div class="catalog-card" 
                     data-name="{{ strtolower($item->nama_inventaris) }}" 
                     data-status="{{ $item->status }}"
                     data-category="{{ $item->kategori->nama_kategori ?? 'Lainnya' }}"
                     data-description="{{ strtolower($item->deskripsi ?? '') }}">
                    
                    <!-- Image Container -->
                    <div class="catalog-card-image-container">
                        @if($item->gambar_inventaris)
                            <img src="{{ asset('storage/katalog_inventaris/' . $item->gambar_inventaris) }}" 
                                 class="catalog-card-image" 
                                 alt="{{ $item->nama_inventaris }}"
                                 loading="lazy">
                        @else
                            <div class="catalog-card-image-placeholder">
                                <i class="fa fa-box"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badge -->
                        <div class="catalog-status-badge {{ $item->status === 'Tersedia' ? 'catalog-status-available' : 'catalog-status-unavailable' }}">
                            {{ $item->status }}
                        </div>
                        
                        <!-- Category Badge -->
                        <div class="catalog-category-badge">
                            <i class="fa fa-tag"></i>
                            {{ $item->kategori->nama_kategori ?? 'Lainnya' }}
                        </div>
                    </div>
                    
                    <!-- Card Content -->
                    <div class="catalog-card-content">
                        <h3 class="catalog-card-title">{{ $item->nama_inventaris }}</h3>
                        
                        <p class="catalog-card-description">
                            {{ $item->deskripsi ?: 'Deskripsi tidak tersedia untuk item ini.' }}
                        </p>
                        
                        <!-- Stock Information -->
                        <div class="catalog-info-section catalog-stock-info">
                            <div class="catalog-stock-label">
                                <i class="fa fa-cubes"></i>
                                Stok Tersedia
                            </div>
                            <div class="catalog-stock-count {{ $item->jumlah <= 2 ? 'catalog-stock-low' : '' }} {{ $item->jumlah == 0 ? 'catalog-stock-out' : '' }}">
                                {{ $item->jumlah }} unit
                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="catalog-card-actions">
                            <a href="{{ route('mahasiswa.katalog.inventaris.show', $item->id) }}"
                               class="catalog-btn-detail"
                               aria-label="Lihat detail {{ $item->nama_inventaris }}">
                                <i class="fa fa-info-circle"></i>
                                Detail
                            </a>
                            
                            @if($item->status === 'Tersedia' && $item->jumlah > 0)
                                <form action="{{ route('mahasiswa.cart.keranjang_inventaris.add') }}" 
                                      method="POST" 
                                      class="d-flex flex-fill">
                                    @csrf
                                    <input type="hidden" name="id_inventaris" value="{{ $item->id }}">
                                    <input type="hidden" name="jumlah" value="1">
                                    <button type="submit" 
                                            class="catalog-btn-primary w-100"
                                            aria-label="Tambahkan {{ $item->nama_inventaris }} ke keranjang">
                                        <i class="fa fa-cart-plus"></i>
                                        Tambah ke Keranjang
                                    </button>
                                </form>
                            @else
                                <button class="catalog-btn-primary w-100" 
                                        disabled
                                        aria-label="Item tidak tersedia">
                                    <i class="fa fa-ban"></i>
                                    Tidak Tersedia
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="catalog-empty-state">
                <div class="catalog-empty-icon">
                    <i class="fa fa-box-open"></i>
                </div>
                <h3 class="catalog-empty-title">Katalog Inventaris Kosong</h3>
                <p class="catalog-empty-description">
                    Saat ini tidak ada inventaris yang tersedia untuk dipinjam. Silakan coba lagi nanti atau hubungi administrator.
                </p>
                <a href="{{ route('mahasiswa.dashboard') }}" class="catalog-empty-action">
                    <i class="fa fa-home"></i>
                    Kembali ke Dashboard
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/catalog-functionality.js') }}"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('catalogSearchInput');
    const categoryFilter = document.getElementById('catalogCategoryFilter');
    const statusFilter = document.getElementById('catalogStatusFilter');
    const catalogGrid = document.getElementById('catalogGrid');
    const resultsCount = document.getElementById('resultsCount');
    
    function filterCatalog() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedCategory = categoryFilter.value;
        const selectedStatus = statusFilter.value;
        const cards = catalogGrid.querySelectorAll('.catalog-card');
        let visibleCount = 0;
        
        cards.forEach(card => {
            const name = card.dataset.name;
            const description = card.dataset.description;
            const category = card.dataset.category;
            const status = card.dataset.status;
            
            const matchesSearch = !searchTerm || 
                name.includes(searchTerm) || 
                description.includes(searchTerm);
            
            const matchesCategory = !selectedCategory || category === selectedCategory;
            const matchesStatus = !selectedStatus || status === selectedStatus;
            
            if (matchesSearch && matchesCategory && matchesStatus) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });
        
        resultsCount.textContent = visibleCount;
    }
    searchInput.addEventListener('input', filterCatalog);
    categoryFilter.addEventListener('change', filterCatalog);
    statusFilter.addEventListener('change', filterCatalog);
    const successAlert = document.getElementById('successAlert');
    const errorAlert = document.getElementById('errorAlert');
    
    if (successAlert) {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(successAlert);
            bsAlert.close();
        }, 3000);
    }
    
    if (errorAlert) {
        setTimeout(() => {
            const bsAlert = new bootstrap.Alert(errorAlert);
            bsAlert.close();
        }, 4000);
    }
});
</script>
@endpush
