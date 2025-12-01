<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Platform - EasyMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" style="background-color:#f7f6f2;">

    {{-- HEADER BAR --}}
    <header class="flex justify-between items-center px-10 py-4 bg-white shadow">
        <div class="flex items-center gap-4">
            <a href="{{ url('/') }}" class="text-gray-600 hover:text-brand-green-dark transition group" title="Kembali ke Beranda">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-brand-green-dark">
                EasyMart <span class="font-normal text-gray-500">Platform Dashboard</span>
            </h1>
        </div>

        <div class="flex items-center space-x-6">
            <span class="text-gray-700">
                {{ Auth::user()->name }} (Platform)
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white rounded-full"
                    style="background-color:#1a432b;">
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="px-10 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold" style="color:#2e603f;">
                Ringkasan Seller
            </h2>
            
            <a href="{{ route('platform.categories.index') }}" 
               class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                Kelola Kategori
            </a>
        </div>

        {{-- GRID 3 KOLOM --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Pending --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-sm text-gray-500 mb-1">PENDING</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $pendingCount }}</p>

                <a href="{{ route('platform.sellers.index', ['status' => 'pending']) }}"
                   class="text-sm mt-2 inline-block" style="color:#2e603f;">
                    Lihat daftar →
                </a>
            </div>

            {{-- Active --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-sm text-gray-500 mb-1">ACTIVE</p>
                <p class="text-3xl font-bold text-green-700">{{ $activeCount }}</p>

                <a href="{{ route('platform.sellers.index', ['status' => 'active']) }}"
                   class="text-sm mt-2 inline-block" style="color:#2e603f;">
                    Lihat daftar →
                </a>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-2xl shadow p-6">
                <p class="text-sm text-gray-500 mb-1">REJECTED</p>
                <p class="text-3xl font-bold text-red-600">{{ $rejectedCount }}</p>

                <a href="{{ route('platform.sellers.index', ['status' => 'rejected']) }}"
                   class="text-sm mt-2 inline-block" style="color:#2e603f;">
                    Lihat daftar →
                </a>
            </div>

        </div>
    </main>

</body>
</html>
