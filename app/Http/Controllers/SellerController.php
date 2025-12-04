<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Models\Seller;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use App\Mail\SellerRegisteredMail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class SellerController extends Controller
{
    // Fungsi untuk mengecek status toko saat tombol diklik
    public function checkStore()
    {
        $user = Auth::user();
        Log::info('checkStore called by user: ' . $user->id);

        // 1. Cek apakah user sudah punya data toko?
        if (!$user->seller) {
            Log::info('No seller found, redirecting to register');
            // Kalau belum, arahkan ke halaman Registrasi
            return redirect()->route('seller.register');
        }

        Log::info('Seller found - Status: ' . $user->seller->status . ', Store: ' . $user->seller->storeName);

        // 2. Kalau sudah punya, cek statusnya
        if ($user->seller->status == 'pending') {
            Log::info('Seller status pending, showing waiting page');
            // Kalau status masih pending, tampilkan halaman menunggu
            return view('auth.seller-waiting'); // File yang kamu screenshot tadi
        }

        // 3. Kalau aktif, masuk ke Dashboard
        Log::info('Seller status active, redirecting to dashboard');
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
        Log::info('Seller registration attempt by user: ' . Auth::id());
        
        // Validasi input
        $validated = $request->validate([
            'storeName' => 'required|string|max:255',
            'storeDescription' => 'nullable|string',
            'picName' => 'required|string|max:255',
            'picPhone' => 'required|string|max:20',
            'picEmail' => 'required|email|max:255',
            'picStreet' => 'required|string|max:255',
            'picRT' => 'nullable|string|max:10',
            'picRW' => 'nullable|string|max:10',
            'picVillage' => 'nullable|string|max:100',
            'picCity' => 'required|string|max:100',
            'picProvince' => 'required|string|max:100',
            'picKtpNumber' => 'required|digits:16',
            'picPhotoPath' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'picKtpFilePath' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'picKtpNumber.required' => 'Nomor KTP wajib diisi',
            'picKtpNumber.digits' => 'NIK harus 16 digit angka',
        ]);

        // Upload foto jika ada
        if ($request->hasFile('picPhotoPath')) {
            $validated['picPhotoPath'] = $request->file('picPhotoPath')->store('seller-photos', 'public');
        }

        if ($request->hasFile('picKtpFilePath')) {
            $validated['picKtpFilePath'] = $request->file('picKtpFilePath')->store('seller-ktp', 'public');
        }

        // Simpan ke database
        $seller = new Seller($validated);
        $seller->user_id = Auth::id();
        $seller->status = 'pending'; // Default status pending
        $seller->save();

        Log::info('Seller registered successfully - ID: ' . $seller->id . ', Store: ' . $seller->storeName);

        // Kirim email konfirmasi pendaftaran
        try {
            Mail::to($seller->picEmail)->send(new SellerRegisteredMail($seller));
            Log::info('Registration confirmation email sent to: ' . $seller->picEmail);
        } catch (\Exception $e) {
            Log::error('Failed to send registration email: ' . $e->getMessage());
            // Tetap lanjutkan meskipun email gagal
        }

        return redirect()->route('seller.check')->with('success', 'Pendaftaran berhasil! Silakan cek email Anda untuk konfirmasi.');
    }
    public function dashboard()
    {
        try {
            // 1. Ambil data Seller milik user yang login
            $user = Auth::user();
            Log::info('Dashboard access attempt by user: ' . $user->id . ' (email: ' . $user->email . ')');
            
            $seller = $user->seller;
            
            if ($seller) {
                Log::info('Seller found - ID: ' . $seller->id . ', Store: ' . $seller->storeName . ', Status: ' . $seller->status);
            } else {
                Log::warning('No seller data found for user ' . $user->id);
            }

            // 2. Cek apakah seller ada & statusnya active
            if (!$seller) {
                Log::info('Redirecting to seller.check - No seller data');
                return redirect()->route('seller.check')->with('error', 'Data toko tidak ditemukan'); 
            }
            
            if ($seller->status !== 'active') {
                Log::info('Redirecting to seller.check - Status is: ' . $seller->status);
                return redirect()->route('seller.check')->with('error', 'Toko Anda belum diaktifkan'); 
            }
            
            Log::info('Seller validation passed, loading dashboard...');

        // 3. Ambil produk dengan relasi reviews
        $products = $seller->products()->withAvg('reviews', 'rating')->get(); 

        // 4. Hitung statistik
        $totalProducts = $products->count();
        $totalStock = $products->sum('stock');
        $totalValue = $products->sum(function($product) {
            return $product->price * $product->stock;
        });
        $lowStockProducts = $products->where('stock', '<', 10)->count();
        
        // Average rating
        $averageRating = $products->avg('reviews_avg_rating') ?? 0;
        
        // Products by category (for chart)
        $categoryData = $products->groupBy('category')->map(function($group) {
            return $group->count();
        });
        
        // Siapkan data untuk grafik
        $productNames = $products->pluck('name')->toArray();
        $productStocks = $products->pluck('stock')->toArray();
        $productRatings = $products->map(function($product) {
            return round($product->reviews_avg_rating ?? 0, 1);
        })->toArray();
        
        // Sales data for weekly chart (simulasi - bisa diganti dengan data real dari orders)
        $weeklySales = [
            'Mon' => rand(400, 700),
            'Tue' => rand(400, 700),
            'Wed' => rand(400, 700),
            'Thu' => rand(400, 700),
            'Fri' => rand(400, 700),
            'Sat' => rand(400, 700),
            'Sun' => rand(400, 700),
        ];
        
        // Data untuk grafik baru
        // 1. Sebaran jumlah stok per produk (Histogram)
        $stockDistribution = [
            '0-10' => $products->whereBetween('stock', [0, 10])->count(),
            '11-25' => $products->whereBetween('stock', [11, 25])->count(),
            '26-50' => $products->whereBetween('stock', [26, 50])->count(),
            '51-100' => $products->whereBetween('stock', [51, 100])->count(),
            '100+' => $products->where('stock', '>', 100)->count(),
        ];
        
        // 2. Sebaran nilai rating per produk (Rating Distribution)
        $ratingDistribution = [
            '5 Star' => $products->filter(fn($p) => ($p->reviews_avg_rating ?? 0) >= 4.5)->count(),
            '4 Star' => $products->filter(fn($p) => ($p->reviews_avg_rating ?? 0) >= 3.5 && ($p->reviews_avg_rating ?? 0) < 4.5)->count(),
            '3 Star' => $products->filter(fn($p) => ($p->reviews_avg_rating ?? 0) >= 2.5 && ($p->reviews_avg_rating ?? 0) < 3.5)->count(),
            '2 Star' => $products->filter(fn($p) => ($p->reviews_avg_rating ?? 0) >= 1.5 && ($p->reviews_avg_rating ?? 0) < 2.5)->count(),
            '1 Star' => $products->filter(fn($p) => ($p->reviews_avg_rating ?? 0) >= 0.1 && ($p->reviews_avg_rating ?? 0) < 1.5)->count(),
            'No Rating' => $products->filter(fn($p) => ($p->reviews_avg_rating ?? 0) == 0)->count(),
        ];
        
        // 3. Sebaran pemberi rating berdasarkan provinsi
        $reviewsByProvince = DB::table('reviews')
            ->join('products', 'reviews.product_id', '=', 'products.id')
            ->where('products.seller_id', $seller->id)
            ->whereNotNull('reviews.provinsi')
            ->select('reviews.provinsi', DB::raw('count(*) as total'))
            ->groupBy('reviews.provinsi')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get()
            ->mapWithKeys(function($item) {
                return [$item->provinsi ?? 'Unknown' => $item->total];
            });
        
        // Fallback jika tidak ada data reviews dengan provinsi
        if ($reviewsByProvince->isEmpty()) {
            $reviewsByProvince = collect(['Belum ada data' => 0]);
        }

        // 5. Ambil kategori untuk form
        $categories = Category::where('is_active', true)->orderBy('name')->get();

        // 6. Kirim data ke View
        return view('seller.dashboard', compact(
            'seller', 
            'products', 
            'productNames', 
            'productStocks', 
            'productRatings',
            'totalProducts',
            'totalStock',
            'totalValue',
            'lowStockProducts',
            'averageRating',
            'categoryData',
            'weeklySales',
            'stockDistribution',
            'ratingDistribution',
            'reviewsByProvince',
            'categories'
        ));
    } catch (\Exception $e) {
        Log::error('Dashboard error for user ' . Auth::id() . ': ' . $e->getMessage());
        return redirect()->route('seller.check')->with('error', 'Terjadi kesalahan saat memuat dashboard');
    }
}

    // --- FUNGSI BARU: MENYIMPAN PRODUK DARI POP-UP ---
    public function storeProduct(Request $request)
    {
        try {
            // 1. Validasi Input
            $request->validate([
                'name' => 'required|string|max:255',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'category' => 'required',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Multiple images
            ], [
                'price.min' => 'Harga tidak boleh negatif',
                'price.numeric' => 'Harga harus berupa angka',
                'stock.min' => 'Stok tidak boleh negatif',
                'stock.integer' => 'Stok harus berupa bilangan bulat',
                'images.*.image' => 'File harus berupa gambar',
                'images.*.max' => 'Ukuran gambar maksimal 2MB',
            ]);

            // 2. Proses Upload Gambar Utama (backward compatibility)
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');
            }

            // 3. Masukkan Produk ke Database
            $product = Product::create([
                'seller_id' => Auth::user()->seller->id,
                'name' => $request->name,
                'price' => $request->price,
                'stock' => $request->stock,
                'category' => $request->category,
                'description' => $request->description,
                'image' => $imagePath,
            ]);

            // 4. Upload Multiple Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $imageFile) {
                    $path = $imageFile->store('products', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'order' => $index + 1,
                        'is_primary' => $index === 0 && !$imagePath, // Set first as primary if no main image
                    ]);
                }
            }

            // 5. Return JSON response
            return response()->json([
                'success' => true,
                'message' => 'Yeay! Produk berhasil ditambahkan!'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $e->validator->errors()->all())
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan produk: ' . $e->getMessage()
            ], 500);
        }
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
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
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
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
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
