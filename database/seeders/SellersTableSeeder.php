<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SellersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sellers')->insert([
            [
                'id' => 1,
                'user_id' => 2,
                'storeName' => 'Nanda Knitting Shop',
                'storeDescription' => 'Toko rajutan terbaik se-Undip!',
                'picName' => 'Princess Nanda',
                'picPhone' => 081234567890,
                'picEmail' => null,
                'picStreet' => 'Jl. Tembalang No. 1',
                'picRT' => 01,
                'picRW' => 02,
                'picVillage' => 'Tembalang',
                'picCity' => 'Semarang',
                'picProvince' => 'Jawa Tengah',
                'picKtpNumber' => 3374123456789000,
                'picPhotoPath' => 'seller/seller-nanda/Senku.jpg',
                'picKtpFilePath' => 'seller/seller-nanda/ktp_indo.webp',
                'status' => 'active',
                'created_at' => '2025-12-11 02:39:24',
                'updated_at' => '2025-12-11 02:39:24'
            ],
            [
                'id' => 2,
                'user_id' => 3,
                'storeName' => 'Toko Budi Electronic',
                'storeDescription' => 'Jual elektronik murah meriah',
                'picName' => 'Budi Santoso',
                'picPhone' => 082345678901,
                'picEmail' => null,
                'picStreet' => 'Jl. Gatot Subroto No. 45',
                'picRT' => 03,
                'picRW' => 05,
                'picVillage' => 'Pleburan',
                'picCity' => 'Semarang',
                'picProvince' => 'Jawa Tengah',
                'picKtpNumber' => 3374567890123456,
                'picPhotoPath' => null,
                'picKtpFilePath' => null,
                'status' => 'pending',
                'created_at' => '2025-12-11 02:39:24',
                'updated_at' => '2025-12-11 02:39:24'
            ],
            [
                'id' => 3,
                'user_id' => 4,
                'storeName' => 'Warung Siti Fashion',
                'storeDescription' => 'Fashion wanita modern',
                'picName' => 'Siti Aminah',
                'picPhone' => 083456789012,
                'picEmail' => null,
                'picStreet' => 'Jl. Pemuda No. 88',
                'picRT' => 02,
                'picRW' => 03,
                'picVillage' => 'Simpang Lima',
                'picCity' => 'Semarang',
                'picProvince' => 'Jawa Tengah',
                'picKtpNumber' => 3374098765432100,
                'picPhotoPath' => null,
                'picKtpFilePath' => null,
                'status' => 'pending',
                'created_at' => '2025-12-11 02:39:25',
                'updated_at' => '2025-12-11 02:39:25'
            ],
            [
                'id' => 4,
                'user_id' => 10,
                'storeName' => 'Test',
                'storeDescription' => 'Test',
                'picName' => 'Test',
                'picPhone' => 081081081081,
                'picEmail' => 'bramantyo989@gmail.com',
                'picStreet' => 'Jalan jalan',
                'picRT' => 002,
                'picRW' => 004,
                'picVillage' => 'NATAH',
                'picCity' => 'KABUPATEN GUNUNGKIDUL',
                'picProvince' => 'DAERAH ISTIMEWA YOGYAKARTA',
                'picKtpNumber' => 3322332233223322,
                'picPhotoPath' => 'foto_pic/ygz4ddi7KZN3E2jEw5zZceFMiUrJcgAORkhVBBbr.jpg',
                'picKtpFilePath' => null,
                'status' => 'active',
                'created_at' => '2025-12-11 03:38:20',
                'updated_at' => '2025-12-11 03:38:20'
            ]
        ]);
    }
}
