<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PinjamInventarisController;
use App\Http\Controllers\ControllerMahasiswa;
use App\Http\Controllers\ControllerRuangan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\RuanganController;

Route::get('/', function () {
    return view('welcome');
});

// Route inventaris umum (user)
Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::get('/inventaris/{id}', [InventarisController::class, 'show'])->name('inventaris.show');

// Route ruangan untuk user
Route::get('/ruangan', [RuanganController::class, 'index'])->name('katalog_ruangan.index');
Route::get('/ruangan/{id}', [RuanganController::class, 'show'])->name('katalog_ruangan.show');

// Route ruangan untuk admin
Route::get('/admin/ruangan', [RuanganController::class, 'adminindex'])->name('admin.katalog_ruangan.index');
Route::get('/admin/ruangan/create', [RuanganController::class, 'admincreate'])->name('admin.katalog_ruangan.create');
Route::get('/admin/invenruangantaris/{id}/edit', [RuanganController::class, 'adminedit'])->name('admin.katalog_ruangan.edit');
Route::put('/admin/invenruangantaris/{id}/update', [RuanganController::class, 'adminupdate'])->name('admin.katalog_ruangan.update');
Route::get('/admin/ruangan/{id}', [RuanganController::class, 'adminshow'])->name('admin.katalog_ruangan.show');
Route::post('/admin/ruangan/store', [RuanganController::class, 'adminstore'])->name('admin.katalog_ruangan.store');
Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'admindestroy'])->name('admin.katalog_ruangan.destroy');

// Admin Inventaris CRUD
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
    Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
    Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
    Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
    Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');
});

// Mahasiswa Inventaris
Route::prefix('mahasiswa')->group(function () {
    Route::get('/inventaris', [InventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.inventaris.index');
    Route::get('/inventaris/{id}', [InventarisController::class, 'mahasiswaShow'])->name('mahasiswa.inventaris.show');
});

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Peminjaman
Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'index'])->name('pinjam-inventaris.index');
Route::get('/pinjam-inventaris/mahasiswa', [PinjamInventarisController::class, 'mahasiswaPinjaman'])->name('pinjam-inventaris.mahasiswa');
Route::get('/pinjam-inventaris/create', [PinjamInventarisController::class, 'create'])->name('pinjam-inventaris.create');
Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
Route::get('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'show'])->name('pinjam-inventaris.show');
Route::delete('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'destroy'])->name('pinjam-inventaris.destroy');
Route::patch('/pinjam-inventaris/{pinjamInventaris}/status', [PinjamInventarisController::class, 'updateStatus'])->name('pinjam-inventaris.update-status');

// Admin
Route::get('/admin/approval', [PinjamInventarisController::class, 'adminApproval'])->name('admin.approval');
