<section>
    <form method="post" action="{{ route('mahasiswa.profile.update') }}" class="mt-3">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="nama_mahasiswa" class="form-label fw-medium">Nama Lengkap</label>
            <input type="text" class="form-control @error('nama_mahasiswa') is-invalid @enderror" 
                   id="nama_mahasiswa" name="nama_mahasiswa" 
                   value="{{ old('nama_mahasiswa', Auth::guard('mahasiswa')->user()->nama_mahasiswa) }}" required>
            @error('nama_mahasiswa')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="nim" class="form-label fw-medium">NIM</label>
            <input type="text" class="form-control" id="nim" 
                   value="{{ Auth::guard('mahasiswa')->user()->nim }}" disabled>
            <small class="text-muted">NIM tidak dapat diubah.</small>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label fw-medium">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                   id="email" name="email" 
                   value="{{ old('email', Auth::guard('mahasiswa')->user()->email) }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i>Simpan Perubahan
            </button>
        </div>
    </form>
</section>