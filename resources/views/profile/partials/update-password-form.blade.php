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
            <i class="fas fa-lock me-3 fs-4 text-white"></i>
            <h5 class="mb-0 fw-bold">Ubah Password</h5>
        </div>
    </div>

    <div class="card-body">
        <form method="post" action="{{ route('mahasiswa.profile.update-password') }}">
            @csrf
            @method('patch')

            <div class="mb-3">
                <label for="current_password" class="form-label fw-small">Password Saat Ini</label>
                <div class="input-wrapper position-relative">
                    <input type="password"
                           class="form-control @error('current_password', 'updatePassword') is-invalid @enderror"
                           id="current_password"
                           name="current_password"
                           required
                           placeholder="Masukkan kata sandi saat ini">
                    <button type="button" class="password-toggle" data-toggle="current_password" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
                @error('current_password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label fw-small">Password Baru</label>
                <div class="input-wrapper position-relative">
                    <input type="password"
                           class="form-control @error('password', 'updatePassword') is-invalid @enderror"
                           id="password"
                           name="password"
                           required
                           placeholder="Masukkan kata sandi baru">
                        <button type="button" class="password-toggle" data-toggle="current_password" aria-label="Toggle password visibility">
                            <i class="fas fa-eye"></i>
                        </button>
                </div>
                @error('password', 'updatePassword')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label fw-small">Konfirmasi Kata Sandi Baru</label>
                <div class="input-wrapper position-relative">
                    <input type="password"
                           class="form-control"
                           id="password_confirmation"
                           name="password_confirmation"
                           required
                           placeholder="Masukkan ulang kata sandi baru">
                    <button type="button" class="password-toggle" data-toggle="password_confirmation" aria-label="Toggle password visibility">
                        <i class="fas fa-eye"></i>
                    </button>
                </div>
            </div>

            <div class="d-flex justify-content-end mt-4">
                <button type="submit" class="btn btn-primary bg-gradient-primary px-4">
                    <i class="fas fa-lock me-2"></i>Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toggleButtons = document.querySelectorAll('.password-toggle');
        toggleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const inputId = button.getAttribute('data-toggle');
                const input = document.getElementById(inputId);
                const icon = button.querySelector('i');
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = "password";
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        });

        // Auto dismiss alert after 4 seconds
        setTimeout(() => {
            const alert = document.querySelector('.alert');
            if (alert) {
                alert.classList.remove('show');
                alert.classList.add('fade');
            }
        }, 4000);
    });
</script>

<style>
    .input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }
    .input-wrapper input {
        padding-right: 2.5rem;
    }
    .password-toggle {
        position: absolute;
        right: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        border: none;
        background: transparent;
        padding: 0;
        margin: 0;
        cursor: pointer;
        color: #6c757d;
        font-size: 1.1rem;
        outline: none;
        z-index: 10;
    }
    .password-toggle:hover {
        color: #0d6efd;
    }
</style>
