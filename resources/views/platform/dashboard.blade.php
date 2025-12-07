@extends('layouts.platform')

@section('title', 'Dashboard Platform - EasyMart')

@push('head')
    {{-- Font Awesome & Google Fonts khusus dashboard --}}
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f7f6f2 0%, #e8f5e8 100%);
            color: #333;
        }
        .card-hover {
            transition: all 0.3s ease;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }
        .card-hover:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }
        .btn-gradient {
            background: linear-gradient(45deg, #1a432b, #2e603f);
            transition: all 0.3s ease;
        }
        .btn-gradient:hover {
            background: linear-gradient(45deg, #2e603f, #1a432b);
            transform: scale(1.02);
            box-shadow: 0 4px 10px rgba(46, 96, 63, 0.3);
        }
        .text-gradient {
            background: linear-gradient(45deg, #2e603f, #4a7c59);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
@endpush

@section('content')

    {{-- RINGKASAN SELLER (VERIFIKASI) --}}
    <section>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                <i class="fas fa-chart-line text-green-600"></i> Ringkasan Penjual
            </h2>
            
            <a href="{{ route('platform.categories.index') }}" 
               class="bg-white border border-green-600 text-green-600 hover:bg-green-50 font-semibold py-2 px-4 rounded-lg text-sm transition flex items-center gap-2 shadow-sm">
                <i class="fas fa-tags"></i> Kelola Kategori
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Pending --}}
            <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col justify-between card-hover border-l-4 border-yellow-400 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-50">
                    <i class="fas fa-clock text-6xl text-yellow-500"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-yellow-600 uppercase tracking-wider mb-1">MENUNGGU PERSETUJUAN</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $pendingCount }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('platform.sellers.index', ['status' => 'pending']) }}"
                       class="text-xs font-semibold text-yellow-600 hover:text-yellow-700 flex items-center gap-1">
                        Lihat detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Active --}}
            <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col justify-between card-hover border-l-4 border-green-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-50">
                    <i class="fas fa-check-circle text-6xl text-green-500"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-green-600 uppercase tracking-wider mb-1">AKTIF</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $activeCount }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('platform.sellers.index', ['status' => 'active']) }}"
                       class="text-xs font-semibold text-green-600 hover:text-green-700 flex items-center gap-1">
                        Lihat detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

            {{-- Rejected --}}
            <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col justify-between card-hover border-l-4 border-red-500 relative overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-50">
                    <i class="fas fa-times-circle text-6xl text-red-500"></i>
                </div>
                <div>
                    <p class="text-xs font-bold text-red-600 uppercase tracking-wider mb-1">DITOLAK</p>
                    <p class="text-4xl font-bold text-gray-800">{{ $rejectedCount }}</p>
                </div>
                <div class="mt-4 pt-4 border-t border-gray-100">
                    <a href="{{ route('platform.sellers.index', ['status' => 'rejected']) }}"
                       class="text-xs font-semibold text-red-600 hover:text-red-700 flex items-center gap-1">
                        Lihat detail <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- DASHBOARD GRAFIS --}}
    <section class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-chart-bar text-green-600"></i> Statistik Visual
        </h2>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Grafik: Produk per Kategori --}}
            <div class="bg-white rounded-xl shadow-sm p-5 card-hover border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">
                    Sebaran Produk per Kategori
                </h3>
                <div class="h-64">
                    <canvas id="chartProductsByCategory"></canvas>
                </div>
            </div>

            {{-- Grafik: Toko per Provinsi --}}
            <div class="bg-white rounded-xl shadow-sm p-5 card-hover border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">
                    Sebaran Toko per Provinsi
                </h3>
                <div class="h-64">
                    <canvas id="chartStoresByProvince"></canvas>
                </div>
            </div>

            {{-- Grafik: Seller aktif vs tidak aktif --}}
            <div class="bg-white rounded-xl shadow-sm p-5 card-hover border border-gray-100">
                <h3 class="text-sm font-semibold text-gray-700 mb-4 border-b pb-2">
                    Rasio Status Seller
                </h3>
                <div class="h-64 flex justify-center">
                    <canvas id="chartSellerStatus"></canvas>
                </div>
            </div>

            {{-- Ringkasan komentar & rating --}}
            <div class="bg-white rounded-xl shadow-sm p-6 flex flex-col justify-center items-center text-center card-hover border border-indigo-100 bg-gradient-to-br from-indigo-50 to-white">
                <div class="w-12 h-12 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 mb-3">
                    <i class="fas fa-star text-xl"></i>
                </div>
                <h3 class="text-gray-600 font-medium mb-1">Total Ulasan Masuk</h3>
                <p class="text-5xl font-bold text-indigo-600 mb-2 tracking-tight">
                    {{ $totalReviews }}
                </p>
                <p class="text-xs text-gray-500">
                    Dari <span class="font-bold text-indigo-700">{{ $totalReviewVisitors }}</span> pengunjung
                </p>
            </div>
        </div>
    </section>

    {{-- PUSAT LAPORAN --}}
    <section class="mt-10">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            <i class="fas fa-file-pdf text-green-600"></i> Pusat Laporan (PDF)
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

            {{-- Report Card 1 --}}
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200 hover:border-green-500 transition-colors group">
                <div class="flex items-start gap-4">
                    <div class="bg-green-100 p-3 rounded-lg text-green-600 group-hover:bg-green-600 group-hover:text-white transition">
                        <i class="fas fa-user-check text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Status Penjual</h3>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                            Laporan lengkap akun penjual berdasarkan status aktif/non-aktif.
                        </p>
                        <a href="{{ route('platform.reports.sellers-status') }}"
                           class="text-xs font-bold text-green-700 hover:underline flex items-center gap-1">
                            Lihat Laporan <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Report Card 2 --}}
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200 hover:border-blue-500 transition-colors group">
                <div class="flex items-start gap-4">
                    <div class="bg-blue-100 p-3 rounded-lg text-blue-600 group-hover:bg-blue-600 group-hover:text-white transition">
                        <i class="fas fa-map-marked-alt text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Lokasi Toko</h3>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                            Rekapitulasi sebaran lokasi toko berdasarkan provinsi.
                        </p>
                        <a href="{{ route('platform.reports.stores-by-province') }}"
                           class="text-xs font-bold text-blue-700 hover:underline flex items-center gap-1">
                            Lihat Laporan <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>

            {{-- Report Card 3 --}}
            <div class="bg-white rounded-xl shadow-sm p-5 border border-gray-200 hover:border-purple-500 transition-colors group">
                <div class="flex items-start gap-4">
                    <div class="bg-purple-100 p-3 rounded-lg text-purple-600 group-hover:bg-purple-600 group-hover:text-white transition">
                        <i class="fas fa-star text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Rating Produk</h3>
                        <p class="text-xs text-gray-500 mb-4 leading-relaxed">
                            Daftar produk dengan performa rating tertinggi ke terendah.
                        </p>
                        <a href="{{ route('platform.reports.products-by-rating') }}"
                           class="text-xs font-bold text-purple-700 hover:underline flex items-center gap-1">
                            Lihat Laporan <i class="fa-solid fa-eye"></i>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection

@push('scripts')
    {{-- Chart.js --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // Data dari controller
        const productCategoryLabels = {!! json_encode($productByCategory->pluck('category')) !!};
        const productCategoryData   = {!! json_encode($productByCategory->pluck('total')) !!};

        const storeProvinceLabels = {!! json_encode($sellerByProvince->pluck('province')) !!};
        const storeProvinceData   = {!! json_encode($sellerByProvince->pluck('total')) !!};

        const sellerStatusLabels = ['Aktif', 'Tidak Aktif'];
        const sellerStatusData   = [{{ $sellerActiveCount }}, {{ $sellerInactiveCount }}];

        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: { borderDash: [2, 4] },
                    ticks: {
                        stepSize: 1,
                        precision: 0
                    }
                },
                x: { grid: { display: false } }
            }
        };

        new Chart(document.getElementById('chartProductsByCategory'), {
            type: 'bar',
            data: {
                labels: productCategoryLabels,
                datasets: [{
                    label: 'Jumlah Produk',
                    data: productCategoryData,
                    backgroundColor: '#4a7c59',
                    borderRadius: 4,
                    barThickness: 30
                }]
            },
            options: commonOptions
        });

        new Chart(document.getElementById('chartStoresByProvince'), {
            type: 'bar',
            data: {
                labels: storeProvinceLabels,
                datasets: [{
                    label: 'Jumlah Toko',
                    data: storeProvinceData,
                    backgroundColor: '#3b82f6',
                    borderRadius: 4,
                    barThickness: 30
                }]
            },
            options: commonOptions
        });

        new Chart(document.getElementById('chartSellerStatus'), {
            type: 'doughnut',
            data: {
                labels: [
                    'Aktif ({{ $sellerActiveCount }})',
                    'Tidak Aktif ({{ $sellerInactiveCount }})'
                ],
                datasets: [{
                    data: sellerStatusData,
                    backgroundColor: ['#22c55e', '#ef4444'],
                    borderWidth: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20 } }
                },
                cutout: '70%'
            }
        });
    </script>
@endpush
