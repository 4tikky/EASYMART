// Edit Product Function
async function editProduct(productId) {
    try {
        const response = await fetch(`/seller/product/${productId}/edit`);
        const product = await response.json();
        
        Swal.fire({
            title: 'Edit Produk',
            html: `
                <form id="editProductForm" class="text-left">
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Nama Produk</label>
                        <input type="text" id="edit_name" value="${product.name}" class="swal2-input w-full" required>
                    </div>
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Harga</label>
                            <input type="number" id="edit_price" value="${product.price}" min="0" step="0.01" class="swal2-input w-full" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-sm font-bold mb-2">Stok</label>
                            <input type="number" id="edit_stock" value="${product.stock}" min="0" class="swal2-input w-full" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Kategori</label>
                        <select id="edit_category" class="swal2-input w-full" required>
                            <option value="Elektronik" ${product.category === 'Elektronik' ? 'selected' : ''}>Elektronik</option>
                            <option value="Fashion" ${product.category === 'Fashion' ? 'selected' : ''}>Fashion</option>
                            <option value="Makanan" ${product.category === 'Makanan' ? 'selected' : ''}>Makanan</option>
                            <option value="Minuman" ${product.category === 'Minuman' ? 'selected' : ''}>Minuman</option>
                            <option value="Kecantikan" ${product.category === 'Kecantikan' ? 'selected' : ''}>Kecantikan</option>
                            <option value="Olahraga" ${product.category === 'Olahraga' ? 'selected' : ''}>Olahraga</option>
                            <option value="Buku" ${product.category === 'Buku' ? 'selected' : ''}>Buku</option>
                            <option value="Mainan" ${product.category === 'Mainan' ? 'selected' : ''}>Mainan</option>
                            <option value="Lainnya" ${product.category === 'Lainnya' ? 'selected' : ''}>Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                        <textarea id="edit_description" rows="3" class="swal2-textarea w-full">${product.description || ''}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Baru (Opsional)</label>
                        <input type="file" id="edit_image" accept="image/*" class="swal2-file w-full">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Update',
            cancelButtonText: 'Batal',
            width: '600px',
            preConfirm: () => {
                const name = document.getElementById('edit_name').value;
                const price = document.getElementById('edit_price').value;
                const stock = document.getElementById('edit_stock').value;
                const category = document.getElementById('edit_category').value;
                const description = document.getElementById('edit_description').value;
                const imageFile = document.getElementById('edit_image').files[0];
                
                if (!name || price < 0 || stock < 0) {
                    Swal.showValidationMessage('Mohon isi semua field dengan benar');
                    return false;
                }
                
                return { name, price, stock, category, description, imageFile };
            }
        }).then((result) => {
            if (result.isConfirmed) {
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
                }).then(() => {
                    Swal.fire('Berhasil!', 'Produk berhasil diupdate', 'success').then(() => location.reload());
                }).catch(() => {
                    Swal.fire('Error!', 'Gagal mengupdate produk', 'error');
                });
            }
        });
    } catch (error) {
        Swal.fire('Error!', 'Gagal memuat data produk', 'error');
    }
}
