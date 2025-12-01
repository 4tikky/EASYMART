<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Produk Berdasarkan Stock</title>
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
        }
        .info {
            margin-bottom: 20px;
            font-size: 12px;
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
            background-color: #4CAF50;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
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
        <h2>LAPORAN DAFTAR PRODUK BERDASARKAN STOCK</h2>
        <p>{{ $seller->storeName }}</p>
    </div>

    <div class="info">
        <p><strong>Tanggal dibuat:</strong> {{ $date }} {{ $time }}</p>
        <p><strong>Oleh:</strong> {{ $seller->picName }} ({{ Auth::user()->name }})</p>
        <p><strong>Jumlah Produk:</strong> {{ $products->count() }} item</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%">No</th>
                <th style="width: 30%">Produk</th>
                <th style="width: 20%">Kategori</th>
                <th style="width: 15%">Harga</th>
                <th style="width: 15%">Rating</th>
                <th style="width: 15%">Stock</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $index => $product)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->category }}</td>
                <td>Rp {{ number_format($product->price, 0, ',', '.') }}</td>
                <td>{{ number_format($product->reviews_avg_rating ?? 0, 1) }} ⭐</td>
                <td>{{ $product->stock }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dokumen ini digenerate secara otomatis oleh sistem EASYMART</p>
        <p>{{ $date }} - {{ $time }}</p>
    </div>
</body>
</html>
