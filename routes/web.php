<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/seller/dashboard', function () {
    return view('seller.dashboard'); // sementara boleh view sederhana
})->name('seller.dashboard')->middleware('auth');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); // sementara
})->name('admin.dashboard')->middleware('auth');

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

require __DIR__.'/auth.php';
