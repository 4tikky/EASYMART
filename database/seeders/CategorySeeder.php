<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pakaian Wanita',
                'description' => 'Koleksi pakaian wanita seperti dress, blouse, rok, celana, dan lainnya',
                'is_active' => true
            ],
            [
                'name' => 'Pakaian Pria',
                'description' => 'Koleksi pakaian pria seperti kemeja, kaos, celana, jaket, dan lainnya',
                'is_active' => true
            ],
            [
                'name' => 'Aksesoris',
                'description' => 'Berbagai aksesoris fashion seperti tas, topi, syal, ikat pinggang, dan lainnya',
                'is_active' => true
            ],
            [
                'name' => 'Rajutan',
                'description' => 'Produk rajutan handmade seperti sweater, cardigan, syal rajut, dan lainnya',
                'is_active' => true
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
