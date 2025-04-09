<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

Route::get('/', function () {
    return view('welcome');
});

// Route buat inventaris umum 

Route::get('/inventaris', [InventarisController::class, 'index'])->name('inventaris.index');
Route::get('/inventaris/{id}', [InventarisController::class, 'show'])->name('inventaris.show');