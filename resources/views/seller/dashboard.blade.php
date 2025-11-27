<x-app-layout>
    <div class="bg-green-700 pb-24 pt-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center">
                <div>
                    <h1 class="text-3xl font-bold text-white">
                        Dashboard Toko {{ $seller->storeName }}
                    </h1>
                    <p class="text-green-100 mt-2 text-sm">
                        Kelola produk, stok, dan pantau performa penjualanmu di sini.
                    </p>
                </div>
                <a href="{{ route('seller.product.create') }}" 
                   class="bg-white text-green-700 hover:bg-green-50 font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Upload Produk
                </a>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 border-l-4 border-green-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Produk</p>
                        <p class="text-2xl font-bold text-gray-800">{{ count($products) }}</p>
                    </div>
                </div>
            </div>
            
            <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 border-l-4 border-blue-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Total Stok Fisik</p>
                        <p class="text-2xl font-bold text-gray-800">{{ collect($productStocks)->sum() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 border-l-4 border-yellow-500">
                <div class="flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-500">Status Toko</p>
                        <p class="text-lg font-bold text-green-600 uppercase">{{ $seller->status }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Statistik Stok Produk</h3>
                <canvas id="stockChart"></canvas>
            </div>

            <div class="bg-white shadow-lg rounded-xl p-6">
                <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Rata-rata Rating Produk</h3>
                <canvas id="ratingChart"></canvas>
            </div>
        </div>

        <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-12">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center bg-gray-50">
                <h3 class="text-lg font-bold text-gray-700">Daftar Produk Anda</h3>
                <span class="text-xs text-gray-500">Menampilkan {{ count($products) }} produk terbaru</span>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-medium text-gray-900">
                                {{ $product->name }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-500">
                                <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs">
                                    {{ $product->category }}
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-900">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                @if($product->stock < 5)
                                    <span class="text-red-500 font-bold">{{ $product->stock }} (Menipis!)</span>
                                @else
                                    <span class="text-gray-900">{{ $product->stock }}</span>
                                @endif
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <button class="text-blue-600 hover:text-blue-900 text-sm font-medium">Edit</button>
                            </td>
                        </tr>
                        @endforeach
                        @if($products->isEmpty())
                        <tr>
                            <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                Belum ada produk. Silakan upload produk pertamamu!
                            </td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const labels = @json($productNames);
        const stockData = @json($productStocks);
        const ratingData = @json($productRatings);

        const ctxStock = document.getElementById('stockChart').getContext('2d');
        new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Stok',
                    data: stockData,
                    backgroundColor: 'rgba(16, 185, 129, 0.6)', // Warna Hijau EasyMart
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1,
                    borderRadius: 5
                }]
            },
            options: { 
                scales: { y: { beginAtZero: true } },
                responsive: true,
                plugins: { legend: { display: false } }
            }
        });

        const ctxRating = document.getElementById('ratingChart').getContext('2d');
        new Chart(ctxRating, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rating (0-5)',
                    data: ratingData,
                    backgroundColor: 'rgba(251, 191, 36, 0.2)', // Kuning Emas
                    borderColor: 'rgba(251, 191, 36, 1)',
                    borderWidth: 3,
                    tension: 0.4, // Garis melengkung halus
                    fill: true
                }]
            },
            options: { scales: { y: { min: 0, max: 5 } } }
        });
    </script>
</x-app-layout>