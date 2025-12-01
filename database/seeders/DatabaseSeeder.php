<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Seller; // Pastikan model Seller ada
use App\Models\Product; // Pastikan model Product ada
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed categories first
        $this->call(CategorySeeder::class);

        // 1. Akun PEMBELI (User Biasa)
        User::create([
            'name' => 'Nanda Pembeli',
            'email' => 'pembeli@easymart.com',
            'password' => Hash::make('password'),
        ]);

        // 2. Akun PENJUAL (Langsung Aktif & Punya Toko)
        $sellerUser = User::create([
            'name' => 'Princess Nanda', // Nama Pemilik Akun
            'email' => 'seller@easymart.com', // Email Login
            'password' => Hash::make('password'),
        ]);

        // Buat Data Toko untuk User di atas
        $seller = Seller::create([
            'user_id' => $sellerUser->id,
            'storeName' => 'Nanda Knitting Shop',
            'storeDescription' => 'Toko rajutan terbaik se-Undip!',
            'picName' => 'Princess Nanda',
            'picPhone' => '081234567890',
            'picEmail' => 'business@nanda.com',
            'picStreet' => 'Jl. Tembalang No. 1',
            'picRT' => '01',
            'picRW' => '02',
            'picVillage' => 'Tembalang',
            'picCity' => 'Semarang',
            'picProvince' => 'Jawa Tengah',
            'picKtpNumber' => '3374123456789000',
            'status' => 'active', // <--- PENTING: Langsung AKTIF biar bisa masuk dashboard
        ]);

        // 3. Tambah Produk Contoh (Biar Dashboard ada isinya)
        Product::create([
            'seller_id' => $seller->id,
            'name' => 'Cardigan Rajut Premium',
            'description' => 'Cardigan rajut bahan lembut, cocok untuk kuliah.',
            'price' => 150000,
            'stock' => 25,
            'category' => 'Pakaian Wanita',
            'image' => null, // Nanti bisa diisi manual kalau mau upload gambar
        ]);

        Product::create([
            'seller_id' => $seller->id,
            'name' => 'Topi Kupluk Lucu',
            'description' => 'Topi hangat untuk musim hujan.',
            'price' => 45000,
            'stock' => 10,
            'category' => 'Aksesoris',
            'image' => null,
        ]);
        
        // 4. Akun ADMIN PLATFORM (Ceritanya Admin)
        User::create([
            'name' => 'Admin Platform',
            'email' => 'admin@easymart.com',
            'password' => Hash::make('password'),
            // Kalau nanti ada kolom 'role', tambahkan: 'role' => 'admin'
        ]);
    }
}