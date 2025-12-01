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
            // Hapus foreign key constraint dulu
            $table->dropForeign(['user_id']);
            
            // Hapus unique constraint
            $table->dropUnique(['product_id', 'user_id']);
            
            // Ubah user_id menjadi nullable
            $table->unsignedBigInteger('user_id')->nullable()->change();
            
            // Tambah kembali foreign key tapi nullable
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
