<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

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
        $product->load('seller');
        
        // Get related products from same seller
        $relatedProducts = Product::where('seller_id', $product->seller_id)
            ->where('id', '!=', $product->id)
            ->latest()
            ->limit(4)
            ->get();
        
        return view('products.show', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}