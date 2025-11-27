<?php
// database/migrations/2025_11_27_000000_create_products_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // produk milik seller
            $table->foreignId('seller_id')
                  ->constrained('sellers')
                  ->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            // kategori: bisa foreign key ke tabel categories kalau sudah ada
            $table->unsignedBigInteger('category_id')->nullable();

            $table->unsignedBigInteger('price');         // harga satuan
            $table->unsignedInteger('stock');            // stok tersedia

            $table->enum('condition', ['new', 'used'])->default('new');

            $table->integer('weight')->default(0); // gram

            $table->text('description')->nullable();

            // gambar
            $table->string('main_image')->nullable();   // path gambar utama
            $table->json('extra_images')->nullable();   // path gambar tambahan (array)

            $table->string('status')->default('active'); // active / inactive / draft

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
