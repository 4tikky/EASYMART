<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class EnsureUserIsPlatform
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (!$user || $user->role !== 'platform') {
            abort(403, 'Hanya pengguna platform yang boleh mengakses halaman ini.');
        }

        return $next($request);
    }
}
