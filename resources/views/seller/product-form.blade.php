<!-- Modal Add/Edit Product -->
<div id="productModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        <div class="sticky top-0 bg-white border-b border-gray-200 px-6 py-4 flex justify-between items-center">
            <h3 class="text-xl font-bold text-gray-900">Tambah Produk Baru</h3>
            <button type="button" onclick="closeProductModal()" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <form id="productForm" action="{{ route('seller.product.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
            @csrf

            <!-- Product Name -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Nama Produk <span class="text-red-500">*</span></label>
                <input type="text" id="name" name="name" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                    placeholder="Contoh: Sweater Rajut">
            </div>

            <!-- Price & Stock -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Harga (Rp) <span class="text-red-500">*</span></label>
                    <input type="number" id="price" name="price" required min="0" step="0.01"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                        placeholder="50000">
                </div>

                <div>
                    <label for="stock" class="block text-sm font-medium text-gray-700 mb-2">Stok <span class="text-red-500">*</span></label>
                    <input type="number" id="stock" name="stock" required min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                        placeholder="100">
                </div>
            </div>

            <!-- Category -->
            <div>
                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Kategori <span class="text-red-500">*</span></label>
                <select id="category" name="category" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent">
                    <option value="">Pilih Kategori</option>
                    @if(isset($categories))
                        @foreach($categories->all() as $cat)
                            <option value="{{ $cat->name }}">{{ $cat->name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                    placeholder="Jelaskan detail produk Anda..."></textarea>
            </div>

            <!-- Main Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Foto Utama Produk</label>
                <input type="file" id="image" name="image" accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                    onchange="previewMainImage(event)">
                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG. Maksimal 2MB</p>
                <div id="mainImagePreview" class="mt-3 hidden">
                    <img id="mainImagePreviewImg" src="" alt="Preview" class="h-32 w-32 object-cover rounded-lg border">
                </div>
            </div>

            <!-- Multiple Additional Images -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">Foto Tambahan (Multiple)</label>
                <input type="file" id="images" name="images[]" accept="image/*" multiple
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent"
                    onchange="previewMultipleImages(event)">
                <p class="mt-1 text-xs text-gray-500">Pilih beberapa foto sekaligus (Ctrl/Cmd + Click). Format: JPG, PNG. Maksimal 2MB per foto</p>
                <div id="multipleImagesPreview" class="mt-3 grid grid-cols-4 gap-2"></div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3 pt-4 border-t">
                <button type="button" onclick="closeProductModal()"
                    class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Batal
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">
                    Simpan Produk
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function showAddProductModal() {
        document.getElementById('productModal').classList.remove('hidden');
        document.getElementById('productModal').classList.add('flex');
        document.getElementById('productForm').reset();
        document.getElementById('mainImagePreview').classList.add('hidden');
        document.getElementById('multipleImagesPreview').innerHTML = '';
    }

    function closeProductModal() {
        document.getElementById('productModal').classList.add('hidden');
        document.getElementById('productModal').classList.remove('flex');
    }

    function previewMainImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('mainImagePreviewImg').src = e.target.result;
                document.getElementById('mainImagePreview').classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function previewMultipleImages(event) {
        const files = event.target.files;
        const previewContainer = document.getElementById('multipleImagesPreview');
        previewContainer.innerHTML = '';

        if (files.length > 0) {
            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" alt="Preview ${index + 1}" 
                             class="h-24 w-24 object-cover rounded-lg border">
                        <span class="absolute top-1 right-1 bg-emerald-500 text-white text-xs px-2 py-1 rounded">
                            ${index + 1}
                        </span>
                    `;
                    previewContainer.appendChild(div);
                }
                reader.readAsDataURL(file);
            });
        }
    }

    // Handle form submission
    document.getElementById('productForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        
        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                closeProductModal();
                location.reload(); // Reload to show new product
            } else {
                alert('Error: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Terjadi kesalahan saat menyimpan produk');
        });
    });
</script>
