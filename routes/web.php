<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PinjamInventarisController;
use App\Http\Controllers\ControllerMahasiswa;
use App\Http\Controllers\ControllerRuangan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\laporinventarisController;
use App\Models\laporinventaris; 
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\AdminLogistikController;


Route::get('/', function () {
    return view('welcome');
});



// Admin Inventaris CRUD
Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::prefix('admin')->group(function () {
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
});
Route::get('/admin/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
Route::get('/admin/inventaris/{id}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
Route::delete('/admin/inventaris/{id}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');


// Mahasiswa Inventaris View
Route::prefix('mahasiswa')->group(function () {
    Route::get('/inventaris', [InventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.inventaris.index');
    Route::get('/inventaris/{id}', [InventarisController::class, 'mahasiswaShow'])->name('mahasiswa.inventaris.show');
});


// Ruangan routes
Route::controller(ControllerRuangan::class)->group(function () {
    Route::get('/ruangan', 'index')->name('ruangan.index');
    Route::get('/ruangan/create', 'create')->name('ruangan.create');
    Route::post('/ruangan/store', 'store')->name('ruangan.store');
    Route::get('/ruangan/{id}/edit', 'edit')->name('ruangan.edit');
    Route::put('/ruangan/{id}', 'update')->name('ruangan.update');
    Route::delete('/ruangan/{id}', 'destroy')->name('ruangan.destroy');
});

// // Ruangan routes
// Route::controller(ControllerRuangan::class)->group(function () {
//     Route::get('/ruangan', 'index')->name('ruangan.index');
//     Route::get('/ruangan/create', 'create')->name('ruangan.create');
//     Route::post('/ruangan/store', 'store')->name('ruangan.store');
//     Route::get('/ruangan/{id}/edit', 'edit')->name('ruangan.edit');
//     Route::put('/ruangan/{id}', 'update')->name('ruangan.update');
//     Route::delete('/ruangan/{id}', 'destroy')->name('ruangan.destroy');
// });

// // Mahasiswa routes
// Route::controller(ControllerMahasiswa::class)->group(function () {
//     Route::get('/mahasiswa', 'index')->name('mahasiswa.index');
//     Route::get('/mahasiswa/create', 'create')->name('mahasiswa.create');
//     Route::post('/mahasiswa/store', 'store')->name('mahasiswa.store');
//     Route::get('/mahasiswa/{id}/edit', 'edit')->name('mahasiswa.edit');
//     Route::put('/mahasiswa/{id}', 'update')->name('mahasiswa.update');
//     Route::delete('/mahasiswa/{id}', 'destroy')->name('mahasiswa.destroy');
// });

// Admin approval interface
Route::prefix('admin')->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [AdminLogistikController::class, 'index'])->name('admin.dashboard');

    // Admin Inventaris CRUD
    Route::get('/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris.index');
    Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('admin.inventaris.create');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('admin.inventaris.store');
    Route::get('/inventaris/{inventaris}/edit', [InventarisController::class, 'edit'])->name('admin.inventaris.edit');
    Route::put('/inventaris/{inventaris}', [InventarisController::class, 'update'])->name('admin.inventaris.update');
    Route::delete('/inventaris/{inventaris}', [InventarisController::class, 'destroy'])->name('admin.inventaris.destroy');
    Route::get('/inventaris/{inventaris}', [InventarisController::class, 'show'])->name('admin.inventaris.show');

    Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'adminIndex'])->name('admin.pinjam-inventaris.index');
    Route::get('/pinjam-inventaris/approval', [PinjamInventarisController::class, 'adminApproval'])->name('admin.pinjam-inventaris.approval');
    Route::get('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'adminShow'])->name('admin.pinjam-inventaris.show');
    Route::patch('/pinjam-inventaris/{pinjamInventaris}/update-status', [PinjamInventarisController::class, 'updateStatus'])->name('pinjam-inventaris.update-status');
    Route::delete('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'destroy'])->name('pinjam-inventaris.destroy');
    Route::put('/pinjam-inventaris/{pinjamInventaris}/update-status', [PinjamInventarisController::class, 'updateStatus'])->name('pinjam-inventaris.update-status');
});


//Lapor Inventaris
Route::get('/laporinventaris', [laporinventarisController::class, 'index'])->name('laporinventaris.index');



Route::get('/mahasiswa/login', [App\Http\Controllers\MahasiswaAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('/mahasiswa/login', [App\Http\Controllers\MahasiswaAuthController::class, 'login'])->name('mahasiswa.login.submit');
Route::post('/mahasiswa/logout', [App\Http\Controllers\MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');

Route::get('/mahasiswa/register', [App\Http\Controllers\MahasiswaAuthController::class, 'showRegistrationForm'])->name('mahasiswa.register');
Route::post('/mahasiswa/register', [App\Http\Controllers\MahasiswaAuthController::class, 'register'])->name('mahasiswa.register.submit');


Route::middleware([\App\Http\Middleware\MahasiswaAuth::class])->prefix('mahasiswa')->group(function() {
    Route::get('/dashboard', function() {
        return view('mahasiswa.page.dashboard');
    })->name('mahasiswa.dashboard');

    // Mahasiswa Inventaris View 
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/inventaris', [InventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.katalog.inventaris.index');
        Route::get('/inventaris/{id}', [InventarisController::class, 'mahasiswaShow'])->name('mahasiswa.katalog.inventaris.show');
    });
    
    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    // Peminjaman routes for mahasiswa
    Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.peminjaman.pinjam-inventaris.index');
    Route::get('/pinjam-inventaris/create', [PinjamInventarisController::class, 'create'])->name('mahasiswa.peminjaman.pinjam-inventaris.create');
    Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
    Route::get('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'show'])->name('mahasiswa.peminjaman.pinjam-inventaris.show');
    Route::get('/pinjam-inventaris/{pinjamInventaris}/edit', [PinjamInventarisController::class, 'edit'])->name('mahasiswa.peminjaman.pinjam-inventaris.edit');
    Route::put('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'update'])->name('pinjam-inventaris.update');
});