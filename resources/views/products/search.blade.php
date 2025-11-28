<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian - EasyMart</title>
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
    
    <!-- Navbar -->
    <nav class="bg-white/80 backdrop-blur-md shadow-sm sticky top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16 gap-4">
                <!-- Logo -->
                <div class="flex items-center flex-shrink-0">
                    <a href="/" class="flex items-center space-x-2">
                        <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                        </svg>
                        <span class="text-2xl font-bold text-brand-dark">Easy<span class="font-light text-brand-green">Mart</span></span>
                    </a>
                </div>

                <!-- Search Bar (Desktop) -->
                <div class="hidden lg:block flex-1 max-w-xl mx-4">
                    <form action="{{ route('products.search') }}" method="GET" class="relative">
                        <input type="text" 
                               name="q" 
                               placeholder="Cari produk, toko..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                               value="{{ $query }}">
                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <!-- Menu Links (Desktop) -->
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

                <!-- Auth Buttons (Desktop) -->
                <div class="hidden md:flex items-center space-x-3 flex-shrink-0">
                    @auth
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-700 hidden lg:inline">Hi, {{ Auth::user()->name }}</span>
                            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-brand-green text-white rounded-full hover:bg-green-800 transition text-sm shadow-md">
                                Dashboard
                            </a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="p-2 text-gray-500 hover:text-red-600 transition" title="Keluar">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('register') }}" class="px-4 py-2 text-brand-green font-medium hover:text-brand-dark transition">Daftar</a>
                        <a href="{{ route('login') }}" class="px-6 py-2 bg-brand-green text-white rounded-full hover:bg-green-800 transition shadow-md">
                            Masuk
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-brand-green">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <!-- Mobile Search Bar -->
            <div class="px-4 pt-4 pb-3">
                <form action="{{ route('products.search') }}" method="GET" class="relative">
                    <input type="text" 
                           name="q" 
                           placeholder="Cari produk, toko..." 
                           class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-500 focus:border-transparent"
                           value="{{ $query }}">
                    <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </form>
            </div>

            <div class="px-4 pb-3 space-y-3">
                <a href="/" class="block text-gray-700 hover:text-brand-green py-2">Beranda</a>
                <a href="/#produk" class="block text-gray-700 hover:text-brand-green py-2">Produk</a>
                @auth
                    @if(Auth::user()->seller)
                        <a href="{{ route('seller.dashboard') }}" class="block text-brand-green font-bold py-2">Toko Saya</a>
                    @else
                        <a href="{{ route('seller.register') }}" class="block text-brand-green py-2">Buka Toko Gratis</a>
                    @endif
                    <a href="{{ route('dashboard') }}" class="block bg-brand-green text-white px-4 py-2 rounded-full text-center">Dashboard</a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full text-left text-red-600 hover:text-red-700 py-2">
                            Keluar
                        </button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-brand-green py-2">Toko Saya</a>
                    <a href="{{ route('register') }}" class="block text-brand-green hover:text-brand-dark py-2">Daftar</a>
                    <a href="{{ route('login') }}" class="block bg-brand-green text-white px-4 py-2 rounded-full text-center">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Search Results Section -->
    <section class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Search Info -->
            <div class="mb-8">
                <h2 class="text-3xl font-bold text-brand-dark mb-2">
                    Hasil untuk "{{ $query }}"
                </h2>
                <p class="text-gray-600">
                    Ditemukan {{ $total }} produk
                </p>
            </div>

            <!-- Products Grid -->
            @if($products->count() > 0)
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach($products as $product)
                        <div class="bg-white rounded-2xl shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden border border-gray-100 group">
                            <!-- Product Image -->
                            <a href="{{ route('products.show', $product) }}" class="block relative overflow-hidden">
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" 
                                         alt="{{ $product->name }}" 
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-300">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            <!-- Product Info -->
                            <div class="p-4">
                                <a href="{{ route('products.show', $product) }}" 
                                   class="block hover:text-brand-green transition-colors">
                                    <h3 class="text-base font-semibold text-gray-900 mb-2 line-clamp-2 min-h-[3rem]">
                                        {{ $product->name }}
                                    </h3>
                                </a>
                                
                                <!-- Price -->
                                <div class="mb-3">
                                    <span class="text-xl font-bold text-brand-green">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <!-- Seller & Stock Info -->
                                <div class="flex items-center justify-between text-sm text-gray-600 border-t pt-3">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        <span class="truncate">{{ $product->seller->storeName }}</span>
                                    </div>
                                    <span class="text-gray-500 text-xs whitespace-nowrap ml-2">
                                        Stok: {{ $product->stock }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-10">
                    {{ $products->links() }}
                </div>
            @else
                <!-- No Results -->
                <div class="bg-white rounded-2xl shadow-sm p-16 text-center border border-dashed border-gray-300">
                    <svg class="w-24 h-24 mx-auto text-gray-300 mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">
                        Produk tidak ditemukan
                    </h3>
                    <p class="text-gray-600 mb-8 text-lg">
                        Maaf, kami tidak menemukan produk yang cocok dengan pencarian "<span class="font-semibold text-brand-green">{{ $query }}</span>"
                    </p>
                    <a href="{{ url('/') }}" 
                       class="inline-flex items-center px-8 py-3 bg-brand-green text-white font-semibold rounded-full hover:bg-green-800 transition-all shadow-lg transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Kembali ke Beranda
                    </a>
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
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            document.getElementById('mobile-menu').classList.toggle('hidden');
        });
    </script>
</body>
</html>