<section>
    <form method="post" action="{{ route('mahasiswa.profile.update-password') }}" class="mt-3">
        @csrf
        @method('patch')

        <div class="mb-3">
            <label for="current_password" class="form-label fw-medium">Password Saat Ini</label>
            <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   id="current_password" name="current_password" required>
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password" class="form-label fw-medium">Password Baru</label>
            <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   id="password" name="password" required>
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label fw-medium">Konfirmasi Password Baru</label>
            <input type="password" class="form-control" id="password_confirmation" 
                   name="password_confirmation" required>
        </div>

        <div class="d-flex justify-content-end mt-4">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-lock me-2"></i>Update Password
            </button>
        </div>
    </form>
</section>