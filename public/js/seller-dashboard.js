// Add Product Function
async function addProduct() {
    try {
        // Fetch categories
        const categoriesResponse = await fetch('/api/categories');
        const categories = await categoriesResponse.json();
        
        // Build category options
        const categoryOptions = categories.map(cat => 
            `<option value="${cat.name}">${cat.name}</option>`
        ).join('');
        
        Swal.fire({
            title: '<strong class="text-2xl text-gray-800">➕ Tambah Produk Baru</strong>',
            html: `
                <style>
                    .add-modal-content {
                        max-height: 70vh;
                        overflow-y: auto;
                        padding: 1rem;
                    }
                    .add-modal-content::-webkit-scrollbar {
                        width: 8px;
                    }
                    .add-modal-content::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 10px;
                    }
                    .add-modal-content::-webkit-scrollbar-thumb {
                        background: #10b981;
                        border-radius: 10px;
                    }
                    .add-modal-content::-webkit-scrollbar-thumb:hover {
                        background: #059669;
                    }
                    .add-form-group {
                        margin-bottom: 1.5rem;
                        text-align: left;
                    }
                    .add-form-label {
                        display: block;
                        font-weight: 600;
                        font-size: 0.875rem;
                        color: #374151;
                        margin-bottom: 0.5rem;
                    }
                    .add-form-label .required {
                        color: #ef4444;
                        margin-left: 2px;
                    }
                    .add-form-input, .add-form-select, .add-form-textarea {
                        width: 100%;
                        padding: 0.625rem 0.75rem;
                        border: 2px solid #e5e7eb;
                        border-radius: 0.5rem;
                        font-size: 0.875rem;
                        transition: all 0.2s;
                        box-sizing: border-box;
                    }
                    .add-form-input:focus, .add-form-select:focus, .add-form-textarea:focus {
                        outline: none;
                        border-color: #10b981;
                        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
                    }
                    .add-form-file {
                        width: 100%;
                        padding: 0.5rem;
                        border: 2px dashed #e5e7eb;
                        border-radius: 0.5rem;
                        font-size: 0.875rem;
                        cursor: pointer;
                        transition: all 0.2s;
                    }
                    .add-form-file:hover {
                        border-color: #10b981;
                        background-color: #f0fdf4;
                    }
                    .add-form-help {
                        font-size: 0.75rem;
                        color: #6b7280;
                        margin-top: 0.25rem;
                    }
                    .add-grid-2 {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }
                    .image-preview-container {
                        display: flex;
                        flex-wrap: wrap;
                        gap: 0.5rem;
                        margin-top: 0.5rem;
                    }
                    .image-preview {
                        width: 80px;
                        height: 80px;
                        object-fit: cover;
                        border-radius: 0.5rem;
                        border: 2px solid #e5e7eb;
                    }
                </style>
                <div class="add-modal-content">
                    <div class="add-form-group">
                        <label class="add-form-label">
                            Nama Produk <span class="required">*</span>
                        </label>
                        <input type="text" id="add_name" class="add-form-input" placeholder="Masukkan nama produk" required>
                    </div>

                    <div class="add-grid-2">
                        <div class="add-form-group">
                            <label class="add-form-label">
                                Harga (Rp) <span class="required">*</span>
                            </label>
                            <input type="number" id="add_price" class="add-form-input" placeholder="0" min="0" step="0.01" required>
                        </div>
                        <div class="add-form-group">
                            <label class="add-form-label">
                                Stok <span class="required">*</span>
                            </label>
                            <input type="number" id="add_stock" class="add-form-input" placeholder="0" min="0" required>
                        </div>
                    </div>

                    <div class="add-form-group">
                        <label class="add-form-label">
                            Kategori <span class="required">*</span>
                        </label>
                        <select id="add_category" class="add-form-select" required>
                            <option value="">Pilih Kategori</option>
                            ${categoryOptions}
                        </select>
                    </div>

                    <div class="add-form-group">
                        <label class="add-form-label">Deskripsi</label>
                        <textarea id="add_description" class="add-form-textarea" rows="4" placeholder="Jelaskan detail produk Anda..."></textarea>
                    </div>

                    <div class="add-form-group">
                        <label class="add-form-label">
                            Gambar Utama <span class="required">*</span>
                        </label>
                        <input type="file" id="add_image" class="add-form-file" accept="image/jpeg,image/jpg,image/png" required>
                        <div class="add-form-help">Format: JPG, JPEG, PNG. Maksimal 2MB</div>
                    </div>

                    <div class="add-form-group">
                        <label class="add-form-label">Gambar Tambahan (Opsional)</label>
                        <input type="file" id="add_images" class="add-form-file" accept="image/jpeg,image/jpg,image/png" multiple>
                        <div class="add-form-help">Pilih hingga 5 gambar tambahan. Format: JPG, JPEG, PNG. Maksimal 2MB per gambar</div>
                        <div id="add_images_preview" class="image-preview-container"></div>
                    </div>
                </div>
            `,
            width: '600px',
            showCancelButton: true,
            confirmButtonText: '💾 Simpan Produk',
            cancelButtonText: '❌ Batal',
            customClass: {
                confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg mr-2',
                cancelButton: 'bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-6 rounded-lg'
            },
            buttonsStyling: false,
            focusConfirm: false,
            didOpen: () => {
                // Preview multiple images
                document.getElementById('add_images').addEventListener('change', function(e) {
                    const preview = document.getElementById('add_images_preview');
                    preview.innerHTML = '';
                    
                    if (e.target.files) {
                        Array.from(e.target.files).slice(0, 5).forEach(file => {
                            const reader = new FileReader();
                            reader.onload = function(event) {
                                const img = document.createElement('img');
                                img.src = event.target.result;
                                img.className = 'image-preview';
                                preview.appendChild(img);
                            };
                            reader.readAsDataURL(file);
                        });
                    }
                });
            },
            preConfirm: () => {
                const name = document.getElementById('add_name').value.trim();
                const price = parseFloat(document.getElementById('add_price').value);
                const stock = parseInt(document.getElementById('add_stock').value);
                const category = document.getElementById('add_category').value;
                const description = document.getElementById('add_description').value.trim();
                const imageFile = document.getElementById('add_image').files[0];
                const additionalImages = document.getElementById('add_images').files;
                
                // Validasi
                if (!name) {
                    Swal.showValidationMessage('❌ Nama produk tidak boleh kosong');
                    return false;
                }
                if (isNaN(price) || price < 0) {
                    Swal.showValidationMessage('❌ Harga harus berupa angka positif');
                    return false;
                }
                if (isNaN(stock) || stock < 0 || !Number.isInteger(stock)) {
                    Swal.showValidationMessage('❌ Stok harus berupa bilangan bulat positif');
                    return false;
                }
                if (!category) {
                    Swal.showValidationMessage('❌ Kategori harus dipilih');
                    return false;
                }
                if (!imageFile) {
                    Swal.showValidationMessage('❌ Gambar utama harus diupload');
                    return false;
                }
                
                // Validasi file gambar utama
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                const maxSize = 2 * 1024 * 1024; // 2MB
                
                if (!validTypes.includes(imageFile.type)) {
                    Swal.showValidationMessage('❌ Format gambar harus JPG, JPEG, atau PNG');
                    return false;
                }
                if (imageFile.size > maxSize) {
                    Swal.showValidationMessage('❌ Ukuran gambar maksimal 2MB');
                    return false;
                }
                
                // Validasi gambar tambahan
                if (additionalImages.length > 5) {
                    Swal.showValidationMessage('❌ Maksimal 5 gambar tambahan');
                    return false;
                }
                
                for (let i = 0; i < additionalImages.length; i++) {
                    if (!validTypes.includes(additionalImages[i].type)) {
                        Swal.showValidationMessage('❌ Semua gambar harus berformat JPG, JPEG, atau PNG');
                        return false;
                    }
                    if (additionalImages[i].size > maxSize) {
                        Swal.showValidationMessage('❌ Ukuran setiap gambar maksimal 2MB');
                        return false;
                    }
                }
                
                return { name, price, stock, category, description, imageFile, additionalImages };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menambahkan produk Anda',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Prepare form data
                const formData = new FormData();
                formData.append('name', result.value.name);
                formData.append('price', result.value.price);
                formData.append('stock', result.value.stock);
                formData.append('category', result.value.category);
                formData.append('description', result.value.description);
                formData.append('image', result.value.imageFile);
                
                // Append additional images
                for (let i = 0; i < result.value.additionalImages.length; i++) {
                    formData.append('images[]', result.value.additionalImages[i]);
                }
                
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Send request
                fetch('/seller/product', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Save failed');
                        }).catch(() => {
                            throw new Error('Save failed');
                        });
                    }
                    return response.json();
                })
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Berhasil!',
                        text: 'Produk berhasil ditambahkan',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg'
                        },
                        buttonsStyling: false
                    }).then(() => location.reload());
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal!',
                        text: 'Gagal menyimpan produk. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg'
                        },
                        buttonsStyling: false
                    });
                    console.error('Error:', error);
                });
            }
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: '❌ Error!',
            text: 'Gagal memuat data kategori',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg'
            },
            buttonsStyling: false
        });
        console.error('Error:', error);
    }
}

// Edit Product Function
async function editProduct(productId) {
    try {
        // Fetch product data and categories in parallel
        const [productResponse, categoriesResponse] = await Promise.all([
            fetch(`/seller/product/${productId}/edit`),
            fetch('/api/categories')
        ]);
        
        const product = await productResponse.json();
        const categories = await categoriesResponse.json();
        
        // Build category options
        const categoryOptions = categories.map(cat => 
            `<option value="${cat.name}" ${product.category === cat.name ? 'selected' : ''}>${cat.name}</option>`
        ).join('');
        
        Swal.fire({
            title: '<strong class="text-2xl text-gray-800">✏️ Edit Produk</strong>',
            html: `
                <style>
                    .edit-modal-content {
                        max-height: 70vh;
                        overflow-y: auto;
                        padding: 1rem;
                    }
                    .edit-modal-content::-webkit-scrollbar {
                        width: 8px;
                    }
                    .edit-modal-content::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 10px;
                    }
                    .edit-modal-content::-webkit-scrollbar-thumb {
                        background: #10b981;
                        border-radius: 10px;
                    }
                    .edit-modal-content::-webkit-scrollbar-thumb:hover {
                        background: #059669;
                    }
                    .edit-form-group {
                        margin-bottom: 1.5rem;
                        text-align: left;
                    }
                    .edit-form-label {
                        display: block;
                        font-weight: 600;
                        font-size: 0.875rem;
                        color: #374151;
                        margin-bottom: 0.5rem;
                    }
                    .edit-form-label .required {
                        color: #ef4444;
                        margin-left: 2px;
                    }
                    .edit-form-input, .edit-form-select, .edit-form-textarea {
                        width: 100%;
                        padding: 0.625rem 0.75rem;
                        border: 2px solid #e5e7eb;
                        border-radius: 0.5rem;
                        font-size: 0.875rem;
                        transition: all 0.2s;
                        box-sizing: border-box;
                    }
                    .edit-form-input:focus, .edit-form-select:focus, .edit-form-textarea:focus {
                        outline: none;
                        border-color: #10b981;
                        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
                    }
                    .edit-form-file {
                        width: 100%;
                        padding: 0.5rem;
                        border: 2px dashed #e5e7eb;
                        border-radius: 0.5rem;
                        font-size: 0.875rem;
                        cursor: pointer;
                        transition: all 0.2s;
                    }
                    .edit-form-file:hover {
                        border-color: #10b981;
                        background-color: #f0fdf4;
                    }
                    .edit-form-help {
                        font-size: 0.75rem;
                        color: #6b7280;
                        margin-top: 0.25rem;
                    }
                    .edit-grid-2 {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }
                    .current-image-preview {
                        width: 100%;
                        max-width: 200px;
                        height: auto;
                        border-radius: 0.5rem;
                        margin-top: 0.5rem;
                        border: 2px solid #e5e7eb;
                    }
                </style>
                <div class="edit-modal-content">
                    <form id="editProductForm">
                        <div class="edit-form-group">
                            <label class="edit-form-label">
                                Nama Produk <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="edit_name" 
                                value="${product.name}" 
                                class="edit-form-input" 
                                placeholder="Contoh: Kaos Rajut Premium"
                                required>
                        </div>

                        <div class="edit-grid-2">
                            <div class="edit-form-group">
                                <label class="edit-form-label">
                                    Harga (Rp) <span class="required">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="edit_price" 
                                    value="${product.price}" 
                                    min="0" 
                                    step="0.01" 
                                    class="edit-form-input"
                                    placeholder="50000"
                                    required>
                                <p class="edit-form-help">Harga per unit produk</p>
                            </div>
                            <div class="edit-form-group">
                                <label class="edit-form-label">
                                    Stok <span class="required">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="edit_stock" 
                                    value="${product.stock}" 
                                    min="0" 
                                    class="edit-form-input"
                                    placeholder="100"
                                    required>
                                <p class="edit-form-help">Jumlah barang tersedia</p>
                            </div>
                        </div>

                        <div class="edit-form-group">
                            <label class="edit-form-label">
                                🏷️ Kategori <span class="required">*</span>
                            </label>
                            <select id="edit_category" class="edit-form-select" required>
                                ${categoryOptions}
                            </select>
                        </div>

                        <div class="edit-form-group">
                            <label class="edit-form-label">
                                Deskripsi Produk
                            </label>
                            <textarea 
                                id="edit_description" 
                                rows="4" 
                                class="edit-form-textarea"
                                placeholder="Deskripsikan produk Anda secara detail...">${product.description || ''}</textarea>
                            <p class="edit-form-help">Jelaskan detail, bahan, ukuran, dan keunggulan produk</p>
                        </div>

                        <div class="edit-form-group">
                            <label class="edit-form-label">
                                Gambar Produk Saat Ini
                            </label>
                            ${product.image_path ? `<img src="/storage/${product.image_path}" alt="Preview" class="current-image-preview">` : '<p class="text-gray-500 text-sm">Tidak ada gambar</p>'}
                        </div>

                        <div class="edit-form-group">
                            <label class="edit-form-label">
                                📸 Upload Gambar Baru (Opsional)
                            </label>
                            <input 
                                type="file" 
                                id="edit_image" 
                                accept="image/jpeg,image/png,image/jpg" 
                                class="edit-form-file">
                            <p class="edit-form-help">Format: JPG, JPEG, PNG. Maksimal 2MB. Kosongkan jika tidak ingin mengubah gambar.</p>
                        </div>
                    </form>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<span style="font-weight: 600;">Update Produk</span>',
            cancelButtonText: '<span style="font-weight: 600;">Batal</span>',
            width: '700px',
            customClass: {
                confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all',
                cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2.5 px-6 rounded-lg transition-all ml-2'
            },
            buttonsStyling: false,
            focusConfirm: false,
            preConfirm: () => {
                const name = document.getElementById('edit_name').value.trim();
                const price = parseFloat(document.getElementById('edit_price').value);
                const stock = parseInt(document.getElementById('edit_stock').value);
                const category = document.getElementById('edit_category').value;
                const description = document.getElementById('edit_description').value.trim();
                const imageFile = document.getElementById('edit_image').files[0];
                
                // Validasi
                if (!name) {
                    Swal.showValidationMessage('❌ Nama produk tidak boleh kosong');
                    return false;
                }
                if (isNaN(price) || price < 0) {
                    Swal.showValidationMessage('❌ Harga harus berupa angka positif');
                    return false;
                }
                if (isNaN(stock) || stock < 0 || !Number.isInteger(stock)) {
                    Swal.showValidationMessage('❌ Stok harus berupa bilangan bulat positif');
                    return false;
                }
                if (!category) {
                    Swal.showValidationMessage('❌ Kategori harus dipilih');
                    return false;
                }
                
                // Validasi file jika ada
                if (imageFile) {
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    
                    if (!validTypes.includes(imageFile.type)) {
                        Swal.showValidationMessage('❌ Format gambar harus JPG, JPEG, atau PNG');
                        return false;
                    }
                    if (imageFile.size > maxSize) {
                        Swal.showValidationMessage('❌ Ukuran gambar maksimal 2MB');
                        return false;
                    }
                }
                
                return { name, price, stock, category, description, imageFile };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang mengupdate produk Anda',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData();
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                formData.append('_token', csrfToken);
                formData.append('_method', 'PUT');
                formData.append('name', result.value.name);
                formData.append('price', result.value.price);
                formData.append('stock', result.value.stock);
                formData.append('category', result.value.category);
                formData.append('description', result.value.description);
                if (result.value.imageFile) {
                    formData.append('image', result.value.imageFile);
                }
                
                fetch(`/seller/product/${productId}`, {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) throw new Error('Update failed');
                    return response.json();
                })
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Berhasil!',
                        text: 'Produk berhasil diupdate',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg'
                        },
                        buttonsStyling: false
                    }).then(() => location.reload());
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal!',
                        text: 'Gagal mengupdate produk. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg'
                        },
                        buttonsStyling: false
                    });
                    console.error('Error:', error);
                });
            }
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: '❌ Error!',
            text: 'Gagal memuat data produk',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg'
            },
            buttonsStyling: false
        });
        console.error('Error:', error);
    }
}

// Add Product Function
async function showAddProductModal() {
    try {
        // Fetch categories from API
        const response = await fetch('/api/categories');
        const categories = await response.json();
        
        if (categories.length === 0) {
            Swal.fire({
                icon: 'warning',
                title: '⚠️ Peringatan',
                text: 'Belum ada kategori aktif. Hubungi admin untuk menambahkan kategori.',
                confirmButtonText: 'OK'
            });
            return;
        }

        // Build category options
        const categoryOptions = categories.map(cat => 
            `<option value="${cat.name}">${cat.name}</option>`
        ).join('');
        
        Swal.fire({
            title: '<strong class="text-2xl text-gray-800">📦 Tambah Produk Baru</strong>',
            html: `
                <style>
                    .add-modal-content {
                        max-height: 70vh;
                        overflow-y: auto;
                        padding: 1rem;
                    }
                    .add-modal-content::-webkit-scrollbar {
                        width: 8px;
                    }
                    .add-modal-content::-webkit-scrollbar-track {
                        background: #f1f1f1;
                        border-radius: 10px;
                    }
                    .add-modal-content::-webkit-scrollbar-thumb {
                        background: #10b981;
                        border-radius: 10px;
                    }
                    .add-modal-content::-webkit-scrollbar-thumb:hover {
                        background: #059669;
                    }
                    .add-form-group {
                        margin-bottom: 1.5rem;
                        text-align: left;
                    }
                    .add-form-label {
                        display: block;
                        font-weight: 600;
                        font-size: 0.875rem;
                        color: #374151;
                        margin-bottom: 0.5rem;
                    }
                    .add-form-label .required {
                        color: #ef4444;
                        margin-left: 2px;
                    }
                    .add-form-input, .add-form-select, .add-form-textarea {
                        width: 100%;
                        padding: 0.625rem 0.75rem;
                        border: 2px solid #e5e7eb;
                        border-radius: 0.5rem;
                        font-size: 0.875rem;
                        transition: all 0.2s;
                        box-sizing: border-box;
                    }
                    .add-form-input:focus, .add-form-select:focus, .add-form-textarea:focus {
                        outline: none;
                        border-color: #10b981;
                        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
                    }
                    .add-form-file {
                        width: 100%;
                        padding: 0.5rem;
                        border: 2px dashed #e5e7eb;
                        border-radius: 0.5rem;
                        font-size: 0.875rem;
                        cursor: pointer;
                        transition: all 0.2s;
                    }
                    .add-form-file:hover {
                        border-color: #10b981;
                        background-color: #f0fdf4;
                    }
                    .add-form-help {
                        font-size: 0.75rem;
                        color: #6b7280;
                        margin-top: 0.25rem;
                    }
                    .add-grid-2 {
                        display: grid;
                        grid-template-columns: repeat(2, 1fr);
                        gap: 1rem;
                    }
                </style>
                <div class="add-modal-content">
                    <form id="addProductForm">
                        <div class="add-form-group">
                            <label class="add-form-label">
                                Nama Produk <span class="required">*</span>
                            </label>
                            <input 
                                type="text" 
                                id="add_name" 
                                class="add-form-input" 
                                placeholder="Contoh: Kaos Rajut Premium"
                                required>
                        </div>

                        <div class="add-grid-2">
                            <div class="add-form-group">
                                <label class="add-form-label">
                                    Harga (Rp) <span class="required">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="add_price" 
                                    min="0" 
                                    step="0.01" 
                                    class="add-form-input"
                                    placeholder="50000"
                                    required>
                                <p class="add-form-help">Harga per unit produk</p>
                            </div>
                            <div class="add-form-group">
                                <label class="add-form-label">
                                    Stok <span class="required">*</span>
                                </label>
                                <input 
                                    type="number" 
                                    id="add_stock" 
                                    min="0" 
                                    class="add-form-input"
                                    placeholder="100"
                                    required>
                                <p class="add-form-help">Jumlah barang tersedia</p>
                            </div>
                        </div>

                        <div class="add-form-group">
                            <label class="add-form-label">
                                🏷️ Kategori <span class="required">*</span>
                            </label>
                            <select id="add_category" class="add-form-select" required>
                                <option value="">-- Pilih Kategori --</option>
                                ${categoryOptions}
                            </select>
                        </div>

                        <div class="add-form-group">
                            <label class="add-form-label">
                                📝 Deskripsi Produk <span class="required">*</span>
                            </label>
                            <textarea 
                                id="add_description" 
                                rows="4" 
                                class="add-form-textarea"
                                placeholder="Deskripsikan produk Anda secara detail..."
                                required></textarea>
                            <p class="add-form-help">Jelaskan detail, bahan, ukuran, dan keunggulan produk</p>
                        </div>

                        <div class="add-form-group">
                            <label class="add-form-label">
                                📸 Foto Produk
                            </label>
                            <input 
                                type="file" 
                                id="add_image" 
                                accept="image/jpeg,image/png,image/jpg" 
                                class="add-form-file">
                            <p class="add-form-help">Format: JPG, JPEG, PNG. Maksimal 2MB. (Opsional)</p>
                        </div>
                    </form>
                </div>
            `,
            showCancelButton: true,
            confirmButtonText: '<span style="font-weight: 600;">💾 Simpan Produk</span>',
            cancelButtonText: '<span style="font-weight: 600;">❌ Batal</span>',
            width: '700px',
            customClass: {
                confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2.5 px-6 rounded-lg transition-all',
                cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2.5 px-6 rounded-lg transition-all ml-2'
            },
            buttonsStyling: false,
            focusConfirm: false,
            preConfirm: () => {
                const name = document.getElementById('add_name').value.trim();
                const price = parseFloat(document.getElementById('add_price').value);
                const stock = parseInt(document.getElementById('add_stock').value);
                const category = document.getElementById('add_category').value;
                const description = document.getElementById('add_description').value.trim();
                const imageFile = document.getElementById('add_image').files[0];
                
                // Validasi
                if (!name) {
                    Swal.showValidationMessage('❌ Nama produk tidak boleh kosong');
                    return false;
                }
                if (isNaN(price) || price < 0) {
                    Swal.showValidationMessage('❌ Harga harus berupa angka positif');
                    return false;
                }
                if (isNaN(stock) || stock < 0 || !Number.isInteger(stock)) {
                    Swal.showValidationMessage('❌ Stok harus berupa bilangan bulat positif');
                    return false;
                }
                if (!category) {
                    Swal.showValidationMessage('❌ Kategori harus dipilih');
                    return false;
                }
                if (!description) {
                    Swal.showValidationMessage('❌ Deskripsi produk tidak boleh kosong');
                    return false;
                }
                
                // Validasi file jika ada
                if (imageFile) {
                    const validTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    const maxSize = 2 * 1024 * 1024; // 2MB
                    
                    if (!validTypes.includes(imageFile.type)) {
                        Swal.showValidationMessage('❌ Format gambar harus JPG, JPEG, atau PNG');
                        return false;
                    }
                    if (imageFile.size > maxSize) {
                        Swal.showValidationMessage('❌ Ukuran gambar maksimal 2MB');
                        return false;
                    }
                }
                
                return { name, price, stock, category, description, imageFile };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Show loading
                Swal.fire({
                    title: 'Memproses...',
                    html: 'Sedang menyimpan produk Anda',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const formData = new FormData();
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                formData.append('_token', csrfToken);
                formData.append('name', result.value.name);
                formData.append('price', result.value.price);
                formData.append('stock', result.value.stock);
                formData.append('category', result.value.category);
                formData.append('description', result.value.description);
                if (result.value.imageFile) {
                    formData.append('image', result.value.imageFile);
                }
                
                fetch('/seller/product', {
                    method: 'POST',
                    body: formData
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Save failed');
                        }).catch(() => {
                            throw new Error('Save failed');
                        });
                    }
                    return response.json();
                })
                .then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: '✅ Berhasil!',
                        text: 'Produk berhasil ditambahkan',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-lg'
                        },
                        buttonsStyling: false
                    }).then(() => location.reload());
                })
                .catch((error) => {
                    Swal.fire({
                        icon: 'error',
                        title: '❌ Gagal!',
                        text: 'Gagal menyimpan produk. Silakan coba lagi.',
                        confirmButtonText: 'OK',
                        customClass: {
                            confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg'
                        },
                        buttonsStyling: false
                    });
                    console.error('Error:', error);
                });
            }
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: '❌ Error!',
            text: 'Gagal memuat data kategori',
            confirmButtonText: 'OK',
            customClass: {
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-6 rounded-lg'
            },
            buttonsStyling: false
        });
        console.error('Error:', error);
    }
}
