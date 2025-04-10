<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

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
