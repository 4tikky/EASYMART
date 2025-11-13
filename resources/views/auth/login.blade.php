<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center" style="background-color: #f7f6f2;">
        
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden max-w-4xl w-full m-4">
            <div class="flex flex-col md:flex-row">
                
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-12">
                    <h1 class="text-5xl font-bold" style="color: #2e603f;">Welcome to</h1>
                    <h2 class="text-7xl font-light" style="color: #a5c0a8;">EasyMart</h2>
                </div>
                
                <div class="w-full md:w-1/2 p-12">
                    <h2 class="text-3xl font-bold text-center mb-8" style="color: #2e603f;">Masuk Akun</h2>
                    
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">Email Universitas:</label>
                            <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Masukan email anda">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
                            <input id="password" type="password" name="password" required autocomplete="current-password"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Masukan password anda">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        
                        <div class="flex items-center justify-between mt-4">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" name="remember">
                                <span class="ms-2 text-sm text-gray-600">Ingat Saya</span>
                            </label>

                            <a href="{{ route('password.request') }}" 
                            class="text-sm font-medium hover:underline" 
                            style="color: #2e603f;">
                                Lupa Sandi?
                            </a>
                        </div>

                        <div class="pt-4">
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-lg font-medium text-white hover:opacity-90"
                                    style="background-color: #1a432b;">
                                Masuk
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Belum Punya Akun? 
                            <a href="{{ route('register') }}" class="font-medium" style="color: #2e603f; hover:underline;">
                                Daftar
                            </a>
                        </p>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    </body>
</html>