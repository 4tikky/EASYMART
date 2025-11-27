<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\Seller;
use App\Models\Product;


class SellerController extends Controller
{
    public function checkStore()
    {
        $user = Auth::user();
        $seller = $user->seller;

        // Kalau BELUM ada, buat otomatis dari data di tabel users
        if (!$seller) {
            $seller = Seller::create([
                'user_id'          => $user->id,
                'storeName'        => $user->nama_toko ?? 'Toko Tanpa Nama',
                'storeDescription' => $user->deskripsi_singkat ?? '',
                'picName'          => $user->name ?? '',
                'picPhone'         => $user->no_handphone_pic ?? '',
                'picEmail'         => $user->email ?? '',
                'picStreet'        => $user->alamat_pic ?? '',
                'picRT'            => $user->rt ?? '',
                'picRW'            => $user->rw ?? '',
                'picVillage'       => $user->nama_kelurahan ?? '',
                'picCity'          => $user->kabupaten_kota ?? '',
                'picProvince'      => $user->provinsi ?? 'Belum diisi',
                'picKtpNumber'     => $user->no_ktp_pic ?? '',
                'picPhotoPath'     => $user->foto_pic ?? '',
                'picKtpFilePath'   => $user->file_upload_ktp_pic ?? '',
                'status'           => $user->status_verifikasi === 'active'
                                        ? 'active'
                                        : 'pending',
            ]);
        }
        // Kalau statusnya bukan active → tampilkan halaman tunggu verifikasi
        if (strtolower($seller->status) !== 'active') {
            return view('auth.seller-waiting', compact('seller'));
        }

        // Kalau sudah active → MASUK ke dashboard seller
        return redirect()->route('seller.dashboard');
    }

    public function dashboard()
    {
        $user = Auth::user();
        $seller = $user->seller;

        if (!$seller || $seller->status !== 'ACTIVE') { // cek sesuai isi kolom di DB (ACTIVE / active)
            return redirect()->route('seller.check');
        }

        // Ambil produk
        $products = Product::where('seller_id', $seller->id)->get();

        $productNames   = $products->pluck('name')->toArray();
        $productStocks  = $products->pluck('stock')->toArray();
        $productRatings = []; // nanti diisi kalau sudah ada fitur rating

        return view('seller.dashboard', compact(
            'seller',
            'products',
            'productNames',
            'productStocks',
            'productRatings'
        ));
    }

    // --- FUNGSI BARU: MENYIMPAN PRODUK DARI POP-UP ---
    public function storeProduct(Request $request)
    {
        // 1. Validasi Input (Biar datanya aman)
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|numeric|min:0',
            'category' => 'required',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ], [
            'name.required' => 'Nama produk wajib diisi.',
            'price.required' => 'Harga produk wajib diisi.',
            'price.min' => 'Harga produk minimal adalah 0.',
            'stock.required' => 'Stok produk wajib diisi.',
            'stock.min' => 'Stok produk minimal adalah 0.',
            'category.required' => 'Kategori produk wajib dipilih.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'image.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 2. Proses Upload Gambar (Kalau user upload foto)
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Foto akan disimpan di folder: storage/app/public/products
            $imagePath = $request->file('image')->store('products', 'public');
        }

        // 3. Mapping kategori teks → angka (sesuai selera, sementara hardcode saja)
        $categoryMap = [
            'Pakaian Wanita' => 1,
            'Pakaian Pria'   => 2,
            'Aksesoris'      => 3,
            'Rajutan'        => 4,
        ];
        $categoryId = $categoryMap[$request->category] ?? null;

        // 4. Simpan ke database pakai kolom yang ADA di migration
        Product::create([
            'seller_id'   => Auth::user()->seller->id,
            'name'        => $request->name,
            'slug'        => Str::slug($request->name) . '-' . Str::random(6),
            'category_id' => $categoryId,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'condition'   => 'new',                // default dulu
            'weight'      => 0,                    // default dulu
            'description' => $request->description,
            'main_image'  => $imagePath,           // ✅ pakai main_image
            'status'      => 'active',
        ]);

        // 4. Kembali ke Dashboard dengan pesan sukses
        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Yeay! Produk berhasil ditambahkan! 🌸');
    }
    public function editProduct(Product $product)
    {
        $seller = Auth::user()->seller;

        // Pastikan produk ini milik seller yang login
        if ($product->seller_id !== $seller->id) {
            abort(403);
        }

        return view('seller.product-edit', compact('seller', 'product'));
    }
    public function updateProduct(Request $request, Product $product)
    {
        $seller = Auth::user()->seller;
        if ($product->seller_id !== $seller->id) {
            abort(403);
        }

        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|numeric',
            'stock'       => 'required|integer',
            'description' => 'nullable|string',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);
        
        if ($request->hasFile('image')) {
            $validated['main_image'] = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'name'        => $request->name,
            'price'       => $request->price,
            'stock'       => $request->stock,
            'description' => $request->description,
            'slug'        => Str::slug($request->name), // kalau mau sekalian update slug
        ]);

        return redirect()->route('seller.dashboard')
                        ->with('success', 'Produk berhasil diperbarui ✨');
    }

    public function destroy(Product $product)
    {
        $seller = Auth::user()->seller;

        // Pastikan produk memang milik seller yang login
        if (!$seller || $product->seller_id !== $seller->id) {
            abort(403, 'Kamu tidak boleh menghapus produk ini.');
        }

        // Kalau ada foto, hapus dari storage
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        // Hapus product dari database
        $product->delete();

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil dihapus 🌸');
    }
}