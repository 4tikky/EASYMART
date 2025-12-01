<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Seller;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

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
        $products = $seller->products()->withAvg('reviews', 'rating')->get(); 

        // Siapkan data untuk grafik
        $productNames = $products->pluck('name')->toArray();
        $productStocks = $products->pluck('stock')->toArray();
        $productRatings = $products->map(function($product) {
            return round($product->reviews_avg_rating ?? 0, 1);
        })->toArray();

        // 4. Kirim data ke View
        return view('seller.dashboard', compact('seller', 'products', 'productNames', 'productStocks', 'productRatings'));
    }
    // --- FUNGSI BARU: MENYIMPAN PRODUK DARI POP-UP ---
    public function storeProduct(Request $request)
    {
        // 1. Validasi Input (Biar datanya aman)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ], [
            'price.min' => 'Harga tidak boleh negatif',
            'price.numeric' => 'Harga harus berupa angka',
            'stock.min' => 'Stok tidak boleh negatif',
            'stock.integer' => 'Stok harus berupa bilangan bulat',
        ]);

        // 2. Proses Upload Gambar (Kalau user upload foto)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Foto akan disimpan di folder: storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Masukkan ke Database
        Product::create([
            'seller_id' => Auth::user()->seller->id, // Otomatis ambil ID toko milik user login
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        // 4. Kembali ke Dashboard dengan pesan sukses
        return redirect()->route('seller.dashboard')->with('success', 'Yeay! Produk berhasil ditambahkan!');
    }

    // Edit Produk
    public function editProduct($id)
    {
        $product = Product::where('id', $id)
            ->where('seller_id', Auth::user()->seller->id)
            ->firstOrFail();

        return response()->json($product);
    }

    // Update Produk
    public function updateProduct(Request $request, $id)
    {
        $product = Product::where('id', $id)
            ->where('seller_id', Auth::user()->seller->id)
            ->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category' => 'required|string|max:100',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update gambar jika ada
        $imagePath = $product->image;
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && \Storage::disk('public')->exists($product->image)) {
                \Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'stock' => $request->stock,
            'category' => $request->category,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil diupdate!');
    }

    // Hapus Produk
    public function deleteProduct($id)
    {
        $product = Product::where('id', $id)
            ->where('seller_id', Auth::user()->seller->id)
            ->firstOrFail();

        // Hapus gambar jika ada
        if ($product->image && \Storage::disk('public')->exists($product->image)) {
            \Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil dihapus!');
    }

    // Export PDF - Laporan Berdasarkan Stock
    public function exportStockReport()
    {
        $seller = Auth::user()->seller;
        $products = Product::where('seller_id', $seller->id)
            ->withAvg('reviews', 'rating')
            ->orderBy('stock', 'desc')
            ->get();

        $pdf = Pdf::loadView('seller.reports.stock', [
            'products' => $products,
            'seller' => $seller,
            'date' => Carbon::now()->format('d-m-Y'),
            'time' => Carbon::now()->format('H:i:s'),
        ]);

        return $pdf->download('Laporan_Stock_' . Carbon::now()->format('d-m-Y') . '.pdf');
    }

    // Export PDF - Laporan Berdasarkan Rating
    public function exportRatingReport()
    {
        $seller = Auth::user()->seller;
        $products = Product::where('seller_id', $seller->id)
            ->withAvg('reviews', 'rating')
            ->orderBy('reviews_avg_rating', 'desc')
            ->get();

        $pdf = Pdf::loadView('seller.reports.rating', [
            'products' => $products,
            'seller' => $seller,
            'date' => Carbon::now()->format('d-m-Y'),
            'time' => Carbon::now()->format('H:i:s'),
        ]);

        return $pdf->download('Laporan_Rating_' . Carbon::now()->format('d-m-Y') . '.pdf');
    }

    // Export PDF - Laporan Produk Segera Dipesan (Stock Rendah)
    public function exportReorderReport()
    {
        $seller = Auth::user()->seller;
        $products = Product::where('seller_id', $seller->id)
            ->where('stock', '<', 10) // Produk dengan stock < 10
            ->orderBy('stock', 'asc')
            ->get();

        $pdf = Pdf::loadView('seller.reports.reorder', [
            'products' => $products,
            'seller' => $seller,
            'date' => Carbon::now()->format('d-m-Y'),
            'time' => Carbon::now()->format('H:i:s'),
        ]);

        return $pdf->download('Laporan_Reorder_' . Carbon::now()->format('d-m-Y') . '.pdf');
    }
}
