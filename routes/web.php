<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PinjamInventarisController;
use App\Http\Controllers\ControllerMahasiswa;
use App\Http\Controllers\ControllerRuangan;
use App\Http\Controllers\CartController;

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

// Mahasiswa routes
Route::controller(ControllerMahasiswa::class)->group(function () {
    Route::get('/mahasiswa', 'index')->name('mahasiswa.index');
    Route::get('/mahasiswa/create', 'create')->name('mahasiswa.create');
    Route::post('/mahasiswa/store', 'store')->name('mahasiswa.store');
    Route::get('/mahasiswa/{id}/edit', 'edit')->name('mahasiswa.edit');
    Route::put('/mahasiswa/{id}', 'update')->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', 'destroy')->name('mahasiswa.destroy');
});

// Inventaris routes
Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::get('/inventaris/create', [InventarisController::class, 'create'])->name('inventaris.create');
Route::post('/inventaris', [InventarisController::class, 'store'])->name('inventaris.store');
Route::get('/inventaris/{id}', [InventarisController::class, 'show'])->name('inventaris.show');
Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit'])->name('inventaris.edit');
Route::put('/inventaris/{id}', [InventarisController::class, 'update'])->name('inventaris.update');
Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy'])->name('inventaris.destroy');


// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::get('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

// Peminjaman routes
Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'index'])->name('pinjam-inventaris.index');
Route::get('/pinjam-inventaris/mahasiswa', [PinjamInventarisController::class, 'mahasiswaPinjaman'])->name('pinjam-inventaris.mahasiswa');
Route::get('/pinjam-inventaris/create', [PinjamInventarisController::class, 'create'])->name('pinjam-inventaris.create');
Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
Route::get('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'show'])->name('pinjam-inventaris.show');
Route::patch('/pinjam-inventaris/{pinjamInventaris}/status', [PinjamInventarisController::class, 'updateStatus'])->name('pinjam-inventaris.update-status');

// Admin approval interface
Route::get('/admin/approval', [PinjamInventarisController::class, 'adminApproval'])->name('admin.approval');

//Lapor Inventaris


