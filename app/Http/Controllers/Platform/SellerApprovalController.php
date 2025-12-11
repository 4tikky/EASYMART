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
        // ---- Ringkasan verifikasi seller dari tabel USERS ----
        $pendingCount  = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', 'pending')->count();
        $activeCount   = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', 'approved')->count();
        $rejectedCount = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', 'rejected')->count();

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

        // 2) Sebaran jumlah toko berdasarkan provinsi (dari users yang approved)
        $sellerByProvince = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', 'approved')
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
        $sellerActiveCount   = $activeCount;
        $sellerInactiveCount = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', '!=', 'approved')->count();

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

        // Data untuk tabel-tabel dashboard
        // Tabel Status Penjual
        $recentSellers = User::where('role', User::ROLE_PENJUAL)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        // Tabel Rating Produk - hitung dari reviews
        $topProducts = Product::with('seller')
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->take(5)
            ->get();

        // Tabel Lokasi Toko
        $recentStores = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', 'approved')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('platform.dashboard', compact(
            'pendingCount',
            'activeCount',
            'rejectedCount',
            'productByCategory',
            'sellerByProvince',
            'sellerActiveCount',
            'sellerInactiveCount',
            'totalReviews',
            'totalReviewVisitors',
            'recentSellers',
            'topProducts',
            'recentStores'
        ));
    }

    /**
     * Daftar seller berdasarkan status (DEFAULT: pending).
     * -> INILAH HALAMAN VERIFIKASI PENJUAL
     */
    public function index(Request $request): View
    {
        $status = $request->query('status', 'pending');
        
        // Map status untuk users table
        $statusMap = [
            'pending' => 'pending',
            'active' => 'approved',
            'rejected' => 'rejected',
        ];
        
        $userStatus = $statusMap[$status] ?? 'pending';

        $sellers = User::where('role', User::ROLE_PENJUAL)
            ->where('status_verifikasi', $userStatus)
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
    public function show($id): View
    {
        $seller = User::where('role', User::ROLE_PENJUAL)->findOrFail($id);
        return view('platform.sellers.show', compact('seller'));
    }

    /**
     * Approve seller -> status APPROVED dan create record di tabel sellers.
     */
    public function approve($id): RedirectResponse
    {
        $user = User::where('role', User::ROLE_PENJUAL)->findOrFail($id);
        
        // Update status di users
        $user->status_verifikasi = 'approved';
        $user->save();
        
        // Buat record di tabel sellers (untuk relasi dengan products)
        if (!$user->seller) {
            Seller::create([
                'user_id' => $user->id,
                'storeName' => $user->nama_toko,
                'storeDescription' => $user->deskripsi_singkat,
                'picName' => $user->name,
                'picPhone' => $user->no_handphone_pic,
                'picEmail' => $user->email,
                'picStreet' => $user->alamat_pic,
                'picRT' => $user->rt,
                'picRW' => $user->rw,
                'picVillage' => $user->nama_kelurahan,
                'picCity' => $user->kabupaten_kota,
                'picProvince' => $user->provinsi,
                'picKtpNumber' => $user->no_ktp_pic,
                'picPhotoPath' => $user->foto_pic,
                'picKtpFilePath' => $user->file_upload_ktp_pic,
                'status' => 'active',
            ]);
        }

        Mail::to($user->email)->send(new SellerApprovedMail($user));

        return back()->with('status', 'Penjual berhasil diaktifkan.');
    }

    /**
     * Reject seller -> status REJECTED.
     */
    public function reject($id): RedirectResponse
    {
        $user = User::where('role', User::ROLE_PENJUAL)->findOrFail($id);
        
        $user->status_verifikasi = 'rejected';
        $user->save();

        Mail::to($user->email)->send(new SellerRejectedMail($user));

        return back()->with('status', 'Penjual berhasil ditolak.');
    }
}