<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

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

        // JIKA ROLE = PENJUAL → WAJIB CEK STATUS VERIFIKASI
        if ($user->role === 'penjual') {
            if ($user->status_verifikasi !== 'disetujui') {
                // kalau masih pending / ditolak → langsung logout lagi
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Akun penjual Anda belum disetujui admin.',
                ])->onlyInput('email');
            }

            // kalau sudah disetujui → boleh masuk dashboard penjual
            return redirect()->route('seller.dashboard');
        }

        // JIKA ROLE = ADMIN / PLATFORM
        if ($user->role === 'platform' || $user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        // fallback (kalau nanti ada role lain)
        return redirect()->intended(route('dashboard', absolute: false));
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
