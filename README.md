# 🛒 EASYMART - Marketplace Platform

Platform marketplace modern berbasis Laravel yang memungkinkan penjual mengelola toko online mereka dengan mudah dan pembeli dapat memberikan review produk.

## ✨ Fitur Utama

### 🏪 Untuk Penjual (Seller)
- **Dashboard Analytics**
  - Statistik total produk, stok, dan status toko
  - Grafik visualisasi stok produk (Bar Chart)
  - Grafik rata-rata rating produk (Line Chart)
  
- **Manajemen Produk**
  - Upload produk dengan gambar
  - Edit produk (nama, harga, stok, kategori, deskripsi, gambar)
  - Hapus produk dengan konfirmasi
  - Validasi harga & stok (tidak boleh negatif)
  
- **Sistem Pelaporan PDF**
  - 📊 Laporan Produk Berdasarkan Stock (urut terbesar)
  - ⭐ Laporan Produk Berdasarkan Rating (urut tertinggi)
  - ⚠️ Laporan Produk Segera Dipesan (stock < 10, highlight kritis)
  
- **Registrasi & Approval**
  - Pendaftaran toko dengan data lengkap
  - Sistem approval oleh platform admin
  - Email notifikasi approval/rejection

### 🛍️ Untuk Pembeli (Customer)
- **Browsing Produk**
  - Tampilan grid produk dengan gambar
  - Search produk by nama
  - Filter kategori
  - Lihat detail produk lengkap
  
- **Sistem Review & Rating**
  - Rating 1-5 bintang dengan visual interaktif
  - Komentar produk
  - Review tanpa login (guest review dengan nama, email, no HP)
  - Review untuk user yang sudah login
  - Hapus review sendiri

### 👨‍💼 Untuk Platform Admin
- **Dashboard Ringkasan**
  - Total seller per status (pending, active, rejected)
  - Statistik keseluruhan
  
- **Manajemen Seller**
  - Lihat daftar seller berdasarkan status
  - Detail informasi seller
  - Approve/Reject pendaftaran seller
  - Kirim email otomatis ke seller

## 🚀 Instalasi

### Prasyarat
- PHP >= 8.2
- Composer
- Node.js & NPM
- MySQL Database
- Git

### Langkah Instalasi

1. **Clone Repository**
   ```bash
   git clone <repository-url>
   cd EASYMART
   ```

2. **Install Dependencies PHP**
   ```bash
   composer install
   ```

3. **Setup Environment**
   ```bash
   # Windows PowerShell
   copy .env.example .env
   
   # Linux/Mac
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   
   Edit file `.env` dan sesuaikan dengan database lokal:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=easymart
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Konfigurasi Email (Opsional)**
   
   Untuk fitur email approval seller:
   ```env
   MAIL_MAILER=smtp
   MAIL_HOST=smtp.gmail.com
   MAIL_PORT=587
   MAIL_USERNAME=your-email@gmail.com
   MAIL_PASSWORD=your-app-password
   MAIL_ENCRYPTION=tls
   MAIL_FROM_ADDRESS=your-email@gmail.com
   MAIL_FROM_NAME="${APP_NAME}"
   ```

7. **Jalankan Migrasi Database**
   ```bash
   php artisan migrate
   ```

8. **Buat Storage Link**
   ```bash
   php artisan storage:link
   ```

9. **Install Dependencies Frontend**
   ```bash
   npm install
   ```

10. **Jalankan Aplikasi**
    
    Terminal 1 - Laravel Server:
    ```bash
    php artisan serve
    ```
    
    Terminal 2 - Vite Dev Server:
    ```bash
    npm run dev
    ```

11. **Akses Aplikasi**
    - Website: http://localhost:8000
    - Login/Register untuk mulai menggunakan

## 📦 Package Utama

- **Laravel 12.x** - Framework PHP
- **Laravel Breeze** - Authentication scaffolding
- **Tailwind CSS** - Styling
- **Alpine.js** - JavaScript framework
- **Chart.js** - Grafik & visualisasi
- **SweetAlert2** - Modal & alert interaktif
- **DomPDF** - Generator laporan PDF

## 🗂️ Struktur Database

### Users
- Role: pembeli, penjual, platform
- Authentication dengan Laravel Breeze

### Sellers
- Data toko penjual
- Status: pending, active, rejected
- Relasi dengan User

### Products
- Data produk
- Relasi dengan Seller
- Image storage

### Reviews
- Rating 1-5
- Komentar
- Support guest & authenticated user
- Relasi dengan Product & User

## 🎨 Teknologi Frontend

- **Tailwind CSS** - Utility-first CSS framework
- **Alpine.js** - Reactive components
- **Vite** - Build tool & bundler
- **Chart.js** - Data visualization
- **SweetAlert2** - Beautiful alerts

## 📊 Dashboard Seller Features

### Grafik Real-time
- Bar Chart untuk stok produk
- Line Chart untuk rating produk
- Data diupdate otomatis dari database

### Export PDF
3 jenis laporan dengan format profesional:
1. **Laporan Stock** - Semua produk urut berdasarkan stok
2. **Laporan Rating** - Semua produk urut berdasarkan rating
3. **Laporan Reorder** - Produk yang perlu segera dipesan ulang

Format PDF mencakup:
- Header dengan nama toko
- Tanggal & waktu generate
- Nama PIC dan user yang generate
- Tabel data lengkap
- Footer otomatis

## 🔐 Role & Permission

### Pembeli (Customer)
- Browse produk
- Review produk (login/guest)
- Search & filter

### Penjual (Seller)
- Registrasi toko
- Upload & kelola produk
- Lihat dashboard & analytics
- Export laporan PDF

### Platform Admin
- Approve/reject seller
- Kelola semua seller
- Send email notification

## 📧 Email Notifications

Sistem otomatis mengirim email ke seller saat:
- ✅ Toko diapprove
- ❌ Toko ditolak

Template email profesional dengan design menarik.

## 🛠️ Development

### Menjalankan Tests
```bash
php artisan test
```

### Build Production
```bash
npm run build
php artisan optimize
```

### Clear Cache
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## 📝 API Routes

### Public Routes
- `GET /` - Homepage dengan daftar produk
- `GET /products/{id}` - Detail produk
- `GET /products/search` - Search produk
- `POST /products/{id}/reviews` - Submit review

### Auth Routes (Seller)
- `GET /seller/dashboard` - Dashboard seller
- `POST /seller/product` - Upload produk
- `GET /seller/product/{id}/edit` - Get data produk
- `PUT /seller/product/{id}` - Update produk
- `DELETE /seller/product/{id}` - Hapus produk
- `GET /seller/export/stock` - Export PDF stock
- `GET /seller/export/rating` - Export PDF rating
- `GET /seller/export/reorder` - Export PDF reorder

### Platform Routes
- `GET /platform/dashboard` - Dashboard platform
- `GET /platform/sellers` - Daftar seller
- `POST /platform/sellers/{id}/approve` - Approve seller
- `POST /platform/sellers/{id}/reject` - Reject seller

## 🐛 Troubleshooting

### Error: "SQLSTATE[HY000] [1049] Unknown database"
```bash
# Buat database terlebih dahulu
mysql -u root -p
CREATE DATABASE easymart;
exit;

# Lalu jalankan migrasi
php artisan migrate
```

### Error: "The stream or file could not be opened"
```bash
# Fix permission storage
chmod -R 775 storage bootstrap/cache
```

### Error: "Vite manifest not found"
```bash
# Jalankan npm run dev di terminal terpisah
npm run dev
```

### Gambar Produk Tidak Muncul
```bash
# Pastikan storage link sudah dibuat
php artisan storage:link
```

## 📄 License

This project is open-sourced software licensed under the MIT license.

## 👥 Contributors

- Development Team - Initial work

## 📞 Support

Untuk bantuan dan pertanyaan:
- Email: support@easymart.com
- Issues: [GitHub Issues](repository-url/issues)

---

**EASYMART** - Your Modern Marketplace Solution 🚀
