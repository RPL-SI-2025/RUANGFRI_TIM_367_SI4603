<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PinjamInventarisController;
use App\Http\Controllers\ControllerMahasiswa;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\laporinventarisController;
use App\Models\laporinventaris;

use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\AdminLogistikController;


Route::get('/', function () {
    return view('welcome');
});


// Admin Dashboard
Route::get('/admin/dashboard', [AdminLogistikController::class, 'index'])->name('admin.dashboard');


// CRUD Inventaris (Admin)
Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris.index');
Route::get('/admin/inventaris/create', [InventarisController::class, 'create'])->name('admin.inventaris.create');
Route::post('/admin/inventaris', [InventarisController::class, 'store'])->name('admin.inventaris.store');
Route::get('/admin/inventaris/{inventaris}/edit', [InventarisController::class, 'edit'])->name('admin.inventaris.edit');
Route::put('/admin/inventaris/{inventaris}', [InventarisController::class, 'update'])->name('admin.inventaris.update');
Route::delete('/admin/inventaris/{inventaris}', [InventarisController::class, 'destroy'])->name('admin.inventaris.destroy');
Route::get('/admin/inventaris/{inventaris}', [InventarisController::class, 'show'])->name('admin.inventaris.show');

//CRUD Ruangan (Admin)
Route::get('/admin/ruangan', [RuanganController::class, 'index'])->name('admin.katalog_ruangan.index');
Route::get('/admin/ruangan/create', [RuanganController::class, 'create'])->name('katalog_admin.ruangan.create');
Route::post('/admin/ruangan/store', [RuanganController::class, 'store'])->name('admin.katalog_ruangan.store');
Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('admin.katalog_ruangan.edit');
Route::put('/admin/ruangan/{id}', [RuanganControllern::class, 'update'])->name('admin.katalog_ruangan.update');
Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'destroy'])->name('admin.katalog_ruangan.destroy');


// Ruangan
Route::controller(RuanganController::class)->prefix('ruangan')->name('ruangan.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});


// // Mahasiswa routes
// Route::controller(ControllerMahasiswa::class)->group(function () {
//     Route::get('/mahasiswa', 'index')->name('mahasiswa.index');
//     Route::get('/mahasiswa/create', 'create')->name('mahasiswa.create');
//     Route::post('/mahasiswa/store', 'store')->name('mahasiswa.store');
//     Route::get('/mahasiswa/{id}/edit', 'edit')->name('mahasiswa.edit');
//     Route::put('/mahasiswa/{id}', 'update')->name('mahasiswa.update');
//     Route::delete('/mahasiswa/{id}', 'destroy')->name('mahasiswa.destroy');
// });


// AApproval Peminjaman Inventaris (Admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/approval', [PinjamInventarisController::class, 'adminApproval'])->name('approval');
    Route::patch('/pinjam-inventaris/{pinjamInventaris}/update-status', [PinjamInventarisController::class, 'updateStatus'])->name('pinjam-inventaris.update-status');
    Route::delete('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'destroy'])->name('pinjam-inventaris.destroy');
});

//Lapor Inventaris
Route::get('/laporinventaris', [laporinventarisController::class, 'index'])->name('laporinventaris.index');



// Auth Mahasiswa
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/login', [MahasiswaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MahasiswaAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [MahasiswaAuthController::class, 'logout'])->name('logout');
    Route::get('/register', [MahasiswaAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [MahasiswaAuthController::class, 'register'])->name('register.submit');
});

Route::middleware(['mahasiswa.auth'])->group(function () {
    Route::get('/mahasiswa/profile/edit', [ProfileController::class, 'edit'])->name('mahasiswa.profile.edit');
    Route::patch('/mahasiswa/profile/update', [ProfileController::class, 'updateProfile'])->name('mahasiswa.profile.update');
    Route::patch('/mahasiswa/profile/update-password', [ProfileController::class, 'updatePassword'])->name('mahasiswa.profile.update-password');
    Route::delete('/mahasiswa/profile/delete', [ProfileController::class, 'destroy'])->name('mahasiswa.profile.delete');
});


// Routes khusus Mahasiswa (dengan middleware)
Route::middleware([\App\Http\Middleware\MahasiswaAuth::class])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa.page.dashboard');
    })->name('dashboard');

    // Katalog Inventaris untuk Mahasiswa
    Route::prefix('inventaris')->name('katalog.inventaris.')->group(function () {
        Route::get('/', [InventarisController::class, 'mahasiswaIndex'])->name('index');
        Route::get('/{id}', [InventarisController::class, 'mahasiswaShow'])->name('show');
    });

    // Peminjaman Inventaris untuk Mahasiswa
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'index'])->name('pinjam-inventaris.index');
        Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
    });

    // Katalog Ruangan untuk Mahasiswa
    Route::prefix('ruangan')->name('katalog_ruangan.')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('index');
        Route::get('/{id}', [RuanganController::class, 'show'])->name('show');
    });

    // Keranjang / Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
    });
});
