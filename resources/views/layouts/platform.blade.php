<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'EasyMart Platform')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>
<body class="font-sans antialiased bg-gray-50  text-slate-800">

    {{-- HEADER PLATFORM --}}
    <header class="bg-emerald-700 shadow-md sticky top-0 z-50">
        {{-- Background Pattern (Optional: memberi tekstur halus) --}}
        <div class="absolute inset-0 bg-gradient-to-r from-emerald-600 to-emerald-800 opacity-100"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">

            {{-- BAGIAN KIRI: BRANDING & KONTEKS --}}
            <div class="flex items-center gap-4">
                {{-- Logo Utama --}}
                <a href="{{ url('/') }}" class="flex items-center gap-2 group">
                    <div class="bg-white/10 p-1.5 rounded-lg group-hover:bg-white/20 transition-all duration-300">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white tracking-wide">
                        Easy<span class="font-light text-emerald-200">Mart</span>
                    </span>
                </a>

                {{-- Separator Vertical --}}
                <div class="hidden sm:block h-6 w-px bg-emerald-500/50 mx-2"></div>

                {{-- Page Title / Breadcrumb --}}
                <a href="{{ route('platform.dashboard') }}"
                   class="hidden sm:flex items-center gap-1 text-sm font-medium text-emerald-100 hover:text-white transition-colors duration-200">
                    <span>Platform Dashboard</span>
                </a>
            </div>

            {{-- BAGIAN KANAN: USER PROFILE & ACTIONS --}}
            <div class="flex items-center gap-3">
                
                {{-- User Profile Pill (Gabungan Nama & Avatar) --}}
                <div class="flex items-center gap-3 pl-4 pr-1 py-1 bg-emerald-800/40 rounded-full border border-emerald-500/30">
                    <div class="hidden md:flex flex-col items-end leading-none mr-1">
                        <span class="text-[10px] uppercase tracking-wider text-emerald-300 font-semibold">Admin</span>
                        <span class="text-sm font-medium text-white">
                            {{ Auth::user()->name ?? 'Admin Platform' }}
                        </span>
                    </div>
                    
                    <a href="{{ route('profile.edit') }}" class="relative group">
                        <div class="w-8 h-8 rounded-full bg-emerald-200 flex items-center justify-center text-emerald-800 font-bold shadow-sm group-hover:bg-white transition-colors">
                            {{-- Inisial Nama --}}
                            {{ substr(Auth::user()->name ?? 'A', 0, 1) }}
                        </div>
                    </a>
                </div>

                {{-- Tombol Logout (Minimalis) --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" 
                            class="p-2 rounded-full text-emerald-200 hover:text-white hover:bg-emerald-600/50 transition-all duration-200"
                            title="Keluar">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                    </button>
                </form>

            </div>
        </div>
    </header>

    {{-- KONTEN UTAMA --}}
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    @stack('scripts')
</body>
</html>