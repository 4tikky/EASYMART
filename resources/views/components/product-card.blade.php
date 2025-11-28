@props(['product'])

<div class="bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group flex flex-col h-full">
    <div class="relative overflow-hidden aspect-square bg-gray-200">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" 
                 alt="{{ $product->name }}" 
                 class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
        @else
            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-400">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>
        @endif
        <span class="absolute top-2 left-2 bg-white/90 backdrop-blur text-xs font-bold px-2 py-1 rounded text-brand-dark shadow-sm">
            {{ $product->category }}
        </span>
    </div>

    <div class="p-4 flex flex-col flex-grow">
        <p class="text-xs text-gray-500 mb-1 flex items-center gap-1">
            <svg class="w-3 h-3 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            {{ $product->seller->storeName ?? 'Toko' }}
        </p>
        
        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight group-hover:text-brand-green transition">
            {{ $product->name }}
        </h3>
        
        <div class="mt-auto pt-3 border-t border-gray-50">
            <p class="text-lg font-bold text-brand-green">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
        </div>
    </div>
</div>