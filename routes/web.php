<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\RuanganController;

Route::get('/', function () {
    return view('welcome');
});

// Route buat inventaris umum

Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::get('/inventaris/{id}', [InventarisController::class, 'show'])->name('inventaris.show');

// Route ruangan user
Route::get('/ruangan', [RuanganController::class, 'index'])->name('katalog_ruangan.index');
Route::get('ruangan/{id}', [RuanganController::class, 'show'])->name('katalog_ruangan.show');

// Route ruangan admin
Route::get('/admin/ruangan', [RuanganController::class, 'adminindex'])->name('admin.katalog_ruangan.index');
Route::get('/admin/ruangan/{id}', [RuanganController::class, 'adminshow'])->name('admin.katalog_ruangan.show');
Route::get('/admin/ruangan/create', [RuanganController::class, 'admincreate'])->name('admin.katalog_ruangan.create');
Route::post('/admin/ruangan/store', [RuanganController::class, 'adminstore'])->name('admin.katalog_ruangan.store');
