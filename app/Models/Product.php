<?php

// app/Models/Product.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'seller_id',
        'name',
        'slug',
        'category_id',
        'price',
        'stock',
        'condition',
        'weight',
        'description',
        'main_image',
        'extra_images',
        'status',
    ];

    protected $casts = [
        'extra_images' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name) . '-' . Str::random(6);
            }
        });
    }

    public function seller()
    {
        return $this->belongsTo(Seller::class);
    }

    public function deleteProduct()
    {
        $seller = Auth::user()->seller;

        // Pastikan produk memang milik seller yang login
        if (!$seller || $this->seller_id !== $seller->id) {
            abort(403, 'Kamu tidak boleh menghapus produk ini.');
        }

        // Kalau ada foto, hapus juga dari storage
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }

        // Hapus produk
        $this->delete();

        return redirect()
            ->route('seller.dashboard')
            ->with('success', 'Produk berhasil dihapus. 🌸');
    }


    // nanti dipakai SRS-04
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }


}
