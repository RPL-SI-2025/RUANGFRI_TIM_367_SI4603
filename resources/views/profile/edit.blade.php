@extends('mahasiswa.layouts.app')

@section('content')
<div class="container py-4">
    <div class="header-container">
        <div class="header-content">
            <div class="header-left">
                <div class="header-icon-wrapper">
                    <div class="header-icon-bg">
                        <i class="fas fa-user-circle header-icon"></i>
                    </div>
                    <div class="header-icon-pulse"></div>
                </div>
                <div class="header-text">
                    <h1 class="header-title">
                        Pengaturan Profil
                    </h1>
                </div>
            </div>
        </div>
    </div>

    @if (session('status'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <ul class="nav nav-tabs" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation" style="flex: 1;">
            <a class="nav-link active" id="profile-info-tab" data-bs-toggle="tab" href="#profile-info" role="tab" aria-controls="profile-info" aria-selected="true">Informasi Profil</a>
        </li>
        <li class="nav-item" role="presentation" style="flex: 1;">
            <a class="nav-link" id="borrowing-info-tab" data-bs-toggle="tab" href="#borrowing-info" role="tab" aria-controls="borrowing-info" aria-selected="false">Informasi Peminjaman</a>
        </li>
        <li class="nav-item" role="presentation" style="flex: 1;">
            <a class="nav-link" id="password-tab" data-bs-toggle="tab" href="#password" role="tab" aria-controls="password" aria-selected="false">Ubah Password</a>
        </li>
        <li class="nav-item" role="presentation" style="flex: 1;">
            <a class="nav-link" id="delete-account-tab" data-bs-toggle="tab" href="#delete-account" role="tab" aria-controls="delete-account" aria-selected="false">Hapus Akun</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="profileTabContent">
        <div class="tab-pane fade show active" id="profile-info" role="tabpanel" aria-labelledby="profile-info-tab">
            @include('profile.partials.update-profile-information-form')
        </div>
        <div class="tab-pane fade" id="borrowing-info" role="tabpanel" aria-labelledby="borrowing-info-tab">
            @include('profile.partials.update-borrowing-information-form')
        </div>
        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
            @include('profile.partials.update-password-form')
        </div>
        <div class="tab-pane fade" id="delete-account" role="tabpanel" aria-labelledby="delete-account-tab">
            @include('profile.partials.delete-user-form')
        </div>
    </div>
</div>

<style>
    /* Header styles */
    .header-container {
        position: relative;
        padding: 20px;
        margin-bottom: 20px;
        color: black; /* Text color for header */
    }

    .header-content {
        position: relative;
        z-index: 1;
        display: flex;
        align-items: center;
    }

    .header-left {
        display: flex;
        align-items: center;
    }

    .header-icon-wrapper {
        position: relative;
        margin-right: 15px;
    }

    .header-icon-bg {
        background-color: white;
        border-radius: 50%;
        padding: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .header-icon {
        font-size: 2rem;
        color: #007bff;
    }

    .header-title {
        font-size: 1.5rem;
        margin: 0;
    }

    /* Tab styles */
    .nav-tabs {
        display: flex;
        justify-content: space-between;
        border-bottom: 2px solid transparent; /* Optional: to keep space for the border */
        background-color: #f1f1f1; /* Background color for tabs */
        border-radius: 0.5rem; /* Rounded corners for tabs */
    }

    .nav-tabs .nav-link {
        flex: 1; /* Make each tab take equal space */
        text-align: center; /* Center text */
        border: none; /* Remove default border */
        padding: 10px 0; /* Padding for tabs */
        font-weight: bold; /* Bold text */
        transition: background-color 0.3s, color 0.3s; /* Smooth transition */
        position: relative; /* For the underline effect */
    }

    .nav-tabs .nav-link.active {
        background: linear-gradient(90deg, #007bff, #0056b3); /* Active tab background */
        color: white; /* Active tab text color */
    }

    .nav-tabs .nav-link:not(.active) {
        color: #007bff; /* Inactive tab text color */
    }

    .nav-tabs .nav-link:hover {
        color: #0056b3; /* Hover text color */
    }

    .nav-tabs .nav-link::after {
        content: '';
        display: block;
        height: 2px; /* Height of the underline */
        background: white; /* Color of the underline */
        width: 100%; /* Full width */
        position: absolute;
        bottom: 0; /* Position at the bottom */
        left: 0; /* Align to the left */
        transform: scaleX(0); /* Initially hidden */
        transition: transform 0.3s ease; /* Smooth transition */
    }

    .nav-tabs .nav-link.active::after {
        transform: scaleX(1); /* Show underline on active tab */
    }
</style>
@endsection
