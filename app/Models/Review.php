<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'comment',
        'guest_name',
        'guest_email',
        'guest_phone',
    ];

    protected $casts = [
        'rating' => 'integer',
    ];

    // Relasi: Review dimiliki oleh satu Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi: Review dimiliki oleh satu User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
