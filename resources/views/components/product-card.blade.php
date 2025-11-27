@props(['product'])

<div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 transform hover:-translate-y-1 flex flex-col h-full">
    
    <div class="relative h-48 w-full bg-gray-100 overflow-hidden">
        @if($product->image)
            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-full h-full object-cover transition duration-700 group-hover:scale-110">
        @else
            <img src="https://placehold.co/400x400/e2e8f0/a5c0a8?text=No+Image" class="w-full h-full object-cover opacity-50">
        @endif
        
        <span class="absolute top-3 left-3 bg-white/90 backdrop-blur-md text-gray-800 text-xs font-bold px-2.5 py-1 rounded-lg shadow-sm">
            {{ $product->category }}
        </span>
    </div>

    <div class="p-5 flex flex-col flex-grow">
        <div class="flex items-center text-xs text-gray-500 mb-2">
            <svg class="w-3.5 h-3.5 mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span class="truncate">{{ $product->seller->storeName ?? 'Toko Tidak Diketahui' }}</span>
        </div>

        <h3 class="text-lg font-bold text-gray-800 line-clamp-2 leading-snug mb-2 group-hover:text-brand-green-dark transition">
            {{ $product->name }}
        </h3>

        <div class="mt-auto pt-3 border-t border-gray-50">
            <span class="text-lg font-extrabold text-brand-green-dark block w-full">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </span>
        </div>
    </div>
</div>