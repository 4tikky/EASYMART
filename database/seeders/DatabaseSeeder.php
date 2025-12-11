<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Seed data yang sudah ada di database
        $this->call([
            // Indonesia location data (order matters!)
            IndonesiaProvincesTableSeeder::class,
            IndonesiaCitiesTableSeeder::class,
            IndonesiaDistrictsTableSeeder::class,
            IndonesiaVillagesTableSeeder::class,
            
            // Master data
            CategoriesTableSeeder::class,
            
            // User & Seller data
            UsersTableSeeder::class,
            SellersTableSeeder::class,
            
            // Product data
            ProductsTableSeeder::class,
            ProductImagesTableSeeder::class,
            
            // Review data
            ReviewsTableSeeder::class,
        ]);
    }
}
