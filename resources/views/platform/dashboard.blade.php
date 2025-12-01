<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Dashboard Platform - EasyMart</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Chart.js untuk grafik SRS-07 --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
    <main class="px-10 py-8 space-y-10">

        {{-- RINGKASAN SELLER (VERIFIKASI) --}}
        <section>
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-3xl font-bold" style="color:#2e603f;">
                    Ringkasan Seller
                </h2>
                
                <a href="{{ route('platform.categories.index') }}" 
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                    Kelola Kategori
                </a>
            </div>

            {{-- GRID 3 KOLOM --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Pending --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-semibold uppercase">PENDING</p>
                        <p class="text-3xl font-bold text-yellow-600">{{ $pendingCount }}</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('platform.sellers.index', ['status' => 'pending']) }}"
                        class="text-sm inline-block font-semibold" style="color:#2e603f;">
                            Lihat daftar →
                        </a>
                    </div>
                </div>

                {{-- Active --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-semibold uppercase">ACTIVE</p>
                        <p class="text-3xl font-bold text-green-700">{{ $activeCount }}</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('platform.sellers.index', ['status' => 'active']) }}"
                        class="text-sm inline-block font-semibold" style="color:#2e603f;">
                            Lihat daftar →
                        </a>
                    </div>
                </div>

                {{-- Rejected --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-sm text-gray-500 mb-1 font-semibold uppercase">REJECTED</p>
                        <p class="text-3xl font-bold text-red-600">{{ $rejectedCount }}</p>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('platform.sellers.index', ['status' => 'rejected']) }}"
                        class="text-sm inline-block font-semibold" style="color:#2e603f;">
                            Lihat daftar →
                        </a>
                    </div>
                </div>

            </div>
        </section>

        {{-- ================= SRS-MartPlace-07: DASHBOARD GRAFIS ================= --}}
        <section>
            <h2 class="text-2xl font-bold mb-4" style="color:#2e603f;">
                Dashboard Grafis (SRS-MartPlace-07)
            </h2>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                {{-- Grafik: Produk per Kategori --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-2">
                        Sebaran Jumlah Produk per Kategori
                    </h3>
                    <canvas id="chartProductsByCategory" class="w-full h-64"></canvas>
                </div>

                {{-- Grafik: Toko per Provinsi --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-2">
                        Sebaran Jumlah Toko per Provinsi
                    </h3>
                    <canvas id="chartStoresByProvince" class="w-full h-64"></canvas>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mt-6">
                {{-- Grafik: Seller aktif vs tidak aktif --}}
                <div class="bg-white rounded-2xl shadow p-6">
                    <h3 class="text-base font-semibold text-gray-800 mb-2">
                        Jumlah Seller Aktif dan Tidak Aktif
                    </h3>
                    <canvas id="chartSellerStatus" class="w-full h-64"></canvas>
                </div>

                {{-- Ringkasan komentar & rating --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-center">
                    <h3 class="text-base font-semibold text-gray-800 mb-4">
                        Pengunjung yang Memberi Komentar &amp; Rating
                    </h3>
                    <p class="text-sm text-gray-600">
                        Total komentar &amp; rating yang masuk:
                    </p>
                    <p class="text-4xl font-bold mt-2" style="color:#2e603f;">
                        {{ $totalReviews }}
                    </p>
                    <p class="text-sm text-gray-500 mt-1">
                        Dari <span class="font-semibold">{{ $totalReviewVisitors }}</span> pengunjung unik.
                    </p>
                </div>
            </div>
        </section>

        {{-- =========== SRS-MartPlace-09,10,11: LAPORAN PDF =========== --}}
        <section>
            <h2 class="text-2xl font-bold mb-4" style="color:#2e603f;">
                Laporan Bagian Platform (PDF)
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- SRS-MartPlace-09 --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            SRS-MartPlace-09
                        </p>
                        <h3 class="mt-2 font-semibold text-gray-800">
                            Laporan Daftar Akun Penjual Berdasarkan Status
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Berisi nama user, PIC, nama toko, dan status,
                            diurutkan berdasarkan status (aktif lalu tidak aktif).
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('platform.reports.sellers-status') }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white"
                        style="background-color:#1a432b;">
                            Unduh Laporan PDF
                        </a>
                    </div>
                </div>

                {{-- SRS-MartPlace-10 --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            SRS-MartPlace-10
                        </p>
                        <h3 class="mt-2 font-semibold text-gray-800">
                            Laporan Daftar Toko Berdasarkan Lokasi Provinsi
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Berisi nama toko, PIC, dan provinsi, diurutkan berdasarkan nama provinsi.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('platform.reports.stores-by-province') }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white"
                        style="background-color:#1a432b;">
                            Unduh Laporan PDF
                        </a>
                    </div>
                </div>

                {{-- SRS-MartPlace-11 --}}
                <div class="bg-white rounded-2xl shadow p-6 flex flex-col justify-between">
                    <div>
                        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            SRS-MartPlace-11
                        </p>
                        <h3 class="mt-2 font-semibold text-gray-800">
                            Laporan Daftar Produk Berdasarkan Rating
                        </h3>
                        <p class="mt-2 text-sm text-gray-600">
                            Berisi daftar produk yang diurutkan berdasarkan rating,
                            lengkap dengan kategori, harga, nama toko, dan provinsi pemberi rating.
                        </p>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('platform.reports.products-by-rating') }}"
                        class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold text-white"
                        style="background-color:#1a432b;">
                            Unduh Laporan PDF
                        </a>
                    </div>
                </div>

            </div>
        </section>

    </main>

    {{-- ================= SCRIPT CHART.JS ================= --}}
    <script>
        // Data dari controller
        const productCategoryLabels = {!! json_encode($productByCategory->pluck('category')) !!};
        const productCategoryData   = {!! json_encode($productByCategory->pluck('total')) !!};

        const storeProvinceLabels = {!! json_encode($storeByProvince->pluck('province')) !!};
        const storeProvinceData   = {!! json_encode($storeByProvince->pluck('total')) !!};

        const sellerStatusLabels = ['Aktif', 'Tidak Aktif'];
        const sellerStatusData   = [{{ $sellerActiveCount }}, {{ $sellerInactiveCount }}];

        // Chart: Produk per kategori
        new Chart(document.getElementById('chartProductsByCategory'), {
            type: 'bar',
            data: {
                labels: productCategoryLabels,
                datasets: [{
                    label: 'Jumlah Produk',
                    data: productCategoryData
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart: Toko per provinsi
        new Chart(document.getElementById('chartStoresByProvince'), {
            type: 'bar',
            data: {
                labels: storeProvinceLabels,
                datasets: [{
                    label: 'Jumlah Toko',
                    data: storeProvinceData
                }]
            },
            options: {
                responsive: true,
                scales: { y: { beginAtZero: true } }
            }
        });

        // Chart: Seller aktif vs tidak aktif
        new Chart(document.getElementById('chartSellerStatus'), {
            type: 'doughnut',
            data: {
                labels: sellerStatusLabels,
                datasets: [{
                    data: sellerStatusData
                }]
            },
            options: {
                responsive: true,
                plugins: { legend: { position: 'bottom' } }
            }
        });
    </script>

</body>
</html>
