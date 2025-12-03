<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Toko Per Provinsi</title>
    <style>
        @page {
            margin: 2cm;
            size: A4 potrait; /* kamu pakai setPaper('A4', 'potrait') di controller */
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
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
            background-color: #fff;
        }
        
        .page-number:after {
            content: counter(page);
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
            color: #fff;
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
        .group-header {
            background-color: #e8f5e9;
            font-weight: bold;
            color: #1a432b;
        }
        .text-center { text-align: center; }
        .text-bold { font-weight: bold; }
        .text-right { text-align: right; }
    </style>
</head>
<body>

    {{-- FOOTER --}}
    <div class="footer">
        <table width="100%">
            <tr>
                <td width="70%">
                    Dokumen ini digenerate secara otomatis oleh Sistem EasyMart.
                </td>
                <td width="30%" class="text-right">
                    Halaman <span class="page-number"></span>
                </td>
            </tr>
        </table>
    </div>

    {{-- HEADER --}}
    <table class="header-table">
        <tr>
            <td width="50%" valign="bottom">
                <h1 class="brand-text">EasyMart</h1>
                <p class="sub-brand">PLATFORM MANAGEMENT REPORT</p>
            </td>
            <td width="50%" valign="bottom">
                <h2 class="report-title">LAPORAN SEBARAN TOKO</h2>
                <div class="report-meta">
                    Dicetak pada: {{ $generatedAt->format('d/m/Y H:i') }} <br>
                    Oleh Admin: {{ $processedBy }}
                </div>
            </td>
        </tr>
    </table>

    {{-- TABEL KONTEN --}}
    <table class="data-table">
        <thead>
            <tr>
                <th width="5%" class="text-center">No</th>
                <th width="30%">Provinsi</th>
                <th width="35%">Nama Toko</th>
                <th width="30%">Nama PIC</th>
            </tr>
        </thead>
        <tbody>
        @php 
            $currentProv = null; 
            $no = 1;
        @endphp

        @forelse ($stores as $index => $store)
            {{-- Jika ganti provinsi, tampilkan header grup --}}
            @if ($currentProv !== $store->province)
                @php $currentProv = $store->province; @endphp
                <tr class="group-header">
                    <td colspan="4">{{ strtoupper($currentProv ?? 'TIDAK DIKETAHUI') }}</td>
                </tr>
            @endif

            <tr>
                <td class="text-center">{{ $no++ }}</td>
                <td>{{ $store->province ?? '-' }}</td>
                <td class="text-bold">{{ $store->store_name }}</td>
                <td>{{ $store->pic_name }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center" style="padding: 20px;">
                    <em>Tidak ada data toko yang ditemukan.</em>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>

</body>
</html>
