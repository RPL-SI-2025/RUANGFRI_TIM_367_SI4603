<?php

use App\Http\Controllers\AdminLogistikController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CartRuanganController;
use App\Http\Controllers\ControllerMahasiswa;
use App\Http\Controllers\InventarisController;
use App\Http\Controllers\laporinventarisController;
use App\Http\Controllers\MahasiswaAuthController;
use App\Http\Controllers\PelaporanController;
use App\Http\Controllers\PinjamInventarisController;

use App\Http\Controllers\PinjamRuanganController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RuanganController;
use App\Models\laporinventaris;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;





Route::get('/', function () {
    return view('mahasiswa.auth.login');
});


// Admin Dashboard
Route::get('/admin/dashboard', [AdminLogistikController::class, 'index'])->name('admin.dashboard');


// CRUD Inventaris (Admin)
Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris.index');
Route::get('/admin/inventaris/create', [InventarisController::class, 'create'])->name('admin.inventaris.create');
Route::post('/admin/inventaris', [InventarisController::class, 'store'])->name('admin.inventaris.store');
Route::get('/admin/inventaris/{inventaris}/edit', [InventarisController::class, 'edit'])->name('admin.inventaris.edit');
Route::put('/admin/inventaris/{inventaris}', [InventarisController::class, 'update'])->name('admin.inventaris.update');
Route::delete('/admin/inventaris/{inventaris}', [InventarisController::class, 'destroy'])->name('admin.inventaris.destroy');
Route::get('/admin/inventaris/{inventaris}', [InventarisController::class, 'show'])->name('admin.inventaris.show');

//CRUD Ruangan (Admin)
Route::get('/admin/ruangan', [RuanganController::class, 'index'])->name('admin.katalog_ruangan.index');
Route::get('/admin/ruangan/create', [RuanganController::class, 'create'])->name('admin.katalog_ruangan.create');
Route::post('/admin/ruangan/store', [RuanganController::class, 'store'])->name('admin.katalog_ruangan.store');
Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('admin.katalog_ruangan.edit');
Route::put('/admin/ruangan/{id}', [RuanganController::class, 'update'])->name('admin.katalog_ruangan.update');
Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'destroy'])->name('admin.katalog_ruangan.destroy');

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


// Ruangan
Route::controller(RuanganController::class)->prefix('ruangan')->name('ruangan.')->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/create', 'create')->name('create');
    Route::post('/store', 'store')->name('store');
    Route::get('/{id}/edit', 'edit')->name('edit');
    Route::put('/{id}', 'update')->name('update');
    Route::delete('/{id}', 'destroy')->name('destroy');
});
Route::controller(InventarisController::class)->group(function () {
    Route::get('/admin/inventaris', [InventarisController::class, 'index'])->name('admin.inventaris.index');
    Route::get('/admin/inventaris/create', [InventarisController::class, 'create'])->name('admin.inventaris.create');
    Route::post('/admin/inventaris', [InventarisController::class, 'store'])->name('admin.inventaris.store');
    Route::get('/admin/inventaris/{inventaris}/edit', [InventarisController::class, 'edit'])->name('admin.inventaris.edit');
    Route::put('/admin/inventaris/{inventaris}', [InventarisController::class, 'update'])->name('admin.inventaris.update');
    Route::delete('/admin/inventaris/{inventaris}', [InventarisController::class, 'destroy'])->name('admin.inventaris.destroy');
    Route::get('/admin/inventaris/{inventaris}', [InventarisController::class, 'show'])->name('admin.inventaris.show');
});



// Ruangan routes
// Route::controller(ControllerRuangan::class)->group(function () {
//     Route::get('/ruangan', 'index')->name('ruangan.index');
//     Route::get('/ruangan/create', 'create')->name('ruangan.create');
//     Route::post('/ruangan/store', 'store')->name('ruangan.store');
//     Route::get('/ruangan/{id}/edit', 'edit')->name('ruangan.edit');
//     Route::put('/ruangan/{id}', 'update')->name('ruangan.update');
//     Route::delete('/ruangan/{id}', 'destroy')->name('ruangan.destroy');
// });

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


// AApproval Peminjaman Inventaris (Admin)
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/approval', [PinjamInventarisController::class, 'adminApproval'])->name('approval');
    Route::patch('/pinjam-inventaris/{pinjamInventaris}/update-status', [PinjamInventarisController::class, 'updateStatus'])->name('pinjam-inventaris.update-status');
    Route::delete('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'destroy'])->name('pinjam-inventaris.destroy');
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
});


//Lapor Inventaris
Route::get('admin/laporinventaris', [laporinventarisController::class, 'index'])->name('admin.lapor_inventaris.index');
Route::get('admin/laporinventaris/create', [laporinventarisController::class, 'create'])->name('admin.lapor_inventaris.create');
Route::post('admin/laporinventaris', [laporinventarisController::class, 'store'])->name('admin.lapor_inventaris.store');
Route::get('admin/laporinventaris/{lapor_inventaris}/edit', [laporinventarisController::class, 'edit'])->name('admin.lapor_inventaris.edit');
Route::put('admin/laporinventaris/{lapor_inventaris}', [laporinventarisController::class, 'update'])->name('admin.lapor_inventaris.update');
Route::delete('admin/laporinventaris/{lapor_inventaris}', [laporinventarisController::class, 'destroy'])->name('admin.lapor_inventaris.destroy');
Route::get('admin/laporinventaris/{lapor_inventaris}', [laporinventarisController::class, 'show'])->name('admin.lapor_inventaris.show');

// Auth Mahasiswa
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/login', [MahasiswaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MahasiswaAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [MahasiswaAuthController::class, 'logout'])->name('logout');
    Route::get('/register', [MahasiswaAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [MahasiswaAuthController::class, 'register'])->name('register.submit');
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


// Routes khusus Mahasiswa (dengan middleware)
Route::middleware([\App\Http\Middleware\MahasiswaAuth::class])->prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/dashboard', function () {
        return view('mahasiswa.page.dashboard');
    })->name('dashboard');

    // Katalog Inventaris untuk Mahasiswa
    Route::prefix('inventaris')->name('katalog.inventaris.')->group(function () {
        Route::get('/', [InventarisController::class, 'mahasiswaIndex'])->name('index');
        Route::get('/{id}', [InventarisController::class, 'mahasiswaShow'])->name('show');
    });

    // Peminjaman Inventaris untuk Mahasiswa
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'index'])->name('pinjam-inventaris.index');
        Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
    });

    //Katalog Ruangan untuk Mahasiswa
    // routes/web.phpz


        Route::get('mahasiswa/katalog/ruangan', [RuanganController::class, 'mahasiswaIndex'])->name('katalog.ruangan.index');
        Route::get('mahasiswa/katalog/ruangan/{id}', [RuanganController::class, 'mahasiswaShow'])->name('katalog.ruangan.show');





    // Route::prefix('ruangan')->name('mahasiswa.katalog.ruangan.')->group(function () {
    //     Route::get('/', [RuanganController::class, 'mahasiswaindex'])->name('index');
    //     Route::get('/{id}', [RuanganController::class, 'mahasiswashow'])->name('show');
    // });

    // Keranjang / Cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', [CartController::class, 'index'])->name('index');
        Route::post('/add', [CartController::class, 'add'])->name('add');
        Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
        Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
        Route::post('/clear', [CartController::class, 'clear'])->name('clear');
        Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');

        Route::get('/ruangan', [CartRuanganController::class, 'index'])->name('ruangan.index');
        Route::post('/ruangan/add', [CartRuanganController::class, 'add'])->name('ruangan.add');
        Route::delete('/ruangan/remove/{id}', [CartRuanganController::class, 'remove'])->name('ruangan.remove');
        Route::post('/ruangan/update/{id}', [CartRuanganController::class, 'update'])->name('ruangan.update');
        Route::post('ruangan/clear', [CartRuanganController::class, 'clear'])->name('ruangan.clear');
        Route::post('/ruangan/checkout', [CartRuanganController::class, 'checkout'])->name('ruangan.checkout');
    });




});

    // Peminjaman routes for mahasiswa
    Route::get('/pinjam-inventaris', [PinjamInventarisController::class, 'mahasiswaIndex'])->name('mahasiswa.peminjaman.pinjam-inventaris.index');
    Route::get('/pinjam-inventaris/create', [PinjamInventarisController::class, 'create'])->name('mahasiswa.peminjaman.pinjam-inventaris.create');
    Route::post('/pinjam-inventaris', [PinjamInventarisController::class, 'store'])->name('pinjam-inventaris.store');
    Route::get('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'show'])->name('mahasiswa.peminjaman.pinjam-inventaris.show');
    Route::get('/pinjam-inventaris/{pinjamInventaris}/edit', [PinjamInventarisController::class, 'edit'])->name('mahasiswa.peminjaman.pinjam-inventaris.edit');
    Route::put('/pinjam-inventaris/{pinjamInventaris}', [PinjamInventarisController::class, 'update'])->name('pinjam-inventaris.update');


    Route::get('/pinjam-Ruangan', [PinjamRuanganController::class, 'index'])->name('mahasiswa.peminjaman.ruangan.index');
    Route::get('/pinjam-Ruangan/create', [PinjamRuanganController::class, 'create'])->name('mahasiswa.peminjaman.ruangan.create');
    Route::post('/pinjam-Ruangan', [PinjamRuanganController::class, 'store'])->name('pinjam-Ruangan.store');
    Route::get('/pinjam-Ruangan/{pinjamRuangan}', [PinjamRuanganController::class, 'show'])->name('mahasiswa.peminjaman.ruangan.show');
    Route::get('/pinjam-Ruangan/{pinjamRuangan}/edit', [PinjamRuanganController::class, 'edit'])->name('mahasiswa.peminjaman.ruangan.edit');
    Route::put('/pinjam-Ruangan/{pinjamRuangan}', [PinjamRuanganController::class, 'update'])->name('pinjam-Ruangan.update');

Route::get('/admin/approval', [PinjamInventarisController::class, 'adminApproval'])->name('admin.approval');

// Pelaporan Ruangan

Route::resource('pelaporans', PelaporanController::class);
