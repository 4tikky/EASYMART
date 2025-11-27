<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;

class SellerController extends Controller
{
    // Fungsi untuk mengecek status toko saat tombol diklik
    public function checkStore()
    {
        $user = Auth::user();

        // 1. Cek apakah user sudah punya data toko?
        if (!$user->seller) {
            // Kalau belum, arahkan ke halaman Registrasi
            return redirect()->route('seller.register');
        }

        // 2. Kalau sudah punya, cek statusnya
        if ($user->seller->status == 'pending') {
            // Kalau status masih pending, tampilkan halaman menunggu
            return view('auth.seller-waiting'); // File yang kamu screenshot tadi
        }

        // 3. Kalau aktif, masuk ke Dashboard
        return redirect()->route('seller.dashboard');
    }

    // Menampilkan Form Pendaftaran
    public function create()
    {
        return view('seller.register'); // Kita harus buat file ini nanti
    }

    // Menyimpan Data Pendaftaran (Sesuai SRS Elemen Data)
    public function store(Request $request)
    {
        // Validasi input (sesuaikan dengan kolom di database)
        $validated = $request->validate([
            'storeName' => 'required|string|max:255',
            'picName' => 'required|string',
            'picPhone' => 'required',
            // ... tambahkan validasi lain sesuai kolom database kamu ...
        ]);

        // Simpan ke database
        $seller = new Seller($validated);
        $seller->user_id = Auth::id(); // Hubungkan dengan user yang login
        $seller->save();

        return redirect()->route('seller.check'); // Cek ulang statusnya
    }
    public function dashboard()
    {
        // 1. Ambil data Seller milik user yang login
        // Kita pakai 'seller' karena di model User fungsinya public function seller()
        $seller = Auth::user()->seller; 

        // 2. Cek apakah seller ada & statusnya active
        if (!$seller || $seller->status !== 'active') {
            return redirect()->route('seller.check'); 
        }

        // 3. Ambil produk untuk grafik (SRS-MartPlace-08)
        // Kita asumsikan relasi di model Seller namanya products()
        $products = $seller->products; 

        // Siapkan data sederhana untuk grafik
        $productNames = $products->pluck('name')->toArray();
        $productStocks = $products->pluck('stock')->toArray();
        $productRatings = []; // Kosongin dulu kalau belum ada fitur review

        // 4. Kirim data ke View
        // Perhatikan kita kirim variabel '$seller', bukan '$store' biar konsisten
        return view('seller.dashboard', compact('seller', 'products', 'productNames', 'productStocks', 'productRatings'));
    }
}