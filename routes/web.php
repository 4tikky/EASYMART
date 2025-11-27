<?php

use App\Models\User;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Platform\SellerApprovalController;
use App\Mail\SellerApprovedMail;
use App\Mail\SellerRejectedMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\SellerController;

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

    });

Route::get('/register/waiting', function () {
    return view('auth.seller-waiting');
})->name('seller.register.waiting');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

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

});


require __DIR__.'/auth.php';
