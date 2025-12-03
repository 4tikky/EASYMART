<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Review; // kalau namanya beda, ganti sendiri
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\SellerApprovedMail;
use App\Mail\SellerRejectedMail;

class SellerApprovalController extends Controller
{
    /**
     * Dashboard platform:
     * ringkasan + grafik sesuai SRS-MartPlace-07.
     */
    public function dashboard(): View
    {
        // ---- Ringkasan verifikasi seller ----
        $pendingCount  = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', User::STATUS_PENDING)
            ->count();

        $activeCount   = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', User::STATUS_ACTIVE)
            ->count();

        $rejectedCount = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', User::STATUS_REJECTED)
            ->count();

        // ================== SRS-MartPlace-07 ==================
        // 1) Sebaran jumlah produk berdasarkan kategori
        $productByCategory = Product::selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->get()
            ->map(function ($row) {
                return [
                    'category' => $row->category ?? 'Tanpa Kategori',
                    'total'    => $row->total,
                ];
            });

        // 2) Sebaran jumlah toko berdasarkan lokasi provinsi
        //    diasumsikan ada relasi user->seller atau kolom 'provinsi' di tabel users/sellers
        $storeByProvince = User::where('role', User::ROLE_PENJUAL)
            ->selectRaw('provinsi, COUNT(*) as total')
            ->groupBy('provinsi')
            ->get()
            ->map(function ($row) {
                return [
                    'province' => $row->provinsi ?? 'Tidak diketahui',
                    'total'    => $row->total,
                ];
            });

        // 3) Jumlah seller aktif dan tidak aktif
        //    "Tidak aktif" di sini aku contohkan: selain ACTIVE = tidak aktif
        $sellerActiveCount   = $activeCount;
        $sellerInactiveCount = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', '!=', User::STATUS_ACTIVE)
            ->count();

        // 4) Jumlah pengunjung yang memberi komentar & rating
        $totalReviews        = Review::count();
        $reviewers = Review::select('user_id', 'guest_email')->get();

        $totalReviewVisitors = $reviewers
            ->map(function ($r) {
                // Kalau user login, kunci uniknya pakai user_id
                if (!is_null($r->user_id)) {
                    return 'user-' . $r->user_id;
                }

                // Kalau tamu, pakai email (boleh diganti guest_phone kalau mau)
                return 'guest-' . strtolower(trim($r->guest_email ?? ''));
            })
            ->filter()   // buang yang kosong (jaga-jaga kalau guest_email null)
            ->unique()
            ->count();

        return view('platform.dashboard', compact(
            'pendingCount',
            'activeCount',
            'rejectedCount',
            'productByCategory',
            'storeByProvince',
            'sellerActiveCount',
            'sellerInactiveCount',
            'totalReviews',
            'totalReviewVisitors'
        ));
    }

    /**
     * Daftar seller berdasarkan status (DEFAULT: pending).
     * -> INILAH HALAMAN VERIFIKASI PENJUAL
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
        abort_unless($seller->role === User::ROLE_PENJUAL, 404);

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

        Mail::to($seller->email)->send(new SellerRejectedMail($seller));

        return back()->with('status', 'Pendaftaran penjual ditolak.');
    }
}