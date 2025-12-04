<x-app-layout>
    <style>
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fadeInUp {
            animation: fadeInUp 0.5s ease-out;
        }

        .card-hover {
            transition: all 0.3s ease;
        }

        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        }

        .gradient-green-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        }

        .gradient-green-light {
            background: linear-gradient(135deg, #34d399 0%, #10b981 100%);
        }

        .gradient-teal {
            background: linear-gradient(135deg, #14b8a6 0%, #0d9488 100%);
        }

        .gradient-emerald {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
        }

        .glassmorphism {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .sort-btn {
            transition: all 0.2s;
        }

        .sort-btn:hover {
            background-color: #d1fae5;
        }

        .sort-btn.active {
            background-color: #10b981;
            color: white;
            font-weight: 600;
        }

        .donut-chart-container {
            position: relative;
            width: 100%;
            height: 280px;
        }

        .chart-legend-custom {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 0;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            margin-right: 8px;
        }
    </style>

    <div class="min-h-screen bg-gray-50 p-6">
        <div class="max-w-[1400px] mx-auto">
            
            <!-- Top Navigation Bar -->
            <div class="bg-gray-900 rounded-2xl px-6 py-4 mb-6 flex items-center justify-between">
                <div class="flex items-center gap-8">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-emerald-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        </div>
                        <span class="text-white font-bold text-lg">{{ $seller->storeName }}</span>
                    </div>
                    <nav class="hidden lg:flex items-center gap-6">
                        <button class="bg-gray-800 text-white px-4 py-2 rounded-lg font-semibold text-sm">Dashboard</button>
                        <button onclick="scrollToProductList()" class="text-gray-400 hover:text-white px-4 py-2 rounded-lg font-semibold text-sm transition">Products</button>
                        <button class="text-gray-400 hover:text-white px-4 py-2 rounded-lg font-semibold text-sm transition">Analytics</button>
                    </nav>
                </div>
                <div class="flex items-center gap-4">
                    <div class="relative hidden md:block">
                        <input type="text" placeholder="Search Anything..." class="bg-gray-800 text-gray-300 px-4 py-2 rounded-lg text-sm w-64 focus:outline-none focus:ring-2 focus:ring-emerald-500">
                        <svg class="w-5 h-5 text-gray-400 absolute right-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <button onclick="addProduct()" class="bg-emerald-500 hover:bg-emerald-600 text-white px-4 py-2 rounded-lg font-semibold text-sm transition flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span class="hidden sm:inline">Add Product</span>
                    </button>
                </div>
            </div>

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column: Cards -->
                <div class="lg:col-span-1 space-y-6">

                    <!-- Sales Categories Chart -->
                    <div class="glassmorphism rounded-2xl p-6 shadow-lg card-hover animate-fadeInUp border border-gray-200" style="animation-delay: 0.2s;">
                        <div class="mb-4">
                            <h3 class="text-lg font-bold text-gray-900">Product Categories</h3>
                            <p class="text-xs text-gray-500">Distribution by category.</p>
                        </div>
                        <div class="donut-chart-container mb-4">
                            <canvas id="categoryChart"></canvas>
                        </div>
                        <div class="chart-legend-custom">
                            @php
                                $categories = $products->groupBy('category');
                                $categoryColors = ['bg-emerald-500', 'bg-emerald-600', 'bg-emerald-700', 'bg-emerald-800', 'bg-green-400', 'bg-green-600', 'bg-teal-500'];
                                $colorIndex = 0;
                            @endphp
                            @foreach($categories as $category => $items)
                            <div class="legend-item {{ $loop->first ? 'border-t pt-3' : '' }}">
                                <div class="flex items-center">
                                    <span class="legend-color {{ $categoryColors[$colorIndex % count($categoryColors)] }}"></span>
                                    <span class="text-sm text-gray-700">{{ $category ?: 'Uncategorized' }}</span>
                                </div>
                                <span class="text-sm font-bold text-gray-900">{{ $items->count() }} Unit</span>
                            </div>
                            @php $colorIndex++; @endphp
                            @endforeach
                            
                            @if($categories->isEmpty())
                            <div class="text-center py-4 text-gray-500 text-sm">
                                No products yet
                            </div>
                            @endif
                        </div>
                    </div>

                </div>

                <!-- Right Column: Charts & Table -->
                <div class="lg:col-span-2 space-y-6">

                    <!-- Grafik Analisis Baru (3 Grafik) -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
                        <!-- 1. Sebaran Jumlah Stok Per Produk -->
                        <div class="glassmorphism rounded-2xl p-6 shadow-lg card-hover border border-gray-200 animate-fadeInUp" style="animation-delay: 0.5s;">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Stock Distribution</h3>
                                    <p class="text-xs text-gray-500">Product quantity by range</p>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                                </button>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <canvas id="stockDistributionChart" height="200"></canvas>
                            </div>
                        </div>

                        <!-- 2. Sebaran Rating Per Produk -->
                        <div class="glassmorphism rounded-2xl p-6 shadow-lg card-hover border border-gray-200 animate-fadeInUp" style="animation-delay: 0.6s;">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Rating Distribution</h3>
                                    <p class="text-xs text-gray-500">Products by rating level</p>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                </button>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <canvas id="ratingDistributionChart" height="200"></canvas>
                            </div>
                        </div>

                        <!-- 3. Sebaran Reviewer Berdasarkan Provinsi -->
                        <div class="glassmorphism rounded-2xl p-6 shadow-lg card-hover border border-gray-200 animate-fadeInUp" style="animation-delay: 0.7s;">
                            <div class="flex items-center justify-between mb-4">
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900">Reviews by Province</h3>
                                    <p class="text-xs text-gray-500">Top 10 reviewer locations</p>
                                </div>
                                <button class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                </button>
                            </div>
                            <div class="bg-gray-50 rounded-xl p-3">
                                <canvas id="provinceChart" height="200"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Product List Table -->
                    <div class="glassmorphism rounded-2xl shadow-lg border border-gray-200 overflow-hidden animate-fadeInUp" style="animation-delay: 0.5s;">
                        <div class="px-6 py-4 border-b border-gray-200 flex flex-col lg:flex-row items-start lg:items-center justify-between gap-4">
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Product List</h3>
                                <p class="text-xs text-gray-500">Manage your products inventory.</p>
                            </div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <button class="text-gray-600 hover:text-gray-900 text-sm font-semibold flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                                    Filter
                                </button>
                                <div class="relative inline-block">
                                    <button id="exportDropdownBtn" class="text-gray-600 hover:text-gray-900 text-sm font-semibold flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                        Export
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                    </button>
                                    <div id="exportDropdown" class="hidden absolute right-0 mt-2 w-56 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
                                        <div class="py-1">
                                            <a href="{{ route('seller.export.stock') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                                <div>
                                                    <div class="font-semibold">Export by Stock</div>
                                                    <div class="text-xs text-gray-500">Sorted highest to lowest</div>
                                                </div>
                                            </a>
                                            <a href="{{ route('seller.export.rating') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-emerald-50 hover:text-emerald-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                                                <div>
                                                    <div class="font-semibold">Export by Rating</div>
                                                    <div class="text-xs text-gray-500">Sorted best to worst</div>
                                                </div>
                                            </a>
                                            <a href="{{ route('seller.export.reorder') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-gray-700 hover:bg-red-50 hover:text-red-600 transition-colors">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                                <div>
                                                    <div class="font-semibold">Export Reorder Alert</div>
                                                    <div class="text-xs text-gray-500">Low stock products</div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter Tabs -->
                        <div class="px-6 py-3 bg-gray-50 border-b border-gray-200 overflow-x-auto">
                            <div class="flex items-center gap-2">
                                <button onclick="sortTable('default')" class="sort-btn active bg-emerald-500 text-white px-4 py-2 text-sm font-semibold rounded-lg whitespace-nowrap">
                                    All Products
                                </button>
                                <button onclick="sortTable('rating')" class="sort-btn bg-white text-gray-600 px-4 py-2 text-sm font-semibold rounded-lg whitespace-nowrap border border-gray-200">
                                    By Rating
                                </button>
                                <button onclick="sortTable('stock')" class="sort-btn bg-white text-gray-600 px-4 py-2 text-sm font-semibold rounded-lg whitespace-nowrap border border-gray-200">
                                    By Stock
                                </button>
                                <button onclick="sortTable('reorder')" class="sort-btn bg-white text-gray-600 px-4 py-2 text-sm font-semibold rounded-lg whitespace-nowrap border border-gray-200">
                                    Reorder Point
                                </button>
                            </div>
                        </div>

                        <div class="overflow-x-auto">
                            <table class="min-w-full">
                                <thead>
                                    <tr class="bg-gray-50 border-b border-gray-200">
                                        <th class="px-6 py-3 text-left">
                                            <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Product ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Product Name</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Stock</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Price</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Rating</th>
                                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody id="productTableBody" class="bg-white divide-y divide-gray-100">
                                    @foreach($products as $product)
                                    <tr class="hover:bg-gray-50 transition-colors product-row" 
                                        data-rating="{{ $product->reviews_avg_rating ?? 0 }}"
                                        data-stock="{{ $product->stock }}"
                                        data-reorder="{{ $product->stock < 10 ? 1 : 0 }}">
                                        <td class="px-6 py-4">
                                            <input type="checkbox" class="rounded border-gray-300 text-emerald-600 focus:ring-emerald-500">
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <span class="font-semibold text-gray-900">#{{ str_pad($product->id, 4, '0', STR_PAD_LEFT) }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex items-center gap-3">
                                                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                                    @if($product->image)
                                                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover rounded-lg">
                                                    @else
                                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="font-medium text-gray-900">{{ Str::limit($product->name, 40) }}</div>
                                                    <div class="text-xs text-gray-500">{{ $product->created_at->format('d M Y') }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-600">
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $product->category ?: 'Uncategorized' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            @if($product->stock < 10)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-red-100 text-red-800">
                                                    {{ $product->stock }} units
                                                </span>
                                            @elseif($product->stock < 25)
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-yellow-100 text-yellow-800">
                                                    {{ $product->stock }} units
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-semibold bg-emerald-100 text-emerald-800">
                                                    {{ $product->stock }} units
                                                </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-sm whitespace-nowrap">
                                            <span class="font-bold text-gray-900">Rp{{ number_format($product->price, 0, ',', '.') }}</span>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex items-center gap-1">
                                                <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                </svg>
                                                <span class="font-semibold text-gray-900">{{ number_format($product->reviews_avg_rating ?? 0, 1) }}</span>
                                                <span class="text-gray-500 text-xs">({{ $product->reviews_count ?? 0 }})</span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm">
                                            <div class="flex items-center gap-2">
                                                <button onclick="editProduct({{ $product->id }})" class="text-gray-400 hover:text-emerald-600 transition" title="Edit">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                </button>
                                                <form action="{{ route('seller.product.delete', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-gray-400 hover:text-red-600 transition" title="Delete">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>

            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/seller-dashboard.js') }}"></script>
    <script>
        // Export dropdown toggle
        document.addEventListener('DOMContentLoaded', function() {
            const exportBtn = document.getElementById('exportDropdownBtn');
            const exportDropdown = document.getElementById('exportDropdown');
            
            if (exportBtn && exportDropdown) {
                exportBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    exportDropdown.classList.toggle('hidden');
                });
                
                // Close dropdown when clicking outside
                document.addEventListener('click', function(e) {
                    if (!exportBtn.contains(e.target) && !exportDropdown.contains(e.target)) {
                        exportDropdown.classList.add('hidden');
                    }
                });
            }
        });
        
        // Scroll to Product List
        function scrollToProductList() {
            const productList = document.querySelector('.glassmorphism.rounded-2xl.shadow-lg');
            if (productList) {
                productList.scrollIntoView({ behavior: 'smooth', block: 'start' });
            }
        }
        
        // Sorting functionality
        function sortTable(type) {
            const tbody = document.getElementById('productTableBody');
            const rows = Array.from(tbody.getElementsByClassName('product-row'));
            
            // Remove active class from all buttons
            document.querySelectorAll('.sort-btn').forEach(btn => {
                btn.classList.remove('active');
                btn.classList.remove('bg-emerald-500', 'text-white');
                btn.classList.add('text-gray-600', 'bg-white', 'border', 'border-gray-200');
            });
            
            // Add active class to clicked button
            event.target.classList.add('active', 'bg-emerald-500', 'text-white');
            event.target.classList.remove('text-gray-600', 'bg-white', 'border', 'border-gray-200');
            
            let sortedRows;
            
            switch(type) {
                case 'rating':
                    sortedRows = rows.sort((a, b) => {
                        const ratingA = parseFloat(a.dataset.rating) || 0;
                        const ratingB = parseFloat(b.dataset.rating) || 0;
                        return ratingB - ratingA;
                    });
                    break;
                    
                case 'stock':
                    sortedRows = rows.sort((a, b) => {
                        const stockA = parseInt(a.dataset.stock) || 0;
                        const stockB = parseInt(b.dataset.stock) || 0;
                        return stockB - stockA;
                    });
                    break;
                    
                case 'reorder':
                    sortedRows = rows.sort((a, b) => {
                        const reorderA = parseInt(a.dataset.reorder) || 0;
                        const reorderB = parseInt(b.dataset.reorder) || 0;
                        return reorderB - reorderA;
                    });
                    break;
                    
                default:
                    sortedRows = rows;
                    break;
            }
            
            tbody.innerHTML = '';
            sortedRows.forEach(row => tbody.appendChild(row));
        }

        // Chart.js Data
        const labels = @json($productNames);
        const stockData = @json($productStocks);
        const ratingData = @json($productRatings);

        // Category Donut Chart
        const ctxCategory = document.getElementById('categoryChart').getContext('2d');
        const categoryData = @json($categoryData);
        const categoryLabels = Object.keys(categoryData);
        const categoryValues = Object.values(categoryData);
        const categoryColors = ['#10b981', '#059669', '#047857', '#065f46', '#064e3b', '#6ee7b7', '#34d399'];
        
        new Chart(ctxCategory, {
            type: 'doughnut',
            data: {
                labels: categoryLabels.length > 0 ? categoryLabels : ['No Data'],
                datasets: [{
                    data: categoryValues.length > 0 ? categoryValues : [1],
                    backgroundColor: categoryLabels.length > 0 ? categoryColors.slice(0, categoryLabels.length) : ['#e5e7eb'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                cutout: '70%',
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' products (' + percentage + '%)';
                            }
                        }
                    }
                }
            }
        });

        // ======= GRAFIK BARU =======
        
        // 1. Stock Distribution Chart (Bar Chart)
        const stockDistData = @json($stockDistribution);
        const ctxStockDist = document.getElementById('stockDistributionChart').getContext('2d');
        new Chart(ctxStockDist, {
            type: 'bar',
            data: {
                labels: Object.keys(stockDistData),
                datasets: [{
                    label: 'Products',
                    data: Object.values(stockDistData),
                    backgroundColor: ['#ef4444', '#f97316', '#eab308', '#22c55e', '#10b981'],
                    borderRadius: 6,
                    barThickness: 30
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.y + ' products';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10 }, color: '#6b7280' }
                    },
                    y: {
                        beginAtZero: true,
                        grid: { color: 'rgba(229, 231, 235, 0.5)' },
                        ticks: { 
                            stepSize: 1,
                            font: { size: 10 }, 
                            color: '#6b7280' 
                        }
                    }
                }
            }
        });

        // 2. Rating Distribution Chart (Doughnut Chart)
        const ratingDistData = @json($ratingDistribution);
        const ctxRatingDist = document.getElementById('ratingDistributionChart').getContext('2d');
        new Chart(ctxRatingDist, {
            type: 'doughnut',
            data: {
                labels: Object.keys(ratingDistData),
                datasets: [{
                    data: Object.values(ratingDistData),
                    backgroundColor: ['#fbbf24', '#fb923c', '#f59e0b', '#ef4444', '#dc2626', '#e5e7eb'],
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'bottom',
                        labels: {
                            font: { size: 10 },
                            color: '#374151',
                            padding: 10,
                            usePointStyle: true
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                const percentage = ((context.parsed / total) * 100).toFixed(1);
                                return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                            }
                        }
                    }
                },
                cutout: '60%'
            }
        });

        // 3. Reviews by Province Chart (Horizontal Bar Chart)
        const provinceData = @json($reviewsByProvince);
        const ctxProvince = document.getElementById('provinceChart').getContext('2d');
        new Chart(ctxProvince, {
            type: 'bar',
            data: {
                labels: Object.keys(provinceData),
                datasets: [{
                    label: 'Reviews',
                    data: Object.values(provinceData),
                    backgroundColor: '#10b981',
                    borderRadius: 4,
                    barThickness: 16
                }]
            },
            options: {
                indexAxis: 'y',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.parsed.x + ' reviews';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        beginAtZero: true,
                        grid: { color: 'rgba(229, 231, 235, 0.5)' },
                        ticks: { 
                            stepSize: 1,
                            font: { size: 9 }, 
                            color: '#6b7280' 
                        }
                    },
                    y: {
                        grid: { display: false },
                        ticks: { 
                            font: { size: 9 }, 
                            color: '#374151',
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                return label.length > 15 ? label.substring(0, 15) + '...' : label;
                            }
                        }
                    }
                }
            }
        });
    </script>
</x-app-layout>
