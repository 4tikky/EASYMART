<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - EasyMart</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Custom Scrollbar untuk bagian form agar terlihat rapi */
        .custom-scrollbar::-webkit-scrollbar {
            width: 8px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 0 24px 24px 0;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #a5c0a8;
            border-radius: 4px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #2e603f;
        }

        /* Label Required Styling */
        label.required::after {
            content: " *";
            color: #dc2626;
            font-weight: bold;
        }
    </style>
</head>

<body class="font-sans antialiased text-gray-900">

    <div class="min-h-screen flex items-center justify-center p-4" style="background: linear-gradient(135deg, #f7f6f2 0%, #e8f5e8 100%);">
        
        <div class="bg-white rounded-3xl shadow-2xl overflow-hidden max-w-6xl w-full flex flex-col md:flex-row max-h-[90vh]">
            
            <div class="w-full md:w-5/12 hidden md:flex flex-col items-center justify-center p-12 bg-gradient-to-br from-green-50 to-green-100 relative text-center">
                <div class="mb-6">
                    <i class="fas fa-store text-8xl text-green-900 animate-bounce"></i>
                </div>
                <h1 class="text-4xl font-bold mb-2" style="color: #2e603f;">Bergabung dengan</h1>
                <h2 class="text-6xl font-light" style="color: #a5c0a8;">EasyMart</h2>
                <p class="mt-6 text-lg text-gray-600 px-8">
                    Jual produk Anda ke pelanggan dan kembangkan bisnis Anda bersama kami.
                </p>
                
                <div class="absolute top-0 left-0 w-32 h-32 bg-green-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob"></div>
                <div class="absolute bottom-0 right-0 w-32 h-32 bg-yellow-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000"></div>
            </div>

            <div class="w-full md:w-7/12 bg-white relative overflow-hidden flex flex-col">
                <div class="h-full overflow-y-auto custom-scrollbar p-8 md:p-12">
                    
                    <h2 class="text-3xl font-bold text-center mb-2" style="color: #2e603f;">Registrasi Toko</h2>
                    <p class="text-center text-gray-500 mb-8 text-sm">Lengkapi data di bawah ini untuk mulai berjualan</p>

                    <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold mb-4 flex items-center" style="color: #2e603f;">
                                <i class="fas fa-shop mr-2"></i> Data Toko
                            </h4>

                            <div class="mb-4 relative">
                                <label for="nama_toko" class="block text-sm font-medium text-gray-700 required mb-1">Nama Toko</label>
                                <div class="relative">
                                    <input id="nama_toko" type="text" name="nama_toko" value="{{ old('nama_toko') }}" required
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                           placeholder="Nama toko Anda">
                                    <i class="fas fa-tag absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <x-input-error :messages="$errors->get('nama_toko')" class="mt-2" />
                            </div>

                            <div class="relative">
                                <label for="deskripsi_singkat" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi Singkat</label>
                                <div class="relative">
                                    <textarea id="deskripsi_singkat" name="deskripsi_singkat" rows="2"
                                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                            placeholder="Jelaskan sedikit tentang toko Anda">{{ old('deskripsi_singkat') }}</textarea>
                                    <i class="fas fa-align-left absolute left-3 top-4 text-gray-400"></i>
                                </div>
                                <x-input-error :messages="$errors->get('deskripsi_singkat')" class="mt-2" />
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold mb-4 flex items-center" style="color: #2e603f;">
                                <i class="fas fa-user-tie mr-2"></i> Data PIC
                            </h4>

                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 required mb-1">Nama Lengkap PIC</label>
                                <div class="relative">
                                    <input id="name" type="text" name="name" value="{{ old('name') }}" required
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                           placeholder="Nama lengkap sesuai KTP">
                                    <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="no_handphone_pic" class="block text-sm font-medium text-gray-700 required mb-1">No. HP / WA</label>
                                    <div class="relative">
                                        <input id="no_handphone_pic" type="text" name="no_handphone_pic" value="{{ old('no_handphone_pic') }}" required
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                               placeholder="0812...">
                                        <i class="fas fa-phone absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    <x-input-error :messages="$errors->get('no_handphone_pic')" class="mt-2" />
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700 required mb-1">Email</label>
                                    <div class="relative">
                                        <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                               class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                               placeholder="nama@email.com">
                                        <i class="fas fa-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    </div>
                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold mb-4 flex items-center" style="color: #2e603f;">
                                <i class="fas fa-map-location-dot mr-2"></i> Alamat
                            </h4>

                            <div class="mb-4">
                                <label for="alamat_pic" class="block text-sm font-medium text-gray-700 required mb-1">Jalan / Nama Gedung</label>
                                <div class="relative">
                                    <textarea id="alamat_pic" name="alamat_pic" required rows="2"
                                            class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                            placeholder="Jl. Merdeka No. 10">{{ old('alamat_pic') }}</textarea>
                                    <i class="fas fa-road absolute left-3 top-4 text-gray-400"></i>
                                </div>
                                <x-input-error :messages="$errors->get('alamat_pic')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 required mb-1">Provinsi</label>
                                    <select id="provinsi" name="provinsi" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $prov)
                                            <option value="{{ $prov->name }}" data-id="{{ $prov->code }}" @selected(old('provinsi') === $prov->name)>
                                                {{ ucwords(strtolower($prov->name)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 required mb-1">Kab/Kota</label>
                                    <select id="kabupaten_kota" name="kabupaten_kota" required disabled class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white disabled:bg-gray-100">
                                        <option value="">Pilih Kab/Kota</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 required mb-1">Kecamatan</label>
                                    <select id="kecamatan" name="kecamatan" required disabled class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white disabled:bg-gray-100">
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 required mb-1">Desa/Kelurahan</label>
                                    <select id="desa_kelurahan" name="nama_kelurahan" required disabled class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 bg-white disabled:bg-gray-100">
                                        <option value="">Pilih Desa/Kelurahan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mt-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 required mb-1">RT</label>
                                    <input type="text" name="rt" value="{{ old('rt') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="001">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 required mb-1">RW</label>
                                    <input type="text" name="rw" value="{{ old('rw') }}" required class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500" placeholder="002">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold mb-4 flex items-center" style="color: #2e603f;">
                                <i class="fas fa-id-card mr-2"></i> Dokumen
                            </h4>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 required mb-1">Nomor KTP</label>
                                <div class="relative">
                                    <input type="text" name="no_ktp_pic" value="{{ old('no_ktp_pic') }}" required
                                           class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                           placeholder="16 Digit NIK">
                                    <i class="fas fa-fingerprint absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Foto Diri (jpg/png)</label>
                                    <input type="file" name="foto_pic" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Scan KTP (img/pdf)</label>
                                    <input type="file" name="file_upload_ktp_pic" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100 cursor-pointer">
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 p-4 rounded-xl border border-gray-100">
                            <h4 class="text-lg font-semibold mb-4 flex items-center" style="color: #2e603f;">
                                <i class="fas fa-shield-alt mr-2"></i> Keamanan
                            </h4>

                            <div class="mb-4">
                                <label for="password" class="block text-sm font-medium text-gray-700 required mb-1">Password</label>
                                <div class="relative">
                                    <input id="password" type="password" name="password" required autocomplete="new-password"
                                           class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                           placeholder="Buat password yang kuat">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <button type="button" id="togglePassword" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                
                                <div class="mt-2">
                                    <div class="h-1.5 w-full rounded-full bg-gray-200 overflow-hidden">
                                        <div id="password-strength-fill" class="h-full w-0 bg-gray-300 transition-all duration-300"></div>
                                    </div>
                                    <p id="password-strength-text" class="mt-1 text-xs text-gray-500">Kekuatan password</p>
                                </div>
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 required mb-1">Konfirmasi Password</label>
                                <div class="relative">
                                    <input id="password_confirmation" type="password" name="password_confirmation" required
                                           class="block w-full pl-10 pr-12 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-all"
                                           placeholder="Ulangi password">
                                    <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                    <button type="button" id="togglePassword2" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600 focus:outline-none">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>

                        <div class="pt-2 flex flex-col gap-3">
                            <button type="submit" 
                                    class="w-full flex justify-center py-3 px-4 border border-transparent rounded-full shadow-lg text-lg font-medium text-white hover:opacity-90 hover:shadow-xl transition-all duration-300 transform hover:scale-[1.02]"
                                    style="background: linear-gradient(135deg, #1a432b 0%, #2e603f 100%);">
                                Daftar Sekarang
                            </button>

                            <a href="{{ route('login') }}" 
                               class="w-full flex justify-center py-3 px-4 rounded-full border border-gray-300 text-lg font-medium text-gray-700 hover:bg-gray-100 transition-all">
                                Batal
                            </a>
                        </div>
                    </form>

                    <div class="text-center mt-6">
                        <p class="text-sm text-gray-600">
                            Sudah punya akun? 
                            <a href="{{ route('login') }}" class="font-medium hover:underline transition-colors duration-200" style="color: #2e603f;">
                                Masuk di sini
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        // === 1. DROPDOWN WILAYAH (Logic Tetap) ===
        const provinceSelect = document.getElementById('provinsi');
        const regencySelect  = document.getElementById('kabupaten_kota');
        const districtSelect = document.getElementById('kecamatan');
        const villageSelect  = document.getElementById('desa_kelurahan');

        function resetRegency() {
            if (!regencySelect) return;
            regencySelect.innerHTML = '<option value="">Pilih Kab/Kota</option>';
            regencySelect.disabled = true;
            resetDistrict();
        }
        function resetDistrict() {
            if (!districtSelect) return;
            districtSelect.innerHTML = '<option value="">Pilih Kecamatan</option>';
            districtSelect.disabled = true;
            resetVillage();
        }
        function resetVillage() {
            if (!villageSelect) return;
            villageSelect.innerHTML = '<option value="">Pilih Desa/Kelurahan</option>';
            villageSelect.disabled = true;
        }

        // Provinsi -> Kota
        if (provinceSelect && regencySelect) {
            provinceSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const provinceCode = selectedOption.getAttribute('data-id');
                resetRegency();
                if (!provinceCode) return;

                fetch(`/locations/regencies/${provinceCode}`)
                    .then(r => r.ok ? r.json() : Promise.reject(r))
                    .then(data => {
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.name;
                            opt.textContent = item.name;
                            opt.setAttribute('data-code', item.code);
                            regencySelect.appendChild(opt);
                        });
                        regencySelect.disabled = false;
                    })
                    .catch(e => console.error(e));
            });
        }

        // Kota -> Kecamatan
        if (regencySelect && districtSelect) {
            regencySelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const cityCode = selectedOption.getAttribute('data-code');
                resetDistrict();
                if (!cityCode) return;

                fetch(`/locations/districts/${cityCode}`)
                    .then(r => r.ok ? r.json() : Promise.reject(r))
                    .then(data => {
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.name;
                            opt.textContent = item.name;
                            opt.setAttribute('data-code', item.code);
                            districtSelect.appendChild(opt);
                        });
                        districtSelect.disabled = false;
                    })
                    .catch(e => console.error(e));
            });
        }

        // Kecamatan -> Desa
        if (districtSelect && villageSelect) {
            districtSelect.addEventListener('change', function () {
                const selectedOption = this.options[this.selectedIndex];
                const districtCode = selectedOption.getAttribute('data-code');
                resetVillage();
                if (!districtCode) return;

                fetch(`/locations/villages/${districtCode}`)
                    .then(r => r.ok ? r.json() : Promise.reject(r))
                    .then(data => {
                        data.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.name;
                            opt.textContent = item.name;
                            opt.setAttribute('data-code', item.code);
                            villageSelect.appendChild(opt);
                        });
                        villageSelect.disabled = false;
                    })
                    .catch(e => console.error(e));
            });
        }

        // === 2. TOGGLE PASSWORD (Updated for Font Awesome) ===
        function setupTogglePassword(inputId, btnId) {
            const input = document.getElementById(inputId);
            const btn   = document.getElementById(btnId);
            if (!input || !btn) return;

            btn.addEventListener('click', function () {
                const icon = this.querySelector('i');
                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('fa-eye');
                    icon.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    icon.classList.remove('fa-eye-slash');
                    icon.classList.add('fa-eye');
                }
            });
        }
        setupTogglePassword('password', 'togglePassword');
        setupTogglePassword('password_confirmation', 'togglePassword2');

        // === 3. PASSWORD STRENGTH INDICATOR ===
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
                const barColors = ['bg-gray-300', 'bg-red-500', 'bg-yellow-400', 'bg-green-500', 'bg-emerald-600'];
                const texts = ['Kekuatan password', 'Lemah', 'Sedang', 'Kuat', 'Sangat kuat'];
                const textColors = ['text-gray-500', 'text-red-500', 'text-yellow-500', 'text-green-500', 'text-emerald-600'];

                const idx = v.length === 0 ? 0 : score;
                barFill.style.width = widths[idx];
                barFill.className = 'h-full transition-all duration-300 ' + barColors[idx];
                textEl.textContent = texts[idx];
                textEl.className = 'mt-1 text-xs ' + textColors[idx];
            });
        }
    });
    </script>

</body>
</html>