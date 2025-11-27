<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selamat Datang di EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            background-color: #f7f6f2; /* Latar belakang krem */
        }
        .text-brand-green-dark { color: #2e603f; }
        .text-brand-green-light { color: #a5c0a8; }
        .bg-brand-green-dark { background-color: #1a432b; }
        .border-brand-green-dark { border-color: #1a432b; }
        .hover-text-brand:hover { color: #1a432b; }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">
    
    <div class="min-h-screen flex flex-col">
        <div class="container mx-auto px-4 md:px-6 py-4 flex-grow">
            
            <header class="flex items-center justify-between py-4">
                <a href="{{ url('/') }}" class="text-3xl md:text-4xl font-bold text-brand-green-dark flex items-center gap-2">
                    <svg class="w-8 h-8 md:w-10 md:h-10 text-brand-green-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Easy<span class="font-light text-brand-green-light">Mart</span>
                </a>

                <div class="w-1/3 relative hidden md:block">
                    <form action="#" method="GET">
                        <input type="text" placeholder="Cari barangmu di sini..."
                               class="w-full py-2 px-4 pr-10 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent transition shadow-sm">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3 text-gray-400 hover:text-brand-green-dark">
                            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-4">
                    @auth
                        <div class="flex items-center space-x-3 ml-4 border-l pl-4 border-gray-300">
                            <div class="hidden md:block text-right">
                                <p class="text-sm font-semibold text-brand-green-dark">Hi, {{ Auth::user()->name }}</p>
                                <a href="{{ url('/dashboard') }}" class="text-xs text-gray-500 hover:underline">Ke Dashboard</a>
                            </div>
                            
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="p-2 rounded-full bg-red-50 text-red-500 hover:bg-red-100 transition" title="Keluar">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex space-x-2">
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-full text-white font-medium hover:opacity-90 transition shadow-sm" style="background-color: #a5c0a8;">
                                Daftar
                            </a>
                            <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-gray-700 font-medium border border-gray-400 hover:bg-gray-100 transition shadow-sm">
                                Masuk
                            </a>
                        </div>
                    @endauth
                </div>
            </header>

            <nav class="mt-6 sticky top-0 z-40 bg-[#f7f6f2]/95 backdrop-blur-sm py-2">
                <div class="max-w-4xl mx-auto bg-white rounded-full shadow-md flex justify-center space-x-4 md:space-x-12 px-4 md:px-8 py-3 overflow-x-auto border border-gray-100">
                    <a href="{{ url('/') }}" class="font-bold text-brand-green-dark border-b-2 border-brand-green-dark pb-1 whitespace-nowrap">Beranda</a>
                    <a href="#" class="font-medium text-gray-600 hover-text-brand whitespace-nowrap transition">Produk</a>
                    <a href="#" class="font-medium text-gray-600 hover-text-brand whitespace-nowrap transition">Chatting</a>
                    
                    @auth
                        @if(Auth::user()->seller)
                            <a href="{{ route('seller.dashboard') }}" class="font-bold text-green-700 hover:text-green-900 whitespace-nowrap flex items-center gap-1">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                Masuk Toko Saya
                            </a>
                        @else
                            <a href="{{ route('seller.register') }}" class="font-medium text-gray-600 hover-text-brand whitespace-nowrap">
                                Buka Toko Gratis
                            </a>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="font-medium text-gray-600 hover-text-brand whitespace-nowrap">
                            Toko Saya
                        </a>
                    @endauth
                </div>
            </nav>

            <main class="mt-10 md:mt-12 mb-20">
                <div class="flex flex-col md:flex-row items-center bg-white rounded-3xl p-8 md:p-12 shadow-xl border border-gray-100 relative overflow-hidden">
                    
                    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 rounded-full bg-green-50 opacity-50 z-0"></div>
                    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-60 h-60 rounded-full bg-yellow-50 opacity-50 z-0"></div>

                    <div class="w-full md:w-1/2 z-10 text-center md:text-left mb-8 md:mb-0">
                        <span class="text-brand-green-light font-bold tracking-wider uppercase text-sm mb-2 block">Katalog Marketplace</span>
                        <h1 class="text-4xl md:text-6xl font-extrabold text-brand-green-dark leading-tight mb-6">
                            Lihat Produk Impianmu <br>
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-600 to-teal-500">Tanpa Ribet!</span>
                        </h1>
                        <p class="text-lg text-gray-600 mb-8 max-w-md mx-auto md:mx-0">
                            Temukan kebutuhan kuliah, makanan, hingga jasa print terdekat di kampusmu.
                        </p>

                        <div class="flex space-x-4 justify-center md:justify-start">
                            <a href="#katalog" class="px-8 py-3 rounded-full text-white text-lg font-bold bg-brand-green-dark hover:bg-green-800 shadow-lg hover:shadow-green-500/30 transition transform hover:-translate-y-1">
                                Jelajahi Sekarang
                            </a>
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 z-10 flex justify-center">
                        <img src="{{ asset('images/home.png') }}" 
                            alt="Ilustrasi EasyMart" 
                            class="w-full max-w-md h-auto rounded-2xl transform md:rotate-3 hover:rotate-0 transition duration-500">
                    </div>
                </div>
            </main>

            <section id="katalog" class="pb-20 scroll-mt-24">
                <div class="flex justify-between items-center mb-8">
                    <h2 class="text-3xl font-bold text-gray-800 flex items-center gap-2">
                        <span class="w-2 h-8 bg-brand-green-dark rounded-full"></span>
                        Katalog Terbaru
                    </h2>
                    <div class="hidden md:flex space-x-2">
                        <button class="px-4 py-1.5 bg-brand-green-dark text-white rounded-full text-sm font-semibold shadow-md">Semua</button>
                        <button class="px-4 py-1.5 bg-white border border-gray-200 text-gray-600 rounded-full text-sm hover:bg-gray-50 transition">Pakaian</button>
                        <button class="px-4 py-1.5 bg-white border border-gray-200 text-gray-600 rounded-full text-sm hover:bg-gray-50 transition">Makanan</button>
                    </div>
                </div>

                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">

                    @forelse($products as $product)
                        <x-product-card :product="$product" />
                    @empty
                        <div class="col-span-full py-16 text-center text-gray-500">
                            Belum ada produk yang dijual saat ini.
                        </div>
                    @endforelse

                </div>
            </section>

        </div>

        <footer class="bg-white border-t border-gray-200 mt-auto py-8">
            <div class="container mx-auto px-6 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} EasyMart. Dibuat dengan ❤️ oleh Kelompok 8</p>
            </div>
        </footer>
    </div>

</body>
</html>