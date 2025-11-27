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
        /* Hover effects */
        .hover-text-brand:hover { color: #1a432b; }
    </style>
</head>
<body class="font-sans antialiased">
    
    <div class="min-h-screen">
        <div class="container mx-auto px-6 py-4">
            
            <header class="flex items-center justify-between">
                <a href="{{ url('/') }}" class="text-4xl font-bold text-brand-green-dark">
                    Easy<span class="font-light text-brand-green-light">Mart</span>
                </a>

                <div class="w-1/3 relative hidden md:block">
                    <form action="#" method="GET">
                        <input type="text" placeholder="Cari barangmu di sini"
                               class="w-full py-2 px-4 pr-10 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-transparent">
                        <button type="submit" class="absolute right-0 top-0 mt-2 mr-3">
                            <svg class="h-6 w-6 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-4">
                

                    @auth
                        <div class="flex items-center space-x-3 ml-4">
                            <span class="text-brand-green-dark font-semibold hidden md:inline">
                                Hi, {{ Auth::user()->name }} 
                            </span>
                            
                            <a href="{{ url('/dashboard') }}" class="text-sm text-gray-500 underline hover:text-brand-green-dark">
                                Dashboard
                            </a>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="px-4 py-2 rounded-full bg-red-100 text-red-600 text-sm font-medium hover:bg-red-200 transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="flex space-x-2">
                            <a href="{{ route('register') }}" class="px-5 py-2 rounded-full text-white font-medium hover:opacity-90 transition" style="background-color: #a5c0a8;">
                                Daftar
                            </a>
                            <a href="{{ route('login') }}" class="px-5 py-2 rounded-full text-gray-700 font-medium border border-gray-400 hover:bg-gray-100 transition">
                                Masuk
                            </a>
                        </div>
                    @endauth
                </div>
            </header>

            <nav class="mt-6">
                <div class="max-w-4xl mx-auto bg-white rounded-full shadow-md flex justify-center space-x-4 md:space-x-12 px-4 md:px-8 py-3 overflow-x-auto">
                    <a href="{{ url('/') }}" class="font-medium text-brand-green-dark border-b-2 border-brand-green-dark pb-1 whitespace-nowrap">Beranda</a>
                    <a href="#" class="font-medium text-gray-600 hover-text-brand whitespace-nowrap">Produk</a>
                    <a href="#" class="font-medium text-gray-600 hover-text-brand whitespace-nowrap">Chatting</a>
                    
                    @auth
                        @if(Auth::user()->seller)
                            <a href="{{ route('seller.dashboard') }}" class="font-bold text-green-700 hover:text-green-900 whitespace-nowrap">
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

            <main class="mt-10 md:mt-16">
                <div class="flex flex-col md:flex-row items-center">
                    
                    <div class="w-full md:w-1/2 mb-8 md:mb-0">
                        <div class="w-full h-64 md:h-96 bg-gray-200 rounded-lg flex items-center justify-center text-gray-400">
                           <img src="https://placehold.co/600x450/f0f4f0/a5c0a8?text=Ilustrasi+3D+EasyMart" 
                                alt="Ilustrasi EasyMart" 
                                class="w-full h-full object-cover rounded-lg shadow-lg">
                        </div>
                    </div>

                    <div class="w-full md:w-1/2 md:pl-16 text-center md:text-left">
                        <h1 class="text-4xl md:text-6xl font-bold text-brand-green-dark leading-tight">
                            Selamat Datang di<br>
                            <span class="font-light text-brand-green-light">EasyMart</span>
                        </h1>
                        <p class="text-lg md:text-xl text-gray-600 mt-6 max-w-md mx-auto md:mx-0">
                            Semua kebutuhan kampus kamu tersedia di sini. Mulai jelajahi platform kami sekarang juga.
                        </p>

                        <div class="mt-10 flex space-x-4 justify-center md:justify-start">
                            <a href="#" 
                               class="px-8 py-3 rounded-full text-white text-lg font-medium bg-brand-green-dark hover:opacity-90 shadow-lg transition transform hover:-translate-y-1">
                                Jelajahi
                            </a>
                            
                            @guest
                                <a href="{{ route('register') }}" 
                                   class="px-8 py-3 rounded-full text-brand-green-dark text-lg font-medium border-2 border-brand-green-dark hover:bg-white shadow-lg transition transform hover:-translate-y-1">
                                    Daftar
                                </a>
                            @endguest
                        </div>
                    </div>

                </div>
            </main>

            <footer class="mt-20 text-center text-gray-500 text-sm py-4">
                &copy; {{ date('Y') }} EasyMart. All rights reserved.
            </footer>

        </div>
    </div>

</body>
</html>