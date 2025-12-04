<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'description',
        'price',
        'stock',
        'category',
        'image',
    ];

    // Relasi: Produk dimiliki oleh satu Penjual (Seller)
    public function seller()
    {
        return $this->belongsTo(Seller::class); // Pastikan kamu punya model Seller
    }

    // Relasi: Produk memiliki banyak Gambar
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    // Relasi: Produk memiliki banyak Review
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Helper: Mendapatkan rata-rata rating
    public function averageRating()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    // Helper: Mendapatkan total review
    public function totalReviews()
    {
        return $this->reviews()->count();
    }
}