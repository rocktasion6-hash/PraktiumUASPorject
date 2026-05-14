<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
// Pastikan baris di bawah ini ada untuk mendefinisikan Response
use Symfony\Component\HttpFoundation\Response; 
use Illuminate\Support\Facades\Auth; // Tambahan opsional untuk performa

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah user sudah login dan memiliki role admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return $next($request);
        }

        // Jika bukan admin, arahkan ke dashboard dengan pesan error
        return redirect('/dashboard')->with('error', 'Anda tidak memiliki akses Admin.');
    }
}