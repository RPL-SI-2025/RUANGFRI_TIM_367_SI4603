@extends('admin.layouts.admin')

@section('title', 'Data Inventaris')

@section('content')
<div class="d-flex justify-content-between mb-3">
    <h4>Data Inventaris</h4>
    <a href="{{ route('admin.inventaris.create') }}" class="btn btn-success">Tambah Inventaris</a>
</div>

@if (session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Filter dan Pencarian -->
<div class="card mb-4">
    <div class="card-header bg-light">
        <h5 class="mb-0">Filter & Pencarian</h5>
    </div>
    <div class="card-body">
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label for="search" class="form-label">Pencarian</label>
                <input type="text" 
                       id="search"
                       class="form-control" 
                       placeholder="Cari nama inventaris...">
            </div>
            <div class="col-md-2">
                <label for="kategori_filter" class="form-label">Kategori</label>
                <select id="kategori_filter" class="form-select">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->nama_kategori }}">
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <label for="status_filter" class="form-label">Status</label>
                <select id="status_filter" class="form-select">
                    <option value="">Semua Status</option>
                    <option value="Tersedia">Tersedia</option>
                    <option value="Tidak Tersedia">Tidak Tersedia</option>
                </select>
            </div>
            <div class="col-md-2">
                <label for="stok_filter" class="form-label">Stok</label>
                <select id="stok_filter" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="habis">Stok Habis (0)</option>
                    <option value="rendah">Stok Rendah (1-5)</option>
                    <option value="normal">Stok Normal (>5)</option>
                </select>
            </div>
            <div class="col-md-3">
                <div class="d-flex gap-2">
                    <button type="button" id="reset_filter" class="btn btn-secondary">
                        <i class="fas fa-refresh"></i> Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Daftar Inventaris 
            <span id="filter-badge" class="badge bg-info" style="display: none;">Filtered</span>
        </h5>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover" id="inventaris-table">
                <thead class="table-light">
                    <tr>
                        <th width="50">No</th>
                        <th width="100">Foto</th>
                        <th>Nama Inventaris</th>
                        <th width="120">Kategori</th>
                        <th>Deskripsi</th>
                        <th width="80">Jumlah</th>
                        <th width="100">Status</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($inventaris as $item)
                    <tr class="inventaris-row" 
                        data-nama="{{ strtolower($item->nama_inventaris) }}"
                        data-kategori="{{ $item->kategori->nama_kategori ?? '' }}"
                        data-status="{{ $item->status }}"
                        data-jumlah="{{ $item->jumlah }}"
                        data-deskripsi="{{ strtolower($item->deskripsi) }}">
                        <td class="row-number">{{ $loop->iteration }}</td>
                        <td>
                            @if ($item->gambar_inventaris)
                                <img src="{{ asset('storage/katalog_inventaris/' . $item->gambar_inventaris) }}"
                                     alt="{{ $item->nama_inventaris }}" 
                                     width="60" 
                                     height="60"
                                     class="img-thumbnail object-fit-cover">
                            @else
                                <div class="bg-light border rounded d-flex align-items-center justify-content-center" 
                                     style="width: 60px; height: 60px;">
                                    <i class="fas fa-image text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $item->nama_inventaris }}</strong>
                            @if($item->kode_inventaris)
                                <br><small class="text-muted">{{ $item->kode_inventaris }}</small>
                            @endif
                        </td>
                        <td>
                            <span class="badge bg-secondary">
                                {{ $item->kategori->nama_kategori ?? 'Tidak ada kategori' }}
                            </span>
                        </td>
                        <td>{{ Str::limit($item->deskripsi, 50) }}</td>
                        <td>
                            <span class="badge {{ $item->jumlah == 0 ? 'bg-danger' : ($item->jumlah <= 5 ? 'bg-warning' : 'bg-success') }}">
                                {{ $item->jumlah }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $item->status == 'Tersedia' ? 'bg-success' : 'bg-danger' }}">
                                {{ $item->status }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <a href="{{ route('admin.inventaris.edit', $item) }}" 
                                   class="btn btn-sm btn-warning"
                                   data-bs-toggle="tooltip" 
                                   title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.inventaris.destroy', $item) }}" 
                                      method="POST" 
                                      class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus inventaris {{ $item->nama_inventaris }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger"
                                            data-bs-toggle="tooltip" 
                                            title="Hapus">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Empty State -->
        <div id="empty-state" class="text-center py-5" style="display: none;">
            <i class="fas fa-search fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">Tidak ada inventaris ditemukan</h5>
            <p class="text-muted">Coba ubah filter pencarian Anda</p>
            <button type="button" id="reset-from-empty" class="btn btn-primary">
                <i class="fas fa-refresh"></i> Reset Filter
            </button>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Get filter elements
    const searchInput = document.getElementById('search');
    const kategoriFilter = document.getElementById('kategori_filter');
    const statusFilter = document.getElementById('status_filter');
    const stokFilter = document.getElementById('stok_filter');
    const resetButton = document.getElementById('reset_filter');
    const resetFromEmptyButton = document.getElementById('reset-from-empty');
    const filterBadge = document.getElementById('filter-badge');
    const emptyState = document.getElementById('empty-state');
    const table = document.getElementById('inventaris-table');
    
    // Get all rows
    const allRows = document.querySelectorAll('.inventaris-row');
    
    let searchTimeout;
    
    // Filter function
    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const selectedKategori = kategoriFilter.value;
        const selectedStatus = statusFilter.value;
        const selectedStok = stokFilter.value;
        
        let visibleRows = 0;
        let stats = {
            total: 0,
            tersedia: 0,
            tidakTersedia: 0,
            stokRendah: 0
        };
        
        allRows.forEach((row, index) => {
            const nama = row.dataset.nama;
            const deskripsi = row.dataset.deskripsi;
            const kategori = row.dataset.kategori;
            const status = row.dataset.status;
            const jumlah = parseInt(row.dataset.jumlah);
            
            let show = true;
            
            // Search filter
            if (searchTerm && !nama.includes(searchTerm) && !deskripsi.includes(searchTerm)) {
                show = false;
            }
            
            // Category filter
            if (selectedKategori && kategori !== selectedKategori) {
                show = false;
            }
            
            // Status filter
            if (selectedStatus && status !== selectedStatus) {
                show = false;
            }
            
            // Stock filter
            if (selectedStok) {
                if (selectedStok === 'habis' && jumlah !== 0) {
                    show = false;
                } else if (selectedStok === 'rendah' && (jumlah <= 0 || jumlah > 5)) {
                    show = false;
                } else if (selectedStok === 'normal' && jumlah <= 5) {
                    show = false;
                }
            }
            
            // Show/hide row
            if (show) {
                row.style.display = '';
                visibleRows++;
                // Update row number
                row.querySelector('.row-number').textContent = visibleRows;
                
                // Update stats
                stats.total++;
                if (status === 'Tersedia') stats.tersedia++;
                if (status === 'Tidak Tersedia') stats.tidakTersedia++;
                if (jumlah > 0 && jumlah <= 5) stats.stokRendah++;
            } else {
                row.style.display = 'none';
            }
        });
        
        // Update statistics
        document.getElementById('total-count').textContent = stats.total;
        document.getElementById('tersedia-count').textContent = stats.tersedia;
        document.getElementById('tidak-tersedia-count').textContent = stats.tidakTersedia;
        document.getElementById('stok-rendah-count').textContent = stats.stokRendah;
        
        // Show/hide empty state
        if (visibleRows === 0) {
            table.style.display = 'none';
            emptyState.style.display = 'block';
        } else {
            table.style.display = 'table';
            emptyState.style.display = 'none';
        }
        
        // Show/hide filter badge
        const hasFilters = searchTerm || selectedKategori || selectedStatus || selectedStok;
        filterBadge.style.display = hasFilters ? 'inline' : 'none';
    }
    
    // Reset function
    function resetFilters() {
        searchInput.value = '';
        kategoriFilter.value = '';
        statusFilter.value = '';
        stokFilter.value = '';
        filterTable();
    }
    
    // Event listeners
    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        searchTimeout = setTimeout(filterTable, 300);
    });
    
    kategoriFilter.addEventListener('change', filterTable);
    statusFilter.addEventListener('change', filterTable);
    stokFilter.addEventListener('change', filterTable);
    resetButton.addEventListener('click', resetFilters);
    resetFromEmptyButton.addEventListener('click', resetFilters);
    
    // Initialize filter on page load
    filterTable();
});
</script>
@endpush