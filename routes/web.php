<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/inventaris', [InventarisController::class, 'index']);
Route::get('/inventaris/create', [InventarisController::class, 'create']);
Route::post('/inventaris', [InventarisController::class, 'store']);
Route::get('/inventaris/{id}', [InventarisController::class, 'show']);
Route::get('/inventaris/{id}/edit', [InventarisController::class, 'edit']);
Route::put('/inventaris/{id}', [InventarisController::class, 'update']);
Route::delete('/inventaris/{id}', [InventarisController::class, 'destroy']);