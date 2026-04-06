@extends('mahasiswa.layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/edit_peminjaman.css') }}">
<link rel="stylesheet" href="{{ asset('css/profile-settings.css') }}">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12 col-lg-10 col-xl-9">

            <!-- Header Card (selaras dengan halaman peminjaman) -->
            <div class="card border-0 shadow-lg mb-4 header-card">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <div class="icon-wrapper me-3">
                                <i class="fas fa-user-cog"></i>
                            </div>
                            <div>
                                <h4 class="text-white mb-1 fw-bold">Pengaturan Profil</h4>
                                <p class="text-white-50 mb-0">Kelola informasi akun dan pengaturan peminjaman</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alert Messages -->
            @if (session('status') || session('success') || session('error'))
                @php
                    $alertType = session('error') ? 'danger' : 'info';
                    $alertMessage = session('error') ?? session('status') ?? session('success');
                @endphp
                <div class="alert alert-{{ $alertType }} alert-modern border-0 shadow-sm mb-4" role="alert">
                    <div class="d-flex align-items-center">
                        <div class="alert-icon me-3">
                            <i class="fa {{ session('error') ? 'fa-exclamation-triangle' : 'fa-check' }}"></i>
                        </div>
                        <div>
                            <strong>{{ session('error') ? 'Kesalahan!' : 'Berhasil!' }}</strong>
                            <p class="mb-0 mt-1">{{ $alertMessage }}</p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Tab Navigation -->
            <div class="section-card mb-4">
                <div class="section-header">
                    <div class="section-icon">
                        <i class="fas fa-sliders-h"></i>
                    </div>
                    <div>
                        <h5 class="section-title">Menu Pengaturan</h5>
                        <p class="section-subtitle">Pilih bagian yang ingin Anda ubah</p>
                    </div>
                </div>
                <div class="section-content">
                    <ul class="nav nav-pills profile-tabs" id="profileTab" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 {{ ($activeTab ?? 'profile') === 'profile' ? 'active' : '' }}"
                                    id="profile-info-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#profile-info"
                                    type="button"
                                    role="tab"
                                    aria-controls="profile-info"
                                    aria-selected="{{ (($activeTab ?? 'profile') === 'profile') ? 'true' : 'false' }}">
                                <i class="fas fa-id-card"></i>
                                Informasi Profil
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 {{ ($activeTab ?? 'profile') === 'peminjaman' ? 'active' : '' }}"
                                    id="borrowing-info-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#borrowing-info"
                                    type="button"
                                    role="tab"
                                    aria-controls="borrowing-info"
                                    aria-selected="{{ (($activeTab ?? 'profile') === 'peminjaman') ? 'true' : 'false' }}">
                                <i class="fas fa-book"></i>
                                Informasi Peminjaman
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 {{ ($activeTab ?? 'profile') === 'password' ? 'active' : '' }}"
                                    id="password-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#password"
                                    type="button"
                                    role="tab"
                                    aria-controls="password"
                                    aria-selected="{{ (($activeTab ?? 'profile') === 'password') ? 'true' : 'false' }}">
                                <i class="fas fa-lock"></i>
                                Ubah Password
                            </button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                            <button class="nav-link w-100 {{ ($activeTab ?? 'profile') === 'delete-account' ? 'active' : '' }}"
                                    id="delete-account-tab"
                                    data-bs-toggle="pill"
                                    data-bs-target="#delete-account"
                                    type="button"
                                    role="tab"
                                    aria-controls="delete-account"
                                    aria-selected="{{ (($activeTab ?? 'profile') === 'delete-account') ? 'true' : 'false' }}">
                                <i class="fas fa-trash-alt"></i>
                                Hapus Akun
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Tab Content -->
            <div class="tab-content" id="profileTabContent">
                <div class="tab-pane fade {{ ($activeTab ?? 'profile') === 'profile' ? 'show active' : '' }}" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab" tabindex="0">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <div class="tab-pane fade {{ ($activeTab ?? 'profile') === 'peminjaman' ? 'show active' : '' }}" id="borrowing-info" role="tabpanel" aria-labelledby="borrowing-info-tab" tabindex="0">
                    @include('profile.partials.update-borrowing-information-form')
                </div>
                <div class="tab-pane fade {{ ($activeTab ?? 'profile') === 'password' ? 'show active' : '' }}" id="password" role="tabpanel" aria-labelledby="password-tab" tabindex="0">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="tab-pane fade {{ ($activeTab ?? 'profile') === 'delete-account' ? 'show active' : '' }}" id="delete-account" role="tabpanel" aria-labelledby="delete-account-tab" tabindex="0">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('[data-password-toggle]').forEach((btn) => {
            btn.addEventListener('click', () => {
                const targetId = btn.getAttribute('data-password-toggle');
                const input = document.getElementById(targetId);
                const icon = btn.querySelector('i');

                if (!input) return;
                const isPassword = input.type === 'password';
                input.type = isPassword ? 'text' : 'password';
                if (icon) {
                    icon.classList.toggle('fa-eye', !isPassword);
                    icon.classList.toggle('fa-eye-slash', isPassword);
                }
            });
        });
    });
</script>
@endpush
@endsection
