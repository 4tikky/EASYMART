<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductImagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_images')->insert([
            [
                'id' => 1,
                'product_id' => 3,
                'image_path' => 'products/XmKDk2KQSMepLyFumZJg2MOIE0vW9FHaCG05p7oC.jpg',
                'order' => 1,
                'is_primary' => 0,
                'created_at' => '2025-12-11 05:55:06',
                'updated_at' => '2025-12-11 05:55:06'
            ],
            [
                'id' => 2,
                'product_id' => 3,
                'image_path' => 'products/R0dpxGbob35KXwqUXYAw0838VgSrnAeDAb36cyhk.jpg',
                'order' => 2,
                'is_primary' => 0,
                'created_at' => '2025-12-11 05:55:06',
                'updated_at' => '2025-12-11 05:55:06'
            ]
        ]);
    }
}
