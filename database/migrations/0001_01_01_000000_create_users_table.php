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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            
            // --- Data Login & PIC (Person in Charge) ---
            $table->string('name'); // Untuk "3. Nama PIC"
            $table->string('email')->unique(); // Untuk "5. email PIC"
            
            // Untuk verifikasi email (SRS-MartPlace-02)
            $table->timestamp('email_verified_at')->nullable(); 
            $table->string('password');
            
            // --- Role & Status Verifikasi ---
            // Role: 'penjual' atau 'platform'
            $table->string('role')->default('penjual'); 
            
            // Status untuk (SRS-MartPlace-02)
            $table->string('status_verifikasi')->default('pending'); // Opsi: 'pending', 'disetujui', 'ditolak'
            
            
            // --- Elemen Data Registrasi Penjual (toko) ---
            // [Semua field di bawah ini dibuat nullable() agar user 'platform' tidak wajib mengisinya]
            
            $table->string('nama_toko')->nullable(); // 1. Nama toko
            $table->text('deskripsi_singkat')->nullable(); // 2. Deskripsi singkat
            $table->string('no_handphone_pic')->nullable(); // 4. No Handphone PIC
            $table->string('alamat_pic')->nullable(); // 6. Alamat (nama jalan) PIC
            $table->string('rt')->nullable(); // 7. RT
            $table->string('rw')->nullable(); // 8. RW
            $table->string('nama_kelurahan')->nullable(); // 9. Nama kelurahan
            $table->string('kabupaten_kota')->nullable(); // 10. Kabupaten/Kota
            $table->string('propinsi')->nullable(); // 11. Propinsi
            $table->string('no_ktp_pic')->nullable(); // 12. No. KTP PIC
            $table->string('foto_pic')->nullable(); // 13. Foto PIC (disimpan sbg path file)
            $table->string('file_upload_ktp_pic')->nullable(); // 14. File upload KTP PIC (disimpan sbg path file)

            $table->rememberToken();
            
            // Timestamps (created_at) juga mencatat tanggal pendaftaran (SRS-MartPlace-02)
            $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};