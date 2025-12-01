<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }} - EasyMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #f7f6f2; }
        .text-brand-dark { color: #1a432b; }
        .text-brand-green { color: #2e603f; }
        .bg-brand-green { background-color: #1a432b; }
        .hover-bg-brand:hover { background-color: #2e603f; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    
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
    <section class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8 mb-12">
                <!-- Product Image -->
                <div class="bg-white rounded-2xl shadow-sm overflow-hidden border border-gray-100">
                    @if($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="w-full h-96 object-cover">
                    @else
                        <div class="w-full h-96 bg-gray-100 flex items-center justify-center">
                            <svg class="w-32 h-32 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>

                <!-- Product Info -->
                <div class="bg-white rounded-2xl shadow-sm p-8 border border-gray-100">
                    <!-- Category Badge -->
                    <span class="inline-block px-3 py-1 bg-green-100 text-brand-green text-sm font-semibold rounded-full mb-4">
                        {{ $product->category }}
                    </span>

                    <!-- Product Name -->
                    <h1 class="text-3xl font-bold text-brand-dark mb-4">
                        {{ $product->name }}
                    </h1>

                    <!-- Price -->
                    <div class="mb-6">
                        <span class="text-4xl font-bold text-brand-green">
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                        </span>
                    </div>

                    <!-- Stock Info -->
                    <div class="mb-6 pb-6 border-b">
                        <div class="flex items-center justify-between">
                            <span class="text-gray-600">Stok Tersedia:</span>
                            <span class="font-semibold text-gray-900">{{ $product->stock }} unit</span>
                        </div>
                        @if($product->stock > 0)
                            <div class="mt-2">
                                <div class="flex items-center text-green-600">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Produk Tersedia</span>
                                </div>
                            </div>
                        @else
                            <div class="mt-2">
                                <div class="flex items-center text-red-600">
                                    <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Stok Habis</span>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Seller Info -->
                    <div class="mb-6 pb-6 border-b">
                        <h3 class="text-sm font-semibold text-gray-500 mb-3">DIJUAL OLEH</h3>
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center mr-3">
                                <svg class="w-6 h-6 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-semibold text-gray-900">{{ $product->seller->storeName }}</p>
                                <p class="text-sm text-gray-500">Penjual Terpercaya</p>
                            </div>
                        </div>
                    </div>

                    <!-- Contact Buttons -->
                    <div class="space-y-3">
                        <a href="https://wa.me/{{ $product->seller->picPhone }}?text=Halo, saya tertarik dengan produk {{ urlencode($product->name) }}" 
                           target="_blank"
                           class="w-full flex items-center justify-center px-6 py-3 bg-green-600 text-white font-semibold rounded-full hover:bg-green-700 transition-all shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Hubungi via WhatsApp
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
                            <div class="mb-6">
                                <label for="modal_guest_phone" class="block text-sm font-medium text-gray-700 mb-2">No. Telepon *</label>
                                <input type="tel" id="modal_guest_phone" 
                                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                       placeholder="08123456789" required>
                                <p id="error_guest_phone" class="text-red-500 text-sm mt-1 hidden"></p>
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

            if (hasError) return;

            // Fill hidden fields
            document.getElementById('guestNameHidden').value = name;
            document.getElementById('guestEmailHidden').value = email;
            document.getElementById('guestPhoneHidden').value = phone;

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
    </script>
</body>
</html>