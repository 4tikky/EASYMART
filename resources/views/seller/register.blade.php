<x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Daftar Sebagai Penjual</h2>
                    
                    <form method="POST" action="{{ route('seller.store') }}" enctype="multipart/form-data" class="space-y-6">
                        @csrf

                        <!-- Informasi Toko -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Toko</h3>
                            
                            <div class="mb-4">
                                <label for="storeName" class="block text-sm font-medium text-gray-700 mb-2">Nama Toko <span class="text-red-500">*</span></label>
                                <input type="text" name="storeName" id="storeName" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                    value="{{ old('storeName') }}">
                                @error('storeName')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="storeDescription" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi Toko</label>
                                <textarea name="storeDescription" id="storeDescription" rows="3"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent">{{ old('storeDescription') }}</textarea>
                                @error('storeDescription')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Informasi Penanggung Jawab -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Informasi Penanggung Jawab</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="picName" class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap <span class="text-red-500">*</span></label>
                                    <input type="text" name="picName" id="picName" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picName') }}">
                                    @error('picName')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="picPhone" class="block text-sm font-medium text-gray-700 mb-2">Nomor HP <span class="text-red-500">*</span></label>
                                    <input type="text" name="picPhone" id="picPhone" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picPhone') }}">
                                    @error('picPhone')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="picEmail" class="block text-sm font-medium text-gray-700 mb-2">Email <span class="text-red-500">*</span></label>
                                <input type="email" name="picEmail" id="picEmail" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                    value="{{ old('picEmail', Auth::user()->email) }}">
                                @error('picEmail')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="picKtpNumber" class="block text-sm font-medium text-gray-700 mb-2">Nomor KTP <span class="text-red-500">*</span></label>
                                <input type="text" name="picKtpNumber" id="picKtpNumber" required maxlength="16" pattern="\d{16}" 
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                    value="{{ old('picKtpNumber') }}"
                                    oninput="this.value = this.value.replace(/\D/g, '').slice(0, 16)">
                                <p class="mt-1 text-xs text-gray-500">NIK harus 16 digit angka</p>
                                @error('picKtpNumber')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Alamat -->
                        <div class="border-b pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Alamat</h3>
                            
                            <div class="mb-4">
                                <label for="picStreet" class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="picStreet" id="picStreet" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                    value="{{ old('picStreet') }}">
                                @error('picStreet')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
                                <div>
                                    <label for="picRT" class="block text-sm font-medium text-gray-700 mb-2">RT</label>
                                    <input type="text" name="picRT" id="picRT"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picRT') }}">
                                </div>

                                <div>
                                    <label for="picRW" class="block text-sm font-medium text-gray-700 mb-2">RW</label>
                                    <input type="text" name="picRW" id="picRW"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picRW') }}">
                                </div>

                                <div class="col-span-2">
                                    <label for="picVillage" class="block text-sm font-medium text-gray-700 mb-2">Kelurahan/Desa</label>
                                    <input type="text" name="picVillage" id="picVillage"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picVillage') }}">
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label for="picProvince" class="block text-sm font-medium text-gray-700 mb-2">Provinsi <span class="text-red-500">*</span></label>
                                    <input type="text" name="picProvince" id="picProvince" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picProvince') }}">
                                    @error('picProvince')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="picCity" class="block text-sm font-medium text-gray-700 mb-2">Kota/Kabupaten <span class="text-red-500">*</span></label>
                                    <input type="text" name="picCity" id="picCity" required
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent"
                                        value="{{ old('picCity') }}">
                                    @error('picCity')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Upload Dokumen -->
                        <div class="pb-6">
                            <h3 class="text-lg font-semibold text-gray-700 mb-4">Dokumen</h3>
                            
                            <div class="mb-4">
                                <label for="picPhotoPath" class="block text-sm font-medium text-gray-700 mb-2">Foto Diri</label>
                                <input type="file" name="picPhotoPath" id="picPhotoPath" accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                                @error('picPhotoPath')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="picKtpFilePath" class="block text-sm font-medium text-gray-700 mb-2">Foto KTP</label>
                                <input type="file" name="picKtpFilePath" id="picKtpFilePath" accept="image/*"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-brand-green focus:border-transparent">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                                @error('picKtpFilePath')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end space-x-4 pt-6">
                            <a href="{{ route('welcome') }}" 
                                class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                                Batal
                            </a>
                            <button type="submit" 
                                class="px-6 py-2 bg-brand-green text-white rounded-lg hover:bg-green-700 transition">
                                Daftar Sekarang
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
