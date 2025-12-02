{{-- 1. Extend Layout Utama --}}
@extends('layouts.platform')

{{-- 2. Judul Halaman --}}
@section('title', 'Laporan Status Seller')

{{-- 3. CSS Khusus Laporan (Dipindahkan ke stack 'head') --}}
@push('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Hapus style body global karena sudah dihandle layout utama */
        
        /* Container diganti jadi .report-paper agar visualnya seperti kertas di atas meja dashboard */
        .report-paper {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            overflow: hidden;
            font-family: 'Roboto', Arial, Helvetica, sans-serif;
            color: #2d3748;
            line-height: 1.6;
            font-size: 14px;
        }

        /* HEADER LAPORAN (Bagian Hijau) */
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
        
        /* Tombol Download Modern */
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

        /* TABLE STYLES */
        .table-container {
            padding: 30px;
            overflow-x: auto;
        }
        .custom-table {
            width: 100%;
            border-collapse: separate;
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
        }
        .custom-table th:last-child, .custom-table td:last-child {
            border-right: none;
        }
        .custom-table th {
            background: linear-gradient(to bottom, #f0fdf4, #dcfce7);
            font-weight: 600;
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            text-align: left;
            color: #166534;
        }
        .custom-table tbody tr:nth-child(even) {
            background-color: #f8fafc;
        }
        .custom-table tbody tr:hover {
            background-color: #f1f5f9;
        }

        /* BADGES */
        .badge-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 90px;
            padding: 4px 12px;
            border-radius: 99px;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.025em;
        }
        .badge-active { background: #dcfce7; color: #15803d; border: 1px solid #86efac; }
        .badge-pending { background: #fef9c3; color: #a16207; border: 1px solid #fde047; }
        .badge-inactive { background: #fee2e2; color: #b91c1c; border: 1px solid #fca5a5; }

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

{{-- 4. Konten Utama --}}
@section('content')

    <div class="w-full">
        
        {{-- Breadcrumb / Tombol Kembali --}}
        <div class="max-w-[1200px] mx-auto mb-4 px-4 sm:px-0">
            <a href="{{ route('platform.dashboard') }}" class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-700 transition-colors">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Dashboard
            </a>
        </div>

        {{-- Wrapper "Kertas" Laporan --}}
        <div class="report-paper">
            
            {{-- HEADER LAPORAN --}}
            <div class="report-header">
                <p class="brand-title">EasyMart</p>
                <p class="report-title">Laporan Akun Penjual Berdasarkan Status</p>
                <p class="meta">
                    Tanggal dibuat: <span>{{ $generatedAt->format('d-m-Y') }}</span> &nbsp;|&nbsp;
                    Diproses oleh: <span>{{ $processedBy }}</span>
                </p>
            </div>

            {{-- TOMBOL DOWNLOAD --}}
            @if (empty($export))
                <div class="btn-wrapper">
                    <a href="{{ route('platform.reports.sellers-status.pdf') }}" class="btn-download-custom">
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
                            <th>Username</th>
                            <th>Nama PIC</th>
                            <th>Nama Toko</th>
                            <th style="width:140px;" class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse ($sellers as $index => $seller)
                        @php
                            // Mapping Status Text
                            $statusLabel = match ($seller->status_verifikasi) {
                                \App\Models\User::STATUS_ACTIVE   => 'AKTIF',
                                \App\Models\User::STATUS_PENDING  => 'PENDING',
                                \App\Models\User::STATUS_REJECTED => 'TIDAK AKTIF',
                                default                           => strtoupper($seller->status_verifikasi),
                            };

                            // Mapping Badge Class
                            $badgeClass = match ($seller->status_verifikasi) {
                                \App\Models\User::STATUS_ACTIVE   => 'badge-status badge-active',
                                \App\Models\User::STATUS_PENDING  => 'badge-status badge-pending',
                                \App\Models\User::STATUS_REJECTED => 'badge-status badge-inactive',
                                default                           => 'badge-status badge-inactive',
                            };

                            // Icon logic
                            $icon = match ($seller->status_verifikasi) {
                                \App\Models\User::STATUS_ACTIVE   => '✅',
                                \App\Models\User::STATUS_PENDING  => '⏳',
                                \App\Models\User::STATUS_REJECTED => '❌',
                                default => '',
                            };
                        @endphp
                        <tr>
                            <td class="text-center font-medium text-slate-500">{{ $index + 1 }}</td>
                            <td class="font-medium text-slate-700">{{ $seller->user_login }}</td>
                            <td class="text-slate-600">{{ $seller->pic_name }}</td>
                            <td class="text-slate-600 font-medium">{{ $seller->nama_toko ?? '-' }}</td>
                            <td class="text-center">
                                <span class="{{ $badgeClass }}">
                                    <span class="mr-1">{{ $icon }}</span> {{ $statusLabel }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-8 text-slate-400 italic">Tidak ada data seller.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            {{-- FOOTER --}}
            <p class="footnote">
                Laporan ini dihasilkan secara otomatis oleh sistem EasyMart Platform pada {{ now()->format('d M Y H:i') }}.
            </p>
        </div>

        {{-- Spacer Bawah --}}
        <div class="h-10"></div>
    </div>
@endsection