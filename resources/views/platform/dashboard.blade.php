@extends('layouts.platform')

@section('title', 'Dashboard Platform - EasyMart')

@push('head')
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        body {
            background: #f7f8fc;
        }

        .stats-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
            transition: all 0.3s ease;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .stats-card:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }

        .stat-value {
            font-size: 32px;
            font-weight: 700;
            color: #1a1d2e;
            line-height: 1;
            margin: 12px 0 4px 0;
        }

        .stat-label {
            font-size: 13px;
            font-weight: 500;
            color: #8b8d97;
            margin-bottom: 8px;
        }

        .percentage {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            font-size: 13px;
            font-weight: 600;
        }

        .percentage.up {
            color: #00c48c;
        }

        .percentage.down {
            color: #ff647c;
        }

        .chart-card {
            background: white;
            border-radius: 20px;
            padding: 24px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        }

        .chart-card.fixed-height {
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .chart-title {
            font-size: 16px;
            font-weight: 600;
            color: #1a1d2e;
        }

        .view-report {
            font-size: 13px;
            font-weight: 500;
            color: #8b8d97;
            text-decoration: none;
            transition: color 0.2s;
        }

        .view-report:hover {
            color: #00c48c;
        }

        .report-card {
            background: white;
            border-radius: 16px;
            padding: 20px;
            border: 1px solid #f0f1f7;
            transition: all 0.3s;
            cursor: pointer;
            display: block;
            text-decoration: none;
            color: inherit;
        }

        .report-card:hover {
            border-color: #00c48c;
            box-shadow: 0 4px 12px rgba(0, 196, 140, 0.1);
            transform: translateY(-2px);
        }

        .report-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 12px;
            transition: all 0.3s;
        }

        .report-card:hover .report-icon {
            transform: scale(1.1);
        }

        .report-title {
            font-size: 15px;
            font-weight: 600;
            color: #1a1d2e;
            margin-bottom: 4px;
        }

        .report-desc {
            font-size: 12px;
            color: #8b8d97;
            line-height: 1.5;
        }

        .section-header {
            font-size: 20px;
            font-weight: 700;
            color: #1a1d2e;
            margin-bottom: 20px;
        }

        /* Table Styles */
        .data-table {
            width: 100%;
            background: white;
            border-radius: 12px;
            overflow: hidden;
        }

        .data-table table {
            width: 100%;
            border-collapse: collapse;
        }

        .data-table thead {
            background: #f7f8fc;
        }

        .data-table th {
            padding: 12px 12px;
            text-align: left;
            font-size: 10px;
            font-weight: 600;
            color: #8b8d97;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .data-table td {
            padding: 12px;
            border-top: 1px solid #f0f1f7;
            font-size: 12px;
            color: #1a1d2e;
            vertical-align: middle;
        }

        .data-table tbody tr:hover {
            background: #f7f8fc;
        }

        .product-img {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            object-fit: cover;
        }

        .product-name {
            font-weight: 500;
            font-size: 12px;
            color: #1a1d2e;
            margin-bottom: 2px;
        }

        .product-date {
            font-size: 10px;
            color: #8b8d97;
        }

        .stock-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 8px;
            font-size: 10px;
            font-weight: 600;
            text-align: center;
            min-width: 45px;
        }

        .stock-high {
            background: #d1fae5;
            color: #00c48c;
        }

        .stock-medium {
            background: #fef3c7;
            color: #f59e0b;
        }

        .stock-low {
            background: #ffe5e9;
            color: #ff647c;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
        }

        .status-pending {
            background: #fff0ed;
            color: #ff9777;
        }

        .status-approved {
            background: #d1fae5;
            color: #00c48c;
        }

        .status-rejected {
            background: #ffe5e9;
            color: #ff647c;
        }

        .rating-stars {
            color: #f59e0b;
            font-size: 13px;
        }

        .rating-count {
            font-size: 10px;
            color: #8b8d97;
            margin-left: 4px;
        }

        /* Tab Styles */
        .tab-navigation {
            display: flex;
            gap: 8px;
            margin-bottom: 16px;
            border-bottom: 1px solid #f0f1f7;
        }

        .tab-btn {
            padding: 10px 16px;
            font-size: 12px;
            font-weight: 500;
            color: #8b8d97;
            background: none;
            border: none;
            border-bottom: 2px solid transparent;
            cursor: pointer;
            transition: all 0.2s;
        }

        .tab-btn:hover {
            color: #00c48c;
        }

        .tab-btn.active {
            color: #00c48c;
            border-bottom-color: #00c48c;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        /* Dropdown Styles */
        .dropdown {
            position: relative;
            display: inline-block;
        }

        .dropdown-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            font-size: 13px;
            font-weight: 500;
            color: white;
            background: #00c48c;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .dropdown-btn:hover {
            background: #00b37d;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            right: 0;
            top: 100%;
            margin-top: 8px;
            background: white;
            min-width: 220px;
            border-radius: 12px;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            overflow: hidden;
        }

        .dropdown-content.show {
            display: block;
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: #1a1d2e;
            text-decoration: none;
            transition: background 0.2s;
            border-bottom: 1px solid #f0f1f7;
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item:hover {
            background: #f7f8fc;
        }

        .dropdown-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dropdown-text {
            flex: 1;
        }

        .dropdown-title {
            font-size: 13px;
            font-weight: 600;
            color: #1a1d2e;
            margin-bottom: 2px;
        }

        .dropdown-desc {
            font-size: 11px;
            color: #8b8d97;
        }
    </style>
@endpush

@section('content')

<div class="max-w-7xl mx-auto px-6 py-8">
    
    {{-- Top Stats Row --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        {{-- Pending Card --}}
        <a href="{{ route('platform.sellers.index', ['status' => 'pending']) }}" class="stats-card cursor-pointer">
            <div class="stat-icon" style="background: #fff0ed;">
                <svg class="w-7 h-7" style="color: #ff9777;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                </svg>
            </div>
            <p class="stat-label">Menunggu Persetujuan</p>
            <p class="stat-value">{{ number_format($pendingCount) }}</p>
            <span class="percentage up">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                15.6%
            </span>
        </a>

        {{-- Active Card --}}
        <a href="{{ route('platform.sellers.index', ['status' => 'active']) }}" class="stats-card cursor-pointer">
            <div class="stat-icon" style="background: #d1fae5;">
                <svg class="w-7 h-7" style="color: #00c48c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <p class="stat-label">Seller Aktif</p>
            <p class="stat-value">{{ number_format($activeCount) }}</p>
            <span class="percentage down">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M14.707 12.293a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 111.414-1.414L9 14.586V3a1 1 0 012 0v11.586l2.293-2.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                6.2%
            </span>
        </a>

        {{-- Rejected Card --}}
        <a href="{{ route('platform.sellers.index', ['status' => 'rejected']) }}" class="stats-card cursor-pointer">
            <div class="stat-icon" style="background: #ffe5e9;">
                <svg class="w-7 h-7" style="color: #ff647c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <p class="stat-label">Ditolak</p>
            <p class="stat-value">{{ number_format($rejectedCount) }}</p>
            <span class="percentage up">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                3.5%
            </span>
        </a>
    </div>

    {{-- Charts Section --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
        {{-- Sebaran Produk Per Kategori --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Sebaran Produk Per Kategori</h3>
                <a href="#" class="view-report">View Report</a>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="productCategoryChart"></canvas>
            </div>
        </div>

        {{-- Sebaran Toko Per Provinsi --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Sebaran Toko Per Provinsi</h3>
                <a href="#" class="view-report">View Report</a>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="storeProvinceChart"></canvas>
            </div>
        </div>

        {{-- Rasio Status Seller --}}
        <div class="chart-card">
            <div class="chart-header">
                <h3 class="chart-title">Rasio Status Seller</h3>
                <a href="#" class="view-report">View Report</a>
            </div>
            <div style="position: relative; height: 250px;">
                <canvas id="sellerStatusChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Total Ulasan & Tabel dengan Tab --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        {{-- Total Ulasan --}}
        <div class="chart-card fixed-height">
            <div class="chart-header" style="margin-bottom: 16px;">
                <h3 class="chart-title">Total Ulasan Masuk</h3>
                <a href="#" class="view-report">View Report</a>
            </div>
            <div class="flex items-start gap-4" style="padding: 8px 0;">
                <div class="stat-icon" style="background: linear-gradient(135deg, #00c48c 0%, #00a67d 100%); width: 56px; height: 56px; flex-shrink: 0;">
                    <svg class="w-7 h-7 text-white" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <p class="stat-value" style="font-size: 28px; margin: 0 0 4px 0;">{{ number_format($totalReviews ?? 0) }}</p>
                    <p class="stat-label" style="margin-bottom: 6px;">Review dari pelanggan</p>
                    <span class="percentage up">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.293 7.707a1 1 0 010-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 01-1.414 1.414L11 5.414V17a1 1 0 11-2 0V5.414L6.707 7.707a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        8.2%
                    </span>
                </div>
            </div>
        </div>

        {{-- Tabel dengan Tab Navigation --}}
        <div class="chart-card" style="grid-column: span 2;">
            <div class="chart-header">
                <h3 class="chart-title">Data Overview</h3>
                <div class="dropdown">
                    <button class="dropdown-btn" onclick="toggleDropdown(event)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh Laporan
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
                        </svg>
                    </button>
                    <div class="dropdown-content">
                        <a href="{{ route('platform.reports.sellers-status') }}" class="dropdown-item">
                            <div class="dropdown-icon" style="background: #d1fae5;">
                                <svg class="w-4 h-4" style="color: #00c48c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="dropdown-text">
                                <div class="dropdown-title">Status Penjual</div>
                                <div class="dropdown-desc">Laporan status aktif/non-aktif</div>
                            </div>
                        </a>
                        <a href="{{ route('platform.reports.stores-by-province') }}" class="dropdown-item">
                            <div class="dropdown-icon" style="background: #d1fae5;">
                                <svg class="w-4 h-4" style="color: #00c48c;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                                </svg>
                            </div>
                            <div class="dropdown-text">
                                <div class="dropdown-title">Lokasi Toko</div>
                                <div class="dropdown-desc">Sebaran toko per provinsi</div>
                            </div>
                        </a>
                        <a href="{{ route('platform.reports.products-by-rating') }}" class="dropdown-item">
                            <div class="dropdown-icon" style="background: #fef3c7;">
                                <svg class="w-4 h-4" style="color: #f59e0b;" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                </svg>
                            </div>
                            <div class="dropdown-text">
                                <div class="dropdown-title">Rating Produk</div>
                                <div class="dropdown-desc">Produk dengan rating terbaik</div>
                            </div>
                        </a>
                        <a href="{{ route('platform.reports.products-by-category') }}" class="dropdown-item">
                            <div class="dropdown-icon" style="background: #e9d5ff;">
                                <svg class="w-4 h-4" style="color: #9333ea;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                </svg>
                            </div>
                            <div class="dropdown-text">
                                <div class="dropdown-title">Kategori Produk</div>
                                <div class="dropdown-desc">Statistik per kategori</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
            
            {{-- Tab Navigation --}}
            <div class="tab-navigation">
                <button class="tab-btn active" onclick="switchTab(event, 'sellers')">Status Penjual</button>
                <button class="tab-btn" onclick="switchTab(event, 'products')">Rating Produk</button>
                <button class="tab-btn" onclick="switchTab(event, 'stores')">Lokasi Toko</button>
            </div>

            {{-- Tab Content: Status Penjual --}}
            <div id="sellers" class="tab-content active">
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>TOKO</th>
                                <th>PROVINSI</th>
                                <th>STATUS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentSellers as $seller)
                            <tr>
                                <td>
                                    <div class="product-name">{{ Str::limit($seller->name, 12) }}</div>
                                    <div class="product-date">{{ $seller->created_at->format('d M Y') }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 11px; color: #8b8d97;">{{ Str::limit($seller->provinsi ?? 'DAERAH ISTIM...', 15) }}</div>
                                </td>
                                <td>
                                    @if($seller->status_verifikasi == 'pending')
                                        <span class="status-badge status-pending">Pending</span>
                                    @elseif($seller->status_verifikasi == 'approved')
                                        <span class="status-badge status-approved">Active</span>
                                    @else
                                        <span class="status-badge status-rejected">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center" style="color: #8b8d97; padding: 20px;">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab Content: Rating Produk --}}
            <div id="products" class="tab-content">
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>PRODUK</th>
                                <th>KATEGORI</th>
                                <th>STOK</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($topProducts as $product)
                            <tr>
                                <td>
                                    <div style="display: flex; align-items: center; gap: 10px;">
                                        <img src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/40' }}" alt="{{ $product->name }}" class="product-img">
                                        <div>
                                            <div class="product-name">{{ Str::limit($product->name, 18) }}</div>
                                            <div class="product-date">Rp{{ number_format($product->price, 0, ',', '.') }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div style="font-size: 11px; color: #1a1d2e;">{{ Str::limit($product->category ?? '-', 12) }}</div>
                                </td>
                                <td>
                                    @php
                                        $stock = $product->stock ?? 0;
                                        $stockClass = $stock > 20 ? 'stock-high' : ($stock > 5 ? 'stock-medium' : 'stock-low');
                                    @endphp
                                    <span class="stock-badge {{ $stockClass }}">{{ $stock }}</span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center" style="color: #8b8d97; padding: 20px;">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Tab Content: Lokasi Toko --}}
            <div id="stores" class="tab-content">
                <div class="data-table">
                    <table>
                        <thead>
                            <tr>
                                <th>TOKO</th>
                                <th>PROVINSI</th>
                                <th>KOTA</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentStores as $store)
                            <tr>
                                <td>
                                    <div class="product-name">{{ Str::limit($store->name, 12) }}</div>
                                    <div class="product-date">{{ $store->created_at->format('d M Y') }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 11px; color: #8b8d97;">{{ Str::limit($store->provinsi ?? 'DAERAH ISTIM...', 15) }}</div>
                                </td>
                                <td>
                                    <div style="font-size: 11px; color: #8b8d97;">{{ $store->kota ?? '-' }}</div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center" style="color: #8b8d97; padding: 20px;">Tidak ada data</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

</div>

@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Data dari controller
        const productCategoryLabels = {!! json_encode($productByCategory->pluck('category') ?? []) !!};
        const productCategoryData = {!! json_encode($productByCategory->pluck('total') ?? []) !!};

        const storeProvinceLabels = {!! json_encode($sellerByProvince->pluck('province') ?? []) !!};
        const storeProvinceData = {!! json_encode($sellerByProvince->pluck('total') ?? []) !!};

        const sellerActiveCount = {{ $sellerActiveCount ?? 0 }};
        const sellerInactiveCount = {{ $sellerInactiveCount ?? 0 }};

        // Product Category Chart
        const productCategoryCtx = document.getElementById('productCategoryChart').getContext('2d');
        new Chart(productCategoryCtx, {
            type: 'bar',
            data: {
                labels: productCategoryLabels,
                datasets: [{
                    label: 'Jumlah Produk',
                    data: productCategoryData,
                    backgroundColor: '#00c48c',
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { 
                            font: { size: 11 },
                            color: '#8b8d97'
                        }
                    },
                    y: {
                        grid: { color: '#f0f1f7', drawBorder: false },
                        ticks: { 
                            font: { size: 11 },
                            color: '#8b8d97',
                            stepSize: 1
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Store Province Chart
        const storeProvinceCtx = document.getElementById('storeProvinceChart').getContext('2d');
        new Chart(storeProvinceCtx, {
            type: 'bar',
            data: {
                labels: storeProvinceLabels,
                datasets: [{
                    label: 'Jumlah Toko',
                    data: storeProvinceData,
                    backgroundColor: '#00c48c',
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: { 
                            font: { size: 11 },
                            color: '#8b8d97'
                        }
                    },
                    y: {
                        grid: { color: '#f0f1f7', drawBorder: false },
                        ticks: { 
                            font: { size: 11 },
                            color: '#8b8d97',
                            stepSize: 1
                        },
                        beginAtZero: true
                    }
                }
            }
        });

        // Seller Status Chart (Doughnut)
        const sellerStatusCtx = document.getElementById('sellerStatusChart').getContext('2d');
        new Chart(sellerStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['Aktif', 'Tidak Aktif'],
                datasets: [{
                    data: [sellerActiveCount, sellerInactiveCount],
                    backgroundColor: ['#5f63f2', '#ff647c'],
                    borderWidth: 0,
                    hoverOffset: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '65%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            usePointStyle: true,
                            padding: 20,
                            font: { size: 12, weight: '500' },
                            color: '#4b5563'
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        padding: 12,
                        cornerRadius: 8,
                        titleFont: { size: 13, weight: '600' },
                        bodyFont: { size: 12 }
                    }
                }
            }
        });

        // Tab Switching Function
        function switchTab(event, tabId) {
            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab-btn');
            tabs.forEach(tab => tab.classList.remove('active'));
            
            // Hide all tab contents
            const contents = document.querySelectorAll('.tab-content');
            contents.forEach(content => content.classList.remove('active'));
            
            // Add active class to clicked tab
            event.currentTarget.classList.add('active');
            
            // Show selected tab content
            document.getElementById(tabId).classList.add('active');
        }

        // Dropdown Toggle Function
        function toggleDropdown(event) {
            event.stopPropagation();
            const dropdown = event.currentTarget.nextElementSibling;
            dropdown.classList.toggle('show');
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const dropdowns = document.querySelectorAll('.dropdown-content');
            dropdowns.forEach(dropdown => {
                if (!dropdown.previousElementSibling.contains(event.target)) {
                    dropdown.classList.remove('show');
                }
            });
        });
    </script>
@endpush
