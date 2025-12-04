<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - EasyMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { 
            background-color: #ffffff; 
            font-family: 'Figtree', sans-serif;
        }
        .product-badge {
            background: linear-gradient(135deg, #34D399 0%, #10B981 100%);
        }
        .thumbnail-active {
            border-color: #10B981 !important;
            box-shadow: 0 0 0 2px rgba(16, 185, 129, 0.2);
        }
        .star-filled { color: #FCD34D; }
        .rating-bar {
            background: #E5E7EB;
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
        }
        .rating-bar-fill {
            background: #FCD34D;
            height: 100%;
            transition: width 0.3s ease;
        }
        .share-btn:hover {
            transform: translateY(-2px);
            transition: all 0.2s;
        }
    </style>
</head>
<body class="antialiased text-gray-900">
    
    <!-- Navbar (sama dengan welcome.blade.php) -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 gap-4">
                <div class="flex items-center flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="text-2xl font-bold text-brand-dark">Easy<span class="font-light text-brand-green">Mart</span></span>
                    </a>
                </div>

                <div class="hidden lg:block flex-1 max-w-xl mx-4">
                    <form action="{{ route('products.search') }}" method="GET" class="relative">
                        <input type="text" name="q" placeholder="Cari produk, toko..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-500 focus:border-transparent transition">
                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="/" class="text-gray-600 hover:text-brand-green transition font-medium">Beranda</a>
                    <a href="/#produk" class="text-gray-600 hover:text-brand-green transition font-medium">Produk</a>
                    @auth
                        @if(Auth::user()->seller)
                            <a href="{{ route('seller.dashboard') }}" class="text-brand-green font-bold hover:underline">Toko Saya</a>
                        @else
                            <a href="{{ route('seller.register') }}" class="text-brand-green hover:text-brand-dark font-medium transition">Buka Toko Gratis</a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-brand-green transition font-medium">Toko Saya</a>
                    @endauth
                </div>

                <div class="hidden md:flex items-center space-x-3 flex-shrink-0">
                    @auth
                        <span class="text-sm text-gray-700 hidden lg:inline">Hi, {{ Auth::user()->name }}</span>
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-brand-green text-white rounded-full hover:bg-green-800 transition text-sm shadow-md">Dashboard</a>
                    @else
                        <a href="{{ route('register') }}" class="px-4 py-2 text-brand-green font-medium hover:text-brand-dark transition">Daftar</a>
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-brand-green text-white rounded-full hover:bg-green-800 transition shadow-md">Masuk</a>
                    @endauth
                </div>

                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-brand-green">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <!-- Breadcrumb -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <div class="flex items-center text-sm text-gray-600">
            <a href="/" class="hover:text-brand-green">Beranda</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <a href="/#produk" class="hover:text-brand-green">Produk</a>
            <svg class="w-4 h-4 mx-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
            <span class="text-gray-900 font-medium truncate">{{ $product->name }}</span>
        </div>
    </div>

    <!-- Product Detail Section -->
    <section class="py-8 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">
                <div class="grid lg:grid-cols-2 gap-0">
                    <!-- Left: Image Gallery -->
                    <div class="p-8 bg-gray-50">
                        <!-- Main Image with Navigation Arrows -->
                        <div class="relative mb-4 group">
                            <div class="bg-white rounded-xl overflow-hidden shadow-sm">
                                @php
                                    $mainImage = $product->images->where('is_primary', true)->first() 
                                              ?? $product->images->first();
                                    $displayImage = $mainImage ? $mainImage->image_path : $product->image;
                                    $allImages = collect();
                                    if($product->image) $allImages->push($product->image);
                                    $allImages = $allImages->merge($product->images->pluck('image_path'));
                                @endphp
                                
                                @if($displayImage)
                                    <img id="mainProductImage" 
                                         src="{{ asset('storage/' . $displayImage) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-[500px] object-cover">
                                @else
                                    <div class="w-full h-[500px] bg-gray-100 flex items-center justify-center">
                                        <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            
                            <!-- Navigation Arrows -->
                            @if($allImages->count() > 1)
                                <button onclick="previousImage()" 
                                        class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button onclick="nextImage()" 
                                        class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/90 hover:bg-white p-3 rounded-full shadow-lg opacity-0 group-hover:opacity-100 transition-opacity">
                                    <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            @endif
                        </div>

                        <!-- Thumbnail Gallery -->
                        @if($allImages->count() > 1)
                            <div class="flex gap-3 overflow-x-auto pb-2" id="thumbnailContainer">
                                @foreach($allImages as $index => $imagePath)
                                    <div class="thumbnail-item flex-shrink-0 cursor-pointer border-2 {{ $index === 0 ? 'thumbnail-active border-green-500' : 'border-gray-200' }} rounded-lg overflow-hidden hover:border-green-400 transition-all"
                                         onclick="changeMainImage('{{ asset('storage/' . $imagePath) }}', this)"
                                         data-index="{{ $index }}">
                                        <img src="{{ asset('storage/' . $imagePath) }}" 
                                             alt="Thumbnail {{ $index + 1 }}" 
                                             class="w-20 h-20 object-cover">
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Right: Product Info -->
                    <div class="p-8 lg:p-12">
                        <!-- Brand/Category Badge -->
                        <span class="inline-block px-3 py-1 product-badge text-white text-xs font-semibold rounded-full mb-3">
                            {{ $product->category }}
                        </span>

                        <!-- Product Name -->
                        <h1 class="text-3xl font-bold text-gray-900 mb-2 leading-tight">
                            {{ $product->name }}
                        </h1>

                        <!-- Rating Summary -->
                        <div class="flex items-center gap-3 mb-6">
                            <div class="flex items-center">
                                @php
                                    $avgRating = $product->averageRating();
                                    $fullStars = floor($avgRating);
                                    $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                                @endphp
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $fullStars)
                                        <svg class="w-5 h-5 star-filled fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @elseif($i == $fullStars + 1 && $hasHalfStar)
                                        <svg class="w-5 h-5" viewBox="0 0 20 20">
                                            <defs>
                                                <linearGradient id="half">
                                                    <stop offset="50%" stop-color="#FCD34D"/>
                                                    <stop offset="50%" stop-color="#D1D5DB"/>
                                                </linearGradient>
                                            </defs>
                                            <path fill="url(#half)" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <span class="text-base font-semibold text-gray-700">{{ number_format($avgRating, 1) }}</span>
                            <span class="text-sm text-gray-500">({{ $product->totalReviews() }} Reviews)</span>
                        </div>

                        <!-- Price with Discount Effect -->
                        <div class="mb-6">
                            <div class="flex items-baseline gap-3">
                                <span class="text-4xl font-bold text-green-600">
                                    Rp{{ number_format($product->price, 0, ',', '.') }}
                                </span>
                                <span class="text-lg text-gray-400 line-through">
                                    Rp{{ number_format($product->price * 1.2, 0, ',', '.') }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $product->description ? Str::limit($product->description, 100) : 'Produk berkualitas dengan harga terjangkau' }}
                            </p>
                        </div>

                        <!-- SKU & Share -->
                        <div class="flex items-center justify-between py-4 border-y border-gray-200 mb-6">
                            <div class="flex items-center gap-4 text-sm">
                                <span class="text-gray-500">SKU:</span>
                                <span class="font-semibold text-gray-700">{{ str_pad($product->id, 6, '0', STR_PAD_LEFT) }}RJ</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="text-sm text-gray-500">Share:</span>
                                <button class="share-btn p-2 rounded-full hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                                    </svg>
                                </button>
                                <button class="share-btn p-2 rounded-full hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                                    </svg>
                                </button>
                                <button class="share-btn p-2 rounded-full hover:bg-gray-100 transition">
                                    <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <!-- Seller Info -->
                        <div class="bg-gray-50 rounded-xl p-4 mb-6">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">{{ $product->seller->storeName }}</p>
                                        <p class="text-xs text-gray-500">Verified Seller</p>
                                    </div>
                                </div>
                                <span class="text-xs text-green-600 bg-green-50 px-3 py-1 rounded-full font-semibold">
                                    ● Online
                                </span>
                            </div>
                        </div>

                        <!-- Stock Status -->
                        <div class="mb-6">
                            @if($product->stock > 0)
                                <div class="flex items-center gap-2 text-green-600 mb-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold">In Stock</span>
                                </div>
                                <p class="text-sm text-gray-600">{{ $product->stock }} units available</p>
                            @else
                                <div class="flex items-center gap-2 text-red-600 mb-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="font-semibold">Out of Stock</span>
                                </div>
                            @endif
                        </div>

                        <!-- WhatsApp Contact Button -->
                        <a href="https://wa.me/{{ $product->seller->picPhone }}?text=Halo, saya tertarik dengan produk {{ urlencode($product->name) }}" 
                           target="_blank"
                           class="w-full flex items-center justify-center gap-3 px-6 py-4 bg-green-600 text-white font-semibold rounded-xl hover:bg-green-700 transition-all shadow-lg hover:shadow-xl">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Contact via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Product Description -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 mb-8">
                <h2 class="text-2xl font-bold text-brand-dark mb-4">Deskripsi Produk</h2>
                <div class="prose max-w-none text-gray-700 leading-relaxed">
                    {{ $product->description }}
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100 mb-8">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-brand-dark">Rating & Review</h2>
                    <div class="flex items-center">
                        <div class="flex items-center mr-3">
                            @php
                                $avgRating = $product->averageRating();
                                $fullStars = floor($avgRating);
                                $hasHalfStar = ($avgRating - $fullStars) >= 0.5;
                            @endphp
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= $fullStars)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @elseif($i == $fullStars + 1 && $hasHalfStar)
                                    <svg class="w-5 h-5 text-yellow-400" viewBox="0 0 20 20">
                                        <defs>
                                            <linearGradient id="half">
                                                <stop offset="50%" stop-color="#FBBF24"/>
                                                <stop offset="50%" stop-color="#D1D5DB"/>
                                            </linearGradient>
                                        </defs>
                                        <path fill="url(#half)" d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-300 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endif
                            @endfor
                        </div>
                        <span class="text-lg font-semibold text-gray-900">{{ number_format($avgRating, 1) }}</span>
                        <span class="text-gray-500 ml-2">({{ $product->totalReviews() }} review)</span>
                    </div>
                </div>

                <!-- Success/Error Messages -->
                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
                        {{ session('error') }}
                    </div>
                @endif

                <!-- Review Form untuk Semua (Login & Guest) -->
                <div class="mb-8 p-6 bg-gray-50 rounded-xl border border-gray-200">
                    @auth
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            @if($userReview)
                                Edit Review Anda
                            @else
                                Tulis Review
                            @endif
                        </h3>
                    @else
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Tulis Review</h3>
                        <p class="text-sm text-gray-600 mb-4">Bagikan pengalaman Anda tentang produk ini</p>
                    @endauth

                    <form id="reviewForm" action="{{ route('products.reviews.store', $product) }}" method="POST">
                        @csrf
                        
                        <!-- Hidden fields untuk guest (akan diisi dari modal) -->
                        @guest
                            <input type="hidden" name="guest_name" id="guestNameHidden">
                            <input type="hidden" name="guest_email" id="guestEmailHidden">
                            <input type="hidden" name="guest_phone" id="guestPhoneHidden">
                            <input type="hidden" name="provinsi" id="guestProvinsiHidden">
                        @endguest

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating</label>
                            <div class="flex items-center space-x-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <label class="cursor-pointer">
                                        <input type="radio" name="rating" value="{{ $i }}" 
                                               class="hidden peer" 
                                               {{ ($userReview && $userReview->rating == $i) ? 'checked' : '' }}
                                               required>
                                        <svg class="w-8 h-8 text-gray-300 peer-checked:text-yellow-400 hover:text-yellow-300 transition-colors fill-current" viewBox="0 0 20 20">
                                            <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                        </svg>
                                    </label>
                                @endfor
                            </div>
                            @error('rating')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="mb-4">
                            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Komentar (Opsional)</label>
                            <textarea name="comment" id="comment" rows="4" 
                                      class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                      placeholder="Bagikan pengalaman Anda tentang produk ini..."
                                      maxlength="1000">{{ $userReview ? $userReview->comment : '' }}</textarea>
                            @error('comment')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        @auth
                        <div class="mb-4">
                            <label for="provinsi" class="block text-sm font-medium text-gray-700 mb-2">Provinsi <span class="text-red-500">*</span></label>
                            <select name="provinsi" id="provinsi" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="">Pilih Provinsi</option>
                                <option value="Aceh" {{ ($userReview && $userReview->provinsi == 'Aceh') ? 'selected' : '' }}>Aceh</option>
                                <option value="Sumatera Utara" {{ ($userReview && $userReview->provinsi == 'Sumatera Utara') ? 'selected' : '' }}>Sumatera Utara</option>
                                <option value="Sumatera Barat" {{ ($userReview && $userReview->provinsi == 'Sumatera Barat') ? 'selected' : '' }}>Sumatera Barat</option>
                                <option value="Riau" {{ ($userReview && $userReview->provinsi == 'Riau') ? 'selected' : '' }}>Riau</option>
                                <option value="Kepulauan Riau" {{ ($userReview && $userReview->provinsi == 'Kepulauan Riau') ? 'selected' : '' }}>Kepulauan Riau</option>
                                <option value="Jambi" {{ ($userReview && $userReview->provinsi == 'Jambi') ? 'selected' : '' }}>Jambi</option>
                                <option value="Sumatera Selatan" {{ ($userReview && $userReview->provinsi == 'Sumatera Selatan') ? 'selected' : '' }}>Sumatera Selatan</option>
                                <option value="Bengkulu" {{ ($userReview && $userReview->provinsi == 'Bengkulu') ? 'selected' : '' }}>Bengkulu</option>
                                <option value="Lampung" {{ ($userReview && $userReview->provinsi == 'Lampung') ? 'selected' : '' }}>Lampung</option>
                                <option value="Bangka Belitung" {{ ($userReview && $userReview->provinsi == 'Bangka Belitung') ? 'selected' : '' }}>Bangka Belitung</option>
                                <option value="DKI Jakarta" {{ ($userReview && $userReview->provinsi == 'DKI Jakarta') ? 'selected' : '' }}>DKI Jakarta</option>
                                <option value="Jawa Barat" {{ ($userReview && $userReview->provinsi == 'Jawa Barat') ? 'selected' : '' }}>Jawa Barat</option>
                                <option value="Jawa Tengah" {{ ($userReview && $userReview->provinsi == 'Jawa Tengah') ? 'selected' : '' }}>Jawa Tengah</option>
                                <option value="DI Yogyakarta" {{ ($userReview && $userReview->provinsi == 'DI Yogyakarta') ? 'selected' : '' }}>DI Yogyakarta</option>
                                <option value="Jawa Timur" {{ ($userReview && $userReview->provinsi == 'Jawa Timur') ? 'selected' : '' }}>Jawa Timur</option>
                                <option value="Banten" {{ ($userReview && $userReview->provinsi == 'Banten') ? 'selected' : '' }}>Banten</option>
                                <option value="Bali" {{ ($userReview && $userReview->provinsi == 'Bali') ? 'selected' : '' }}>Bali</option>
                                <option value="Nusa Tenggara Barat" {{ ($userReview && $userReview->provinsi == 'Nusa Tenggara Barat') ? 'selected' : '' }}>Nusa Tenggara Barat</option>
                                <option value="Nusa Tenggara Timur" {{ ($userReview && $userReview->provinsi == 'Nusa Tenggara Timur') ? 'selected' : '' }}>Nusa Tenggara Timur</option>
                                <option value="Kalimantan Barat" {{ ($userReview && $userReview->provinsi == 'Kalimantan Barat') ? 'selected' : '' }}>Kalimantan Barat</option>
                                <option value="Kalimantan Tengah" {{ ($userReview && $userReview->provinsi == 'Kalimantan Tengah') ? 'selected' : '' }}>Kalimantan Tengah</option>
                                <option value="Kalimantan Selatan" {{ ($userReview && $userReview->provinsi == 'Kalimantan Selatan') ? 'selected' : '' }}>Kalimantan Selatan</option>
                                <option value="Kalimantan Timur" {{ ($userReview && $userReview->provinsi == 'Kalimantan Timur') ? 'selected' : '' }}>Kalimantan Timur</option>
                                <option value="Kalimantan Utara" {{ ($userReview && $userReview->provinsi == 'Kalimantan Utara') ? 'selected' : '' }}>Kalimantan Utara</option>
                                <option value="Sulawesi Utara" {{ ($userReview && $userReview->provinsi == 'Sulawesi Utara') ? 'selected' : '' }}>Sulawesi Utara</option>
                                <option value="Sulawesi Tengah" {{ ($userReview && $userReview->provinsi == 'Sulawesi Tengah') ? 'selected' : '' }}>Sulawesi Tengah</option>
                                <option value="Sulawesi Selatan" {{ ($userReview && $userReview->provinsi == 'Sulawesi Selatan') ? 'selected' : '' }}>Sulawesi Selatan</option>
                                <option value="Sulawesi Tenggara" {{ ($userReview && $userReview->provinsi == 'Sulawesi Tenggara') ? 'selected' : '' }}>Sulawesi Tenggara</option>
                                <option value="Gorontalo" {{ ($userReview && $userReview->provinsi == 'Gorontalo') ? 'selected' : '' }}>Gorontalo</option>
                                <option value="Sulawesi Barat" {{ ($userReview && $userReview->provinsi == 'Sulawesi Barat') ? 'selected' : '' }}>Sulawesi Barat</option>
                                <option value="Maluku" {{ ($userReview && $userReview->provinsi == 'Maluku') ? 'selected' : '' }}>Maluku</option>
                                <option value="Maluku Utara" {{ ($userReview && $userReview->provinsi == 'Maluku Utara') ? 'selected' : '' }}>Maluku Utara</option>
                                <option value="Papua" {{ ($userReview && $userReview->provinsi == 'Papua') ? 'selected' : '' }}>Papua</option>
                                <option value="Papua Barat" {{ ($userReview && $userReview->provinsi == 'Papua Barat') ? 'selected' : '' }}>Papua Barat</option>
                                <option value="Papua Tengah" {{ ($userReview && $userReview->provinsi == 'Papua Tengah') ? 'selected' : '' }}>Papua Tengah</option>
                                <option value="Papua Pegunungan" {{ ($userReview && $userReview->provinsi == 'Papua Pegunungan') ? 'selected' : '' }}>Papua Pegunungan</option>
                                <option value="Papua Selatan" {{ ($userReview && $userReview->provinsi == 'Papua Selatan') ? 'selected' : '' }}>Papua Selatan</option>
                                <option value="Papua Barat Daya" {{ ($userReview && $userReview->provinsi == 'Papua Barat Daya') ? 'selected' : '' }}>Papua Barat Daya</option>
                            </select>
                            @error('provinsi')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        @endauth
                        
                        <div class="flex items-center space-x-3">
                            <button type="submit" 
                                    class="px-6 py-2 bg-brand-green text-white rounded-full hover:bg-green-800 transition font-medium">
                                @auth
                                    @if($userReview)
                                        Update Review
                                    @else
                                        Kirim Review
                                    @endif
                                @else
                                    Kirim Review
                                @endauth
                            </button>
                            @auth
                                @if($userReview)
                                    <form action="{{ route('products.reviews.destroy', [$product, $userReview]) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                onclick="return confirm('Yakin ingin menghapus review?')"
                                                class="px-6 py-2 bg-red-500 text-white rounded-full hover:bg-red-600 transition font-medium">
                                            Hapus Review
                                        </button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </form>
                </div>

                <!-- Modal for Guest User Info -->
                @guest
                <div id="guestModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center p-4">
                    <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full p-6 transform transition-all">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-brand-dark">Informasi Anda</h3>
                            <button onclick="closeGuestModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                        <p class="text-sm text-gray-600 mb-6">Silakan isi informasi Anda untuk melanjutkan review</p>
                        
                        <form id="guestInfoForm" onsubmit="submitGuestInfo(event)">
                            <div class="mb-4">
                                <label for="modal_guest_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap *</label>
                                <input type="text" id="modal_guest_name" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       placeholder="Masukkan nama Anda" required>
                                <p id="error_guest_name" class="text-red-500 text-sm mt-1 hidden"></p>
                            </div>
                            <div class="mb-4">
                                <label for="modal_guest_email" class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" id="modal_guest_email" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       placeholder="contoh@email.com" required>
                                <p id="error_guest_email" class="text-red-500 text-sm mt-1 hidden"></p>
                            </div>
                            <div class="mb-4">
                                <label for="modal_guest_phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                                <input type="tel" id="modal_guest_phone" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       placeholder="08123456789" required>
                                <p id="error_guest_phone" class="text-red-500 text-sm mt-1 hidden"></p>
                            </div>
                            <div class="mb-6">
                                <label for="modal_guest_provinsi" class="block text-sm font-medium text-gray-700 mb-2">Provinsi *</label>
                                <select id="modal_guest_provinsi" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                    <option value="">Pilih Provinsi</option>
                                    <option value="Aceh">Aceh</option>
                                    <option value="Sumatera Utara">Sumatera Utara</option>
                                    <option value="Sumatera Barat">Sumatera Barat</option>
                                    <option value="Riau">Riau</option>
                                    <option value="Kepulauan Riau">Kepulauan Riau</option>
                                    <option value="Jambi">Jambi</option>
                                    <option value="Sumatera Selatan">Sumatera Selatan</option>
                                    <option value="Bengkulu">Bengkulu</option>
                                    <option value="Lampung">Lampung</option>
                                    <option value="Bangka Belitung">Bangka Belitung</option>
                                    <option value="DKI Jakarta">DKI Jakarta</option>
                                    <option value="Jawa Barat">Jawa Barat</option>
                                    <option value="Jawa Tengah">Jawa Tengah</option>
                                    <option value="DI Yogyakarta">DI Yogyakarta</option>
                                    <option value="Jawa Timur">Jawa Timur</option>
                                    <option value="Banten">Banten</option>
                                    <option value="Bali">Bali</option>
                                    <option value="Nusa Tenggara Barat">Nusa Tenggara Barat</option>
                                    <option value="Nusa Tenggara Timur">Nusa Tenggara Timur</option>
                                    <option value="Kalimantan Barat">Kalimantan Barat</option>
                                    <option value="Kalimantan Tengah">Kalimantan Tengah</option>
                                    <option value="Kalimantan Selatan">Kalimantan Selatan</option>
                                    <option value="Kalimantan Timur">Kalimantan Timur</option>
                                    <option value="Kalimantan Utara">Kalimantan Utara</option>
                                    <option value="Sulawesi Utara">Sulawesi Utara</option>
                                    <option value="Sulawesi Tengah">Sulawesi Tengah</option>
                                    <option value="Sulawesi Selatan">Sulawesi Selatan</option>
                                    <option value="Sulawesi Tenggara">Sulawesi Tenggara</option>
                                    <option value="Gorontalo">Gorontalo</option>
                                    <option value="Sulawesi Barat">Sulawesi Barat</option>
                                    <option value="Maluku">Maluku</option>
                                    <option value="Maluku Utara">Maluku Utara</option>
                                    <option value="Papua">Papua</option>
                                    <option value="Papua Barat">Papua Barat</option>
                                    <option value="Papua Tengah">Papua Tengah</option>
                                    <option value="Papua Pegunungan">Papua Pegunungan</option>
                                    <option value="Papua Selatan">Papua Selatan</option>
                                    <option value="Papua Barat Daya">Papua Barat Daya</option>
                                </select>
                                <p id="error_guest_provinsi" class="text-red-500 text-sm mt-1 hidden"></p>
                            </div>
                            <div class="flex space-x-3">
                                <button type="button" onclick="closeGuestModal()" 
                                        class="flex-1 px-6 py-2 border border-gray-300 text-gray-700 rounded-full hover:bg-gray-50 transition font-medium">
                                    Batal
                                </button>
                                <button type="submit" 
                                        class="flex-1 px-6 py-2 bg-brand-green text-white rounded-full hover:bg-green-800 transition font-medium">
                                    Lanjutkan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                @endguest

                <!-- Reviews List -->
                <div class="space-y-6">
                    @forelse($product->reviews()->latest()->get() as $review)
                        <div class="border-b border-gray-200 pb-6 last:border-0">
                            <div class="flex items-start justify-between mb-3">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-brand-green rounded-full flex items-center justify-center text-white font-bold mr-3">
                                        @if($review->user)
                                            {{ strtoupper(substr($review->user->name, 0, 1)) }}
                                        @else
                                            {{ strtoupper(substr($review->guest_name, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div>
                                        <p class="font-semibold text-gray-900">
                                            @if($review->user)
                                                {{ $review->user->name }}
                                            @else
                                                {{ $review->guest_name }}
                                            @endif
                                        </p>
                                        <div class="flex items-center mt-1">
                                            @for($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-300' }} fill-current" viewBox="0 0 20 20">
                                                    <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                                </svg>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                                <span class="text-sm text-gray-500">{{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            @if($review->comment)
                                <p class="text-gray-700 ml-13 leading-relaxed">{{ $review->comment }}</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-16 h-16 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                            </svg>
                            <p class="text-gray-500">Belum ada review untuk produk ini</p>
                            <p class="text-sm text-gray-400 mt-1">Jadilah yang pertama memberikan review!</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Related Products -->
            @if($relatedProducts->count() > 0)
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-brand-dark mb-6">Produk Lainnya dari {{ $product->seller->storeName }}</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                    @foreach($relatedProducts as $related)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 group">
                            <a href="{{ route('products.show', $related) }}" class="block relative overflow-hidden">
                                @if($related->image)
                                    <img src="{{ asset('storage/' . $related->image) }}" 
                                         alt="{{ $related->name }}" 
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>
                            <div class="p-4">
                                <a href="{{ route('products.show', $related) }}" class="block hover:text-brand-green transition-colors">
                                    <h3 class="text-base font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[3rem]">
                                        {{ $related->name }}
                                    </h3>
                                </a>
                                <div class="text-xl font-bold text-brand-green">
                                    Rp {{ number_format($related->price, 0, ',', '.') }}
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 py-12 mt-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <div>
                    <div class="flex items-center space-x-2 mb-4">
                        <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        <span class="text-xl font-bold text-white">EasyMart</span>
                    </div>
                    <p class="text-sm">Katalog Marketplace yang memudahkan pengguna untuk melihat produk terpecaya</p>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Menu</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="/" class="hover:text-brand-green transition">Beranda</a></li>
                        <li><a href="/#produk" class="hover:text-brand-green transition">Produk</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Untuk Penjual</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="{{ route('seller.register') }}" class="hover:text-brand-green transition">Buka Toko</a></li>
                        <li><a href="{{ route('seller.dashboard') }}" class="hover:text-brand-green transition">Dashboard</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-white font-semibold mb-4">Bantuan</h3>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#" class="hover:text-brand-green transition">FAQ</a></li>
                        <li><a href="#" class="hover:text-brand-green transition">Hubungi Kami</a></li>
                    </ul>
                </div>
            </div>
            <div class="border-t border-gray-800 pt-8 text-center text-sm">
                <p>© {{ date('Y') }} EasyMart. Dibuat dengan ❤️ oleh Kelompok 8</p>
            </div>
        </div>
    </footer>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
            document.getElementById('mobile-menu')?.classList.toggle('hidden');
        });

        @guest
        // Handle guest review form submission
        document.getElementById('reviewForm').addEventListener('submit', function(e) {
            // Cek apakah guest sudah mengisi informasi
            const guestName = document.getElementById('guestNameHidden').value;
            const guestEmail = document.getElementById('guestEmailHidden').value;
            const guestPhone = document.getElementById('guestPhoneHidden').value;

            // Jika belum lengkap, tampilkan modal
            if (!guestName || !guestEmail || !guestPhone) {
                e.preventDefault();
                openGuestModal();
            }
        });

        function openGuestModal() {
            const modal = document.getElementById('guestModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeGuestModal() {
            const modal = document.getElementById('guestModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function submitGuestInfo(e) {
            e.preventDefault();
            
            // Clear previous errors
            document.querySelectorAll('[id^="error_"]').forEach(el => {
                el.classList.add('hidden');
                el.textContent = '';
            });

            // Get values
            const name = document.getElementById('modal_guest_name').value.trim();
            const email = document.getElementById('modal_guest_email').value.trim();
            const phone = document.getElementById('modal_guest_phone').value.trim();
            const provinsi = document.getElementById('modal_guest_provinsi').value;

            // Validate
            let hasError = false;

            if (!name || name.length < 2) {
                document.getElementById('error_guest_name').textContent = 'Nama harus diisi minimal 2 karakter';
                document.getElementById('error_guest_name').classList.remove('hidden');
                hasError = true;
            }

            if (!email || !email.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
                document.getElementById('error_guest_email').textContent = 'Email tidak valid';
                document.getElementById('error_guest_email').classList.remove('hidden');
                hasError = true;
            }

            if (!phone || phone.length < 10) {
                document.getElementById('error_guest_phone').textContent = 'No. telepon minimal 10 digit';
                document.getElementById('error_guest_phone').classList.remove('hidden');
                hasError = true;
            }

            if (!provinsi) {
                document.getElementById('error_guest_provinsi').textContent = 'Provinsi harus dipilih';
                document.getElementById('error_guest_provinsi').classList.remove('hidden');
                hasError = true;
            }

            if (hasError) return;

            // Fill hidden fields
            document.getElementById('guestNameHidden').value = name;
            document.getElementById('guestEmailHidden').value = email;
            document.getElementById('guestPhoneHidden').value = phone;
            document.getElementById('guestProvinsiHidden').value = provinsi;

            // Close modal
            closeGuestModal();

            // Submit form
            document.getElementById('reviewForm').submit();
        }

        // Close modal when clicking outside
        document.getElementById('guestModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeGuestModal();
            }
        });
        @endguest

        // Image Gallery Functions
        let currentImageIndex = 0;
        const allImages = [
            @php
                $allImages = collect();
                if($product->image) $allImages->push($product->image);
                $allImages = $allImages->merge($product->images->pluck('image_path'));
            @endphp
            @foreach($allImages as $imagePath)
                "{{ asset('storage/' . $imagePath) }}"{{ !$loop->last ? ',' : '' }}
            @endforeach
        ];

        function changeMainImage(imageSrc, thumbnailElement) {
            // Update main image
            document.getElementById('mainProductImage').src = imageSrc;
            
            // Remove active border from all thumbnails
            document.querySelectorAll('.thumbnail-item').forEach(item => {
                item.classList.remove('thumbnail-active', 'border-green-500');
                item.classList.add('border-gray-200');
            });
            
            // Add active border to clicked thumbnail
            thumbnailElement.classList.remove('border-gray-200');
            thumbnailElement.classList.add('thumbnail-active', 'border-green-500');
            
            // Update current index
            currentImageIndex = parseInt(thumbnailElement.dataset.index);
        }

        function previousImage() {
            currentImageIndex = (currentImageIndex - 1 + allImages.length) % allImages.length;
            updateImage();
        }

        function nextImage() {
            currentImageIndex = (currentImageIndex + 1) % allImages.length;
            updateImage();
        }

        function updateImage() {
            document.getElementById('mainProductImage').src = allImages[currentImageIndex];
            
            // Update thumbnail borders
            document.querySelectorAll('.thumbnail-item').forEach((item, index) => {
                if (index === currentImageIndex) {
                    item.classList.remove('border-gray-200');
                    item.classList.add('thumbnail-active', 'border-green-500');
                } else {
                    item.classList.remove('thumbnail-active', 'border-green-500');
                    item.classList.add('border-gray-200');
                }
            });
        }

        // Tab Functions
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('text-green-600', 'border-b-2', 'border-green-600');
                button.classList.add('text-gray-500');
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            activeTab.classList.remove('text-gray-500');
            activeTab.classList.add('text-green-600', 'border-b-2', 'border-green-600');
        }
    </script>
</body>
</html>