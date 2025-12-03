<?php
use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Platform\SellerApprovalController;
use App\Http\Controllers\Platform\PlatformReportController;
use App\Mail\SellerApprovedMail;
use App\Mail\SellerRejectedMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use App\Http\Controllers\LocationController;


Route::get('/test-email', function () {
    $user = User::where('role', 'penjual')->first();
    Mail::to($user->email)->send(new SellerApprovedMail($user));
    return 'Email test terkirim (kalau tidak ada error di layar).';
});

Route::middleware(['auth', 'platform'])
    ->prefix('platform')
    ->name('platform.')
    ->group(function () {
    // Dashboard ringkasan seller
        Route::get('/dashboard', [SellerApprovalController::class, 'dashboard'])
            ->name('dashboard');
        // Daftar seller per status
        Route::get('/sellers', [SellerApprovalController::class, 'index'])
            ->name('sellers.index');
        // Detail satu seller
        Route::get('/sellers/{seller}', [SellerApprovalController::class, 'show'])
            ->name('sellers.show');
        // Approve seller
        Route::post('/sellers/{seller}/approve', [SellerApprovalController::class, 'approve'])
            ->name('sellers.approve');
        // Reject seller
        Route::post('/sellers/{seller}/reject', [SellerApprovalController::class, 'reject'])
            ->name('sellers.reject');

        // SRS-MartPlace-09: laporan seller per status
        Route::get('/reports/sellers-status', [PlatformReportController::class, 'sellersStatus'])
            ->name('reports.sellers-status');

        Route::get('/reports/sellers-status/pdf', [PlatformReportController::class, 'sellersStatusPdf'])
            ->name('reports.sellers-status.pdf');

        // SRS-MartPlace-10: laporan toko per provinsi
        Route::get('/reports/stores-by-province', [PlatformReportController::class, 'storesByProvince'])
            ->name('reports.stores-by-province');

        Route::get('/reports/stores-by-province/pdf', [PlatformReportController::class, 'storesByProvincePdf'])
            ->name('reports.stores-by-province.pdf');

        // SRS-MartPlace-11: laporan produk berdasarkan rating
        Route::get('/reports/products-by-rating', [PlatformReportController::class, 'productsByRating'])
            ->name('reports.products-by-rating');

        Route::get('/reports/products-by-rating/pdf', [PlatformReportController::class, 'productsByRatingPdf'])
            ->name('reports.products-by-rating.pdf');
    });

// Category Management Routes (Platform Admin)
use App\Http\Controllers\CategoryController;
Route::middleware(['auth', 'platform'])
    ->prefix('platform')
    ->name('platform.')
    ->group(function () {
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
    });

// API endpoint untuk get active categories (untuk seller)
Route::get('/api/categories', [CategoryController::class, 'getActiveCategories'])->name('api.categories');

Route::get('/register/waiting', function () {
    return view('auth.seller-waiting');
})->name('seller.register.waiting');

Route::get('/', function () {
    $products = Product::with('seller')->latest()->get(); 
    
    return view('welcome', compact('products'));
});

// Route untuk Search Produk
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

// Route untuk Detail Produk (opsional, jika belum ada)
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Route untuk Review Produk (tidak perlu login lagi)
Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])->name('products.reviews.store');

// Route untuk hapus review (hanya untuk logged in user)
Route::middleware('auth')->group(function () {
    Route::delete('/products/{product}/reviews/{review}', [ProductController::class, 'destroyReview'])->name('products.reviews.destroy');
});

Route::get('/dashboard', function () {
    $user = Auth::user();
    
    // Redirect platform admin ke platform dashboard
    if ($user->role === 'platform') {
        return redirect()->route('platform.dashboard');
    }
    
    // Redirect seller ke seller dashboard
    if ($user->seller) {
        return redirect()->route('seller.dashboard');
    }
    
    // User biasa (pembeli) redirect ke home
    return redirect('/');
})->middleware(['auth', 'verified'])->name('dashboard');

// ====== ROUTE AJAX WILAYAH (INI YANG PENTING) ======
Route::get('/locations/regencies/{province}', [LocationController::class, 'getRegencies'])
    ->name('locations.regencies');

Route::get('/locations/districts/{city}', [LocationController::class, 'getDistricts'])
    ->name('locations.districts');

Route::get('/locations/villages/{district}', [LocationController::class, 'getVillages'])
    ->name('locations.villages');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Logout route
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');

Route::middleware(['auth'])->group(function () {
    
    // 1. Pintu Masuk Utama (Klik "Toko Saya")
    Route::get('/toko-saya', [SellerController::class, 'checkStore'])->name('seller.check');
    
    // 2. Halaman Registrasi Toko
    Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
    
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    
    // 2. TAMBAHKAN INI: Form Upload Produk
    //Route::get('/seller/product/create', [SellerController::class, 'createProduct'])->name('seller.product.create');
    
    // 3. TAMBAHKAN INI: Proses Simpan Produk
    Route::post('/seller/product', [SellerController::class, 'storeProduct'])->name('seller.product.store');
    
    // Edit Produk
    Route::get('/seller/product/{id}/edit', [SellerController::class, 'editProduct'])->name('seller.product.edit');
    Route::put('/seller/product/{id}', [SellerController::class, 'updateProduct'])->name('seller.product.update');
    
    // Hapus Produk
    Route::delete('/seller/product/{id}', [SellerController::class, 'deleteProduct'])->name('seller.product.delete');
    
    // Export PDF Reports
    Route::get('/seller/export/stock', [SellerController::class, 'exportStockReport'])->name('seller.export.stock');
    Route::get('/seller/export/rating', [SellerController::class, 'exportRatingReport'])->name('seller.export.rating');
    Route::get('/seller/export/reorder', [SellerController::class, 'exportReorderReport'])->name('seller.export.reorder');
});

require __DIR__.'/auth.php';