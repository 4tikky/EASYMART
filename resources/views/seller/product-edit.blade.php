<x-app-layout>
    <div class="bg-[#f7f6f2] min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

            {{-- Breadcrumb + Title --}}
            <div class="mb-6">
                <p class="text-xs text-gray-500 uppercase tracking-wider mb-1">
                    Dashboard Toko / Produk
                </p>
                <div class="flex items-center justify-between gap-4">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">
                            Edit Produk
                        </h1>
                        <p class="text-sm text-gray-500 mt-1">
                            Ubah informasi produk yang sudah terdaftar di toko <span class="font-semibold">{{ $seller->storeName }}</span>.
                        </p>
                    </div>

                    <a href="{{ route('seller.dashboard') }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-gray-300 text-sm text-gray-700 bg-white hover:bg-gray-50 shadow-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24"
                             stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M15 19l-7-7 7-7"/>
                        </svg>
                        Kembali ke Dashboard
                    </a>
                </div>
            </div>

            {{-- Card Form --}}
            <div class="bg-white shadow-lg rounded-2xl overflow-hidden border border-gray-100">
                {{-- Header card --}}
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div>
                        <h2 class="text-lg font-semibold text-gray-800">
                            {{ $product->name }}
                        </h2>
                        <p class="text-xs text-gray-500 mt-1">
                            Perbarui detail produk agar pembeli mendapatkan informasi yang akurat.
                        </p>
                    </div>

                    @if($product->main_image)
                        <div class="hidden sm:flex items-center gap-3">
                            <span class="text-xs text-gray-500">Pratinjau</span>
                            <img src="{{ asset('storage/'.$product->main_image) }}"
                                 class="h-12 w-12 rounded-lg object-cover border border-gray-200">
                        </div>
                    @endif
                </div>

                {{-- Body form --}}
                <form action="{{ route('seller.product.update', $product) }}"
                      method="POST"
                      enctype="multipart/form-data"
                      class="px-6 py-6 space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Nama produk --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nama Produk
                        </label>
                        <input type="text"
                               name="name"
                               value="{{ old('name', $product->name) }}"
                               class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm
                                      px-3 py-2.5 shadow-sm bg-gray-50">
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Harga & stok --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Harga (Rp)
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-3 flex items-center text-xs text-gray-400">Rp</span>
                                <input type="number"
                                       name="price"
                                       value="{{ old('price', $product->price) }}"
                                       class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm
                                              pl-9 pr-3 py-2.5 shadow-sm bg-gray-50">
                            </div>
                            @error('price')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Stok
                            </label>
                            <input type="number"
                                   name="stock"
                                   value="{{ old('stock', $product->stock) }}"
                                   class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm
                                          px-3 py-2.5 shadow-sm bg-gray-50">
                            @error('stock')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Deskripsi --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Deskripsi
                        </label>
                        <textarea name="description"
                                  rows="4"
                                  class="block w-full rounded-xl border-gray-300 focus:border-emerald-500 focus:ring-emerald-500 text-sm
                                         px-3 py-2.5 shadow-sm bg-gray-50 resize-y">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Foto produk --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Foto Produk (opsional)
                        </label>

                        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center">
                            @if($product->main_image)
                                <img src="{{ asset('storage/'.$product->main_image) }}"
                                     class="h-20 w-20 rounded-xl object-cover border border-gray-200">
                            @endif

                            <label class="inline-flex items-center px-4 py-2.5 rounded-full bg-emerald-50 text-emerald-700 text-sm font-semibold cursor-pointer hover:bg-emerald-100 shadow-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M4 3a2 2 0 00-2 2v9.5A1.5 1.5 0 003.5 16h13a1.5 1.5 0 001.5-1.5V8a2 2 0 00-2-2h-3.586l-1.707-1.707A1 1 0 0010.586 4H4z" />
                                </svg>
                                Pilih File
                                <input type="file" name="image" class="hidden" accept="image/*">
                            </label>

                            <p class="text-xs text-gray-500">
                                Format: JPG/PNG, maks 2MB.
                            </p>
                        </div>

                        @error('image')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Footer actions --}}
                    <div class="pt-4 border-t border-gray-100 flex justify-end gap-3">
                        <a href="{{ route('seller.dashboard') }}"
                           class="inline-flex items-center px-5 py-2.5 rounded-full border border-gray-300 text-sm text-gray-700 bg-white hover:bg-gray-50">
                            Batal
                        </a>
                        <button type="submit"
                                class="inline-flex items-center px-6 py-2.5 rounded-full bg-emerald-600 text-sm font-semibold text-white shadow-md hover:bg-emerald-700">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
