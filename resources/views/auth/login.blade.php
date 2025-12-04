<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Animasi Blob untuk background sisi kiri */
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
    </style>
</head>
<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #f7f6f2 0%, #e8f5e8 100%);">
        
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-5xl w-full flex flex-col md:flex-row transform transition-all duration-300 hover:scale-[1.01]">
            
            <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-12 bg-gradient-to-br from-green-50 to-green-100 relative overflow-hidden text-center">
                <div class="mb-6 z-10">
                    <i class="fas fa-store text-8xl text-green-900 animate-bounce"></i>
                </div>
                
                <h1 class="text-4xl font-bold mb-2 z-10" style="color: #2e603f;">Welcome Back to</h1>
                <h2 class="text-6xl font-light z-10" style="color: #a5c0a8;">EasyMart</h2>
                <p class="mt-6 text-lg text-gray-600 px-8 z-10">
                    Masuk untuk melanjutkan berjualan.
                </p>

                <div class="absolute top-0 left-0 w-32 h-32 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-8 left-20 w-32 h-32 bg-pink-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            </div>
            
            <div class="w-full md:w-1/2 p-10 md:p-12 bg-white flex flex-col justify-center">
                <h2 class="text-3xl font-bold text-center mb-8" style="color: #2e603f;">Masuk Akun</h2>
                
                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <div class="relative">
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                   class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Masukkan email Anda">
                            <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                        </div>
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all duration-200"
                                   placeholder="Masukkan password Anda">
                            <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            
                            <button type="button" id="toggle-password" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                <i class="fas fa-eye" id="eye-icon"></i>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>
                    
                    <div class="flex items-center justify-between mt-4">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer select-none">
                            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                            <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" 
                               class="text-sm font-medium hover:underline transition-colors duration-200" 
                               style="color: #2e603f;">
                                Lupa Sandi?
                            </a>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-lg font-medium text-white hover:opacity-90 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]"
                                style="background: linear-gradient(135deg, #1a432b 0%, #2e603f 100%);">
                            Masuk Sekarang
                        </button>
                    </div>
                </form>

                <div class="text-center mt-8">
                    <p class="text-sm text-gray-600">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="font-medium hover:underline transition-colors duration-200" style="color: #2e603f;">
                            Daftar Disini
                        </a>
                    </p>
                </div>
            </div>
            
        </div>
    </div>

    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.classList.remove('fa-eye');
                eyeIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                eyeIcon.classList.remove('fa-eye-slash');
                eyeIcon.classList.add('fa-eye');
            }
        });
    </script>
</body>
</html>