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
            
            // Map route patterns to titles
            $titleMap = [
                'mahasiswa.katalog.inventaris' => 'Katalog Inventaris',
                'cart' => 'Keranjang Peminjaman',
                'pinjam-inventaris' => 'Peminjaman Inventaris',
                'mahasiswa.dashboard' => 'Dashboard',
            ];
            
            // Check for matching routes
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
