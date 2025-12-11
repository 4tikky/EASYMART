<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'id' => 1,
                'seller_id' => 1,
                'name' => 'Cardigan Rajut Premium',
                'description' => 'Cardigan rajut bahan lembut, cocok untuk kuliah.',
                'price' => 150000.00,
                'stock' => 25,
                'category' => 'Pakaian Wanita',
                'image' => 'products/HSJ3JtQ5rDqha8zbkCVwWBDGnOhXd6pSr4PNN8xk.png',
                'created_at' => '2025-12-11 02:39:24',
                'updated_at' => '2025-12-11 05:59:20'
            ],
            [
                'id' => 2,
                'seller_id' => 1,
                'name' => 'Topi Kupluk Lucu',
                'description' => 'Topi hangat untuk musim hujan.',
                'price' => 45000.00,
                'stock' => 10,
                'category' => 'Aksesoris',
                'image' => 'products/fdWPS5mpcDbpijIEUDdquyVOgpv38GU6I9oj1LEF.jpg',
                'created_at' => '2025-12-11 02:39:24',
                'updated_at' => '2025-12-11 05:56:03'
            ],
            [
                'id' => 3,
                'seller_id' => 1,
                'name' => 'Topi Rajut',
                'description' => 'Topi rajut handmade',
                'price' => 20000.00,
                'stock' => 10,
                'category' => 'Rajutan',
                'image' => 'products/ViOSnF5LSbqpbjrXWEgQWTJFXs5qxhYY5BoaLeMw.jpg',
                'created_at' => '2025-12-11 05:55:06',
                'updated_at' => '2025-12-11 05:55:06'
            ],
            [
                'id' => 4,
                'seller_id' => 4,
                'name' => 'Kaos Polos Premium',
                'description' => 'Kaos polos dengan bahan premium',
                'price' => 30000.00,
                'stock' => 20,
                'category' => 'Pakaian Pria',
                'image' => 'products/xuUYt0cStsuRbXYcjWaNfuGENjT5K8HAFlIL4EqD.jpg',
                'created_at' => '2025-12-11 08:28:12',
                'updated_at' => '2025-12-11 08:28:12'
            ],
            [
                'id' => 5,
                'seller_id' => 4,
                'name' => 'Kemeja Kuliah Flanel',
                'description' => 'Kemeja flanel dengan motif tidak pasaran dan edisi terbatas dari Bramss store',
                'price' => 20000.00,
                'stock' => 10,
                'category' => 'Pakaian Pria',
                'image' => 'products/wkbcRdGVj2OpxSrHdWwa2kOpQ3XQa8CuSdXgqMmv.jpg',
                'created_at' => '2025-12-11 08:29:39',
                'updated_at' => '2025-12-11 08:29:39'
            ],
            [
                'id' => 6,
                'seller_id' => 4,
                'name' => 'Celana Cargo',
                'description' => 'Celana cargo kualitas premium',
                'price' => 50000.00,
                'stock' => 30,
                'category' => 'Pakaian Pria',
                'image' => 'products/0jN99mPMOiCv4tktUjdsdrWOISUgJ58jiMh4ygvy.jpg',
                'created_at' => '2025-12-11 08:33:45',
                'updated_at' => '2025-12-11 08:33:45'
            ],
            [
                'id' => 7,
                'seller_id' => 1,
                'name' => 'Rok Rajut Panjang',
                'description' => 'Rok kualitas eropa',
                'price' => 75000.00,
                'stock' => 5,
                'category' => 'Pakaian Wanita',
                'image' => 'products/lc5RI4LuPnnPFnXLcxNbMPYaMj3117AERchZPKot.jpg',
                'created_at' => '2025-12-11 08:36:03',
                'updated_at' => '2025-12-11 08:36:03'
            ],
            [
                'id' => 8,
                'seller_id' => 1,
                'name' => 'Vest Rajut Eropa',
                'description' => 'Vest dengan rajutan dari bulu mata bidadari',
                'price' => 35000.00,
                'stock' => 50,
                'category' => 'Pakaian Wanita',
                'image' => 'products/K6ukujxSUhdnkoAVCwAyf1eBc6QXYNm2ptZQSdZe.jpg',
                'created_at' => '2025-12-11 08:37:13',
                'updated_at' => '2025-12-11 08:37:13'
            ]
        ]);
    }
}
