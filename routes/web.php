<?php
use App\Http\Controllers\HistoryController;
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

/*
|--------------------------------------------------------------------------
| Default Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [AdminLogistikController::class, 'landing'])->name('landing');

Route::middleware(['auth:mahasiswa'])->group(function () {
    Route::get('/mahasiswa/dashboard', [MahasiswaAuthController::class, 'dashboard'])->name('mahasiswa.dashboard');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Auth::routes(['verify' => true]);


// Email verification routes
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/dashboard');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('status', 'verification-link-sent');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

/*
|--------------------------------------------------------------------------
| Mahasiswa Authentication Routes
|--------------------------------------------------------------------------
*/
Route::prefix('mahasiswa')->name('mahasiswa.')->group(function () {
    Route::get('/login', [MahasiswaAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [MahasiswaAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [MahasiswaAuthController::class, 'logout'])->name('logout');
    Route::get('/register', [MahasiswaAuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [MahasiswaAuthController::class, 'register'])->name('register.submit');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminLogistikController::class, 'index'])->name('dashboard');
    Route::get('/create', [RuanganController::class, 'create'])->name('admin.katalog_ruangan.create');
    Route::get('/pinjam-approval', [PinjamRuanganController::class, 'approval'])->name('admin.pinjam.approval');

    // Inventaris Management
    Route::prefix('inventaris')->name('inventaris.')->group(function () {
        Route::get('/', [InventarisController::class, 'index'])->name('index');
        Route::get('/create', [InventarisController::class, 'create'])->name('create');
        Route::post('/', [InventarisController::class, 'store'])->name('store');
        Route::get('/{inventaris}', [InventarisController::class, 'show'])->name('show');
        Route::get('/{inventaris}/edit', [InventarisController::class, 'edit'])->name('edit');
        Route::put('/{inventaris}', [InventarisController::class, 'update'])->name('update');
        Route::delete('/{inventaris}', [InventarisController::class, 'destroy'])->name('destroy');
    });

    // Peminjaman Inventaris Management
    Route::prefix('pinjam-inventaris')->name('pinjam-inventaris.')->group(function () {
        Route::get('/', [PinjamInventarisController::class, 'adminIndex'])->name('index');
        Route::get('/{pinjamInventaris}', [PinjamInventarisController::class, 'adminShow'])->name('show');
        Route::delete('/{pinjamInventaris}', [PinjamInventarisController::class, 'destroy'])->name('destroy');
        Route::put('/{pinjamInventaris}/update-status', [PinjamInventarisController::class, 'updateStatus'])->name('update-status');
        Route::put('/{pinjamInventaris}/notes', [PinjamInventarisController::class, 'updateNotes'])->name('update-notes');
    });

    // Peminjaman Ruangan Management
    Route::prefix('pinjam-ruangan')->name('pinjam-ruangan.')->group(function () {
        Route::get('/', [PinjamRuanganController::class, 'adminIndex'])->name('index');
        Route::get('/{pinjamRuangan}', [PinjamRuanganController::class, 'adminShow'])->name('show');
        Route::put('/{pinjamRuangan}/update-status', [PinjamRuanganController::class, 'updateStatus'])->name('update-status');
        Route::put('/{pinjamRuangan}/update-notes', [PinjamRuanganController::class, 'updateNotes'])->name('update-notes');
    });

    // Laporan Inventaris Management
    Route::prefix('lapor-inventaris')->name('lapor_inventaris.')->group(function () {
        Route::get('/', [laporinventarisController::class, 'index'])->name('index');
        Route::get('/create', [laporinventarisController::class, 'create'])->name('create');
        Route::post('/', [laporinventarisController::class, 'store'])->name('store');
        Route::get('/{lapor_inventaris}', [laporinventarisController::class, 'show'])->name('show');
        Route::get('/{lapor_inventaris}/edit', [laporinventarisController::class, 'edit'])->name('edit');
        Route::put('/{lapor_inventaris}', [laporinventarisController::class, 'update'])->name('update');
        Route::delete('/{lapor_inventaris}', [laporinventarisController::class, 'destroy'])->name('destroy');
        Route::get('/{id}/download-pdf', [laporInventarisController::class, 'admindownloadPDF'])->name('download-pdf');
    });

    // Laporan Ruangan Management
    Route::prefix('lapor-ruangan')->name('lapor_ruangan.')->group(function () {
        Route::get('/', [PelaporanController::class, 'index'])->name('index');
        Route::get('/{id}', [PelaporanController::class, 'show'])->name('show');
        Route::put('/{id}', [PelaporanController::class, 'update'])->name('update');
    });

    // Ruangan Management
    Route::prefix('ruangan')->name('katalog_ruangan.')->group(function () {
        Route::get('/', [RuanganController::class, 'index'])->name('index');
        Route::get('/create', [RuanganController::class, 'create'])->name('create');
        Route::post('/store', [RuanganController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [RuanganController::class, 'edit'])->name('edit');
        Route::put('/{id}', [RuanganController::class, 'update'])->name('update');
        Route::delete('/{id}', [RuanganController::class, 'destroy'])->name('destroy');
    });

    // Jadwal Management
    Route::prefix('jadwal')->name('jadwal.')->group(function () {
        Route::get('/', [App\Http\Controllers\JadwalRuanganController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\JadwalRuanganController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\JadwalRuanganController::class, 'store'])->name('store');
        Route::get('/{jadwal}', [App\Http\Controllers\JadwalRuanganController::class, 'show'])->name('show');
        Route::get('/{jadwal}/edit', [App\Http\Controllers\JadwalRuanganController::class, 'edit'])->name('edit');
        Route::put('/{jadwal}', [App\Http\Controllers\JadwalRuanganController::class, 'update'])->name('update');
        Route::delete('/{jadwal}', [App\Http\Controllers\JadwalRuanganController::class, 'destroy'])->name('destroy');
        Route::post('/generate', [App\Http\Controllers\JadwalRuanganController::class, 'generateJadwal'])->name('generate');
    });

    // history admin
   Route::prefix('history')->name('history_inventaris.')->group(function () {
        Route::get('/', [HistoryController::class, 'adminindex'])->name('index');
        Route::get('/{type}/{id}', [HistoryController::class, 'adminshow'])->name('show');
    });
    
});
/*
|--------------------------------------------------------------------------
| Mahasiswa Protected Routes
|--------------------------------------------------------------------------
*/
Route::middleware([MahasiswaAuth::class])->prefix('mahasiswa')->name('mahasiswa.')->group(function() {
    
    // Dashboard


    // Profile Management
    Route::prefix('profile')->name('profile.')->group(function () {
        Route::get('/edit', [ProfileController::class, 'edit'])->name('edit');
        Route::patch('/update', [ProfileController::class, 'updateProfile'])->name('update');
        Route::patch('/update-password', [ProfileController::class, 'updatePassword'])->name('update-password');
        Route::delete('/delete', [ProfileController::class, 'destroy'])->name('delete');
    });

    // Katalog
    Route::prefix('katalog')->name('katalog.')->group(function () {
        // Inventaris Catalog
        Route::prefix('inventaris')->name('inventaris.')->group(function () {
            Route::get('/', [InventarisController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/{id}', [InventarisController::class, 'mahasiswaShow'])->name('show');
        });
        
        // Ruangan Catalog
        Route::prefix('ruangan')->name('ruangan.')->group(function () {
            Route::get('/', [RuanganController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/{id}', [RuanganController::class, 'mahasiswaShow'])->name('show');
        });
    });

    // Cart Management
    Route::prefix('cart')->name('cart.')->group(function () {
        // Inventaris Cart
        Route::prefix('inventaris')->name('keranjang_inventaris.')->group(function () {
            Route::get('/', [CartController::class, 'index'])->name('index');
            Route::post('/add', [CartController::class, 'add'])->name('add');
            Route::post('/remove/{id}', [CartController::class, 'remove'])->name('remove');
            Route::put('/update/{id}', [CartController::class, 'update'])->name('update');
            Route::post('/clear', [CartController::class, 'clear'])->name('clear');
            Route::post('/checkout', [CartController::class, 'checkout'])->name('checkout');
        });

        // Ruangan Cart
        Route::prefix('ruangan')->name('keranjang_ruangan.')->group(function () {
            Route::get('/', [RuanganCartController::class, 'index'])->name('index');
            Route::post('/add', [RuanganCartController::class, 'add'])->name('add');
            Route::post('/remove/{key}', [RuanganCartController::class, 'remove'])->name('remove');
            Route::put('/update/{key}', [RuanganCartController::class, 'update'])->name('update');
            Route::post('/clear', [RuanganCartController::class, 'clear'])->name('clear');
            Route::post('/checkout', [RuanganCartController::class, 'checkout'])->name('checkout');
        });
    });

    // Peminjaman Management
    Route::prefix('peminjaman')->name('peminjaman.')->group(function () {
        // Inventaris Peminjaman
        Route::prefix('inventaris')->name('pinjam-inventaris.')->group(function () {
            Route::get('/', [PinjamInventarisController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/create', [PinjamInventarisController::class, 'create'])->name('create');
            Route::post('/', [PinjamInventarisController::class, 'store'])->name('store');
            Route::get('/{pinjamInventaris}', [PinjamInventarisController::class, 'show'])->name('show');
            Route::get('/{pinjamInventaris}/edit', [PinjamInventarisController::class, 'edit'])->name('edit');
            Route::put('/{pinjamInventaris}', [PinjamInventarisController::class, 'update'])->name('update');
            Route::delete('/{pinjamInventaris}', [PinjamInventarisController::class, 'destroy'])->name('destroy');
        });

        // Ruangan Peminjaman
        Route::prefix('ruangan')->name('pinjam-ruangan.')->group(function () {
            Route::get('/', [PinjamRuanganController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/create', [PinjamRuanganController::class, 'create'])->name('create');
            Route::post('/', [PinjamRuanganController::class, 'store'])->name('store');
            Route::get('/{pinjamRuangan}', [PinjamRuanganController::class, 'show'])->name('show');
            Route::get('/{pinjamRuangan}/edit', [PinjamRuanganController::class, 'edit'])->name('edit');
            Route::put('/{pinjamRuangan}', [PinjamRuanganController::class, 'update'])->name('update');
            Route::put('/{pinjamRuangan}/cancel', [PinjamRuanganController::class, 'cancel'])->name('cancel');
        });
    });

    // Pelaporan Management
    Route::prefix('pelaporan')->name('pelaporan.')->group(function () {
        // Inventaris Pelaporan
        Route::prefix('inventaris')->name('lapor_inventaris.')->group(function () {
            Route::get('/', [laporinventarisController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/create', [laporinventarisController::class, 'mahasiswaCreate'])->name('create');
            Route::post('/', [laporinventarisController::class, 'mahasiswaStore'])->name('store');
            Route::get('/{id}', [laporinventarisController::class, 'mahasiswaShow'])->name('show');
            Route::get('/{id}/edit', [laporinventarisController::class, 'mahasiswaEdit'])->name('edit');
            Route::put('/{id}', [laporinventarisController::class, 'mahasiswaUpdate'])->name('update');
            Route::get('/{id}/download-pdf', [laporinventarisController::class, 'downloadPDF'])->name('download-pdf');
        });

        // Ruangan Pelaporan
        Route::prefix('ruangan')->name('lapor_ruangan.')->group(function () {
            Route::get('/', [PelaporanController::class, 'mahasiswaIndex'])->name('index');
            Route::get('/create', [PelaporanController::class, 'mahasiswaCreate'])->name('create');
            Route::post('/', [PelaporanController::class, 'mahasiswaStore'])->name('store');
            Route::get('/{id}', [PelaporanController::class, 'mahasiswaShow'])->name('show');
            Route::get('/{id}/edit', [PelaporanController::class, 'mahasiswaEdit'])->name('edit');
            Route::put('/{id}', [PelaporanController::class, 'mahasiswaUpdate'])->name('update');
        });
    });

    // History Management
    Route::prefix('history')->name('history.')->group(function () {
        Route::get('/', [HistoryController::class, 'index'])->name('index');
        Route::get('/{type}/{id}', [HistoryController::class, 'show'])->name('show');
        Route::get('/history', [HistoryController::class, 'index'])->name('mahasiswa.history.history_inventaris.index');
        Route::get('/history/{type}/{id}', [HistoryController::class, 'show'])->name('mahasiswa.history.history_inventaris.show');
    });

    // Jadwal API Routes
    Route::prefix('jadwal')->group(function () {
        Route::get('/ruangan/{id_ruangan}', [App\Http\Controllers\JadwalRuanganController::class, 'getRuanganJadwal']);
        Route::get('/timeslots', [App\Http\Controllers\JadwalRuanganController::class, 'getTimeSlots']);
    });
});


/*
|--------------------------------------------------------------------------
| Debug Routes
|--------------------------------------------------------------------------
*/
// Route::get('/debug/operational-days/{id_ruangan}', [App\Http\Controllers\JadwalRuanganController::class, 'debugOperationalDays'])->name('debug.operational-days');