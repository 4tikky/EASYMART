@props(['product'])

<a href="{{ route('products.show', $product) }}" class="bg-white rounded-xl shadow-sm hover:shadow-xl transition duration-300 border border-gray-100 overflow-hidden group flex flex-col h-full">
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
        <!-- Store Name and Rating -->
        <div class="flex items-center justify-between mb-2">
            <p class="text-xs text-gray-500 flex items-center gap-1">
                <svg class="w-3 h-3 text-brand-green" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ $product->seller->storeName ?? 'Toko' }}
            </p>
            @if($product->reviews_avg_rating)
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-yellow-500 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs font-semibold text-gray-700">{{ number_format($product->reviews_avg_rating, 1) }}</span>
                </div>
            @else
                <div class="flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                    <span class="text-xs text-gray-400">-</span>
                </div>
            @endif
        </div>
        
        <!-- Location -->
        <p class="text-xs text-gray-500 mb-2 flex items-center gap-1">
            <svg class="w-3 h-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
            </svg>
            <span class="line-clamp-1">{{ $product->seller->picCity ?? '-' }}{{ $product->seller->picProvince ? ', ' . $product->seller->picProvince : '' }}</span>
        </p>
        
        <!-- Product Name -->
        <h3 class="font-semibold text-gray-900 mb-2 line-clamp-2 leading-tight group-hover:text-brand-green transition">
            {{ $product->name }}
        </h3>
        
        <!-- Price -->
        <div class="mt-auto pt-3 border-t border-gray-50">
            <p class="text-lg font-bold text-brand-green">
                Rp {{ number_format($product->price, 0, ',', '.') }}
            </p>
        </div>
    </div>
</a>