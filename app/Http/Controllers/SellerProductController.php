<?php

// app/Http/Controllers/SellerProductController.php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SellerProductController extends Controller
{
    public function index()
    {
        $seller = Auth::user()->seller;

        $products = Product::where('seller_id', $seller->id)
            ->latest()
            ->paginate(12);

        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        return view('seller.products.create');
    }

    public function store(Request $request)
    {
        $seller = Auth::user()->seller;

        $validated = $request->validate([
            'name'        => ['required', 'string', 'max:255'],
            'category_id' => ['nullable', 'integer'],
            'price'       => ['required', 'integer', 'min:1'],
            'stock'       => ['required', 'integer', 'min:0'],
            'condition'   => ['required', 'in:new,used'],
            'weight'      => ['required', 'integer', 'min:0'],
            'description' => ['nullable', 'string'],
            'main_image'  => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
            'extra_images.*' => ['image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        // simpan gambar utama
        $mainImagePath = null;
        if ($request->hasFile('main_image')) {
            $mainImagePath = $request->file('main_image')
                ->store('products/main', 'public');
        }

        // simpan gambar tambahan
        $extraImagesPaths = [];
        if ($request->hasFile('extra_images')) {
            foreach ($request->file('extra_images') as $file) {
                $extraImagesPaths[] = $file->store('products/extra', 'public');
            }
        }

        Product::create([
            'seller_id'   => $seller->id,
            'name'        => $validated['name'],
            'slug'        => Str::slug($validated['name']) . '-' . Str::random(6),
            'category_id' => $validated['category_id'] ?? null,
            'price'       => $validated['price'],
            'stock'       => $validated['stock'],
            'condition'   => $validated['condition'],
            'weight'      => $validated['weight'],
            'description' => $validated['description'] ?? null,
            'main_image'  => $mainImagePath,
            'extra_images'=> $extraImagesPaths,
            'status'      => 'active',
        ]);

        return redirect()
            ->route('seller.products.index')
            ->with('status', 'Produk berhasil ditambahkan.');
    }
}
