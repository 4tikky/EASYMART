{{-- 1. Gunakan Layout Utama Platform --}}
@extends('layouts.platform')

{{-- 2. Judul Tab Browser --}}
@section('title', 'Laporan Produk by Rating')

{{-- 3. CSS Khusus Laporan (Dipindahkan ke stack 'head') --}}
@push('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Kita hapus style 'body' agar tidak merusak Layout Utama */
        
        /* Container diganti namanya jadi .report-paper agar tidak bentrok dengan tailwind */
        .report-paper {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            font-family: 'Roboto', Arial, Helvetica, sans-serif; /* Font khusus laporan */
            color: #2d3748;
        }

        /* HEADER LAPORAN (Bagian Hijau di dalam kertas) */
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

        /* BUTTON WRAPPER */
        .btn-wrapper {
            padding: 20px 30px;
            text-align: center;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
        }
        
        /* Custom Button Style (dikombinasikan dengan tailwind reset) */
        .btn-download-custom {
            display: inline-flex;
            align-items: center;
            background: linear-gradient(135deg, #1a432b 0%, #2d5a3d 100%);
            color: #fff;
            padding: 10px 24px;
            border-radius: 9999px; /* Pill shape */
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
            color: white; /* Memastikan text tetap putih */
        }
        .btn-download-custom::before {
            content: '📄';
            margin-right: 8px;
        }

        /* TABLE STYLES */
        .table-container {
            padding: 30px;
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            border-collapse: separate; /* Changed for border-radius to work */
            border-spacing: 0;
            margin: 0;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }
        .custom-table th, .custom-table td {
            border-bottom: 1px solid #e2e8f0;
            border-right: 1px solid #e2e8f0;
            padding: 12px 15px;
            font-size: 14px;
        }
        .custom-table th:last-child, .custom-table td:last-child {
            border-right: none;
        }
        .custom-table th {
            background: linear-gradient(to bottom, #f0fdf4, #dcfce7); /* Tailwind green-50 to green-100 */
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
            color: #166534; /* green-800 */
        }
        .custom-table tbody tr:nth-child(even) {
            background-color: #f8fafc; /* slate-50 */
        }
        .custom-table tbody tr:hover {
            background-color: #f1f5f9; /* slate-100 */
        }

        /* BADGES */
        .badge-custom {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 60px;
            padding: 4px 10px;
            border-radius: 99px;
            font-size: 12px;
            font-weight: 700;
        }
        .badge-good { background: #dcfce7; color: #15803d; border: 1px solid #86efac; } /* Green */
        .badge-medium { background: #fef9c3; color: #a16207; border: 1px solid #fde047; } /* Yellow */
        .badge-bad { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; } /* Red */

        /* FOOTNOTE */
        .footnote {
            padding: 15px 30px;
            font-size: 12px;
            color: #64748b;
            background: #f8fafc;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            font-style: italic;
        }
    </style>
@endpush

{{-- 4. Isi Konten Utama --}}
@section('content')

    {{-- Wrapper utama di Layout --}}
    <div class="w-full">
        
        {{-- Tombol Kembali (Optional, bagus untuk UX) --}}
        <div class="max-w-[1200px] mx-auto mb-4 px-4 sm:px-0">
            <a href="{{ route('platform.dashboard') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Kertas Laporan --}}
        <div class="report-paper">
            
            {{-- HEADER LAPORAN (Internal) --}}
            <div class="report-header">
                <p class="brand-title">EasyMart</p>
                <p class="report-title">Laporan Daftar Produk Berdasarkan Rating</p>
                <p class="meta">
                    Tanggal dibuat: <span>{{ $generatedAt->format('d-m-Y') }}</span> &nbsp;|&nbsp; 
                    Diproses oleh: <span>{{ $processedBy }}</span>
                </p>
            </div>

            {{-- TOMBOL DOWNLOAD PDF --}}
            @if (empty($export))
                <div class="btn-wrapper">
                    <a href="{{ route('platform.reports.products-by-rating.pdf') }}" class="btn-download-custom">
                        Unduh Laporan PDF
                    </a>
                </div>
            @endif

            {{-- TABEL DATA --}}
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width:50px;" class="text-center">No</th>
                            <th>Produk</th>
                            <th style="width:180px;">Kategori</th>
                            <th style="width:140px;" class="text-right">Harga</th>
                            <th style="width:100px;" class="text-center">Rating</th>
                            <th>Nama Toko</th>
                            <th style="width:150px;">Provinsi</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($rows as $index => $row)
                        @php
                            $rating = (float) $row->rating;
                            if ($rating >= 4) {
                                $badgeClass = 'badge-custom badge-good';
                                $icon = '⭐';
                            } elseif ($rating >= 3) {
                                $badgeClass = 'badge-custom badge-medium';
                                $icon = '⚠️';
                            } else {
                                $badgeClass = 'badge-custom badge-bad';
                                $icon = '❌';
                            }
                        @endphp
                        <tr>
                            <td class="text-center font-medium text-slate-500">{{ $index + 1 }}</td>
                            <td class="font-medium text-slate-700">{{ $row->product_name }}</td>
                            <td class="text-slate-600">{{ $row->category ?? '-' }}</td>
                            <td class="text-right font-mono text-slate-700">Rp {{ number_format($row->price, 0, ',', '.') }}</td>
                            <td class="text-center">
                                <span class="{{ $badgeClass }}">
                                    <span class="mr-1">{{ $icon }}</span> {{ $row->rating }}
                                </span>
                            </td>
                            <td class="text-slate-600">{{ $row->store_name }}</td>
                            <td class="text-slate-500 text-sm">{{ $row->reviewer_province ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-8 text-slate-400">Tidak ada data produk.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER KERTAS --}}
            <p class="footnote">
                Laporan ini dihasilkan secara otomatis oleh sistem EasyMart Platform pada {{ now()->format('d M Y H:i') }}.
            </p>
        </div>
        
        {{-- Spacer Bawah --}}
        <div class="h-10"></div>
    </div>

@endsection