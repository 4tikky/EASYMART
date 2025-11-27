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
}