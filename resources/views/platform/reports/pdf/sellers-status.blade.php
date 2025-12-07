<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Akun Penjual</title>
    <style>
        /* SETUP HALAMAN PDF (A4) */
        @page {
            margin: 2cm;
            size: A4 portrait;
        }

        /* RESET STYLE */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif; /* Font standar PDF */
            font-size: 11px;
            color: #333;
            background-color: #fff;
            margin: 0;
            padding: 0;
        }

        /* HEADER LAPORAN (TABLE LAYOUT) */
        .header-table {
            width: 100%;
            margin-bottom: 20px;
            border-bottom: 2px solid #1a432b; /* Hijau Tebal */
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

        /* TOMBOL DOWNLOAD (HANYA MUNCUL DI WEB) */
        .no-print {
            text-align: right;
            margin-bottom: 20px;
        }
        .btn-download {
            background-color: #1a432b;
            color: #fff;
            padding: 8px 15px;
            text-decoration: none;
            font-size: 12px;
            border-radius: 4px;
            font-weight: bold;
        }

        /* TABEL DATA UTAMA */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .data-table thead th {
            background-color: #1a432b; /* Header Hijau */
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
        /* Zebra Striping */
        .data-table tbody tr:nth-child(even) {
            background-color: #f2f7f4;
        }
        /* Page Break Prevention */
        .data-table tr {
            page-break-inside: avoid;
        }

        /* UTILITIES */
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-bold { font-weight: bold; }
        
        /* BADGES STATUS (FLAT COLORS FOR PDF) */
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
            color: #fff;
            text-align: center;
            min-width: 60px;
            text-transform: uppercase;
        }
        .bg-green { background-color: #2da44e; }  /* Aktif */
        .bg-yellow { background-color: #d29922; } /* Pending */
        .bg-red { background-color: #cf222e; }    /* Rejected/Non-Aktif */

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

    {{-- TOMBOL DOWNLOAD (HANYA DI WEB) --}}
    @if (empty($export))
        <div class="no-print">
            <a href="{{ route('platform.reports.sellers-status.pdf') }}" class="btn-download">
                Unduh PDF
            </a>
        </div>
    @endif

    {{-- HEADER MENGGUNAKAN TABLE --}}
    <table class="header-table">
        <tr>
            <td width="50%" valign="bottom">
                <h1 class="brand-text">EasyMart</h1>
                <p class="sub-brand">PLATFORM MANAGEMENT REPORT</p>
            </td>
            <td width="50%" valign="bottom">
                <h2 class="report-title">LAPORAN STATUS AKUN PENJUAL</h2>
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
                <th width="25%">Nama Pengguna (User)</th>
                <th width="25%">Nama PIC</th>
                <th width="25%">Nama Toko</th>
                <th width="20%" class="text-center">Status Verifikasi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($sellers as $index => $seller)
            @php
                // Logika Label & Badge Warna
                $statusLabel = match ($seller->status) {
                    'active'   => 'AKTIF',
                    'pending'  => 'PENDING',
                    'rejected' => 'DITOLAK',
                    default    => strtoupper($seller->status),
                };

                $badgeClass = match ($seller->status) {
                    'active'   => 'bg-green',
                    'pending'  => 'bg-yellow',
                    'rejected' => 'bg-red',
                    default    => 'bg-red',
                };
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-bold">{{ $seller->user->email }}</td>
                <td>{{ $seller->picName }}</td>
                <td>{{ $seller->storeName ?? '-' }}</td>
                <td class="text-center">
                    <span class="badge {{ $badgeClass }}">{{ $statusLabel }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center" style="padding: 20px;">
                    <em>Tidak ada data penjual yang ditemukan.</em>
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