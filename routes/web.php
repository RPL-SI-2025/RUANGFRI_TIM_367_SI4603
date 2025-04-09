<?php


use App\Http\Controllers\ControllerRuangan;

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});


Route::controller(ControllerRuangan::class)->group(function () {
    Route::get('/ruangan', 'index')->name('ruangan.index');
    Route::get('/ruangan/create', 'create')->name('ruangan.create');
    Route::post('/ruangan/store', 'store')->name('ruangan.store');
    Route::get('/ruangan/{id}/edit', 'edit')->name('ruangan.edit');
    Route::put('/ruangan/{id}', 'update')->name('ruangan.update');
    Route::delete('/ruangan/{id}', 'destroy')->name('ruangan.destroy');
});
