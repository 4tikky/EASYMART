Laravel Project Setup Guide

Panduan ini membantu Anda melakukan instalasi dan menjalankan proyek Laravel yang telah di-clone dari GitHub. Ikuti langkah-langkah berikut agar aplikasi dapat berjalan dengan baik di lingkungan lokal Anda.
1. Install dependencies PHP dengan Composer:
composer install

2. Copy file environment:
cp .env.example .env

Jika menggunakan PowerShell, gunakan:
copy .env.example .env

3. Generate application key:
php artisan key:generate

4. Atur konfigurasi database di file .env sesuai dengan database lokal Anda.

5. Jalankan migrasi database:
php artisan migratephp artisan migrate

6. Install dependencies frontend:
npm install

7. Jalankan server Laravel:
php artisan serve

8. Jalankan server frontend di terminal berbeda:
npm run dev
