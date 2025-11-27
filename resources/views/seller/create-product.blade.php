@extends('seller.layouts.app') {{-- sesuaikan dengan layout seller-mu --}}

@section('content')
<div class="max-w-4xl mx-auto mt-8 bg-white rounded-2xl shadow p-6">
    <h1 class="text-2xl font-bold text-brand-green-dark mb-4">
        Tambah Produk Baru
    </h1>

    @if ($errors->any())
        <div class="mb-4 p-4 rounded-lg bg-red-50 text-red-700 text-sm">
            <ul class="list-disc pl-5 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Kategori</label>
                <input type="text" name="category_id" value="{{ old('category_id') }}"
                       class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500"
                       placeholder="ID kategori (sementara)">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Harga (Rp)</label>
                <input type="number" name="price" value="{{ old('price') }}"
                       class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Stok</label>
                <input type="number" name="stock" value="{{ old('stock') }}"
                       class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Kondisi</label>
                <select name="condition"
                        class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="new"  {{ old('condition') == 'new'  ? 'selected' : '' }}>Baru</option>
                    <option value="used" {{ old('condition') == 'used' ? 'selected' : '' }}>Bekas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Berat (gram)</label>
                <input type="number" name="weight" value="{{ old('weight', 0) }}"
                       class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
            <textarea name="description" rows="4"
                      class="mt-1 w-full border-gray-300 rounded-lg shadow-sm focus:ring-green-500 focus:border-green-500">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Foto Utama (wajib)</label>
                <input type="file" name="main_image"
                       class="mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Foto Tambahan (opsional, boleh lebih dari 1)</label>
                <input type="file" name="extra_images[]" multiple
                       class="mt-1 w-full text-sm text-gray-700 border border-gray-300 rounded-lg cursor-pointer bg-gray-50">
            </div>
        </div>

        <div class="pt-4 flex justify-end space-x-3">
            <a href="{{ route('seller.products.index') }}"
               class="px-4 py-2 rounded-full border border-gray-300 text-gray-700 text-sm">
               Batal
            </a>

            <button type="submit"
                    class="px-6 py-2 rounded-full bg-brand-green-dark text-white text-sm font-medium hover:opacity-90">
                Simpan Produk
            </button>
        </div>
    </form>
</div>
@endsection
