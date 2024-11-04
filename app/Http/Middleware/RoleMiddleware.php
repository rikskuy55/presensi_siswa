<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check()) {
            // Debugging: Periksa role saat ini
            if (Auth::user()->role == $role) {
                return $next($request);
            }
        }
    
        return redirect('login')->withErrors('Anda tidak memiliki akses ke halaman ini.');
    }
}
