<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('reviews')->insert([
            [
                'id' => 1,
                'product_id' => 1,
                'user_id' => null,
                'guest_name' => 'Bramss',
                'guest_email' => 'bramantyokn989@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 5,
                'comment' => 'kainnya kelihatan bagus dan tebal',
                'provinsi' => 'DI Yogyakarta',
                'created_at' => '2025-12-11 05:50:00',
                'updated_at' => '2025-12-11 05:50:00'
            ],
            [
                'id' => 2,
                'product_id' => 1,
                'user_id' => null,
                'guest_name' => 'Nanda',
                'guest_email' => 'ananda123@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 5,
                'comment' => 'harganya mahal banget',
                'provinsi' => 'DKI Jakarta',
                'created_at' => '2025-12-11 05:50:43',
                'updated_at' => '2025-12-11 05:50:43'
            ],
            [
                'id' => 3,
                'product_id' => 1,
                'user_id' => null,
                'guest_name' => 'Oyen',
                'guest_email' => 'Oyen123@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 4,
                'comment' => 'jahitannya kurang rapi',
                'provinsi' => 'Jawa Tengah',
                'created_at' => '2025-12-11 06:00:35',
                'updated_at' => '2025-12-11 06:00:35'
            ],
            [
                'id' => 4,
                'product_id' => 3,
                'user_id' => null,
                'guest_name' => 'Oyen',
                'guest_email' => 'Oyen123@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 5,
                'comment' => 'Lucu modelnya',
                'provinsi' => 'Jawa Tengah',
                'created_at' => '2025-12-11 06:01:31',
                'updated_at' => '2025-12-11 06:01:31'
            ],
            [
                'id' => 5,
                'product_id' => 3,
                'user_id' => null,
                'guest_name' => 'Bramss',
                'guest_email' => 'bramantyoknk989@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 5,
                'comment' => 'Udah pesen sesuai ukuran yang dateng kekecilan',
                'provinsi' => 'DI Yogyakarta',
                'created_at' => '2025-12-11 06:02:04',
                'updated_at' => '2025-12-11 06:02:04'
            ],
            [
                'id' => 6,
                'product_id' => 3,
                'user_id' => null,
                'guest_name' => 'Jojon',
                'guest_email' => 'JoJo7o7@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 3,
                'comment' => 'barang saya lama sampai',
                'provinsi' => 'Jawa Timur',
                'created_at' => '2025-12-11 06:02:42',
                'updated_at' => '2025-12-11 06:02:42'
            ],
            [
                'id' => 7,
                'product_id' => 2,
                'user_id' => null,
                'guest_name' => 'Jojon',
                'guest_email' => 'JoJo7o7@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 2,
                'comment' => 'kurang sesuai dengan gambar',
                'provinsi' => 'Jawa Timur',
                'created_at' => '2025-12-11 06:03:02',
                'updated_at' => '2025-12-11 06:03:02'
            ],
            [
                'id' => 8,
                'product_id' => 2,
                'user_id' => null,
                'guest_name' => 'Bramss',
                'guest_email' => 'bramantyokn989@gmail.com',
                'guest_phone' => 019392908390,
                'rating' => 5,
                'comment' => 'sellernya amanah',
                'provinsi' => 'DI Yogyakarta',
                'created_at' => '2025-12-11 06:03:17',
                'updated_at' => '2025-12-11 06:03:17'
            ]
        ]);
    }
}
