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
                        <i class="fa fa-door-open catalog-title-icon"></i>
                        Katalog Ruangan
                    </h1>
                    <p class="catalog-subtitle">Lihat daftar ruangan yang tersedia untuk dipinjam</p>
                </div>
                <div class="catalog-stats">
                    <i class="fa fa-list"></i>
                    <span>{{ $ruangans->count() }} Ruangan Tersedia</span>
                </div>
                <a href="{{ route('mahasiswa.cart.keranjang_ruangan.index') }}"
                    class="catalog-cart-button">
                    <i class="fa fa-shopping-basket"></i>
                    Keranjang
                    @if(session()->has('cart_ruangan') && count(session('cart_ruangan')) > 0)
                        <span class="catalog-cart-badge">{{ count(session('cart_ruangan')) }}</span>
                    @endif
                </a>
            </div>

            <!-- Search and Filter Section -->
            <div class="catalog-filters">
                <div class="row align-items-center">
                    <div class="col-md-5">
                        <div class="catalog-search-container">
                            <i class="fa fa-search catalog-search-icon"></i>
                            <input type="text"
                                   class="catalog-search-input"
                                   placeholder="Cari ruangan berdasarkan nama atau deskripsi..."
                                   id="catalogSearchInput"
                                   autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-7 text-md-end mt-3 mt-md-0">
                        <div class="d-flex justify-content-md-end align-items-center gap-3">
                            <!-- Lokasi Filter -->
                            <select class="catalog-filter-select" id="catalogLokasiFilter" name="lokasi">
                                <option value="">Semua Lokasi</option>

                                @foreach($lokasiOptions as $lok)
                                    <option value="{{ $lok }}" {{ request('lokasi') == $lok ? 'selected' : '' }}>
                                        {{ $lok }}
                                    </option>
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
                                <span id="resultsCount">{{ $ruangans->count() }}</span> dari {{ $ruangans->count() }} ruangan
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
        {{-- @dd($ruangans->items()); --}}
        @if($ruangans->count() > 0)


            <div class="catalog-grid" id="catalogGrid">
                @foreach($ruangans as $ruangan)

                {{-- @dd($ruangan->gambar); --}}
                    <div class="catalog-card"
                         data-name="{{ strtolower($ruangan->nama_ruangan) }}"
                         data-status="{{ $ruangan->status }}"
                         data-description="{{ strtolower($ruangan->deskripsi ?? '') }}">

                        <!-- Image Container -->
                        <div class="catalog-card-image-container">
                            {{-- @dd($ruangan) --}}
                            @if($ruangan->gambar)

                                <img src="{{ asset('storage/katalog_ruangan/' . $ruangan->gambar) }}"
                                     class="catalog-card-image"
                                     alt="{{ $ruangan->nama_ruangan }}"
                                     loading="lazy">
                            @else
                                <div class="catalog-card-image-placeholder">
                                    <i class="fa fa-door-closed"></i>
                                </div>
                            @endif

                            <!-- Status Badge -->
                            <div class="catalog-status-badge {{ $ruangan->status === 'Tersedia' ? 'catalog-status-available' : 'catalog-status-unavailable' }}">
                                {{ $ruangan->status }}
                            </div>
                        </div>

                        <!-- Card Content -->
                        <div class="catalog-card-content">
                            <h3 class="catalog-card-title">{{ $ruangan->nama_ruangan }}</h3>

                            <p class="catalog-card-description">
                                {{ $ruangan->deskripsi ?: 'Deskripsi tidak tersedia untuk ruangan ini.' }}
                            </p>

                            <!-- Kapasitas Info -->
                            <div class="catalog-info-section">
                                <div class="catalog-stock-label">
                                    <i class="fa fa-users"></i>
                                    Kapasitas
                                </div>
                                <div class="catalog-stock-count">
                                    {{ $ruangan->kapasitas }} orang
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="catalog-card-actions">
                                <a href="{{ route('mahasiswa.katalog.ruangan.show', $ruangan->id) }}"
                                   class="catalog-btn-detail"
                                   aria-label="Lihat detail {{ $ruangan->nama_ruangan }}">
                                    <i class="fa fa-info-circle"></i>
                                    Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <!-- Empty State -->
            <div class="catalog-empty-state">
                <div class="catalog-empty-icon">
                    <i class="fa fa-door-closed"></i>
                </div>
                <h3 class="catalog-empty-title">Tidak Ada Ruangan</h3>
                <p class="catalog-empty-description">
                    Saat ini tidak ada ruangan yang tersedia. Silakan coba lagi nanti atau hubungi administrator.
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
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('catalogSearchInput');
    const statusFilter = document.getElementById('catalogStatusFilter');
    const catalogGrid = document.getElementById('catalogGrid');
    const resultsCount = document.getElementById('resultsCount');

    function filterCatalog() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedStatus = statusFilter.value;
        const cards = catalogGrid.querySelectorAll('.catalog-card');
        let visibleCount = 0;

        cards.forEach(card => {
            const name = card.dataset.name;
            const description = card.dataset.description;
            const status = card.dataset.status;

            const matchesSearch = !searchTerm ||
                name.includes(searchTerm) ||
                description.includes(searchTerm);

            const matchesStatus = !selectedStatus || status === selectedStatus;

            if (matchesSearch && matchesStatus) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        resultsCount.textContent = visibleCount;
    }

    searchInput.addEventListener('input', filterCatalog);
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
