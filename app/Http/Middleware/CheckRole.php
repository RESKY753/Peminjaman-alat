<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. Cek apakah user belum login sama sekali
        if (!Auth::check()) {
            return redirect('/')->with('error', 'Silakan login terlebih dahulu.');
        }

        $user = Auth::user();

        // 2. Cek apakah role user ada di dalam daftar role yang diizinkan
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika user sudah login tapi role-nya salah (misal peminjam maksa buka admin),
        // kembalikan ke halaman sebelumnya dengan pesan peringatan
        return redirect()->back()->with('error', 'Akses ditolak! Anda tidak memiliki izin ke halaman tersebut.');
    }
}
