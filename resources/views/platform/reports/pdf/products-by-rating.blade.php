<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Produk Rating</title>
    <style>
        /* SETUP HALAMAN PDF (A4) */
        @page {
            margin: 2cm;
            size: A4 portrait;
        }

        /* RESET STYLE */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif; /* Font standar PDF yang aman */
            font-size: 11px; /* Ukuran font standar surat */
            color: #333;
            background-color: #fff; /* Hemat tinta, background putih */
            margin: 0;
            padding: 0;
        }

        /* HEADER LAPORAN */
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a432b; /* Garis tebal hijau */
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

        /* TABEL DATA UTAMA */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table thead th {
            background-color: #1a432b; /* Header Hijau Gelap */
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
            border: 1px solid #ddd; /* Grid tipis */
            vertical-align: middle;
        }
        /* Zebra Striping (Baris selang-seling) */
        .data-table tbody tr:nth-child(even) {
            background-color: #f2f7f4;
        }
        /* Mencegah baris terpotong saat ganti halaman */
        .data-table tr {
            page-break-inside: avoid;
        }

        /* UTILITIES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        
        /* BADGES RATING (Versi Print Friendly - Flat Color) */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            min-width: 25px;
        }
        .bg-green { background-color: #2da44e; } /* Good */
        .bg-yellow { background-color: #d29922; } /* Medium */
        .bg-red { background-color: #cf222e; }    /* Bad */

        /* FOOTER HALAMAN */
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
    </style>
</head>
<body>

    {{-- HEADER MENGGUNAKAN TABLE (Lebih rapi di PDF) --}}
    <table class="header-table">
        <tr>
            <td width="50%" valign="bottom">
                <h1 class="brand-text">EasyMart</h1>
                <p class="sub-brand">PLATFORM MANAGEMENT REPORT</p>
            </td>
            <td width="50%" valign="bottom">
                <h2 class="report-title">LAPORAN RATING PRODUK</h2>
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
                <th width="25%">Nama Produk</th>
                <th width="15%">Kategori</th>
                <th width="15%" class="text-right">Harga (IDR)</th>
                <th width="10%" class="text-center">Rating</th>
                <th width="15%">Nama Toko</th>
                <th width="15%">Provinsi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($rows as $index => $row)
            @php
                $rating = (float) $row->rating;
                // Logika Badge
                if ($rating >= 4.5) {
                    $badgeClass = 'bg-green';
                } elseif ($rating >= 3) {
                    $badgeClass = 'bg-yellow';
                } else {
                    $badgeClass = 'bg-red';
                }
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-bold">{{ $row->product_name }}</td>
                <td>{{ $row->category ?? '-' }}</td>
                <td class="text-right">{{ number_format($row->price, 0, ',', '.') }}</td>
                <td class="text-center">
                    <span class="badge {{ $badgeClass }}">{{ number_format($rating, 1) }}</span>
                </td>
                <td>{{ $row->store_name }}</td>
                <td>{{ $row->reviewer_province ?? '-' }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center" style="padding: 20px;">
                    <em>Tidak ada data yang tersedia untuk laporan ini.</em>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

    {{-- FOOTER KHUSUS PDF --}}
    <div class="footer">
        <table width="100%">
            <tr>
                <td width="70%">Dokumen ini digenerate secara otomatis oleh Sistem EasyMart.</td>
                <td width="30%" class="text-right">Halaman <span class="page-number"></span></td>
            </tr>
        </table>
    </div>

</body>
</html>