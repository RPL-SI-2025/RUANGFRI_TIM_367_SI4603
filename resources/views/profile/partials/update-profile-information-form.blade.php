@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="card border-0 shadow-lg main-card mb-4">
    <div class="card-header text-white py-3 border-0 card-header-futuristic"
        style="background: linear-gradient(90deg, #0069d9 0%, #0056b3 100%);">
        <div class="d-flex align-items-center">
            <i class="fa fa-user me-3 fs-4 text-white"></i>
            <h5 class="mb-0 fw-bold">Informasi Profil</h5>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('mahasiswa.profile.update') }}" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="nama_mahasiswa" class="form-label">Nama Lengkap</label>
                <input type="text" readonly
                    class="form-control bg-secondary-subtle @error('nama_mahasiswa') is-invalid @enderror"
                    name="nama_mahasiswa" value="{{ old('nama_mahasiswa', $user?->nama_mahasiswa) }}"
                    placeholder="Nama lengkap">
                @error('nama_mahasiswa') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" readonly
                    class="form-control bg-secondary-subtle @error('email') is-invalid @enderror"
                    name="email" value="{{ old('email', $user?->email) }}" placeholder="Email">
                @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                    <input type="text" class="form-control @error('tempat_lahir') is-invalid @enderror"
                        name="tempat_lahir" value="{{ old('tempat_lahir', $user?->tempat_lahir) }}"
                        placeholder="Tempat Lahir">
                    @error('tempat_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                    <input type="date" class="form-control @error('tanggal_lahir') is-invalid @enderror"
                        name="tanggal_lahir" value="{{ old('tanggal_lahir', $user?->tanggal_lahir) }}">
                    @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>

            <div class="mb-3">
                <label for="wa" class="form-label">No. WhatsApp</label>
                <input type="text" class="form-control @error('wa') is-invalid @enderror"
                    name="wa" value="{{ old('wa', $user?->wa) }}" placeholder="No. WhatsApp">
                @error('wa') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat</label>
                <input type="text" class="form-control @error('alamat') is-invalid @enderror"
                    name="alamat" value="{{ old('alamat', $user?->alamat) }}" placeholder="Alamat">
                @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary bg-gradient-primary px-4">
                    <i class="fas fa-save me-2"></i>Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
