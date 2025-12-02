{{-- 1. Extend Layout Utama --}}
@extends('layouts.platform')

{{-- 2. Judul Halaman --}}
@section('title', 'Kelola Kategori Produk')

{{-- 3. CSS Tambahan --}}
@push('head')
    <style>
        /* Style Table Header agar senada dengan tema Emerald */
        th {
            background-color: #ecfdf5; /* emerald-50 */
            color: #065f46; /* emerald-800 */
            text-transform: uppercase;
            font-size: 0.75rem; /* text-xs */
            font-weight: 700;
            letter-spacing: 0.05em;
        }
        
        /* Custom SweetAlert Confirm Button color override */
        .swal2-confirm {
            background-color: #059669 !important; /* emerald-600 */
        }
        .swal2-confirm:hover {
            background-color: #047857 !important; /* emerald-700 */
        }
    </style>
@endpush

{{-- 4. Konten Utama --}}
@section('content')

    <div class="w-full">
        
        {{-- Header Page (Judul & Tombol Tambah) --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                    <span>🏷️</span> Kelola Kategori Produk
                </h2>
                <p class="text-sm text-gray-500 mt-1">
                    Atur daftar kategori produk yang tersedia di platform EasyMart.
                </p>
            </div>
            
            <button onclick="showAddCategoryModal()" 
                class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 text-white font-semibold rounded-full shadow-md transition transform hover:-translate-y-0.5 hover:shadow-lg text-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Tambah Kategori
            </button>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 p-4 rounded-lg bg-emerald-100 border border-emerald-200 text-emerald-800 flex items-center gap-3 shadow-sm">
                <svg class="w-6 h-6 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span class="font-bold">Berhasil!</span> {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('error'))
            <div class="mb-6 p-4 rounded-lg bg-red-100 border border-red-200 text-red-800 flex items-center gap-3 shadow-sm">
                <svg class="w-6 h-6 text-red-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                <div>
                    <span class="font-bold">Error!</span> {{ session('error') }}
                </div>
            </div>
        @endif

        {{-- TABLE KATEGORI --}}
        <div class="bg-white shadow-md rounded-xl overflow-hidden border border-gray-100">
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-4 border-b border-gray-200 text-left">No</th>
                            <th class="px-5 py-4 border-b border-gray-200 text-left">Nama Kategori</th>
                            <th class="px-5 py-4 border-b border-gray-200 text-left">Slug</th>
                            <th class="px-5 py-4 border-b border-gray-200 text-left">Deskripsi</th>
                            <th class="px-5 py-4 border-b border-gray-200 text-left">Jumlah Produk</th>
                            <th class="px-5 py-4 border-b border-gray-200 text-left">Status</th>
                            <th class="px-5 py-4 border-b border-gray-200 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        @forelse($categories as $index => $category)
                        <tr class="hover:bg-slate-50 transition-colors duration-150">
                            <td class="px-5 py-4 text-sm text-gray-500 font-medium">{{ $index + 1 }}</td>
                            <td class="px-5 py-4 text-sm font-bold text-gray-800">{{ $category->name }}</td>
                            <td class="px-5 py-4 text-sm text-gray-500 font-mono text-xs">{{ $category->slug }}</td>
                            <td class="px-5 py-4 text-sm text-gray-600 italic">{{ Str::limit($category->description ?? '-', 50) }}</td>
                            <td class="px-5 py-4 text-sm">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-50 text-blue-700 border border-blue-200">
                                    {{ $category->products->count() }} Produk
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm">
                                <form action="{{ route('platform.categories.toggle', $category) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit" 
                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold cursor-pointer transition-colors duration-200 border
                                        {{ $category->is_active 
                                            ? 'bg-emerald-50 text-emerald-700 border-emerald-200 hover:bg-emerald-100' 
                                            : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100' }}">
                                        {{ $category->is_active ? '✓ Aktif' : '✗ Nonaktif' }}
                                    </button>
                                </form>
                            </td>
                            <td class="px-5 py-4 text-sm text-center">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Edit --}}
                                    <button onclick="editCategory({{ $category->id }}, '{{ $category->name }}', '{{ $category->description }}')" 
                                        class="p-1.5 rounded-md text-amber-600 hover:bg-amber-50 hover:text-amber-800 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                    </button>
                                    
                                    {{-- Tombol Hapus --}}
                                    @if($category->products->count() == 0)
                                    <form action="{{ route('platform.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menghapus kategori ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 rounded-md text-red-600 hover:bg-red-50 hover:text-red-800 transition-colors" title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </form>
                                    @else
                                    <button class="p-1.5 rounded-md text-gray-300 cursor-not-allowed" title="Tidak bisa dihapus karena masih ada produk" disabled>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-5 py-10 text-center">
                                <div class="flex flex-col items-center justify-center text-gray-500">
                                    <svg class="w-12 h-12 mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                                    <p>Belum ada kategori.</p>
                                    <button onclick="showAddCategoryModal()" class="mt-2 text-emerald-600 hover:underline text-sm font-semibold">Tambah kategori sekarang</button>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        
        {{-- Spacer agar tidak mentok bawah --}}
        <div class="h-10"></div>
    </div>
@endsection

{{-- 5. Javascript (Pindah ke stack scripts) --}}
@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function showAddCategoryModal() {
            Swal.fire({
                title: '<strong class="text-2xl text-gray-700">➕ Tambah Kategori</strong>',
                html: `
                    <form id="addCategoryForm" class="text-left px-4">
                        <div class="mb-4">
                            <label class="block text-gray-600 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                            <input type="text" id="add_name" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition" placeholder="Contoh: Pakaian Anak" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 text-sm font-bold mb-2">Deskripsi</label>
                            <textarea id="add_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition" placeholder="Deskripsi singkat (opsional)"></textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Simpan',
                cancelButtonText: 'Batal',
                width: '500px',
                padding: '1.5em',
                customClass: {
                    confirmButton: 'bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-6 rounded-lg',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded-lg ml-2',
                    popup: 'rounded-xl'
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const name = document.getElementById('add_name').value.trim();
                    if (!name) {
                        Swal.showValidationMessage('Nama kategori wajib diisi');
                        return false;
                    }
                    return {
                        name: name,
                        description: document.getElementById('add_description').value.trim()
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    createAndSubmitForm('{{ route("platform.categories.store") }}', 'POST', {
                        _token: '{{ csrf_token() }}',
                        name: result.value.name,
                        description: result.value.description
                    });
                }
            });
        }

        function editCategory(id, currentName, currentDesc) {
            Swal.fire({
                title: '<strong class="text-2xl text-gray-700">✏️ Edit Kategori</strong>',
                html: `
                    <form id="editCategoryForm" class="text-left px-4">
                        <div class="mb-4">
                            <label class="block text-gray-600 text-sm font-bold mb-2">Nama Kategori <span class="text-red-500">*</span></label>
                            <input type="text" id="edit_name" value="${currentName}" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-600 text-sm font-bold mb-2">Deskripsi</label>
                            <textarea id="edit_description" rows="3" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">${currentDesc || ''}</textarea>
                        </div>
                    </form>
                `,
                showCancelButton: true,
                confirmButtonText: 'Update',
                cancelButtonText: 'Batal',
                width: '500px',
                padding: '1.5em',
                customClass: {
                    confirmButton: 'bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg',
                    cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold py-2 px-6 rounded-lg ml-2',
                    popup: 'rounded-xl'
                },
                buttonsStyling: false,
                preConfirm: () => {
                    const name = document.getElementById('edit_name').value.trim();
                    if (!name) {
                        Swal.showValidationMessage('Nama kategori wajib diisi');
                        return false;
                    }
                    return {
                        name: name,
                        description: document.getElementById('edit_description').value.trim()
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    createAndSubmitForm(`/platform/categories/${id}`, 'POST', {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        name: result.value.name,
                        description: result.value.description
                    });
                }
            });
        }

        // Helper function untuk membuat form dinamis (membersihkan kode berulang)
        function createAndSubmitForm(action, method, data) {
            const form = document.createElement('form');
            form.method = method;
            form.action = action;

            for (const key in data) {
                if (data.hasOwnProperty(key)) {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = data[key];
                    form.appendChild(input);
                }
            }
            document.body.appendChild(form);
            form.submit();
        }
    </script>
@endpush