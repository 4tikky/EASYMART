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
        <h1 class="text-2xl font-bold text-brand-green-dark">
            EasyMart <span class="font-normal text-gray-500">Platform Dashboard</span>
        </h1>

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
        <h2 class="text-3xl font-bold mb-6" style="color:#2e603f;">
            Ringkasan Seller
        </h2>

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
