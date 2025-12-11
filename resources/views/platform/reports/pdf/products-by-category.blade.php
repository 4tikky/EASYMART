<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Per Kategori</title>
    <style>
        @page {
            margin: 2cm;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a432b;
            padding-bottom: 10px;
        }
        .brand-text {
            font-size: 24px;
            font-weight: bold;
            color: #1a432b;
            text-transform: uppercase;
            margin: 0;
        }
        .sub-brand {
            font-size: 10px;
            color: #666;
            margin-top: 2px;
            letter-spacing: 1px;
        }
        .report-title {
            font-size: 16px;
            font-weight: bold;
            text-align: right;
            color: #333;
            margin: 0;
        }
        .report-meta {
            font-size: 10px;
            text-align: right;
            color: #666;
            margin-top: 5px;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table thead th {
            background-color: #1a432b;
            color: #ffffff;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            padding: 10px 8px;
            text-align: left;
            border: 1px solid #1a432b;
        }
        .data-table tbody td {
            padding: 8px;
            font-size: 10px;
            border: 1px solid #ddd;
            vertical-align: middle;
        }
        .data-table tbody tr:nth-child(even) {
            background-color: #f2f7f4;
        }
        .data-table tr {
            page-break-inside: avoid;
        }

        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        
        .badge-cat {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            background-color: #e0e7ff;
            color: #3730a3;
        }

        .footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 30px;
            font-size: 9px;
            color: #888;
            border-top: 1px solid #ddd;
            padding-top: 5px;
        }
        .page-number:after {
            content: counter(page);
        }

        .summary-box {
            margin-top: 15px;
            padding: 10px;
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
        }
    </style>
</head>
<body>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td width="50%" valign="bottom">
                <h1 class="brand-text">EasyMart</h1>
                <p class="sub-brand">PLATFORM MANAGEMENT REPORT</p>
            </td>
            <td width="50%" valign="bottom">
                <h2 class="report-title">LAPORAN PRODUK PER KATEGORI</h2>
                <div class="report-meta">
                    Dicetak pada: {{ $generatedAt->format('d/m/Y H:i') }} <br>
                    Oleh Admin: {{ $processedBy }}
                </div>
            </td>
        </tr>
    </table>

    {{-- TABEL DATA --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="20%">Kategori</th>
                <th width="30%">Nama Produk</th>
                <th width="20%">Toko</th>
                <th width="13%" class="text-right">Harga</th>
                <th width="12%" class="text-center">Stok</th>
            </tr>
        </thead>
        <tbody>
            @forelse($products as $index => $product)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>
                    <span class="badge-cat">{{ $product->category ?? 'Tanpa Kategori' }}</span>
                </td>
                <td class="text-bold">{{ $product->name }}</td>
                <td>{{ $product->seller->storeName ?? '-' }}</td>
                <td class="text-right">Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td class="text-center">{{ $product->stock }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 20px; color: #999;">
                    Tidak ada data produk
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- SUMMARY --}}
    <div class="summary-box">
        <table width="100%">
            <tr>
                <td width="33%" class="text-center">
                    <strong>Total Produk:</strong> {{ $products->count() }}
                </td>
                <td width="33%" class="text-center">
                    <strong>Kategori:</strong> {{ $products->pluck('category')->unique()->count() }}
                </td>
                <td width="34%" class="text-center">
                    <strong>Total Nilai:</strong> Rp {{ number_format($products->sum('price'), 0, ',', '.') }}
                </td>
            </tr>
        </table>
    </div>

    {{-- FOOTER (Nomor Halaman) --}}
    <div class="footer">
        <table width="100%">
            <tr>
                <td width="50%" class="text-left">
                    &copy; {{ date('Y') }} EasyMart Platform
                </td>
                <td width="50%" class="text-right">
                    Halaman <span class="page-number"></span>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
