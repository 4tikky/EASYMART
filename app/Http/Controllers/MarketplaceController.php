<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class MarketplaceController extends Controller
{
    // Halaman beranda (tanpa pencarian ⇒ Katalog Terbaru)
    public function index()
    {
        $products = Product::with(['seller'])
            ->withAvg('reviews', 'rating')
            ->orderByDesc('created_at')
            ->paginate(12);

        return view('welcome', [
            'products' => $products,
            'keyword'  => null,  // supaya variabel selalu ada
        ]);
    }

    // Pencarian produk (SRS-MartPlace-05)
    public function search(Request $request)
    {
        $keyword = trim($request->input('q'));

        if ($keyword === '') {
            // kalau kotak search kosong, balik ke beranda saja
            return redirect()->route('home');
        }

        $products = Product::with(['seller', 'category'])
            ->withAvg('reviews', 'rating')
            ->where(function ($query) use ($keyword) {
                // 1. Nama produk
                $query->where('name', 'like', "%{$keyword}%")

                    // // 2. Nama kategori produk
                    // ->orWhereHas('category', function ($q) use ($keyword) {
                    //     $q->where('name', 'like', "%{$keyword}%");
                    // })

                    // 3. Nama toko
                    // 4. Lokasi toko (kabupaten/kota & provinsi)
                    ->orWhereHas('seller', function ($q) use ($keyword) {
                        $q->where('storeName', 'like', "%{$keyword}%")
                          ->orWhere('picCity', 'like', "%{$keyword}%")
                          ->orWhere('picProvince', 'like', "%{$keyword}%");
                    });
            })
            ->orderByDesc('created_at')
            ->paginate(12)
            ->withQueryString();   // biar ?q=... tetap ada saat ganti halaman

        return view('welcome', [
            'products' => $products,
            'keyword'  => $keyword,
        ]);
    }
}
