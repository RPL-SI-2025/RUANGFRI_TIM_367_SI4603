<?php


use App\Http\Controllers\ControllerMahasiswa;

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


Route::controller(ControllerMahasiswa::class)->group(function () {
    Route::get('/mahasiswa', 'index')->name('mahasiswa.index');
    Route::get('/mahasiswa/create', 'create')->name('mahasiswa.create');
    Route::post('/mahasiswa/store', 'store')->name('mahasiswa.store');
    Route::get('/mahasiswa/{id}/edit', 'edit')->name('mahasiswa.edit');
    Route::put('/mahasiswa/{id}', 'update')->name('mahasiswa.update');
    Route::delete('/mahasiswa/{id}', 'destroy')->name('mahasiswa.destroy');
});