<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Selamat Datang di EasyMart</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Inline Styles untuk Warna Kustom (dari login.blade.php) -->
    <style>
        body {
            background-color: #f7f6f2; /* Latar belakang krem */
        }
        .text-brand-green-dark { color: #2e603f; }
        .text-brand-green-light { color: #a5c0a8; }
        .bg-brand-green-dark { background-color: #1a432b; }
        .border-brand-green-dark { border-color: #1a432b; }
    </style>
</head>
<body class="font-sans antialiased">
    
    <div class="min-h-screen">
        <div class="container mx-auto px-6 py-4">
            
            <!-- ====== Top Header ====== -->
            <header class="flex items-center justify-between">
                <!-- Logo -->
                <a href="{{ url('/') }}" class="text-4xl font-bold text-brand-green-dark">
                    Easy<span class="font-light text-brand-green-light">Mart</span>
                </a>

                <!-- Search Bar -->
                <div class="w-1/3 relative">
                    <form action="#" method="GET">
                        <input type="text" placeholder="Cari barangmu di sini"
                               class="w-full py-2 px-4 pr-10 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3">
                            <!-- Ikon Search SVG -->
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <!-- Tombol Kanan -->
                <div class="flex items-center space-x-4">
                    <a href="#" class="flex items-center text-gray-700 hover:text-brand-green-dark">
                        <!-- Ikon Keranjang SVG -->
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="ml-2">Keranjang Belanja</span>
                    </a>
                    <a href="{{ route('register') }}" class="px-5 py-2 rounded-full text-white font-medium" style="background-color: #a5c0a8; hover:opacity-90;">
                        Daftar
                    </a>
                    <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-gray-700 font-medium border border-gray-400 hover:bg-gray-100">
                        Masuk
                    </a>
                </div>
            </header>

            <!-- ====== Menu Navigasi ====== -->
            <nav class="mt-6">
                <div class="max-w-4xl mx-auto bg-white rounded-full shadow-md flex justify-center space-x-12 px-8 py-3">
                    <a href="#" class="font-medium text-brand-green-dark border-b-2 border-brand-green-dark pb-1">Beranda</a>
                    <a href="#" class="font-medium text-gray-600 hover:text-brand-green-dark">Produk</a>
                    <a href="#" class="font-medium text-gray-600 hover:text-brand-green-dark">Pesanan Saya</a>
                    <a href="#" class="font-medium text-gray-600 hover:text-brand-green-dark">Chatting</a>
                    <a href="#" class="font-medium text-gray-600 hover:text-brand-green-dark">Toko Saya</a>
                </div>
            </nav>

            <!-- ====== Hero Section ====== -->
            <main class="mt-16">
                <div class="flex flex-col md:flex-row items-center">
                    
                    <!-- Kolom Kiri: Ilustrasi -->
                    <div class="w-full md:w-1/2">
                        <!-- GANTI URL INI dengan file ilustrasi 3D Anda -->
                        <img src="https://placehold.co/600x450/f0f4f0/a5c0a8?text=Ilustrasi+3D+EasyMart" 
                             alt="Ilustrasi EasyMart" 
                             class="w-full h-auto rounded-lg">
                    </div>

                    <!-- Kolom Kanan: Teks -->
                    <div class="w-full md:w-1/2 md:pl-16 text-center md:text-left mt-8 md:mt-0">
                        <h1 class="text-6xl font-bold text-brand-green-dark">
                            Selamat Datang di<br>
                            <span class="font-light text-brand-green-light">EasyMart</span>
                        </h1>
                        <p class="text-xl text-gray-600 mt-6 max-w-md mx-auto md:mx-0">
                            Semua kebutuhan kampus kamu tersedia di sini. Mulai jelajahi platform kami.
                        </p>

                        <!-- Tombol Hero -->
                        <div class="mt-10 flex space-x-6 justify-center md:justify-start">
                            <a href="#" 
                               class="px-8 py-3 rounded-full text-white text-lg font-medium bg-brand-green-dark hover:opacity-90 shadow-lg">
                                Jelajahi
                            </a>
                            <a href="{{ route('register') }}" 
                               class="px-8 py-3 rounded-full text-brand-green-dark text-lg font-medium border-2 border-brand-green-dark hover:bg-white shadow-lg">
                                Daftar
                            </a>
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>

</body>
</html>