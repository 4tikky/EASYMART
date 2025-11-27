<!-- <x-app-layout>
    <div class="py-12 bg-gray-50">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center text-green-700 hover:text-green-900 mb-6 font-medium transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Kembali ke Dashboard
            </a>

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg border-t-4 border-green-500">
                <div class="p-8">
                    
                    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Produk Baru</h2>
                    
                    <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-5">
                            <label class="block text-gray-700 font-bold mb-2">Nama Produk</label>
                            <input type="text" name="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition" placeholder="Contoh: Cardigan Rajut Premium" required>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-5">
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Harga (Rp)</label>
                                <input type="number" name="price" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition" placeholder="150000" required>
                            </div>
                            
                            <div>
                                <label class="block text-gray-700 font-bold mb-2">Stok Awal</label>
                                <input type="number" name="stock" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition" placeholder="10" required>
                            </div>
                        </div>

                        <div class="mb-5">
                            <label class="block text-gray-700 font-bold mb-2">Kategori Produk</label>
                            <select name="category" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition" required>
                                <option value="" disabled selected>Pilih Kategori</option>
                                <option value="Pakaian Wanita">Pakaian Wanita</option>
                                <option value="Pakaian Pria">Pakaian Pria</option>
                                <option value="Aksesoris">Aksesoris</option>
                                <option value="Rajutan">Rajutan Handmade</option>
                                <option value="Lainnya">Lainnya</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label class="block text-gray-700 font-bold mb-2">Deskripsi Produk</label>
                            <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-green-500 focus:ring focus:ring-green-200 transition" placeholder="Jelaskan detail produkmu di sini..." required></textarea>
                        </div>

                        <div class="mb-8">
                            <label class="block text-gray-700 font-bold mb-2">Foto Produk</label>
                            <div class="flex items-center justify-center w-full">
                                <label class="flex flex-col w-full h-32 border-2 border-dashed border-green-300 hover:bg-green-50 hover:border-green-500 transition rounded-lg cursor-pointer">
                                    <div class="flex flex-col items-center justify-center pt-7">
                                        <svg class="w-8 h-8 text-green-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <p class="pt-1 text-sm tracking-wider text-gray-400 group-hover:text-green-600">Pilih foto produk</p>
                                    </div>
                                    <input type="file" name="image" class="opacity-0" />
                                </label>
                            </div>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-8 rounded-full shadow-lg transform transition hover:-translate-y-1">
                                Simpan Produk
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> -->