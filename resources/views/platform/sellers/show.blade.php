{{-- 1. Extend Layout Utama --}}
@extends('layouts.platform')

{{-- 2. Judul Halaman --}}
@section('title', 'Detail Penjual - ' . $seller->storeName)

{{-- 3. CSS Tambahan --}}
@push('head')
    <style>
        .info-label {
            font-size: 0.85rem;
            color: #64748b; /* slate-500 */
            margin-bottom: 0.25rem;
            text-transform: uppercase;
            letter-spacing: 0.025em;
            font-weight: 600;
        }
        .info-value {
            font-size: 1rem;
            color: #1e293b; /* slate-800 */
            font-weight: 500;
        }
        .card-section {
            background-color: white;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            padding: 1.5rem;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            height: 100%;
        }
        .section-title {
            font-size: 1.125rem; /* text-lg */
            font-weight: 700;
            color: #0f172a; /* slate-900 */
            margin-bottom: 1.25rem;
            padding-bottom: 0.75rem;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
@endpush

{{-- 4. Konten Utama --}}
@section('content')

    <div class="w-full max-w-7xl mx-auto">

        {{-- NAVIGASI BALIK --}}
        <div class="mb-6">
            <a href="{{ route('platform.sellers.index', ['status' => $seller->status]) }}" 
               class="inline-flex items-center text-sm text-slate-500 hover:text-emerald-700 transition-colors font-medium">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Seller
            </a>
        </div>

        {{-- HEADER HALAMAN & STATUS --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-8">
            <div>
                <h2 class="text-3xl font-bold text-slate-800">
                    {{ $seller->storeName }}
                </h2>
                <div class="flex items-center gap-3 mt-2 text-sm text-slate-500">
                    <span class="flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        {{ $seller->picName }}
                    </span>
                    <span class="w-1 h-1 bg-slate-300 rounded-full"></span>
                    <span>{{ $seller->user->email }}</span>
                </div>
            </div>

            {{-- Badge Status --}}
            @php
                $statusColor = match($seller->status) {
                    'active' => 'bg-emerald-100 text-emerald-800 border-emerald-200',
                    'pending' => 'bg-amber-100 text-amber-800 border-amber-200',
                    'rejected' => 'bg-rose-100 text-rose-800 border-rose-200',
                    default => 'bg-slate-100 text-slate-800 border-slate-200'
                };
            @endphp
            <span class="px-4 py-2 rounded-full text-sm font-bold border {{ $statusColor }} shadow-sm flex items-center gap-2">
                Status: {{ strtoupper($seller->status) }}
            </span>
        </div>

        {{-- GRID LAYOUT UTAMA (Baris 1) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

            {{-- KOLOM KIRI: INFORMASI AKUN & PIC --}}
            <section class="card-section h-full">
                <h3 class="section-title">
                    <span class="bg-blue-100 text-blue-600 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg></span>
                    Data Akun & PIC
                </h3>
                <div class="space-y-5">
                    <div>
                        <p class="info-label">Nama Lengkap PIC</p>
                        <p class="info-value">{{ $seller->picName }}</p>
                    </div>
                    <div>
                        <p class="info-label">Email</p>
                        <p class="info-value">{{ $seller->user->email }}</p>
                    </div>
                    <div>
                        <p class="info-label">Nomor Handphone</p>
                        <p class="info-value flex items-center gap-2">
                            {{ $seller->picPhone }}
                            <a href="https://wa.me/{{ preg_replace('/^0/', '62', $seller->picPhone) }}" target="_blank" class="text-xs bg-emerald-50 text-emerald-600 border border-emerald-200 px-2 py-0.5 rounded hover:bg-emerald-100 transition">
                                Chat WA ↗
                            </a>
                        </p>
                    </div>
                    <div>
                        <p class="info-label">Nomor KTP (NIK)</p>
                        <p class="info-value">{{ $seller->picKtpNumber }}</p>
                    </div>
                </div>
            </section>

            {{-- KOLOM KANAN: DATA TOKO & ALAMAT (Sesuai Request) --}}
            <section class="card-section h-full">
                <h3 class="section-title">
                    <span class="bg-purple-100 text-purple-600 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg></span>
                    Data Toko & Alamat
                </h3>
                <div class="grid grid-cols-1 gap-y-5">
                    <div>
                        <p class="info-label">Nama Toko</p>
                        <p class="info-value text-lg text-emerald-800">{{ $seller->storeName }}</p>
                    </div>
                    <div>
                        <p class="info-label">Deskripsi Toko</p>
                        <p class="text-slate-600 italic text-sm">{{ $seller->storeDescription ?: 'Tidak ada deskripsi.' }}</p>
                    </div>
                    
                    <div class="border-t border-slate-100 my-2"></div>

                    <div class="grid grid-cols-2 gap-4">
                        <div class="col-span-2">
                            <p class="info-label">Alamat Jalan</p>
                            <p class="info-value">{{ $seller->picStreet }}</p>
                        </div>
                        <div>
                            <p class="info-label">RT / RW</p>
                            <p class="info-value">{{ $seller->picRT }} / {{ $seller->picRW }}</p>
                        </div>
                        <div>
                            <p class="info-label">Kelurahan</p>
                            <p class="info-value">{{ $seller->picVillage }}</p>
                        </div>
                        <div>
                            <p class="info-label">Kota/Kab</p>
                            <p class="info-value">{{ $seller->picCity }}</p>
                        </div>
                        <div>
                            <p class="info-label">Provinsi</p>
                            <p class="info-value">{{ $seller->picProvince }}</p>
                        </div>
                    </div>
                </div>
            </section>

        </div>

        {{-- BARIS 2: DOKUMEN VERIFIKASI (Full Width di Bawah) --}}
        <section class="card-section mb-6">
            <h3 class="section-title">
                <span class="bg-orange-100 text-orange-600 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg></span>
                Dokumen Verifikasi
            </h3>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                {{-- Foto Wajah --}}
                <div class="space-y-3">
                    <p class="info-label">Foto Wajah PIC</p>
                    @if($seller->picPhotoPath)
                        <div class="relative group bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm h-64 flex items-center justify-center">
                            <img src="{{ asset('storage/'.$seller->picPhotoPath) }}" 
                                 class="max-w-full max-h-full object-contain"
                                 alt="Foto PIC">
                            <a href="{{ asset('storage/'.$seller->picPhotoPath) }}" target="_blank" 
                               class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition font-medium">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                Perbesar Foto
                            </a>
                        </div>
                    @else
                        <div class="h-64 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Tidak ada foto diupload</span>
                        </div>
                    @endif
                </div>

                {{-- Scan KTP --}}
                <div class="space-y-3">
                    <p class="info-label">Scan KTP</p>
                    @if($seller->picKtpFilePath)
                        <div class="relative group bg-slate-50 border border-slate-200 rounded-xl overflow-hidden shadow-sm h-64 flex items-center justify-center">
                            <img src="{{ asset('storage/'.$seller->picKtpFilePath) }}" 
                                 class="max-w-full max-h-full object-contain"
                                 alt="Scan KTP">
                            <a href="{{ asset('storage/'.$seller->picKtpFilePath) }}" target="_blank" 
                               class="absolute inset-0 bg-black/50 flex items-center justify-center text-white opacity-0 group-hover:opacity-100 transition font-medium">
                                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                Perbesar KTP
                            </a>
                        </div>
                    @else
                        <div class="h-64 bg-slate-50 border-2 border-dashed border-slate-300 rounded-xl flex flex-col items-center justify-center text-slate-400">
                            <svg class="w-10 h-10 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0c0 .884-.5 2-2 2h4c-1.5 0-2-1.116-2-2z"/></svg>
                            <span>Tidak ada KTP diupload</span>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        {{-- BARIS 3: AKSI (Hanya muncul jika Pending) --}}
        @if($seller->status === 'pending')
            <div class="bg-white border-t-4 border-emerald-500 rounded-xl shadow-lg p-6 flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Verifikasi Pendaftaran</h3>
                    <p class="text-slate-600 text-sm mt-1">
                        Harap periksa kelengkapan data dan dokumen di atas sebelum memberikan keputusan.
                    </p>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto">
                    {{-- Tombol Tolak --}}
                    <form method="POST" action="{{ route('platform.sellers.reject', $seller) }}" class="flex-1 md:flex-none">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENOLAK penjual ini?')"
                            class="w-full md:w-auto px-6 py-3 rounded-lg border-2 border-rose-500 text-rose-600 hover:bg-rose-50 font-bold transition">
                            ✗ Tolak
                        </button>
                    </form>

                    {{-- Tombol Setuju --}}
                    <form method="POST" action="{{ route('platform.sellers.approve', $seller) }}" class="flex-1 md:flex-none">
                        @csrf
                        <button type="submit" onclick="return confirm('Apakah Anda yakin ingin MENYETUJUI penjual ini?')"
                            class="w-full md:w-auto px-8 py-3 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-bold shadow-md hover:shadow-lg transition transform hover:-translate-y-0.5">
                            ✓ Setujui Penjual
                        </button>
                    </form>
                </div>
            </div>
        @endif

        {{-- Spacer Bawah --}}
        <div class="h-10"></div>
    </div>

@endsection