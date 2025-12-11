@extends('layouts.platform')

@section('title', 'Laporan Produk by Kategori')

@push('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .report-paper {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            font-family: 'Roboto', Arial, Helvetica, sans-serif;
            color: #2d3748;
        }

        .report-header {
            background: linear-gradient(135deg, #1a432b 0%, #2d5a3d 100%);
            color: #fff;
            padding: 24px 30px;
            border-bottom: 2px solid #0f2a1a;
        }
        .brand-title {
            font-size: 24px;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
        }
        .brand-title::before {
            content: '🛒';
            margin-right: 10px;
            font-size: 28px;
        }
        .report-title {
            font-size: 18px;
            font-weight: 500;
            margin: 8px 0 0;
            opacity: 0.95;
        }
        .meta {
            font-size: 13px;
            margin-top: 12px;
            opacity: 0.8;
            font-weight: 300;
        }
        .meta span {
            font-weight: 600;
        }

        .btn-wrapper {
            padding: 20px 30px;
            text-align: center;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        .btn-download-custom {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #1a432b 0%, #2d5a3d 100%);
            color: #fff;
            padding: 10px 24px;
            border-radius: 9999px;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 12px rgba(26, 67, 43, 0.2);
            border: none;
            cursor: pointer;
        }
        .btn-download-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(26, 67, 43, 0.3);
            color: white;
        }
        .btn-download-custom::before {
            content: '📄';
            margin-right: 8px;
        }

        .table-container {
            padding: 30px;
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 14px;
            border-radius: 8px;
            overflow: hidden;
        }
        .custom-table thead {
            background: linear-gradient(135deg, #1a432b 0%, #2d5a3d 100%);
            color: #fff;
        }
        .custom-table thead th {
            padding: 14px 16px;
            text-align: left;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        .custom-table tbody tr {
            border-bottom: 1px solid #e2e8f0;
            transition: background-color 0.2s;
        }
        .custom-table tbody tr:hover {
            background-color: #f7fafc;
        }
        .custom-table tbody td {
            padding: 14px 16px;
            color: #4a5568;
        }
        .custom-table tbody tr:last-child {
            border-bottom: none;
        }

        .badge-category {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        
        .price-text {
            font-weight: 600;
            color: #2d5a3d;
        }

        .stock-badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
        }
        .stock-high {
            background: #d1fae5;
            color: #065f46;
        }
        .stock-medium {
            background: #fef3c7;
            color: #92400e;
        }
        .stock-low {
            background: #fee2e2;
            color: #991b1b;
        }

        .footer-info {
            padding: 20px 30px;
            background: #f8fafc;
            font-size: 12px;
            color: #718096;
            text-align: center;
            border-top: 1px solid #e2e8f0;
        }
    </style>
@endpush

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8">
    <div class="report-paper">
        {{-- Header --}}
        <div class="report-header">
            <h1 class="brand-title">EasyMart Platform</h1>
            <h2 class="report-title">Laporan Produk Berdasarkan Kategori</h2>
            <p class="meta">
                Dicetak pada: <span>{{ $generatedAt->format('d F Y, H:i') }} WIB</span><br>
                Diproses oleh: <span>{{ $processedBy }}</span>
            </p>
        </div>

        {{-- Button Download PDF --}}
        @if(!$export)
        <div class="btn-wrapper">
            <a href="{{ route('platform.reports.products-by-category.pdf') }}" class="btn-download-custom">
                Unduh PDF
            </a>
        </div>
        @endif

        {{-- Table --}}
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">No</th>
                        <th style="width: 20%;">Kategori</th>
                        <th style="width: 30%;">Nama Produk</th>
                        <th style="width: 20%;">Toko</th>
                        <th style="width: 12%;">Harga</th>
                        <th style="width: 13%;">Stok</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $index => $product)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>
                            <span class="badge-category" style="background: {{ ['#e0e7ff', '#fef3c7', '#fee2e2', '#d1fae5', '#e9d5ff'][($index % 5)] }}; color: {{ ['#3730a3', '#92400e', '#991b1b', '#065f46', '#6b21a8'][($index % 5)] }};">
                                {{ $product->category ?? 'Tanpa Kategori' }}
                            </span>
                        </td>
                        <td style="font-weight: 500;">{{ $product->name }}</td>
                        <td>{{ $product->seller->storeName ?? '-' }}</td>
                        <td class="price-text">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                        <td>
                            @if($product->stock > 20)
                                <span class="stock-badge stock-high">{{ $product->stock }} unit</span>
                            @elseif($product->stock > 5)
                                <span class="stock-badge stock-medium">{{ $product->stock }} unit</span>
                            @else
                                <span class="stock-badge stock-low">{{ $product->stock }} unit</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px; color: #a0aec0;">
                            Tidak ada data produk
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Footer --}}
        <div class="footer-info">
            <p>
                Total Produk: <strong>{{ $products->count() }}</strong> | 
                Kategori: <strong>{{ $products->pluck('category')->unique()->count() }}</strong>
            </p>
            <p style="margin-top: 8px; font-size: 11px;">
                &copy; {{ date('Y') }} EasyMart Platform - Laporan ini bersifat rahasia
            </p>
        </div>
    </div>
</div>
@endsection
