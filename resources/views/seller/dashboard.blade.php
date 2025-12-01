<x-app-layout>
    <div x-data="{ showModal: false }">

        <div class="bg-green-700 pb-24 pt-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <div>
                        <h1 class="text-3xl font-bold text-white">
                            Dashboard Toko {{ $seller->storeName }}
                        </h1>
                        <p class="text-green-100 mt-2 text-sm">
                            Kelola produk, stok, dan pantau performa penjualanmu di sini.
                        </p>
                    </div>
                    
                    <button @click="showModal = true" 
                       class="bg-white text-green-700 hover:bg-green-50 font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Upload Produk
                    </button>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16">
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 border-l-4 border-green-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 text-green-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Produk</p>
                            <p class="text-2xl font-bold text-gray-800">{{ count($products) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 border-l-4 border-blue-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Stok Fisik</p>
                            <p class="text-2xl font-bold text-gray-800">{{ collect($productStocks)->sum() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow-lg rounded-xl p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 text-yellow-600">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Status Toko</p>
                            <p class="text-lg font-bold text-green-600 uppercase">{{ $seller->status }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div class="bg-white shadow-lg rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Statistik Stok Produk</h3>
                    <canvas id="stockChart"></canvas>
                </div>
                <div class="bg-white shadow-lg rounded-xl p-6">
                    <h3 class="text-lg font-bold text-gray-700 mb-4 border-b pb-2">Rata-rata Rating Produk</h3>
                    <canvas id="ratingChart"></canvas>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-xl overflow-hidden mb-12">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-700">Daftar Produk Anda</h3>
                    
                    <!-- Tombol Export PDF -->
                    <div class="flex gap-2">
                        <a href="{{ route('seller.export.stock') }}" class="inline-flex items-center px-3 py-2 bg-green-600 text-white text-xs font-semibold rounded hover:bg-green-700 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            PDF Stock
                        </a>
                        <a href="{{ route('seller.export.rating') }}" class="inline-flex items-center px-3 py-2 bg-red-600 text-white text-xs font-semibold rounded hover:bg-red-700 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            PDF Rating
                        </a>
                        <a href="{{ route('seller.export.reorder') }}" class="inline-flex items-center px-3 py-2 bg-yellow-600 text-white text-xs font-semibold rounded hover:bg-yellow-700 transition">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                            PDF Reorder
                        </a>
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Produk</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Stok</th>
                                <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($products as $product)
                            <tr class="hover:bg-gray-50">
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-medium text-gray-900">{{ $product->name }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">Rp {{ number_format($product->price) }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $product->stock }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <button onclick="editProduct({{ $product->id }})" class="text-blue-600 hover:text-blue-800 font-semibold mr-3">Edit</button>
                                    <form action="{{ route('seller.product.delete', $product->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div x-show="showModal" 
             style="display: none;" 
             class="fixed inset-0 z-50 overflow-y-auto" 
             aria-labelledby="modal-title" role="dialog" aria-modal="true">
            
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div @click="showModal = false" class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg w-full">
                    
                    <div class="bg-green-700 px-4 py-3 sm:px-6 flex justify-between items-center">
                        <h3 class="text-lg leading-6 font-medium text-white" id="modal-title">
                            Tambah Produk Baru
                        </h3>
                        <button @click="showModal = false" class="text-green-200 hover:text-white">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>

                    <form action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data" id="productForm">
                        @csrf
                        <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                            
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                                <input type="text" name="name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-4">
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Harga (Rp)</label>
                                    <input type="number" name="price" id="price" min="0" step="0.01" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    @error('price')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                                    <input type="number" name="stock" id="stock" min="0" step="1" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    @error('stock')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                                <select name="category" class="shadow border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                                    <option value="Pakaian Wanita">Pakaian Wanita</option>
                                    <option value="Pakaian Pria">Pakaian Pria</option>
                                    <option value="Aksesoris">Aksesoris</option>
                                    <option value="Rajutan">Rajutan</option>
                                </select>
                                @error('category')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                                <textarea name="description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                                @error('description')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                             <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Foto Produk</label>
                                <input type="file" name="image" accept="image/jpeg,image/png,image/jpg" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100"/>
                                <p class="text-xs text-gray-500 mt-1">Format: JPG, JPEG, PNG. Maksimal 2MB</p>
                                @error('image')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>
                        
                        <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                            <button type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm">
                                Simpan Produk
                            </button>
                            <button @click="showModal = false" type="button" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                Batal
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/seller-dashboard.js') }}"></script>
    <script>
        // Validasi form produk
        document.getElementById('productForm')?.addEventListener('submit', function(e) {
            const price = parseFloat(document.getElementById('price').value);
            const stock = parseInt(document.getElementById('stock').value);

            if (price < 0) {
                e.preventDefault();
                alert('❌ Harga tidak boleh kurang dari 0!');
                document.getElementById('price').focus();
                return false;
            }

            if (stock < 0) {
                e.preventDefault();
                alert('❌ Stok tidak boleh kurang dari 0!');
                document.getElementById('stock').focus();
                return false;
            }

            if (!Number.isInteger(stock)) {
                e.preventDefault();
                alert('❌ Stok harus berupa bilangan bulat!');
                document.getElementById('stock').focus();
                return false;
            }
        });

        // Validasi real-time saat input
        document.getElementById('price')?.addEventListener('input', function() {
            if (parseFloat(this.value) < 0) {
                this.setCustomValidity('Harga tidak boleh negatif');
                this.reportValidity();
            } else {
                this.setCustomValidity('');
            }
        });

        document.getElementById('stock')?.addEventListener('input', function() {
            if (parseInt(this.value) < 0) {
                this.setCustomValidity('Stok tidak boleh negatif');
                this.reportValidity();
            } else {
                this.setCustomValidity('');
            }
        });

        // Chart.js
        const labels = @json($productNames);
        const stockData = @json($productStocks);
        const ratingData = @json($productRatings);

        const ctxStock = document.getElementById('stockChart').getContext('2d');
        new Chart(ctxStock, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Stok',
                    data: stockData,
                    backgroundColor: 'rgba(16, 185, 129, 0.6)', 
                    borderColor: 'rgba(16, 185, 129, 1)',
                    borderWidth: 1
                }]
            },
            options: { scales: { y: { beginAtZero: true } } }
        });

        const ctxRating = document.getElementById('ratingChart').getContext('2d');
        new Chart(ctxRating, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rating',
                    data: ratingData,
                    backgroundColor: 'rgba(251, 191, 36, 0.2)',
                    borderColor: 'rgba(251, 191, 36, 1)',
                    borderWidth: 2,
                    fill: true
                }]
            },
            options: { scales: { y: { min: 0, max: 5 } } }
        });
    </script>
</x-app-layout>