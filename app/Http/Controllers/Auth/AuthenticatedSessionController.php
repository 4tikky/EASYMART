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

        // 1. CEK STATUS PENJUAL (Tetap kita cek verifikasinya)
        if ($user->role === 'penjual') {
            // Pastikan relasi seller ada sebelum dicek
            if ($user->status_verifikasi !== User::STATUS_ACTIVE) {
                Auth::guard('web')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();

                return back()->withErrors([
                    'email' => 'Akun penjual Anda belum disetujui admin.',
                ])->onlyInput('email');
            }
            
            // PERUBAHAN DI SINI:
            // Jangan return redirect()->route('dashboard');
            // Biarkan kodingan lanjut ke bawah (ke redirect '/')
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
