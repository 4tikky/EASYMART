<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerRejectionMail;
use App\Mail\SellerApprovedMail;
use App\Mail\SellerRejectedMail;

class SellerApprovalController extends Controller
{
    /**
     * Dashboard platform:
     * ringkasan jumlah seller per status.
     */
    public function dashboard(): View
    {
        $pendingCount  = User::where('role', User::ROLE_PENJUAL)
                             ->where('status_verifikasi', User::STATUS_PENDING)
                             ->count();

        $activeCount   = User::where('role', User::ROLE_PENJUAL)
                             ->where('status_verifikasi', User::STATUS_ACTIVE)
                             ->count();

        $rejectedCount = User::where('role', User::ROLE_PENJUAL)
                             ->where('status_verifikasi', User::STATUS_REJECTED)
                             ->count();

        return view('platform.dashboard', compact(
            'pendingCount', 'activeCount', 'rejectedCount'
        ));
    }

    /**
     * Daftar seller berdasarkan status (default: pending).
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', User::STATUS_PENDING);

        $sellers = User::where('role', User::ROLE_PENJUAL)
                       ->where('status_verifikasi', $status)
                       ->orderBy('created_at', 'desc')
                       ->paginate(10);

        return view('platform.sellers.index', [
            'sellers' => $sellers,
            'status'  => $status,
        ]);
    }

    /**
     * Detail satu seller.
     */
    public function show(User $seller): View
    {
        abort_unless(
            $seller->role === User::ROLE_PENJUAL,
            404
        );

        return view('platform.sellers.show', compact('seller'));
    }

    /**
     * Approve seller -> status ACTIVE (sesuai SRS).
     */
    public function approve(User $seller): RedirectResponse
    {
        abort_unless($seller->role === User::ROLE_PENJUAL, 404);

        $seller->status_verifikasi = User::STATUS_ACTIVE;
        $seller->save();

        // Kirim email disetujui
        Mail::to($seller->email)->send(new SellerApprovedMail($seller));

        return back()->with('status', 'Penjual berhasil diaktifkan.');
    }

    /**
     * Reject seller -> status REJECTED.
     */
    public function reject(User $seller): RedirectResponse
    {
        abort_unless($seller->role === User::ROLE_PENJUAL, 404);

        $seller->status_verifikasi = User::STATUS_REJECTED;
        $seller->save();

        // Kirim email ditolak
        Mail::to($seller->email)->send(new SellerRejectedMail($seller));

        return back()->with('status', 'Pendaftaran penjual ditolak.');
    }
}
