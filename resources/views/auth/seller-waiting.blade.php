<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Menunggu Verifikasi - EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Blob Background */
        @keyframes blob {
            0% { transform: translate(0px, 0px) scale(1); }
            33% { transform: translate(30px, -50px) scale(1.1); }
            66% { transform: translate(-20px, 20px) scale(0.9); }
            100% { transform: translate(0px, 0px) scale(1); }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-4000 {
            animation-delay: 4s;
        }
    </style>
</head>
<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #f7f6f2 0%, #e8f5e8 100%);">
        
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row transform transition-all duration-300 hover:scale-[1.01]">
            
            <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-12 bg-gradient-to-br from-green-50 to-green-100 relative overflow-hidden text-center">
                <div class="mb-6 z-10">
                    <i class="fas fa-user-clock text-8xl text-green-900 animate-pulse"></i>
                </div>
                
                <h1 class="text-4xl font-bold mb-2 z-10" style="color: #2e603f;">Terima Kasih</h1>
                <h2 class="text-6xl font-light z-10" style="color: #a5c0a8;">EasyMart</h2>
                <p class="mt-6 text-lg text-gray-600 px-8 z-10">
                    Langkah awal untuk memulai bisnis digital Anda bersama kami.
                </p>

                <div class="absolute top-0 left-0 w-32 h-32 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-32 h-32 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            </div>

            <div class="w-full md:w-1/2 p-10 md:p-12 bg-white flex flex-col justify-center items-center text-center">
                
                <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mb-6">
                    <i class="fas fa-check text-4xl text-green-600"></i>
                </div>

                <h2 class="text-3xl font-bold mb-4" style="color: #2e603f;">
                    Registrasi Berhasil!
                </h2>

                <div class="space-y-4 text-gray-600 mb-8">
                    <p class="leading-relaxed">
                        Data pendaftaran toko Anda telah kami terima dengan aman. 
                        Saat ini, tim admin kami sedang melakukan proses verifikasi data Anda.
                    </p>
                    <p class="text-sm bg-yellow-50 text-yellow-800 p-4 rounded-lg border border-yellow-100">
                        <i class="fas fa-info-circle mr-1"></i> 
                        Mohon tunggu persetujuan admin sebelum dapat mengakses Dashboard Penjual. Notifikasi akan dikirimkan ke email Anda.
                    </p>
                </div>

                @if (session('status'))
                    <div class="mb-6 px-4 py-2 bg-green-50 text-green-700 rounded-lg text-sm font-medium border border-green-200 w-full">
                        {{ session('status') }}
                    </div>
                @endif

                <a href="{{ route('login') }}"
                   class="inline-flex items-center justify-center w-full px-6 py-3 rounded-full text-white text-lg font-medium shadow-lg hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02] group"
                   style="background: linear-gradient(135deg, #1a432b 0%, #2e603f 100%);">
                    <i class="fas fa-arrow-left mr-2 group-hover:-translate-x-1 transition-transform"></i>
                    Kembali ke Halaman Login
                </a>

                <p class="mt-8 text-xs text-gray-400">
                    &copy; {{ date('Y') }} EasyMart. All rights reserved.
                </p>
            </div>

        </div>
    </div>

</body>
</html>