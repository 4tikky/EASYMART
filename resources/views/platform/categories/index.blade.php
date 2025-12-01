<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Kategori - EasyMart Platform</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased" style="background-color:#f7f6f2;">

    {{-- HEADER BAR --}}
    <header class="flex justify-between items-center px-10 py-4 bg-white shadow">
        <div class="flex items-center gap-4">
            <a href="{{ route('platform.dashboard') }}" class="text-gray-600 hover:text-brand-green-dark transition group" title="Kembali ke Dashboard">
                <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-brand-green-dark">
                EasyMart <span class="font-normal text-gray-500">Platform Dashboard</span>
            </h1>
        </div>

        <div class="flex items-center space-x-6">
            <span class="text-gray-700">
                {{ Auth::user()->name }} (Platform)
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="px-4 py-2 text-sm font-medium text-white rounded-full"
                    style="background-color:#1a432b;">
                    Logout
                </button>
            </form>
        </div>
    </header>

    {{-- MAIN CONTENT --}}
    <main class="px-10 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold" style="color:#2e603f;">
                🏷️ Kelola Kategori Produk
            </h2>
            
            <button onclick="showAddCategoryModal()" 
                class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded-full shadow-lg transition transform hover:-translate-y-1 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kategori
            </button>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                <p class="font-bold">✅ Berhasil!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded">
                <p class="font-bold">❌ Error!</p>
                <p>{{ session('error') }}</p>
            </div>
        @endif

        {{-- TABLE KATEGORI --}}
        <div class="bg-white shadow-lg rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">No</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama Kategori</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Slug</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Jumlah Produk</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categories as $index => $category)
                        <tr class="hover:bg-gray-50">
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $index + 1 }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-bold text-gray-900">{{ $category->name }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-600">{{ $category->slug }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-gray-600">{{ $category->description ?? '-' }}</td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full font-semibold">{{ $category->products->count() }}</span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <form action="{{ route('platform.categories.toggle', $category) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 rounded-full font-semibold text-xs {{ $category->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $category->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" 
                                    class="text-blue-600 hover:text-blue-800 font-semibold mr-3">Edit</button>
                                
                                @if($category->products->count() == 0)
                                <form action="{{ route('platform.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 font-semibold">Hapus</button>
                                </form>
                                @else
                                <span class="text-gray-400 text-xs">(Tidak bisa dihapus)</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center text-gray-500">
                                Belum ada kategori. Klik tombol "Tambah Kategori" untuk menambahkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAddCategoryModal() {
            Swal.fire({
                title: '<strong class="text-2xl">➕ Tambah Kategori Baru</strong>',
                html: `
                    <form id="addCategoryForm" class="text-left p-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                            <input type="text" id="add_name" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Contoh: Pakaian Anak" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                            <textarea id="add_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Deskripsi kategori (opsional)"></textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Tambah',
                cancelButtonText: 'Batal',
                width: '600px',
                customClass: {
                    confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded ml-2'
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const name = document.getElementById('add_name').value.trim();
                    
                    if (!name) {
                        Swal.showValidationMessage('Nama kategori harus diisi');
                        return false;
                    }
                    
                    return {
                        name: name,
                        description: document.getElementById('add_description').value.trim()
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '{{ route("platform.categories.store") }}';
                    
                    const csrfField = document.createElement('input');
                    csrfField.type = 'hidden';
                    csrfField.name = '_token';
                    csrfField.value = '{{ csrf_token() }}';
                    
                    const nameField = document.createElement('input');
                    nameField.type = 'hidden';
                    nameField.name = 'name';
                    nameField.value = result.value.name;
                    
                    const descField = document.createElement('input');
                    descField.type = 'hidden';
                    descField.name = 'description';
                    descField.value = result.value.description;
                    
                    form.appendChild(csrfField);
                    form.appendChild(nameField);
                    form.appendChild(descField);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }

        function editCategory(id, currentName, currentDesc) {
            Swal.fire({
                title: '<strong class="text-2xl">✏️ Edit Kategori</strong>',
                html: `
                    <form id="editCategoryForm" class="text-left p-4">
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                            <input type="text" id="edit_name" value="${currentName}" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Deskripsi</label>
                            <textarea id="edit_description" rows="3" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">${currentDesc || ''}</textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                cancelButtonText: 'Batal',
                width: '600px',
                customClass: {
                    confirmButton: 'bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-6 rounded',
                    cancelButton: 'bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-6 rounded ml-2'
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const name = document.getElementById('edit_name').value.trim();
                    
                    if (!name) {
                        Swal.showValidationMessage('Nama kategori harus diisi');
                        return false;
                    }
                    
                    return {
                        name: name,
                        description: document.getElementById('edit_description').value.trim()
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/platform/categories/${id}`;
                    
                    const csrfField = document.createElement('input');
                    csrfField.type = 'hidden';
                    csrfField.name = '_token';
                    csrfField.value = '{{ csrf_token() }}';
                    
                    const methodField = document.createElement('input');
                    methodField.type = 'hidden';
                    methodField.name = '_method';
                    methodField.value = 'PUT';
                    
                    const nameField = document.createElement('input');
                    nameField.type = 'hidden';
                    nameField.name = 'name';
                    nameField.value = result.value.name;
                    
                    const descField = document.createElement('input');
                    descField.type = 'hidden';
                    descField.name = 'description';
                    descField.value = result.value.description;
                    
                    form.appendChild(csrfField);
                    form.appendChild(methodField);
                    form.appendChild(nameField);
                    form.appendChild(descField);
                    
                    document.body.appendChild(form);
                    form.submit();
                }
            });
        }
    </script>

</body>
</html>
