@php
    $selectedCategory = request('category', 'all');
    $filteredProducts = $selectedCategory === 'all' 
        ? $products 
        : $products->filter(function($product) use ($selectedCategory) {
            return $product->category === $selectedCategory;
          });
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EasyMart - Marketplace Kampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    <style>
        body { background-color: #f7f6f2; }
        .text-brand-dark { color: #1a432b; }
        .text-brand-green { color: #2e603f; }
        .bg-brand-green { background-color: #1a432b; }
        .hover-bg-brand:hover { background-color: #2e603f; }
        .text-brand-light { color: #a5c0a8; }
        .bg-brand-light { background-color: #e8f5e9; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    
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
                        <input type="text" 
                               name="q" 
                               placeholder="Cari produk, toko..." 
                               class="w-full pl-11 pr-4 py-2.5 border border-gray-300 rounded-full focus:ring-2 focus:ring-green-500 focus:border-transparent transition"
                               value="{{ request('q') }}">
                        <svg class="absolute left-4 top-3 h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </form>
                </div>

                <div class="hidden md:flex items-center space-x-8">
                    <a href="#" class="text-gray-600 hover:text-brand-green transition font-medium">Beranda</a>
                    <a href="#produk" class="text-gray-600 hover:text-brand-green transition font-medium">Produk</a>
                    
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

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3">
                            <span class="text-sm text-gray-700 hidden md:inline">Hi, {{ Auth::user()->name }}</span>
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

                <div class="md:hidden">
                    <button id="mobile-menu-btn" class="text-gray-700 hover:text-brand-green">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden md:hidden border-t border-gray-200 bg-white">
            <div class="px-4 py-3 space-y-3">
                <a href="#" class="block text-gray-700 hover:text-brand-green">Beranda</a>
                <a href="#produk" class="block text-gray-700 hover:text-brand-green">Produk</a>
                @auth
                    @if(Auth::user()->seller)
                        <a href="{{ route('seller.dashboard') }}" class="block text-brand-green font-bold">Toko Saya</a>
                    @else
                        <a href="{{ route('seller.register') }}" class="block text-brand-green">Buka Toko Gratis</a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="block text-gray-700 hover:text-brand-green">Toko Saya</a>
                @endauth
            </div>
        </div>
    </nav>

    <section class="bg-brand-green text-white py-20 relative overflow-hidden">
        <div class="absolute top-0 right-0 -mr-20 -mt-20 w-96 h-96 rounded-full bg-white opacity-5 z-0"></div>
        <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-72 h-72 rounded-full bg-green-400 opacity-10 z-0"></div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <div class="space-y-6 text-center md:text-left">
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight">
                        Katalog Marketplace<br>
                        <span class="text-green-300">Terpercaya</span>
                    </h1>
                    <p class="text-xl text-green-100">
                        Lihat Produk Impianmu Tanpa Ribet!
                    </p>
                    <p class="text-lg text-green-50/80">
                        Temukan kebutuhan kuliah, makanan, hingga jasa print terdekat di kampusmu.
                    </p>
                    <div class="flex flex-wrap gap-4 pt-4 justify-center md:justify-start">
                        <a href="#produk" class="px-8 py-3 bg-white text-brand-green rounded-full font-bold hover:bg-green-50 transition shadow-lg transform hover:-translate-y-1">
                            Jelajahi Sekarang
                        </a>
                    </div>
                </div>
                <div class="hidden md:block">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 transform rotate-2 hover:rotate-0 transition duration-500">
                         <img src="images/home.png" alt="Hero Image" class="rounded-lg shadow-2xl w-full">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-3 gap-8">
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-brand-dark">Cepat & Mudah</h3>
                    <p class="text-gray-600">Temukan produk yang kamu butuhkan dengan cepat.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-brand-dark">Komunitas Sekitar</h3>
                    <p class="text-gray-600">Lihat produk disekitarmu.</p>
                </div>
                <div class="text-center p-6 bg-white rounded-2xl shadow-sm hover:shadow-md transition border border-gray-100">
                    <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                    </div>
                    <h3 class="text-xl font-semibold mb-2 text-brand-dark">Aman & Terpercaya</h3>
                    <p class="text-gray-600">Transaksi aman dengan sistem verifikasi pengguna.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="produk" class="py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-brand-dark mb-4">Katalog Terbaru</h2>
                <p class="text-gray-600">Produk pilihan dari penjual terpercaya</p>
            </div>

            <!-- Filter Kategori (Fungsional) -->
            <div class="flex flex-wrap justify-center gap-2 mb-10">
                <a href="/?category=all#produk" 
                   class="px-6 py-2 rounded-full font-medium shadow-md transition {{ $selectedCategory === 'all' ? 'bg-brand-green text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-green-50' }}">
                    Semua
                </a>
                <a href="/?category=Pakaian Wanita#produk" 
                   class="px-6 py-2 rounded-full font-medium shadow-md transition {{ $selectedCategory === 'Pakaian Wanita' ? 'bg-brand-green text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-green-50' }}">
                    Pakaian Wanita
                </a>
                <a href="/?category=Pakaian Pria#produk" 
                   class="px-6 py-2 rounded-full font-medium shadow-md transition {{ $selectedCategory === 'Pakaian Pria' ? 'bg-brand-green text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-green-50' }}">
                    Pakaian Pria
                </a>
                <a href="/?category=Aksesoris#produk" 
                   class="px-6 py-2 rounded-full font-medium shadow-md transition {{ $selectedCategory === 'Aksesoris' ? 'bg-brand-green text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-green-50' }}">
                    Aksesoris
                </a>
                <a href="/?category=Rajutan#produk" 
                   class="px-6 py-2 rounded-full font-medium shadow-md transition {{ $selectedCategory === 'Rajutan' ? 'bg-brand-green text-white' : 'bg-white border border-gray-200 text-gray-600 hover:bg-green-50' }}">
                    Rajutan
                </a>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @forelse($filteredProducts as $product)
                    <x-product-card :product="$product" />
                @empty
                    <div class="col-span-full text-center py-16 bg-white rounded-xl shadow-sm border border-dashed border-gray-300">
                        <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        <h3 class="text-xl font-semibold text-gray-700 mb-2">
                            {{ $selectedCategory === 'all' ? 'Belum Ada Produk' : 'Tidak ada produk di kategori ini' }}
                        </h3>
                        <p class="text-gray-500 mb-6">
                            {{ $selectedCategory === 'all' ? 'Jadilah penjual pertama!' : 'Coba kategori lain atau lihat semua produk' }}
                        </p>
                        @auth
                            @if(!Auth::user()->seller)
                                <a href="{{ route('seller.register') }}" class="inline-block px-6 py-3 bg-brand-green text-white rounded-full hover:bg-green-800 transition font-medium">
                                    Mulai Berjualan
                                </a>
                            @endif
                        @else
                            <a href="{{ route('register') }}" class="inline-block px-6 py-3 bg-brand-green text-white rounded-full hover:bg-green-800 transition font-medium">
                                Daftar Sekarang
                            </a>
                        @endauth
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <footer class="bg-gray-900 text-gray-300 py-12">
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
                        <li><a href="#" class="hover:text-brand-green transition">Beranda</a></li>
                        <li><a href="#produk" class="hover:text-brand-green transition">Produk</a></li>
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