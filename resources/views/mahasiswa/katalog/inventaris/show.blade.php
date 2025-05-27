@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="text-primary mb-0 fw-bold">
                    <i class="fa fa-box me-2"></i>Detail Inventaris
                </h4>
                <a href="{{ route('mahasiswa.katalog.inventaris.index') }}" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa fa-arrow-left me-1"></i> Kembali
                </a>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5">
                            @if($inventaris->gambar_inventaris)
                                <img src="{{ asset('storage/katalog_inventaris/' . $inventaris->gambar_inventaris) }}" 
                                     class="img-fluid rounded-start h-100 w-100 object-cover" 
                                     alt="{{ $inventaris->nama_inventaris }}" 
                                     style="object-fit: cover; max-height: 400px;">
                            @else
                                <div class="bg-light h-100 d-flex justify-content-center align-items-center">
                                    <i class="fa fa-box-open text-muted" style="font-size: 5rem;"></i>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7">
                            <div class="card-body">
                                <h4 class="card-title text-primary fw-bold mb-3">{{ $inventaris->nama_inventaris }}</h4>
                                
                                <div class="mb-3">
                                    <span class="badge bg-info rounded-pill">
                                        <i class="fa fa-cubes me-1"></i> Stok: {{ $inventaris->jumlah }} unit
                                    </span>
                                </div>
                                
                                <h6 class="fw-bold text-secondary mt-4 mb-2">Deskripsi:</h6>
                                <p class="card-text text-muted">{{ $inventaris->deskripsi }}</p>
                                
                                <h6 class="fw-bold text-secondary mt-4 mb-2">Status:</h6>
                                @if($inventaris->status == 'Tersedia')
                                    <span class="badge bg-success">Tersedia</span>
                                @else
                                    <span class="badge bg-danger">Tidak Tersedia</span>
                                @endif
                                
                                @if($inventaris->status == 'Tersedia')
                                    <form action="{{ route('mahasiswa.cart.keranjang_inventaris.add') }}" method="POST" class="mt-4">
                                        @csrf
                                        <input type="hidden" name="id_inventaris" value="{{ $inventaris->id }}">
                                        
                                        <div class="row mb-3 align-items-center">
                                            <div class="col-md-3">
                                                <label for="jumlah" class="form-label fw-medium mb-0">Jumlah</label>
                                            </div>
                                            <div class="col-md-9">
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light">
                                                        <i class="fa fa-hashtag text-primary"></i>
                                                    </span>
                                                    <input type="number" id="jumlah" name="jumlah" 
                                                           class="form-control" min="1" 
                                                           max="{{ $inventaris->jumlah }}" value="1" required>
                                                </div>
                                                <small class="text-muted">Maksimal {{ $inventaris->jumlah }} unit</small>
                                            </div>
                                        </div>
                                        
                                        <div class="d-flex mt-4">
                                            <button type="submit" class="btn btn-outline-primary rounded-pill me-2 flex-grow-1">
                                                <i class="fa fa-cart-plus me-1"></i> Tambah ke Keranjang
                                            </button>
                                            <a href="{{ route('mahasiswa.cart.keranjang_inventaris.index') }}" class="btn btn-primary rounded-pill flex-grow-1">
                                                <i class="fa fa-shopping-basket me-1"></i> Lihat Keranjang
                                            </a>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-warning mt-4">
                                        <i class="fa fa-exclamation-circle me-2"></i> 
                                        Inventaris ini sedang tidak tersedia untuk peminjaman
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection