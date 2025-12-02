{{-- 1. Extend Layout Utama yang sudah dibuat --}}
@extends('layouts.platform')

{{-- 2. Set Judul Halaman --}}
@section('title', 'Daftar Seller - EasyMart')

{{-- 3. Masukkan CSS Khusus Halaman ini ke Stack 'head' --}}
@push('head')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        /* Kita hapus style 'body' agar mengikuti background dari Layout Utama */
        
        .container-custom {
            /* Ganti nama class agar tidak bentrok dengan tailwind container */
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.05);
            overflow: hidden;
            /* Margin diatur oleh parent padding di layout */
        }

        .section-header {
            display: flex;
            align-items: center;
            font-size: 20px;
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 16px;
        }
        .section-header::before {
            content: '👥';
            margin-right: 8px;
            font-size: 24px;
        }
        
        /* Filter Button Styles */
        .filter-btn {
            display: inline-flex;
            align-items: center;
            padding: 8px 16px;
            border-radius: 25px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 13px; /* Penyesuaian ukuran */
        }
        .filter-btn.active {
            background: linear-gradient(135deg, #059669 0%, #047857 100%); /* Sesuaikan dengan Emerald theme */
            color: #fff;
        }
        .filter-btn:not(.active) {
            background: #fff;
            color: #047857;
            border: 1px solid #059669;
        }
        .filter-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        /* Badge Styles */
        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }
        .badge-pending { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .badge-active { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-rejected { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* Action Buttons */
        .btn-action {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.2s ease;
            color: white;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .btn-detail { background-color: #3b82f6; }
        .btn-detail:hover { background-color: #2563eb; }
        
        .btn-approve { background-color: #10b981; }
        .btn-approve:hover { background-color: #059669; }
        
        .btn-reject { background-color: #ef4444; }
        .btn-reject:hover { background-color: #dc2626; }

        /* Table Styling Overrides */
        th {
            background-color: #f0fdf4; /* Emerald-50 */
            color: #065f46;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.05em;
        }
    </style>
@endpush

{{-- 4. Masukkan Konten Utama ke Section 'content' --}}
@section('content')

    {{-- Container Utama (Isi Halaman) --}}
    <div class="container-custom w-full">
        <div class="p-6 sm:p-8">
            
            @php
                use App\Models\User;
                $labelMap = [
                    User::STATUS_PENDING  => 'Pending',
                    User::STATUS_ACTIVE   => 'Disetujui',
                    User::STATUS_REJECTED => 'Ditolak',
                ];
                $statusLabel = $labelMap[$status] ?? ucfirst($status);
            @endphp

            {{-- Header Bagian Atas (Judul & Filter) --}}
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
                <div>
                    <h2 class="section-header !mb-1">
                        Daftar Seller ({{ $statusLabel }})
                    </h2>
                    <p class="text-sm text-slate-500 ml-9">
                        Kelola data seller dengan status: <span class="font-semibold text-emerald-700">{{ strtolower($statusLabel) }}</span>
                    </p>
                </div>

                {{-- Filter Buttons --}}
                <div class="flex flex-wrap gap-2 ml-8 md:ml-0">
                    <a href="{{ route('platform.sellers.index', ['status' => User::STATUS_PENDING]) }}"
                       class="filter-btn {{ $status === User::STATUS_PENDING ? 'active' : '' }}">
                       ⏳ Pending
                    </a>

                    <a href="{{ route('platform.sellers.index', ['status' => User::STATUS_ACTIVE]) }}"
                       class="filter-btn {{ $status === User::STATUS_ACTIVE ? 'active' : '' }}">
                       ✅ Active
                    </a>

                    <a href="{{ route('platform.sellers.index', ['status' => User::STATUS_REJECTED]) }}"
                       class="filter-btn {{ $status === User::STATUS_REJECTED ? 'active' : '' }}">
                       ❌ Rejected
                    </a>
                </div>
            </div>

            {{-- Alert Flash Message --}}
            @if (session('status'))
                <div class="mb-6 p-4 rounded-lg bg-emerald-100 border border-emerald-200 text-emerald-800 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    {{ session('status') }}
                </div>
            @endif

            {{-- Tabel Data --}}
            <div class="overflow-hidden border border-gray-200 rounded-lg">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm divide-y divide-gray-200">
                        <thead>
                            <tr class="divide-x divide-gray-200 border-b border-gray-300">
                                <th class="py-3 px-4 text-left">Nama Toko</th>
                                <th class="py-3 px-4 text-left">Nama PIC</th>
                                <th class="py-3 px-4 text-left">Email</th>
                                <th class="py-3 px-4 text-left">No HP</th>
                                <th class="py-3 px-4 text-left">Lokasi</th>
                                <th class="py-3 px-4 text-left">Status</th>
                                <th class="py-3 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse ($sellers as $seller)
                            <tr class="divide-x divide-gray-200 hover:bg-slate-50 transition-colors duration-150">
                                <td class="py-3 px-4 font-semibold text-gray-800">{{ $seller->nama_toko }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $seller->name }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $seller->email }}</td>
                                <td class="py-3 px-4 text-gray-600">{{ $seller->no_handphone_pic }}</td>
                                <td class="py-3 px-4 text-gray-600">
                                    {{ $seller->kabupaten_kota }}, {{ $seller->propinsi ?? $seller->provinsi }}
                                </td>
                                <td class="py-3 px-4">
                                    <span class="badge-status
                                        @if($seller->status_verifikasi === User::STATUS_PENDING) badge-pending
                                        @elseif($seller->status_verifikasi === User::STATUS_ACTIVE) badge-active
                                        @else badge-rejected @endif">
                                        {{ $seller->status_verifikasi }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center justify-center gap-2">
                                        {{-- Tombol Detail (Selalu Muncul) --}}
                                        <a href="{{ route('platform.sellers.show', $seller->id) }}"
                                           class="btn-action btn-detail" title="Lihat Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>

                                        @if ($seller->status_verifikasi === 'pending')
                                            {{-- Form Approve --}}
                                            <form method="POST" action="{{ route('platform.sellers.approve', $seller->id) }}">
                                                @csrf
                                                <button type="submit" class="btn-action btn-approve" title="Setujui" onclick="return confirm('Setujui seller ini?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                                </button>
                                            </form>

                                            {{-- Form Reject --}}
                                            <form method="POST" action="{{ route('platform.sellers.reject', $seller->id) }}">
                                                @csrf
                                                <button type="submit" class="btn-action btn-reject" title="Tolak" onclick="return confirm('Tolak seller ini?')">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-8 text-center text-gray-400 italic">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        Tidak ada seller dengan status ini.
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-4 py-4 bg-gray-50 border-t border-gray-200">
                    {{ $sellers->links() }}
                </div>
            </div>
            
        </div>
    </div>

@endsection