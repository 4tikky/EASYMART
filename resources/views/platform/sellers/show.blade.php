{{-- resources/views/platform/sellers/show.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Detail Penjual - EasyMart Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased" style="background-color:#f7f6f2;">

    {{-- HEADER --}}
    <header class="flex justify-between items-center px-10 py-4 bg-white shadow">
        <h1 class="text-2xl font-bold text-brand-green-dark">
            EasyMart <span class="font-normal text-gray-500">Platform Dashboard</span>
        </h1>

        <div class="flex items-center space-x-6">
            <span class="text-gray-700">
                {{ Auth::user()->name }} (Platform)
            </span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="px-4 py-2 text-sm font-medium text-white rounded-full"
                        style="background-color:#1a432b;">
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- KONTEN --}}
    <main class="px-10 py-8 max-w-5xl mx-auto">

        {{-- Tombol kembali --}}
        <a href="{{ route('platform.sellers.index', ['status' => $seller->status_verifikasi]) }}"
           class="text-sm text-brand-green-dark">&larr; Kembali ke daftar seller</a>

        <h2 class="text-3xl font-bold mt-4 mb-6" style="color:#2e603f;">
            Detail Penjual
        </h2>

        {{-- Info status --}}
        <div class="mb-6">
            <span class="inline-block px-3 py-1 rounded-full text-sm
                @if($seller->status_verifikasi === \App\Models\User::STATUS_PENDING)
                    bg-yellow-100 text-yellow-700
                @elseif($seller->status_verifikasi === \App\Models\User::STATUS_ACTIVE)
                    bg-green-100 text-green-700
                @else
                    bg-red-100 text-red-700
                @endif
            ">
                Status Verifikasi: {{ strtoupper($seller->status_verifikasi) }}
            </span>
        </div>

        {{-- DATA AKUN & PIC --}}
        <section class="bg-white rounded-2xl shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Data Akun & PIC</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-medium text-gray-500">Nama PIC</p>
                    <p class="text-gray-800">{{ $seller->name }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">Email</p>
                    <p class="text-gray-800">{{ $seller->email }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">No. HP PIC</p>
                    <p class="text-gray-800">{{ $seller->no_handphone_pic }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">No. KTP PIC</p>
                    <p class="text-gray-800">{{ $seller->no_ktp_pic }}</p>
                </div>
            </div>
        </section>

        {{-- DATA TOKO --}}
        <section class="bg-white rounded-2xl shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Data Toko</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="font-medium text-gray-500">Nama Toko</p>
                    <p class="text-gray-800">{{ $seller->nama_toko }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">Deskripsi Singkat</p>
                    <p class="text-gray-800">{{ $seller->deskripsi_singkat ?: '-' }}</p>
                </div>
            </div>
        </section>

        {{-- ALAMAT --}}
        <section class="bg-white rounded-2xl shadow p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Alamat PIC & Toko</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                <div class="md:col-span-2">
                    <p class="font-medium text-gray-500">Nama Jalan</p>
                    <p class="text-gray-800">{{ $seller->alamat_pic }}</p>
                </div>

                <div>
                    <p class="font-medium text-gray-500">RT/RW</p>
                    <p class="text-gray-800">
                        RT {{ $seller->rt }} / RW {{ $seller->rw }}
                    </p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">Kelurahan</p>
                    <p class="text-gray-800">{{ $seller->nama_kelurahan }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">Kabupaten/Kota</p>
                    <p class="text-gray-800">{{ $seller->kabupaten_kota }}</p>
                </div>
                <div>
                    <p class="font-medium text-gray-500">Provinsi</p>
                    <p class="text-gray-800">{{ $seller->provinsi }}</p>
                </div>
            </div>
        </section>

        {{-- DOKUMEN IDENTITAS --}}
        <section class="bg-white rounded-2xl shadow p-6 mb-8">
            <h3 class="text-xl font-semibold mb-4">Dokumen Identitas PIC</h3>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm">
                <div>
                    <p class="font-medium text-gray-500 mb-2">Foto PIC</p>
                    @if($seller->foto_pic)
                        <img src="{{ asset('storage/'.$seller->foto_pic) }}"
                             alt="Foto PIC"
                             class="rounded-lg border max-w-xs">
                    @else
                        <p class="text-gray-400">Belum mengunggah foto PIC.</p>
                    @endif
                </div>
                <div>
                    <p class="font-medium text-gray-500 mb-2">Foto / Scan KTP</p>
                    @if($seller->file_upload_ktp_pic)
                        <a href="{{ asset('storage/'.$seller->file_upload_ktp_pic) }}"
                           target="_blank"
                           class="inline-block px-4 py-2 rounded-full text-sm font-medium text-white"
                           style="background-color:#1a432b;">
                            Lihat File KTP
                        </a>
                    @else
                        <p class="text-gray-400">Belum mengunggah file KTP.</p>
                    @endif
                </div>
            </div>
        </section>

        {{-- TOMBOL APPROVE / REJECT (hanya kalau masih pending) --}}
        @if($seller->status_verifikasi === \App\Models\User::STATUS_PENDING)
            <section class="flex space-x-4">
                <form method="POST" action="{{ route('platform.sellers.approve', $seller) }}">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Setujui penjual ini?')"
                            class="px-6 py-3 rounded-full text-white font-semibold"
                            style="background-color:#1a432b;">
                        Setujui Penjual
                    </button>
                </form>

                <form method="POST" action="{{ route('platform.sellers.reject', $seller) }}">
                    @csrf
                    <button type="submit"
                            onclick="return confirm('Tolak pendaftaran penjual ini?')"
                            class="px-6 py-3 rounded-full font-semibold text-white"
                            style="background-color:#b91c1c;">
                        Tolak Pendaftaran
                    </button>
                </form>
            </section>
        @endif

        {{-- pesan status --}}
        @if (session('status'))
            <p class="mt-6 text-sm text-green-700">
                {{ session('status') }}
            </p>
        @endif

    </main>
</body>
</html>
