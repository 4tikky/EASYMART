<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Segera Dipesan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 5px 0;
            color: #D32F2F;
        }
        .info {
            margin-bottom: 20px;
            font-size: 12px;
        }
        .warning {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 10px;
            margin: 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #FFC107;
            color: #333;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        .low-stock {
            background-color: #ffebee !important;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            font-size: 11px;
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>⚠️ LAPORAN PRODUK SEGERA DIPESAN</h2>
        <p>{{ $seller->storeName }}</p>
    </div>

    <div class="info">
        <p><strong>Tanggal dibuat:</strong> {{ $date }} {{ $time }}</p>
        <p><strong>Oleh:</strong> {{ $seller->picName }} ({{ Auth::user()->name }})</p>
        <p><strong>Jumlah Produk Stock Rendah:</strong> {{ $products->count() }} item</p>
    </div>

    @if($products->count() > 0)
    <div class="warning">
        <strong>⚠️ PERHATIAN!</strong><br>
        Produk-produk berikut memiliki stock kurang dari 10 unit. Segera lakukan pemesanan ulang untuk menghindari kehabisan stock!
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 35%">Produk</th>
                <th style="width: 20%">Kategori</th>
                <th style="width: 20%">Harga</th>
                <th style="width: 20%">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr class="{{ $product->stock < 5 ? 'low-stock' : '' }}">
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>
                    {{ $product->stock }} 
                    @if($product->stock < 5)
                        <span style="color: red;">● KRITIS</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div style="text-align: center; padding: 40px; background-color: #d4edda; border-radius: 8px; margin-top: 20px;">
        <h3 style="color: #155724;">✓ Semua Produk Aman!</h3>
        <p>Tidak ada produk dengan stock rendah saat ini.</p>
    </div>
    @endif

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem EASYMART</p>
        <p>{{ $date }} - {{ $time }}</p>
    </div>
</body>
</html>
