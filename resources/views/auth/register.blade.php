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

    {{-- Styling kecil: label required & password strength --}}
    <style>
        label.required::after {
            content: " *";
            color: #dc2626; /* merah */
            font-weight: bold;
        }
    </style>
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
                <div class="w-full md:w-1/2 p-12 md:max-h-[90vh] md:overflow-y-auto">
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
                            <label for="nama_toko" class="block text-sm font-medium text-gray-700 required">
                                Nama Toko
                            </label>
                            <input id="nama_toko" type="text" name="nama_toko" value="{{ old('nama_toko') }}" required
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
                            <label for="name" class="block text-sm font-medium text-gray-700 required">
                                Nama PIC
                            </label>
                            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="Masukan nama lengkap Anda">
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        {{-- No HP PIC --}}
                        <div>
                            <label for="no_handphone_pic" class="block text-sm font-medium text-gray-700 required">
                                No HP PIC
                            </label>
                            <input id="no_handphone_pic" type="text" name="no_handphone_pic" value="{{ old('no_handphone_pic') }}" required
                                   class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                   placeholder="0812XXXXXXXX">
                            <x-input-error :messages="$errors->get('no_handphone_pic')" class="mt-2" />
                        </div>

                        {{-- Email PIC --}}
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 required">
                                Email PIC
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
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
                            <label for="alamat_pic" class="block text-sm font-medium text-gray-700 required">
                                Jalan
                            </label>
                            <textarea id="alamat_pic" name="alamat_pic" required
                                      class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                      rows="3" placeholder="Jl. Pahlawan No. 10">{{ old('alamat_pic') }}</textarea>
                            <x-input-error :messages="$errors->get('alamat_pic')" class="mt-2" />
                        </div>

                        {{-- Provinsi & Kab/Kota (dropdown berantai) --}}
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            {{-- Provinsi --}}
                            <div>
                                <label for="provinsi" class="block text-sm font-medium text-gray-700 required">
                                    Provinsi
                                </label>
                                <select id="provinsi" name="provinsi" required
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm
                                               focus:outline-none focus:ring-green-500 focus:border-green-500">
                                    <option value="">Pilih Provinsi</option>
                                    @foreach($provinces as $prov)
                                        <option value="{{ $prov->name }}"
                                                data-id="{{ $prov->code }}"
                                                @selected(old('provinsi') === $prov->name)>
                                            {{ ucwords(strtolower($prov->name)) }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('provinsi')" class="mt-2" />
                            </div>
                            
                            {{-- Kab/Kota --}}
                            <div>
                                <label for="kabupaten_kota" class="block text-sm font-medium text-gray-700 required">
                                    Kab/Kota
                                </label>
                                <select id="kabupaten_kota" name="kabupaten_kota" required
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm
                                               focus:outline-none focus:ring-green-500 focus:border-green-500"
                                        disabled>
                                    <option value="">Pilih Kab/Kota</option>
                                </select>
                                <x-input-error :messages="$errors->get('kabupaten_kota')" class="mt-2" />
                            </div>
                        </div>

                        {{-- Kecamatan / Desa(Kelurahan) / Dusun --}}
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="kecamatan" class="block text-sm font-medium text-gray-700 required">
                                    Kecamatan
                                </label>
                                <select id="kecamatan" name="kecamatan" required
                                        class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm
                                            focus:outline-none focus:ring-green-500 focus:border-green-500"
                                        disabled>
                                    <option value="">Kec. ...</option>
                                </select>
                                <x-input-error :messages="$errors->get('kecamatan')" class="mt-2" />
                            </div>

                            <div>
                                <label for="nama_kelurahan" class="block text-sm font-medium text-gray-700 required">
                                    Desa/Kelurahan
                                </label>
                                <select id="desa_kelurahan" name="nama_kelurahan" required
                                    class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm
                                            focus:outline-none focus:ring-green-500 focus:border-green-500"
                                        disabled>
                                    <option value="">Kel. / Desa ...</option>
                                </select>
                                <x-input-error :messages="$errors->get('nama_kelurahan')" class="mt-2" />
                            </div>
                        </div>

                        {{-- RT / RW --}}
                        <div class="grid grid-cols-2 gap-4 mt-4">
                            <div>
                                <label for="rt" class="block text-sm font-medium text-gray-700 required">
                                    RT
                                </label>
                                <input id="rt" type="text" name="rt" value="{{ old('rt') }}" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="001">
                                <x-input-error :messages="$errors->get('rt')" class="mt-2" />
                            </div>
                            <div>
                                <label for="rw" class="block text-sm font-medium text-gray-700 required">
                                    RW
                                </label>
                                <input id="rw" type="text" name="rw" value="{{ old('rw') }}" required
                                       class="mt-1 block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="002">
                                <x-input-error :messages="$errors->get('rw')" class="mt-2" />
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
                            <label for="no_ktp_pic" class="block text-sm font-medium text-gray-700 required">
                                No. KTP PIC
                            </label>
                            <input id="no_ktp_pic" type="text" name="no_ktp_pic" value="{{ old('no_ktp_pic') }}" required
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
                            <label for="password" class="block text-sm font-medium text-gray-700 required">
                                Password
                            </label>
                            <div class="relative">
                                <input id="password" type="password" name="password" required autocomplete="new-password"
                                       class="mt-1 block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="Masukan password anda">
                                <span id="togglePassword"
                                      class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-xl transition-transform duration-150 hover:scale-110 select-none">
                                    👁️
                                </span>
                            </div>
                            {{-- Password strength indicator --}}
                            <div class="mt-2">
                                <div class="h-2 w-full rounded-full bg-gray-200 overflow-hidden">
                                    <div id="password-strength-fill" class="h-2 w-0 bg-gray-300 transition-all duration-300"></div>
                                </div>
                                <p id="password-strength-text" class="mt-1 text-xs text-gray-500">
                                    Masukkan password untuk melihat kekuatan.
                                </p>
                            </div>
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        {{-- Konfirmasi Password --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 required">
                                Konfirmasi Password
                            </label>
                            <div class="relative">
                                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                                       class="mt-1 block w-full px-4 py-3 pr-10 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-green-500 focus:border-green-500"
                                       placeholder="Konfirmasi password anda">
                                <span id="togglePassword2"
                                      class="absolute right-3 top-1/2 -translate-y-1/2 cursor-pointer text-xl transition-transform duration-150 hover:scale-110 select-none">
                                    👁️
                                </span>
                            </div>
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

    {{-- Script: dropdown Provinsi->Kab/Kota + toggle password + strength indicator --}}
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // === DROPDOWN PROVINSI -> KAB/KOTA ===
            const provinceSelect = document.getElementById('provinsi');
            const regencySelect  = document.getElementById('kabupaten_kota');
            const districtSelect = document.getElementById('kecamatan');
            const villageSelect = document.getElementById('desa_kelurahan');

            function resetRegency() {
                    if (!regencySelect) return;
                    regencySelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
                    regencySelect.disabled = true;
                    resetDistrict();
                }

            function resetDistrict() {
                if (!districtSelect) return;
                districtSelect.innerHTML = '<option value="">Kec. ...</option>';
                districtSelect.disabled = true;
            }

            function resetVillage() {
                if (!villageSelect) return;
                villageSelect.innerHTML = '<option value="">Kel. / Desa ...</option>';
                villageSelect.disabled = true;
            }

            // ====== PROVINSI -> KAB/KOTA ======
            if (provinceSelect && regencySelect) {
                provinceSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const provinceCode = selectedOption.getAttribute('data-id'); // kode provinsi

                    resetRegency();

                    if (!provinceCode) return;

                    fetch(`/locations/regencies/${provinceCode}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('HTTP ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.name;            // yang disimpan di users.kabupaten_kota
                                opt.textContent = item.name;
                                opt.setAttribute('data-code', item.code); // untuk kecamatan
                                regencySelect.appendChild(opt);
                            });
                            regencySelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error mengambil data kabupaten/kota:', error);
                            regencySelect.disabled = false;
                        });
                });
            }

            // ====== KAB/KOTA -> KECAMATAN ======
            if (regencySelect && districtSelect) {
                regencySelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const cityCode = selectedOption.getAttribute('data-code'); // kode kab/kota

                    resetDistrict();

                    if (!cityCode) return;

                    fetch(`/locations/districts/${cityCode}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('HTTP ' + response.status);
                            }
                            return response.json();
                        })
                        .then(data => {
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.name;         // yang disimpan di users.kecamatan
                                opt.textContent = item.name;
                                opt.setAttribute('data-code', item.code); // untuk desa/kelurahan
                                districtSelect.appendChild(opt);
                            });
                            districtSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error mengambil data kecamatan:', error);
                            districtSelect.disabled = false;
                        });
                });
            }

            // Saat kecamatan berubah -> load desa/kelurahan
            if (districtSelect && villageSelect) {
                districtSelect.addEventListener('change', function () {
                    const selectedOption = this.options[this.selectedIndex];
                    const districtCode = selectedOption.getAttribute('data-code');

                    resetVillage();

                    if (!districtCode) return;

                    fetch(`/locations/villages/${districtCode}`)
                        .then(response => {
                            if (!response.ok) throw new Error('HTTP ' + response.status);
                            return response.json();
                        })
                        .then(data => {
                            data.forEach(item => {
                                const opt = document.createElement('option');
                                opt.value = item.name; // disimpan di DB
                                opt.textContent = item.name;
                                opt.setAttribute('data-code', item.code);
                                villageSelect.appendChild(opt);
                            });
                            villageSelect.disabled = false;
                        })
                        .catch(error => {
                            console.error('Error desa/kelurahan:', error);
                            villageSelect.disabled = false;
                        });
                });
            }

        // === TOGGLE PASSWORD (ICON MATA) ===
        function setupTogglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);

            if (!input || !icon) return;

            icon.addEventListener('click', function () {
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.textContent = '🙈';
                } else {
                    input.type = 'password';
                    icon.textContent = '👁️';
                }
            });
        }

        setupTogglePassword('password', 'togglePassword');
        setupTogglePassword('password_confirmation', 'togglePassword2');

        // === PASSWORD STRENGTH INDICATOR ===
        const pwdInput = document.getElementById('password');
        const barFill  = document.getElementById('password-strength-fill');
        const textEl   = document.getElementById('password-strength-text');

        if (pwdInput && barFill && textEl) {
            pwdInput.addEventListener('input', function () {
                const v = pwdInput.value || '';
                let score = 0;

                if (v.length >= 8) score++;
                if (/[A-Z]/.test(v)) score++;
                if (/[0-9]/.test(v)) score++;
                if (/[^A-Za-z0-9]/.test(v)) score++;

                const widths = ['0%', '25%', '50%', '75%', '100%'];
                const barColors = [
                    'bg-gray-300',
                    'bg-red-500',
                    'bg-yellow-400',
                    'bg-green-500',
                    'bg-emerald-600'
                ];
                const texts = [
                    'Masukkan password untuk melihat kekuatan.',
                    'Lemah',
                    'Sedang',
                    'Kuat',
                    'Sangat kuat'
                ];
                const textColors = [
                    'text-gray-500',
                    'text-red-500',
                    'text-yellow-500',
                    'text-green-500',
                    'text-emerald-600'
                ];

                const idx = v.length === 0 ? 0 : score;

                barFill.style.width = widths[idx];
                barFill.className = 'h-2 transition-all duration-300 ' + barColors[idx];

                textEl.textContent = texts[idx];
                textEl.className = 'mt-1 text-xs ' + textColors[idx];
            });
        }
    });
    </script>

</body>
</html>
