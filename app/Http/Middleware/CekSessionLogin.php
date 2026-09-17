<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CekSessionLogin
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // Cek apakah session login-nya TIDAK ADA / belum login
        if (!Auth::check()) {
            // Kalau gak ada session, tendang balik ke halaman login dengan pesan
            return redirect('/')->with('error', 'Sesi habis atau kamu belum login. Silakan login dulu!');
        }

        // Kalau ada session-nya, silakan lanjut masuk
        return $next($request);
    }
}