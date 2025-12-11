<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'id' => 1,
                'name' => 'Pakaian Wanita',
                'slug' => 'pakaian-wanita',
                'description' => 'Koleksi pakaian wanita seperti dress, blouse, rok, celana, dan lainnya',
                'is_active' => 1,
                'created_at' => '2025-12-11 02:39:23',
                'updated_at' => '2025-12-11 02:39:23'
            ],
            [
                'id' => 2,
                'name' => 'Pakaian Pria',
                'slug' => 'pakaian-pria',
                'description' => 'Koleksi pakaian pria seperti kemeja, kaos, celana, jaket, dan lainnya',
                'is_active' => 1,
                'created_at' => '2025-12-11 02:39:23',
                'updated_at' => '2025-12-11 02:39:23'
            ],
            [
                'id' => 3,
                'name' => 'Aksesoris',
                'slug' => 'aksesoris',
                'description' => 'Berbagai aksesoris fashion seperti tas, topi, syal, ikat pinggang, dan lainnya',
                'is_active' => 1,
                'created_at' => '2025-12-11 02:39:23',
                'updated_at' => '2025-12-11 02:39:23'
            ],
            [
                'id' => 4,
                'name' => 'Rajutan',
                'slug' => 'rajutan',
                'description' => 'Produk rajutan handmade seperti sweater, cardigan, syal rajut, dan lainnya',
                'is_active' => 1,
                'created_at' => '2025-12-11 02:39:23',
                'updated_at' => '2025-12-11 02:39:23'
            ]
        ]);
    }
}
