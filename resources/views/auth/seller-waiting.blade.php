<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Registrasi Berhasil - EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center" style="background-color: #f7f6f2;">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden max-w-6xl w-full m-4">
            <div class="flex flex-col md:flex-row">
                
                <!-- Kolom Kiri: Welcome -->
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-12">
                    <h1 class="text-5xl font-bold" style="color: #2e603f;">Welcome to</h1>
                    <h2 class="text-7xl font-light" style="color: #a5c0a8;">EasyMart</h2>
                </div>

                <!-- Kolom Kanan: Pesan Registrasi Berhasil -->
                <div class="w-full md:w-1/2 p-12 flex items-center justify-center">
                    <div class="w-full max-w-md text-center space-y-6">
                        <h2 class="text-3xl font-bold" style="color: #2e603f;">
                            Registrasi Berhasil
                        </h2>

                        <p class="text-gray-700 leading-relaxed">
                            Data pendaftaran penjual Anda sudah kami terima.
                            Silakan menunggu persetujuan admin sebelum dapat login ke dashboard penjual.
                            Informasi lebih lanjut akan dikirimkan melalui email yang Anda daftarkan.
                        </p>

                        @if (session('status'))
                            <div class="text-sm text-green-700">
                                {{ session('status') }}
                            </div>
                        @endif

                        <a href="{{ route('login') }}"
                           class="inline-flex justify-center px-6 py-3 rounded-full text-white text-lg font-medium shadow-sm hover:opacity-90"
                           style="background-color: #1a432b;">
                            Kembali ke Halaman Login
                        </a>

                        <p class="text-sm text-gray-500">
                            Jika akun Anda sudah disetujui admin, silakan login menggunakan email dan password yang telah didaftarkan.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>

</body>
</html>
