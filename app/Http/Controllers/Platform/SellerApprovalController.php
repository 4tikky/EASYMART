<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
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
        $pendingCount  = Seller::where('status', 'pending')->count();
        $activeCount   = Seller::where('status', 'active')->count();
        $rejectedCount = Seller::where('status', 'rejected')->count();

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
        // 2) Sebaran jumlah toko berdasarkan provinsi
        $sellerByProvince = Seller::selectRaw('picProvince, COUNT(*) as total')
            ->groupBy('picProvince')
            ->get()
            ->map(function ($row) {
                return [
                    'province' => $row->picProvince ?? 'Tidak diketahui',
                    'total'    => $row->total,
                ];
            });

        // 3) Jumlah seller aktif dan tidak aktif
        $sellerActiveCount   = $activeCount;
        $sellerInactiveCount = Seller::where('status', '!=', 'active')->count();

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
            'sellerByProvince',
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
        $status = $request->query('status', 'pending');

        $sellers = \App\Models\Seller::with('user')
            ->where('status', $status)
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
    public function show(Seller $seller): View
    {
        $seller->load('user');
        return view('platform.sellers.show', compact('seller'));
    }

    /**
     * Approve seller -> status ACTIVE (sesuai SRS).
     */
    public function approve(Seller $seller): RedirectResponse
    {
        $seller->status = 'active';
        $seller->save();

        Mail::to($seller->user->email)->send(new SellerApprovedMail($seller));

        return back()->with('status', 'Penjual berhasil diaktifkan.');
    }

    /**
     * Reject seller -> status REJECTED.
     */
    public function reject(Seller $seller): RedirectResponse
    {
        $seller->status = 'rejected';
        $seller->save();

        Mail::to($seller->user->email)->send(new SellerRejectedMail($seller));

        return back()->with('status', 'Penjual berhasil ditolak.');
    }
}