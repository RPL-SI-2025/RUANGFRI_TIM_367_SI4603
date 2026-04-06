<div class="section-card mb-4">
    <div class="section-header">
        <div class="section-icon">
            <i class="fas fa-lock"></i>
        </div>
        <div>
            <h5 class="section-title">Ubah Password</h5>
            <p class="section-subtitle">Gunakan minimal 8 karakter</p>
        </div>
    </div>

    <div class="section-content">
        <form method="post" action="{{ route('mahasiswa.profile.update-password') }}">
            @csrf
            @method('patch')

            <div class="form-group-modern">
                <label for="current_password" class="form-label-modern">
                    <i class="fas fa-key me-2"></i>Password Saat Ini
                </label>
                <div class="input-group">
                    <input type="password"
                           class="form-control form-control-modern @error('current_password', 'updatePassword') is-invalid @enderror"
                           id="current_password"
                           name="current_password"
                           required
                           placeholder="Masukkan password saat ini">
                    <button class="btn btn-outline-primary" type="button" data-password-toggle="current_password" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-modern">
                <label for="password" class="form-label-modern">
                    <i class="fas fa-lock me-2"></i>Password Baru
                </label>
                <div class="input-group">
                    <input type="password"
                           class="form-control form-control-modern @error('password', 'updatePassword') is-invalid @enderror"
                           id="password"
                           name="password"
                           required
                           placeholder="Masukkan password baru">
                    <button class="btn btn-outline-primary" type="button" data-password-toggle="password" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('password', 'updatePassword')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group-modern">
                <label for="password_confirmation" class="form-label-modern">
                    <i class="fas fa-check-circle me-2"></i>Konfirmasi Password Baru
                </label>
                <div class="input-group">
                    <input type="password"
                           class="form-control form-control-modern"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           placeholder="Masukkan ulang password baru">
                    <button class="btn btn-outline-primary" type="button" data-password-toggle="password_confirmation" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="fas fa-lock me-2"></i>Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
