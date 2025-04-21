<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MahasiswaAuth
{
    public function handle(Request $request, Closure $next)
    {

        if (!Auth::guard('mahasiswa')->check()) {
            return redirect()->route('mahasiswa.login');
        }
        
        return $next($request);
    }
}