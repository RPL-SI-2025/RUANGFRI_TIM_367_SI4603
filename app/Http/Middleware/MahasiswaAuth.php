<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class MahasiswaAuth
{
    public function handle(Request $request, Closure $next)
    {
        $mahasiswaId = Session::get('mahasiswa_id');
        $isLoggedIn = Session::get('is_logged_in');
        
        if (!$mahasiswaId || !$isLoggedIn) {
            return redirect()->route('mahasiswa.login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }
        
        return $next($request);
    }
}