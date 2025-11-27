<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Menghubungkan Produk ke Tabel Penjual (Sellers)
            // Penting: Pastikan nama tabelnya 'sellers' sesuai yang kamu buat sebelumnya
            $table->foreignId('seller_id')->constrained('sellers')->onDelete('cascade');
            
            // Data Produk (Sesuai Referensi Tokopedia & SRS)
            $table->string('name');             // Nama Produk
            $table->text('description');        // Deskripsi
            $table->integer('price');           // Harga (SRS-MartPlace-11)
            $table->integer('stock');           // Stok (SRS-MartPlace-12)
            $table->string('category');         // Kategori (SRS-MartPlace-05)
            $table->string('image')->nullable(); // Foto Produk
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
