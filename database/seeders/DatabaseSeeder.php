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
            'role' => User::ROLE_PENJUAL,
        ]);

        // Buat Data Toko untuk User di atas
        $seller = Seller::create([
            'user_id' => $sellerUser->id,
            'storeName' => 'Nanda Knitting Shop',
            'storeDescription' => 'Toko rajutan terbaik se-Undip!',
            'picName' => 'Princess Nanda',
            'picPhone' => '081234567890',
            'picStreet' => 'Jl. Tembalang No. 1',
            'picRT' => '01',
            'picRW' => '02',
            'picVillage' => 'Tembalang',
            'picCity' => 'Semarang',
            'picProvince' => 'Jawa Tengah',
            'picKtpNumber' => '3374123456789000',
            'picPhotoPath' => 'seller/seller-nanda/Senku.jpg',
            'picKtpFilePath' => 'seller/seller-nanda/ktp_indo.webp',
            'status' => 'pending',
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
        
        // 3. Akun PENJUAL PENDING 1
        $pendingSeller1 = User::create([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PENJUAL,
        ]);

        Seller::create([
            'user_id' => $pendingSeller1->id,
            'storeName' => 'Toko Budi Electronic',
            'storeDescription' => 'Jual elektronik murah meriah',
            'picName' => 'Budi Santoso',
            'picPhone' => '082345678901',
            'picStreet' => 'Jl. Gatot Subroto No. 45',
            'picRT' => '03',
            'picRW' => '05',
            'picVillage' => 'Pleburan',
            'picCity' => 'Semarang',
            'picProvince' => 'Jawa Tengah',
            'picKtpNumber' => '3374567890123456',
            'picPhotoPath' => null,
            'picKtpFilePath' => null,
            'status' => 'pending',
        ]);

        // 4. Akun PENJUAL PENDING 2
        $pendingSeller2 = User::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'password' => Hash::make('password'),
            'role' => User::ROLE_PENJUAL,
        ]);

        Seller::create([
            'user_id' => $pendingSeller2->id,
            'storeName' => 'Warung Siti Fashion',
            'storeDescription' => 'Fashion wanita modern',
            'picName' => 'Siti Aminah',
            'picPhone' => '083456789012',
            'picStreet' => 'Jl. Pemuda No. 88',
            'picRT' => '02',
            'picRW' => '03',
            'picVillage' => 'Simpang Lima',
            'picCity' => 'Semarang',
            'picProvince' => 'Jawa Tengah',
            'picKtpNumber' => '3374098765432100',
            'picPhotoPath' => null,
            'picKtpFilePath' => null,
            'status' => 'pending',
        ]);

        // 5. Akun ADMIN PLATFORM
        User::create([
            'name' => 'Admin Platform',
            'email' => 'admin@easymart.com',
            'password' => Hash::make('password'),
            'role' => 'platform',
        ]);
    }
}