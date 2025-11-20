<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center" style="background-color: #f7f6f2;">
        <div class="bg-white rounded-2xl shadow-lg overflow-hidden max-w-6xl w-full m-4">
            <div class="flex flex-col md:flex-row">
                
                {{-- Kolom kiri --}}
                <div class="w-full md:w-1/2 flex flex-col items-center justify-center p-12">
                    <h1 class="text-5xl font-bold" style="color: #2e603f;">Welcome to</h1>
                    <h2 class="text-7xl font-light" style="color: #a5c0a8;">EasyMart</h2>
                </div>

                {{-- Kolom kanan: Form --}}
                <div class="w-full md:w-1/2 p-12 max-h-[90vh] overflow-y-auto">
                    <h2 class="text-3xl font-bold text-center mb-8" style="color: #2e603f;">
                        Formulir Registrasi Data Penjual (Toko)
                    </h2>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-5">
                        @csrf

                        {{-- ================== --}}
                        {{-- DATA TOKO          --}}
                        {{-- ================== --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2">
                            Data Toko
                        </h4>

                        {{-- Nama Toko --}}
                        <div>
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700">
                                Nama Toko*
                            </label>
                            <input id="nama_toko" type="text" name="nama_toko" :value="old('nama_toko')" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Nama toko Anda">
                            <x-input-error :messages="$errors->get('nama_toko')" class="mt-2" />
                        </div>

                        {{-- Deskripsi Singkat --}}
                        <div>
                            <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700">
                                Deskripsi Singkat
                            </label>
                            <textarea id="deskripsi_singkat" name="deskripsi_singkat"
                                      class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                      rows="3" placeholder="Jelaskan sedikit tentang toko Anda">{{ old('deskripsi_singkat') }}</textarea>
                            <x-input-error :messages="$errors->get('deskripsi_singkat')" class="mt-2" />
                        </div>

                        {{-- ================== --}}
                        {{-- DATA PIC           --}}
                        {{-- ================== --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 pt-4">
                            Data PIC
                        </h4>

                        {{-- Nama PIC --}}
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">
                                Nama PIC*
                            </label>
                            <input id="name" type="text" name="name" :value="old('name')" required autofocus
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Masukan nama lengkap Anda">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- No HP PIC --}}
                        <div>
                            <label for="no_handphone_pic" class="block text-sm font-medium text-gray-700">
                                No HP PIC*
                            </label>
                            <input id="no_handphone_pic" type="text" name="no_handphone_pic" :value="old('no_handphone_pic')" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="0812XXXXXXXX">
                            <x-input-error :messages="$errors->get('no_handphone_pic')" class="mt-2" />
                        </div>

                        {{-- Email PIC --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">
                                Email PIC*
                            </label>
                            <input id="email" type="email" name="email" :value="old('email')" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="contoh@email.com">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        {{-- ================== --}}
                        {{-- ALAMAT PIC         --}}
                        {{-- ================== --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 pt-4">
                            Alamat PIC
                        </h4>

                        {{-- Jalan --}}
                        <div>
                            <label for="alamat_pic" class="block text-sm font-medium text-gray-700">
                                Jalan*
                            </label>
                            <textarea id="alamat_pic" name="alamat_pic" required
                                      class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                      rows="3" placeholder="Jl. Pahlawan No. 10">{{ old('alamat_pic') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat_pic')" class="mt-2" />
                        </div>

                        {{-- RT / RW / Kelurahan --}}
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700">RT*</label>
                                <input id="rt" type="text" name="rt" :value="old('rt')" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="001">
                                <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                            </div>
                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700">RW*</label>
                                <input id="rw" type="text" name="rw" :value="old('rw')" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="002">
                                <x-input-error :messages="$errors->get('rw')" class="mt-2" />
                            </div>
                            <div>
                                <label for="nama_kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan*</label>
                                <input id="nama_kelurahan" type="text" name="nama_kelurahan" :value="old('nama_kelurahan')" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="Mugassari">
                                <x-input-error :messages="$errors->get('nama_kelurahan')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Kab/Kota & Provinsi --}}
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label for="kabupaten_kota" class="block text-sm font-medium text-gray-700">
                                    Kab/Kota*
                                </label>
                                <input id="kabupaten_kota" type="text" name="kabupaten_kota" :value="old('kabupaten_kota')" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="Kota Semarang">
                                <x-input-error :messages="$errors->get('kabupaten_kota')" class="mt-2" />
                            </div>
                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700">
                                    Provinsi*
                                </label>
                                <input id="provinsi" type="text" name="provinsi" :value="old('provinsi')" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="Jawa Tengah">
                                <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                            </div>
                        </div>

                        {{-- ================== --}}
                        {{-- DOKUMEN IDENTITAS  --}}
                        {{-- ================== --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 pt-4">
                            Dokumen Identitas PIC
                        </h4>

                        {{-- No. KTP PIC --}}
                        <div>
                            <label for="no_ktp_pic" class="block text-sm font-medium text-gray-700">
                                No. KTP PIC*
                            </label>
                            <input id="no_ktp_pic" type="text" name="no_ktp_pic" :value="old('no_ktp_pic')" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="3374XXXXXXXXXXXX">
                            <x-input-error :messages="$errors->get('no_ktp_pic')" class="mt-2" />
                        </div>

                        {{-- Foto PIC --}}
                        <div>
                            <label for="foto_pic" class="block text-sm font-medium text-gray-700">
                                Foto PIC (jpg/png, ≤2MB)
                            </label>
                            <input id="foto_pic" type="file" name="foto_pic"
                                   class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm text-gray-900
                                          file:border-0 file:rounded-l-lg
                                          file:bg-gray-70 file:py-3 file:px-5 file:mr-4
                                          file:text-sm file:font-medium file:text-gray-700
                                          hover:file:bg-gray-100">
                            <x-input-error :messages="$errors->get('foto_pic')" class="mt-2" />
                        </div>

                        {{-- File KTP --}}
                        <div>
                            <label for="file_upload_ktp_pic" class="block text-sm font-medium text-gray-700">
                                File KTP (jpg/png/pdf, ≤5MB)
                            </label>
                            <input id="file_upload_ktp_pic" type="file" name="file_upload_ktp_pic"
                                   class="mt-1 block w-full border border-gray-300 rounded-lg shadow-sm cursor-pointer focus:outline-none focus:ring-green-500 focus:border-green-500 text-sm text-gray-900
                                          file:border-0 file:rounded-l-lg
                                          file:bg-gray-70 file:py-3 file:px-5 file:mr-4
                                          file:text-sm file:font-medium file:text-gray-700
                                          hover:file:bg-gray-100">
                            <x-input-error :messages="$errors->get('file_upload_ktp_pic')" class="mt-2" />
                        </div>

                        {{-- ================== --}}
                        {{-- KEAMANAN AKUN      --}}
                        {{-- ================== --}}
                        <h4 class="text-lg font-semibold text-gray-800 border-b pb-2 pt-4">
                            Keamanan Akun
                        </h4>

                        {{-- Password --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700">
                                Password:
                            </label>
                            <input id="password" type="password" name="password" required autocomplete="new-password"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Masukan password anda">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                                Konfirmasi Password:
                            </label>
                            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Konfirmasi password anda">
                            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                        </div>

                        {{-- ================== --}}
                        {{-- Tombol Submit      --}}
                        {{-- ================== --}}
                        <div class="pt-4 flex flex-col gap-3">
                            <button type="submit"
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-sm text-lg font-medium text-white hover:opacity-90"
                                    style="background-color: #1a432b;">
                                Registrasi Penjual
                            </button>

                            <a href="{{ route('login') }}"
                               class="w-full flex justify-center py-3 px-4 rounded-full border border-gray-300 text-lg font-medium text-gray-700 hover:bg-gray-50">
                                Batal
                            </a>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun?
                            <a href="{{ route('login') }}" class="font-medium" style="color: #2e603f;">
                                Masuk
                            </a>
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
</html>
