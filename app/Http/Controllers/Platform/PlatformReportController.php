<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PlatformReportController extends Controller
{
    // (SRS-MartPlace-09)
    // Laporan daftar akun penjual berdasarkan status
    public function sellersStatus()
    {
        $generatedAt = now();
        $processedBy = Auth::user()->name;

        // Ambil data seller dengan relasi user
        $sellers = Seller::with('user')
            ->select(
                'id',
                'user_id',
                'picName',
                'storeName',
                'status'
            )
            // urutkan: yang aktif dulu, baru yang lain
            ->orderByRaw("status = 'active' DESC")
            ->orderBy('picName')
            ->get();

        return view('platform.reports.sellers-status', [
            'sellers'     => $sellers,
            'generatedAt' => $generatedAt,
            'processedBy' => $processedBy,
            'export'      => false,   // supaya tombol "Unduh PDF" MUNCUL di web
        ]);
    }

    // Download PDF laporan akun penjual
    public function sellersStatusPdf()
    {
        $generatedAt = now();
        $processedBy = Auth::user()->name;

        $sellers = Seller::with('user')
            ->select(
                'id',
                'user_id',
                'picName',
                'storeName',
                'status'
            )
            ->orderByRaw("status = 'active' DESC")
            ->orderBy('picName')
            ->get();

        $pdf = Pdf::loadView('platform.reports.pdf.sellers-status', [
                'sellers'     => $sellers,
                'generatedAt' => $generatedAt,
                'processedBy' => $processedBy,
                'export'      => true,   // flag: PDF → tombol "Unduh PDF" disembunyikan
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-akun-penjual-'.now()->format('Ymd_His').'.pdf');
    }

    // (SRS-MartPlace-10)
    // Laporan daftar toko berdasarkan lokasi provinsi (WEB)
    public function storesByProvince()
    {
        $generatedAt = now();
        $processedBy = Auth::user()->name;

        $stores = Seller::query()
            ->select(
                'storeName as store_name',   // alias ke snake_case
                'picName as pic_name',
                'picProvince as province'
            )
            ->orderBy('picProvince')
            ->orderBy('storeName')
            ->get();

        return view('platform.reports.stores-by-province', [
            'stores'      => $stores,
            'generatedAt' => $generatedAt,
            'processedBy' => $processedBy,
            'export'      => false,  // kalau di view mau pakai flag ini juga
        ]);
    }

    // Laporan daftar toko berdasarkan lokasi provinsi (PDF)
    public function storesByProvincePdf()
    {
        $generatedAt = now();
        $processedBy = Auth::user()->name;

        $stores = Seller::query()
            ->select(
                'storeName as store_name',
                'picName as pic_name',
                'picProvince as province'
            )
            ->orderBy('picProvince')
            ->orderBy('storeName')
            ->get();

        $pdf = Pdf::loadView('platform.reports.pdf.stores-by-province', [
                'stores'      => $stores,
                'generatedAt' => $generatedAt,
                'processedBy' => $processedBy,
                'export'      => true,
            ])
            ->setPaper('A4', 'portrait'); // <- tadi typo "potrait"

        return $pdf->download('laporan-toko-per-provinsi-'.now()->format('Ymd_His').'.pdf');
    }

    // (SRS-MartPlace-11)
    // Laporan produk + rating, diurutkan rating menurun (WEB)
    public function productsByRating()
    {
        $generatedAt = now();
        $processedBy = Auth::user()->name;

        $rows = Review::query()
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('sellers', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
            ->selectRaw('
                products.name        as product_name,
                products.category    as category,
                products.price       as price,
                reviews.rating       as rating,
                sellers.storeName    as store_name,
                users.provinsi       as reviewer_province
            ')
            ->orderByDesc('reviews.rating')
            ->orderBy('products.name')
            ->get();

        return view('platform.reports.products-by-rating', [
            'rows'        => $rows,
            'generatedAt' => $generatedAt,
            'processedBy' => $processedBy,
            'export'      => false,   // pakai pola sama kalau view-nya butuh
        ]);
    }

    // Laporan produk + rating (PDF)
    public function productsByRatingPdf()
    {
        $generatedAt = now();
        $processedBy = Auth::user()->name;

        $rows = Review::query()
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->join('sellers', 'products.seller_id', '=', 'sellers.id')
            ->leftJoin('users', 'reviews.user_id', '=', 'users.id')
            ->selectRaw('
                products.name      AS product_name,
                products.category  AS category,
                products.price     AS price,
                reviews.rating     AS rating,
                sellers.storeName  AS store_name,
                users.provinsi     AS reviewer_province
            ')
            ->orderByDesc('reviews.rating')
            ->orderBy('products.name')
            ->get();

        // kalau kamu punya view khusus PDF, bisa ganti ke:
        // 'platform.reports.pdf.products-by-rating'
        $pdf = Pdf::loadView('platform.reports.pdf.products-by-rating', [
                'rows'        => $rows,
                'generatedAt' => $generatedAt,
                'processedBy' => $processedBy,
                'export'      => true,   // kalau di Blade mau hide tombol, dll.
            ])
            ->setPaper('A4', 'portrait');

        return $pdf->download('laporan-produk-berdasarkan-rating-'.now()->format('Ymd_His').'.pdf');
    }
}
