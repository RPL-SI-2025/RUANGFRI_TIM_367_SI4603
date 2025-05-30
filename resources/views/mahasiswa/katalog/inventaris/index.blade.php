
@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary mb-0 fw-bold">
            <i class="fa fa-boxes me-2"></i>Katalog Inventaris
        </h4>
        <a href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}" class="btn btn-outline-primary rounded-pill">
            <i class="fa fa-shopping-basket me-1"></i> Lihat Keranjang
        </a>
    </div>

<!-- Add Filter Section -->
<div class="card shadow-sm mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('mahasiswa.katalog.inventaris.index') }}" class="row g-3 align-items-end">
            <!-- Search Filter -->
            <div class="col-md-4">
                <label for="search" class="form-label text-primary fw-bold">Cari Inventaris</label>
                <div class="input-group">
                    <span class="input-group-text border-end-0 bg-white">
                        <i class="fa fa-search text-muted"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0" 
                           id="search" 
                           name="search" 
                           placeholder="Cari berdasarkan nama atau deskripsi..."
                           value="{{ request('search') }}">
                </div>
            </div>

            <!-- Kategori Filter -->
            <div class="col-md-4">
                <label for="kategori_id" class="form-label text-primary fw-bold">Filter Kategori</label>
                <select name="kategori_id" id="kategori_id" class="form-select rounded-pill">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Buttons -->
            <div class="col-md-4">
                <button type="submit" class="btn btn-primary rounded-pill">
                    <i class="fa fa-filter me-2"></i>Filter
                </button>
                @if(request()->hasAny(['kategori_id', 'search']))
                    <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" class="btn btn-outline-secondary rounded-pill">
                        <i class="fa fa-times me-2"></i>Reset
                    </a>
                @endif
            </div>
        </form>
    </div>
</div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
            <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert">
            <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @foreach($inventaris as $item)
        <div class="col-md-4 mb-2">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="position-relative">
                    @if($item->gambar_inventaris)
                        <img src="{{ asset('storage/katalog_inventaris/' . $item->gambar_inventaris) }}" 
                             class="card-img-top" alt="{{ $item->nama_inventaris }}" 
                             style="height: 200px; object-fit: cover;">
                    @else
                        <div class="bg-light d-flex justify-content-center align-items-center" style="height: 200px;">
                            <i class="fa fa-box text-muted" style="font-size: 4rem;"></i>
                        </div>
                    @endif
                    <div class="position-absolute bottom-0 start-0 end-0 p-2 bg-gradient-dark">
                        <div class="d-flex align-items-center">
                            <div class="stock-badge me-2">
                                <span class="badge bg-info rounded-pill">
                                    <i class="fa fa-cubes"></i> Stok: {{ $item->jumlah }}
                                </span>
                            </div>
                            <div class="kategori-badge">
                                <span class="badge bg-secondary rounded-pill">
                                    <i class="fa fa-tag"></i> {{ $item->kategori->nama_kategori ?? 'N/A' }}
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="position-absolute top-0 end-0 mt-2 me-2">
                        <span class="badge {{ $item->status === 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                            {{ $item->status }}
                        </span>
                    </div>
                </div>
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title fw-bold mb-0">{{ $item->nama_inventaris }}</h5>
                    </div>
                    <p class="card-text text-muted flex-grow-1 mb-3">{{ Str::limit($item->deskripsi, 80) }}</p>
                    <div class="d-flex justify-content-between">
    <a href="{{ route('mahasiswa.katalog.inventaris.show', $item->id) }}"
       class="btn btn-sm btn-outline-primary rounded-pill">
        <i class="fa fa-info-circle me-1"></i> Detail
    </a>
    @if($item->status === 'Tersedia' && $item->jumlah > 0)
        <form action="{{ route('mahasiswa.cart.keranjang_inventaris.add') }}" method="POST">
            @csrf
            <input type="hidden" name="id_inventaris" value="{{ $item->id }}">
            <input type="hidden" name="jumlah" value="1">
            <button class="btn btn-sm btn-primary rounded-pill">
                <i class="fa fa-cart-plus me-1"></i> Tambahkan
            </button>
        </form>
    @else
        <button class="btn btn-sm btn-secondary rounded-pill" disabled>
            <i class="fa fa-ban me-1"></i> Tidak Tersedia
        </button>
    @endif
</div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@endsection
@push('scripts')
<script>
    
    document.addEventListener('DOMContentLoaded', function() {
        const successAlert = document.getElementById('successAlert');
        const errorAlert = document.getElementById('errorAlert');
        
        if (successAlert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(successAlert);
                bsAlert.close();
            }, 2000);
        }
        
        if (errorAlert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(errorAlert);
                bsAlert.close();
            }, 3000);
        }
    });
</script>
@endpush