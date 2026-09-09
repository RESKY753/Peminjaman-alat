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
        // 1. Cek apakah user sudah login
        if (!Auth::check()) {
            return redirect('/');
        }

        $user = Auth::user();

        // 2. Cek apakah role sesuai
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. Jika tidak cocok, tampilkan view kustom 403 lengkap dengan countdown
        return response()->view('error.403', [], 403);
    }
}
