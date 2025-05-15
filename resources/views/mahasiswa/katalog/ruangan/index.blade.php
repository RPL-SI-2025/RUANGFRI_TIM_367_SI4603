@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="text-primary mb-0 fw-bold">
            <i class="fa fa-building me-2"></i>Katalog Ruangan
        </h4>
    </div>

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert" 
         style="transition: all 0.3s ease; border-radius: 10px; border: none; box-shadow: 0 3px 10px rgba(0,0,0,0.08);" 
         onmouseover="this.style.opacity='0.9'; this.style.transform='scale(1.01)';" 
         onmouseout="this.style.opacity='1'; this.style.transform='scale(1)';">
        <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="errorAlert"
         style="transition: all 0.3s ease; border-radius: 10px; border: none; box-shadow: 0 3px 10px rgba(0,0,0,0.08);" 
         onmouseover="this.style.opacity='0.9'; this.style.transform='scale(1.01)';" 
         onmouseout="this.style.opacity='1'; this.style.transform='scale(1)';">
        <i class="fa fa-exclamation-circle me-2"></i>{{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="row g-4">
        @foreach($ruangans as $item)
        <div class="col-md-4 mb-2">
            <div class="card h-100 shadow-sm border-0 rounded-lg overflow-hidden">
                <div class="position-relative">
                    <img src="{{ $item->gambar ? asset('storage/katalog_ruangan/' . $item->gambar) : asset('images/default-room.jpg') }}" 
                         class="card-img-top" alt="{{ $item->nama_ruangan }}" 
                         style="height: 200px; object-fit: cover;">
                <div class="position-absolute bottom-0 start-0 end-0 p-2 bg-gradient-dark">
                    <div class="d-flex align-items-center">
                        <div class="location-badge me-2">
                            <i class="fa fa-building"></i>
                        </div>
                        <div class="facilities-badge small text-white">
                            <span class="fw-medium">Lokasi:</span> {{ Str::limit($item->lokasi, 20) }}
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
                        <h5 class="card-title fw-bold mb-0">{{ $item->nama_ruangan }}</h5>
                        <span class="badge bg-light text-dark border ms-2">
                            <i class="fa fa-users text-primary me-1"></i>{{ $item->kapasitas }} orang
                        </span>
                    </div>
                    <p class="card-text text-muted flex-grow-1 mb-3">{{ Str::limit($item->deskripsi, 80) }}</p>
                    <div class="mb-3">
                        <h6 class="text-secondary small fw-bold mb-2">
                            <i class="fa fa-check-circle text-primary me-1"></i>Fasilitas
                        </h6>
                        <div class="d-flex flex-wrap gap-1">
                            @php
                                $facilities = explode(',', $item->fasilitas);
                                $maxFacilities = 3; 
                            @endphp
                            
                            @foreach(array_slice($facilities, 0, $maxFacilities) as $facility)
                                <span class="badge bg-light-subtle text-dark-emphasis border">
                                    <i class="fa fa-check text-success me-1"></i>{{ trim($facility) }}
                                </span>
                            @endforeach
                            
                            @if(count($facilities) > $maxFacilities)
                                <span class="badge bg-light-subtle text-primary">
                                    +{{ count($facilities) - $maxFacilities }} lainnya
                                </span>
                            @endif
                        </div>
                    </div>
                    
                </div>
                <div class="card-footer bg-white border-top-0 pt-0">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('mahasiswa.katalog.ruangan.show', $item->id) }}"
                           class="btn btn-sm btn-outline-primary rounded-pill">
                            <i class="fa fa-info-circle me-1"></i> Detail
                        </a>
                        @if($item->status === 'Tersedia')
                        <form action="{{ route('mahasiswa.cart.keranjang_ruangan.add') }}" method="POST">
                            @csrf
                            <input type="hidden" name="id_ruangan" value="{{ $item->id }}">
                            <input type="hidden" name="tanggal_booking" value="{{ date('Y-m-d') }}">
                            <input type="hidden" name="waktu_mulai" value="08:00:00">
                            <input type="hidden" name="waktu_selesai" value="10:00:00">
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
            }, 2000);
        }
    });
</script>
@endpush