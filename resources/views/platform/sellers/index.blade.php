<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Daftar Seller - EasyMart</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { background-color: #f7f6f2; }
        .text-brand-green-dark { color:#2e603f; }
        .bg-brand-green-dark { background-color:#1a432b; }
    </style>
</head>
<body class="font-sans antialiased">

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
                    class="px-4 py-2 text-sm font-medium text-white rounded-full bg-brand-green-dark">
                Logout
            </button>
        </form>
    </div>
</header>

<main class="px-10 py-8">
    @php
        use App\Models\User;

        $labelMap = [
            User::STATUS_PENDING  => 'Pending',
            User::STATUS_ACTIVE   => 'Disetujui',
            User::STATUS_REJECTED => 'Ditolak',
        ];

        $statusLabel = $labelMap[$status] ?? ucfirst($status);
    @endphp

    <div class="flex items-center justify-between mb-6">
        <div>
            <h2 class="text-3xl font-bold text-brand-green-dark">
                Daftar Seller ({{ $statusLabel }})
            </h2>
            <p class="text-sm text-gray-600">
                Seller dengan status verifikasi:
                <span class="font-semibold">{{ strtolower($statusLabel) }}</span>
            </p>
        </div>

        <!-- Filter status: PAKAI KONSTANTA, BUKAN 'disetujui' / 'ditolak' -->
        <div class="space-x-2">
            <a href="{{ route('platform.sellers.index', ['status' => User::STATUS_PENDING]) }}"
               class="px-3 py-1 rounded-full text-sm
                      {{ $status === User::STATUS_PENDING ? 'bg-brand-green-dark text-white' : 'bg-white border' }}">
                Pending
            </a>

            <a href="{{ route('platform.sellers.index', ['status' => User::STATUS_ACTIVE]) }}"
               class="px-3 py-1 rounded-full text-sm
                      {{ $status === User::STATUS_ACTIVE ? 'bg-brand-green-dark text-white' : 'bg-white border' }}">
                Active
            </a>

            <a href="{{ route('platform.sellers.index', ['status' => User::STATUS_REJECTED]) }}"
               class="px-3 py-1 rounded-full text-sm
                      {{ $status === User::STATUS_REJECTED ? 'bg-brand-green-dark text-white' : 'bg-white border' }}">
                Rejected
            </a>
        </div>
    </div>

    @if (session('status'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-50 text-sm text-green-800 border border-green-200">
            {{ session('status') }}
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow p-6">
        <table class="min-w-full text-sm">
            <thead class="border-b">
                <tr class="text-left text-gray-600">
                    <th class="py-2 pr-4">Nama Toko</th>
                    <th class="py-2 pr-4">Nama PIC</th>
                    <th class="py-2 pr-4">Email</th>
                    <th class="py-2 pr-4">No HP</th>
                    <th class="py-2 pr-4">Lokasi</th>
                    <th class="py-2 pr-4">Status</th>
                    <th class="py-2 pr-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse ($sellers as $seller)
                <tr class="border-b last:border-0">
                    <td class="py-3 pr-4 font-medium text-gray-900">{{ $seller->nama_toko }}</td>
                    <td class="py-3 pr-4">{{ $seller->name }}</td>
                    <td class="py-3 pr-4">{{ $seller->email }}</td>
                    <td class="py-3 pr-4">{{ $seller->no_handphone_pic }}</td>
                    <td class="py-3 pr-4">
                        {{ $seller->kabupaten_kota }}, {{ $seller->propinsi ?? $seller->provinsi }}
                    </td>
                    <td class="py-3 pr-4 capitalize">
                        {{ $seller->status_verifikasi }}
                    </td>

                    <td class="py-3 pr-4">
                        <div class="flex items-center justify-center space-x-2">

                            {{-- Jika status pending → tampilkan Setujui & Tolak --}}
                            @if ($seller->status_verifikasi === 'pending')

                                {{-- Tombol Detail --}}
                                <a href="{{ route('platform.sellers.show', $seller->id) }}"
                                class="px-3 py-1 rounded-full text-xs font-semibold text-white bg-blue-600">
                                    Detail
                                </a>

                                {{-- Tombol Setujui --}}
                                <form method="POST" action="{{ route('platform.sellers.approve', $seller->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-full text-xs font-semibold text-white bg-green-600">
                                        Setujui
                                    </button>
                                </form>

                                {{-- Tombol Tolak --}}
                                <form method="POST" action="{{ route('platform.sellers.reject', $seller->id) }}">
                                    @csrf
                                    <button type="submit"
                                        class="px-3 py-1 rounded-full text-xs font-semibold text-white bg-red-600">
                                        Tolak
                                    </button>
                                </form>


                            {{-- Jika status active / rejected → tampil tombol Detail --}}
                            @else
                                <a href="{{ route('platform.sellers.show', $seller->id) }}"
                                class="px-3 py-1 rounded-full text-xs font-semibold text-white bg-blue-600">
                                    Detail
                                </a>
                            @endif

                        </div>
                    </td>

                </tr>
            @empty
                <tr>
                    <td colspan="7" class="py-4 text-center text-gray-500">
                        Tidak ada seller dengan status ini.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $sellers->links() }}
        </div>
    </div>
</main>

</body>
</html>
