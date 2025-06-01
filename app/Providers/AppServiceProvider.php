<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('mahasiswa.layouts.navbar', function ($view) {
            $routeName = Route::currentRouteName();
            $pageTitle = 'Sistem Peminjaman Inventaris';
            
            
            $titleMap = [
                'mahasiswa.katalog.inventaris' => 'Katalog Inventaris',
                'mahasiswa.katalog.ruangan' => 'Katalog Ruangan',
                'mahasiswa.peminjaman.pinjam-inventaris' => 'Peminjaman Inventaris',
                'mahasiswa.peminjaman.pinjam-ruangan' => 'Peminjaman Ruangan',
                'mahasiswa.pelaporan.lapor_inventaris' => 'Pelaporan Inventaris',
                'mahasiswa.pelaporan.lapor_ruangan' => 'Pelaporan Ruangan',
                'mahasiswa.history' => 'Riwayat Peminjaman',
                'profile' => 'Profil Saya',
                'cart' => 'Keranjang Peminjaman',
                'mahasiswa.dashboard' => 'Dashboard',
            ];
            
            
            foreach ($titleMap as $route => $title) {
                if (strpos($routeName, $route) !== false) {
                    $pageTitle = $title;
                    break;
                }
            }
            
            $view->with('pageTitle', $pageTitle);
        });
    }
}
