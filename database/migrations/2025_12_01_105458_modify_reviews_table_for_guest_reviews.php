<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Hapus semua foreign key constraint dulu
            $table->dropForeign(['product_id']);
            $table->dropForeign(['user_id']);
        });
        
        Schema::table('reviews', function (Blueprint $table) {
            // Hapus unique constraint setelah foreign key dihapus
            $table->dropUnique('reviews_product_id_user_id_unique');
            
            // Ubah user_id menjadi nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Tambah kembali foreign key
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            
            // Tambah kolom untuk guest reviewer
            $table->string('guest_name')->nullable()->after('user_id');
            $table->string('guest_email')->nullable()->after('guest_name');
            $table->string('guest_phone')->nullable()->after('guest_email');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reviews', function (Blueprint $table) {
            // Kembalikan perubahan
            $table->dropForeign(['user_id']);
            $table->dropColumn(['guest_name', 'guest_email', 'guest_phone']);
            $table->unsignedBigInteger('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unique(['product_id', 'user_id']);
        });
    }
};
