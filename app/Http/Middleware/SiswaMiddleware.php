<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SiswaMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        // Cek apakah pengguna sudah login dan memiliki role 'admin'
        if (Auth::check() && Auth::user()->role === 'siswa') {
            return $next($request);
        }

        // Jika tidak memenuhi syarat, redirect atau tampilkan pesan error
        return redirect('login')->with('error', 'Anda tidak memiliki akses ke halaman ini.');
    }
}
