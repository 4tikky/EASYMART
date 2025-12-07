<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = $request->user();

        // 1. CEK STATUS PENJUAL (Cek status di tabel sellers)
        if ($user->role === 'penjual') {
            // Cek apakah user punya seller dan statusnya active
            if (!$user->seller || $user->seller->status !== 'active') {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun penjual Anda belum disetujui admin.',
                ])->onlyInput('email');
            }
        }

        // 2. KHUSUS ADMIN/PLATFORM (Biasanya Admin tetap mau langsung Dashboard)
        if ($user->role === 'platform' || $user->role === 'admin') {
            return redirect()->route('platform.dashboard');
        }

        // 3. SEMUA USER (TERMASUK PENJUAL) AKAN MASUK KE SINI (HOME)
        return redirect()->intended('/'); 
    }
    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
