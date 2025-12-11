<?php
use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Platform\SellerApprovalController;
use App\Http\Controllers\Platform\PlatformReportController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LocationController;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

// ==========================================
// PUBLIC ROUTES (No Authentication Required)
// ==========================================

// Homepage
Route::get('/', function () {
    $products = Product::with('seller')
        ->withAvg('reviews', 'rating')
        ->latest()
        ->get(); 
    
    return view('welcome', compact('products'));
});

// Product Routes
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{product}/reviews', [ProductController::class, 'storeReview'])->name('products.reviews.store');

// API endpoint untuk get active categories (untuk seller)
Route::get('/api/categories', [CategoryController::class, 'getActiveCategories'])->name('api.categories');

// Location AJAX Routes
Route::get('/locations/regencies/{province}', [LocationController::class, 'getRegencies'])->name('locations.regencies');
Route::get('/locations/districts/{city}', [LocationController::class, 'getDistricts'])->name('locations.districts');
Route::get('/locations/villages/{district}', [LocationController::class, 'getVillages'])->name('locations.villages');

Route::get('/register/waiting', function () {
    return view('auth.seller-waiting');
})->name('seller.register.waiting');

// ==========================================
// AUTHENTICATED ROUTES
// ==========================================

Route::middleware('auth')->group(function () {
    
    // Dashboard - Auto redirect based on role
    Route::get('/dashboard', function () {
        $user = Auth::user();
        
        // Redirect platform admin ke platform dashboard
        if ($user->role === 'platform') {
            return redirect('/platform/dashboard');
        }
        
        // Redirect seller ke seller dashboard
        if ($user->seller) {
            return redirect('/seller/dashboard');
        }
        
        // User biasa (pembeli) redirect ke home
        return redirect('/');
    })->middleware('verified')->name('dashboard');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Delete Review (only for logged in users)
    Route::delete('/products/{product}/reviews/{review}', [ProductController::class, 'destroyReview'])->name('products.reviews.destroy');
    
    // Seller Routes
    Route::get('/toko-saya', [SellerController::class, 'checkStore'])->name('seller.check');
    Route::get('/seller/register', [SellerController::class, 'create'])->name('seller.register');
    Route::post('/seller/register', [SellerController::class, 'store'])->name('seller.store');
    
    Route::get('/seller/dashboard', [SellerController::class, 'dashboard'])->name('seller.dashboard');
    
    // Product Management
    Route::post('/seller/product', [SellerController::class, 'storeProduct'])->name('seller.product.store');
    Route::get('/seller/product/{id}/edit', [SellerController::class, 'editProduct'])->name('seller.product.edit');
    Route::put('/seller/product/{id}', [SellerController::class, 'updateProduct'])->name('seller.product.update');
    Route::delete('/seller/product/{id}', [SellerController::class, 'deleteProduct'])->name('seller.product.delete');
    
    // Export PDF Reports
    Route::get('/seller/export/stock', [SellerController::class, 'exportStockReport'])->name('seller.export.stock');
    Route::get('/seller/export/rating', [SellerController::class, 'exportRatingReport'])->name('seller.export.rating');
    Route::get('/seller/export/reorder', [SellerController::class, 'exportReorderReport'])->name('seller.export.reorder');
});

// ==========================================
// PLATFORM ADMIN ROUTES
// ==========================================

Route::middleware(['auth', 'platform'])
    ->prefix('platform')
    ->name('platform.')
    ->group(function () {
        // Dashboard
        Route::get('/dashboard', [SellerApprovalController::class, 'dashboard'])->name('dashboard');
        
        // Seller Management
        Route::get('/sellers', [SellerApprovalController::class, 'index'])->name('sellers.index');
        Route::get('/sellers/{id}', [SellerApprovalController::class, 'show'])->name('sellers.show');
        Route::post('/sellers/{id}/approve', [SellerApprovalController::class, 'approve'])->name('sellers.approve');
        Route::post('/sellers/{id}/reject', [SellerApprovalController::class, 'reject'])->name('sellers.reject');
        
        // Category Management
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
        Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
        Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
        Route::post('/categories/{category}/toggle', [CategoryController::class, 'toggleStatus'])->name('categories.toggle');
        
        // Reports
        Route::get('/reports/sellers-status', [PlatformReportController::class, 'sellersStatus'])->name('reports.sellers-status');
        Route::get('/reports/sellers-status/pdf', [PlatformReportController::class, 'sellersStatusPdf'])->name('reports.sellers-status.pdf');
        Route::get('/reports/stores-by-province', [PlatformReportController::class, 'storesByProvince'])->name('reports.stores-by-province');
        Route::get('/reports/stores-by-province/pdf', [PlatformReportController::class, 'storesByProvincePdf'])->name('reports.stores-by-province.pdf');
        Route::get('/reports/products-by-rating', [PlatformReportController::class, 'productsByRating'])->name('reports.products-by-rating');
        Route::get('/reports/products-by-rating/pdf', [PlatformReportController::class, 'productsByRatingPdf'])->name('reports.products-by-rating.pdf');
    });

require __DIR__.'/auth.php';