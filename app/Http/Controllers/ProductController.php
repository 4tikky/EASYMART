<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Search products by name, description, category, or seller store name
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        // Jika query kosong, redirect ke homepage
        if (empty($query)) {
            return redirect('/');
        }
        
        // Search produk berdasarkan nama, deskripsi, kategori, atau nama toko
        $products = Product::with('seller')
            ->where(function($q) use ($query) {
                // Search di nama produk, deskripsi, dan kategori
                $q->where('name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%")
                  ->orWhere('category', 'LIKE', "%{$query}%")
                  // Search di nama toko (storeName)
                  ->orWhereHas('seller', function($sellerQuery) use ($query) {
                      $sellerQuery->where('storeName', 'LIKE', "%{$query}%");
                  });
            })
            ->latest()
            ->paginate(12);
        
        return view('products.search', [
            'products' => $products,
            'query' => $query,
            'total' => $products->total()
        ]);
    }
    
    /**
     * Show product detail
     */
    public function show(Product $product)
    {
        $product->load(['seller', 'reviews.user']);
        
        // Get related products from same seller
        $relatedProducts = Product::where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();
        
        // Check if current user already reviewed this product (untuk logged in user)
        $userReview = null;
        if (Auth::check()) {
            $userReview = Review::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();
        }
        
        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'userReview' => $userReview
        ]);
    }

    /**
     * Store a review for a product
     */
    public function storeReview(Request $request, Product $product)
    {
        // Validasi input
        $rules = [
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ];

        // Jika user belum login, wajib isi data guest
        if (!Auth::check()) {
            $rules['guest_name'] = 'required|string|max:255';
            $rules['guest_email'] = 'required|email|max:255';
            $rules['guest_phone'] = 'required|string|max:20';
        }

        $validated = $request->validate($rules);

        if (Auth::check()) {
            // User yang sudah login
            $existingReview = Review::where('product_id', $product->id)
                ->where('user_id', Auth::id())
                ->first();

            if ($existingReview) {
                // Update review yang sudah ada
                $existingReview->update([
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'] ?? null,
                ]);
                return redirect()->back()->with('success', 'Review berhasil diperbarui!');
            } else {
                // Buat review baru
                Review::create([
                    'product_id' => $product->id,
                    'user_id' => Auth::id(),
                    'rating' => $validated['rating'],
                    'comment' => $validated['comment'] ?? null,
                ]);
                return redirect()->back()->with('success', 'Review berhasil ditambahkan!');
            }
        } else {
            // Guest user - cek apakah email sudah pernah review produk ini
            $existingReview = Review::where('product_id', $product->id)
                ->where('guest_email', $validated['guest_email'])
                ->first();

            if ($existingReview) {
                return redirect()->back()->with('error', 'Email ini sudah pernah memberikan review untuk produk ini.');
            }

            // Buat review baru untuk guest
            Review::create([
                'product_id' => $product->id,
                'user_id' => null,
                'rating' => $validated['rating'],
                'comment' => $validated['comment'] ?? null,
                'guest_name' => $validated['guest_name'],
                'guest_email' => $validated['guest_email'],
                'guest_phone' => $validated['guest_phone'],
            ]);
            
            return redirect()->back()->with('success', 'Review berhasil ditambahkan!');
        }
    }

    /**
     * Delete a review
     */
    public function destroyReview(Product $product, Review $review)
    {
        // Pastikan user adalah pemilik review
        if ($review->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses untuk menghapus review ini');
        }

        $review->delete();
        return redirect()->back()->with('success', 'Review berhasil dihapus!');
    }
}