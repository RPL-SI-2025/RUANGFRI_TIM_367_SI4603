<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\PinjamInventarisController;
use App\Http\Controllers\ControllerMahasiswa;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\laporinventarisController;
use App\Models\laporinventaris;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\AdminLogistikController;
use App\Http\Controllers\RuanganCartController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PinjamRuanganController;
use App\Http\Middleware\MahasiswaAuth;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;




Route::get('/', function () {
    return view('mahasiswa.auth.login');
});

// Ruangan routes
Route::controller(RuanganController::class)->group(function () {
    Route::get('/ruangan', 'index')->name('ruangan.index');
    Route::get('/ruangan/create', 'create')->name('ruangan.create');
    Route::post('/ruangan/store', 'store')->name('ruangan.store');
    Route::get('/ruangan/{id}/edit', 'edit')->name('ruangan.edit');
    Route::put('/ruangan/{id}', 'update')->name('ruangan.update');
    Route::delete('/ruangan/{id}', 'destroy')->name('ruangan.destroy');
});


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

    Route::get('/pinjam-ruangan', [PinjamRuanganController::class, 'adminIndex'])->name('admin.pinjam-ruangan.index');
    Route::get('/pinjam-ruangan/approval', [PinjamRuanganController::class, 'adminApproval'])->name('admin.pinjam-ruangan.approval');
    Route::get('/pinjam-ruangan/{pinjamRuangan}', [PinjamRuanganController::class, 'adminShow'])->name('admin.pinjam-ruangan.show');
    Route::put('/pinjam-ruangan/{pinjamRuangan}/update-status', [PinjamRuanganController::class, 'updateStatus'])->name('pinjam-ruangan.update-status');

    Route::get('/laporinventaris', [laporinventarisController::class, 'index'])->name('admin.lapor_inventaris.index');
    Route::get('/laporinventaris/create', [laporinventarisController::class, 'create'])->name('admin.lapor_inventaris.create');
    Route::post('/laporinventaris', [laporinventarisController::class, 'store'])->name('admin.lapor_inventaris.store');
    Route::get('/laporinventaris/{lapor_inventaris}/edit', [laporinventarisController::class, 'edit'])->name('admin.lapor_inventaris.edit');
    Route::put('/laporinventaris/{lapor_inventaris}', [laporinventarisController::class, 'update'])->name('admin.lapor_inventaris.update');
    Route::delete('/laporinventaris/{lapor_inventaris}', [laporinventarisController::class, 'destroy'])->name('admin.lapor_inventaris.destroy');
    Route::get('/laporinventaris/{lapor_inventaris}', [laporinventarisController::class, 'show'])->name('admin.lapor_inventaris.show');


    Route::get('/lapor-ruangan', [PelaporanController::class, 'index'])->name('admin.lapor_ruangan.index');
    Route::get('/lapor-ruangan/{id}', [PelaporanController::class, 'show'])->name('admin.lapor_ruangan.show');
    Route::put('/lapor-ruangan/{id}', [PelaporanController::class, 'update'])->name('admin.lapor_ruangan.update');

    Route::get('/ruangan', [RuanganController::class, 'index'])->name('admin.katalog_ruangan.index');
    Route::get('/ruangan/create', [RuanganController::class, 'create'])->name('admin.katalog_ruangan.create');
    Route::post('/ruangan/store', [RuanganController::class, 'store'])->name('admin.katalog_ruangan.store');
    Route::get('/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('admin.katalog_ruangan.edit');
    Route::put('/ruangan/{id}', [RuanganController::class, 'update'])->name('admin.katalog_ruangan.update');
    Route::delete('/ruangan/{id}', [RuanganController::class, 'destroy'])->name('admin.katalog_ruangan.destroy');


});




Auth::routes(['verify' => true]);

Route::middleware(['auth:mahasiswa'])->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/update', [ProfileController::class, 'updateProfile'])->name('mahasiswa.profile.update');
    Route::patch('profile/update-password', [ProfileController::class, 'updatePassword'])->name('mahasiswa.profile.update-password');
    Route::delete('profile/delete', [ProfileController::class, 'destroy'])->name('mahasiswa.profile.delete');
});
// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard'); // Redirect after successful verification
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');


Route::get('/mahasiswa/login', [App\Http\Controllers\MahasiswaAuthController::class, 'showLoginForm'])->name('mahasiswa.login');
Route::post('/mahasiswa/login', [App\Http\Controllers\MahasiswaAuthController::class, 'login'])->name('mahasiswa.login.submit');
Route::post('/mahasiswa/logout', [App\Http\Controllers\MahasiswaAuthController::class, 'logout'])->name('mahasiswa.logout');
Route::get('/mahasiswa/register', [App\Http\Controllers\MahasiswaAuthController::class, 'showRegistrationForm'])->name('mahasiswa.register');
Route::post('/mahasiswa/register', [App\Http\Controllers\MahasiswaAuthController::class, 'register'])->name('mahasiswa.register.submit');
Route::middleware(['auth:mahasiswa'])->group(function () {
    Route::get('profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile/update', [ProfileController::class, 'updateProfile'])->name('mahasiswa.profile.update');
    Route::patch('profile/update-password', [ProfileController::class, 'updatePassword'])->name('mahasiswa.profile.update-password');
    Route::delete('profile/delete', [ProfileController::class, 'destroy'])->name('mahasiswa.profile.delete');
});


Route::middleware([\App\Http\Middleware\MahasiswaAuth::class])->prefix('mahasiswa')->group(function() {
    Route::get('/dashboard', function() {
        return view('mahasiswa.page.dashboard');
    })->name('mahasiswa.dashboard');

    // Mahasiswa Inventaris View
    Route::prefix('mahasiswa')->group(function () {
        Route::get('/inventaris', [InventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.katalog.inventaris.index');
        Route::get('/inventaris/{id}', [InventarisController::class, 'mahasiswaShow'])->name('mahasiswa.katalog.inventaris.show');

        Route::get('/ruangan', [RuanganController::class, 'mahasiswaIndex'])->name('mahasiswa.katalog.ruangan.index');
        Route::get('/ruangan/{id}', [RuanganController::class, 'mahasiswaShow'])->name('mahasiswa.katalog.ruangan.show');
    });

    // Cart routes
    Route::get('/cart', [CartController::class, 'index'])->name('mahasiswa.cart.keranjang_inventaris.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::put('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    Route::post('/cart/checkout', [CartController::class, 'checkout'])->name('cart.checkout');

    Route::get('/ruangan-cart', [RuanganCartController::class, 'index'])->name('mahasiswa.cart.keranjang_ruangan.index');
    Route::post('/ruangan-cart/add', [RuanganCartController::class, 'add'])->name('mahasiswa.cart.keranjang_ruangan.add');
    Route::post('/ruangan-cart/remove/{key}', [RuanganCartController::class, 'remove'])->name('mahasiswa.cart.keranjang_ruangan.remove');
    Route::put('/ruangan-cart/update/{key}', [RuanganCartController::class, 'update'])->name('mahasiswa.cart.keranjang_ruangan.update');
    Route::post('/ruangan-cart/clear', [RuanganCartController::class, 'clear'])->name('mahasiswa.cart.keranjang_ruangan.clear');
    Route::post('/ruangan-cart/checkout', [RuanganCartController::class, 'checkout'])->name('mahasiswa.cart.keranjang_ruangan.checkout');

    // Peminjaman routes for mahasiswa
    Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.peminjaman.pinjam-inventaris.index');
    Route::get('/pinjam-inventaris/create', [PinjamInventarisController::class, 'create'])->name('mahasiswa.peminjaman.pinjam-inventaris.create');
    Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
    Route::get('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'show'])->name('mahasiswa.peminjaman.pinjam-inventaris.show');
    Route::get('/pinjam-inventaris/{pinjamInventaris}/edit', [PinjamInventarisController::class, 'edit'])->name('mahasiswa.peminjaman.pinjam-inventaris.edit');
    Route::put('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'update'])->name('pinjam-inventaris.update');

    Route::get('/pinjam-ruangan', [PinjamRuanganController::class, 'mahasiswaIndex'])->name('mahasiswa.peminjaman.pinjam-ruangan.index');
    Route::get('/pinjam-ruangan/create', [PinjamRuanganController::class, 'create'])->name('mahasiswa.peminjaman.pinjam-ruangan.create');
    Route::post('/pinjam-ruangan', [PinjamRuanganController::class, 'store'])->name('pinjam-ruangan.store');
    Route::get('/pinjam-ruangan/{pinjamRuangan}', [PinjamRuanganController::class, 'show'])->name('mahasiswa.peminjaman.pinjam-ruangan.show');
    Route::get('/pinjam-ruangan/{pinjamRuangan}/edit', [PinjamRuanganController::class, 'edit'])->name('mahasiswa.peminjaman.pinjam-ruangan.edit');
    Route::put('/pinjam-ruangan/{pinjamRuangan}', [PinjamRuanganController::class, 'update'])->name('pinjam-ruangan.update');
    Route::put('/pinjam-ruangan/{pinjamRuangan}/cancel', [PinjamRuanganController::class, 'cancel'])->name('mahasiswa.peminjaman.pinjam-ruangan.cancel');

    Route::get('/pelaporan/lapor-inventaris', [laporinventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.pelaporan.lapor_inventaris.index');
    Route::get('/pelaporan/lapor-inventaris/create', [laporinventarisController::class, 'mahasiswaCreate'])->name('mahasiswa.pelaporan.lapor_inventaris.create');
    Route::post('/pelaporan/lapor-inventaris', [laporinventarisController::class, 'mahasiswaStore'])->name('mahasiswa.pelaporan.lapor_inventaris.store');
    Route::get('/pelaporan/lapor-inventaris/{id}/edit', [laporinventarisController::class, 'mahasiswaEdit'])->name('mahasiswa.pelaporan.lapor_inventaris.edit');
    Route::put('/pelaporan/lapor-inventaris/{id}', [laporinventarisController::class, 'mahasiswaUpdate'])->name('mahasiswa.pelaporan.lapor_inventaris.update');
    Route::get('/pelaporan/lapor-inventaris/{id}', [laporinventarisController::class, 'mahasiswaShow'])->name('mahasiswa.pelaporan.lapor_inventaris.show');

    Route::get('/pelaporan/lapor-ruangan', [PelaporanController::class, 'mahasiswaIndex'])->name('mahasiswa.pelaporan.lapor_ruangan.index');
    Route::get('/pelaporan/lapor-ruangan/create', [PelaporanController::class, 'mahasiswaCreate'])->name('mahasiswa.pelaporan.lapor_ruangan.create');
    Route::post('/pelaporan/lapor-ruangan', [PelaporanController::class, 'mahasiswaStore'])->name('mahasiswa.pelaporan.lapor_ruangan.store');
    Route::get('/pelaporan/lapor-ruangan/{id}/edit', [PelaporanController::class, 'mahasiswaEdit'])->name('mahasiswa.pelaporan.lapor_ruangan.edit');
    Route::put('/pelaporan/lapor-ruangan/{id}', [PelaporanController::class, 'mahasiswaUpdate'])->name('mahasiswa.pelaporan.lapor_ruangan.update');
    Route::get('/pelaporan/lapor-ruangan/{id}', [PelaporanController::class, 'mahasiswaShow'])->name('mahasiswa.pelaporan.lapor_ruangan.show');


});
