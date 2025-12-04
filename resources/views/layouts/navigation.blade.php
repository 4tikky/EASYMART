<nav x-data="{ open: false }" class="bg-gradient-to-r from-green-600 via-emerald-600 to-teal-600 shadow-xl sticky top-0 z-50 backdrop-blur-lg bg-opacity-95">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20">
            <div class="flex items-center">
                <div class="shrink-0 flex items-center">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                        <div class="p-2 bg-white bg-opacity-20 rounded-xl backdrop-blur-sm group-hover:bg-opacity-30 transition-all duration-300 group-hover:scale-110 transform">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        </div>
                        <span class="text-3xl font-black text-white tracking-tight">
                            Easy<span class="font-light">Mart</span>
                        </span>
                    </a>
                </div>

                <div class="hidden space-x-2 sm:ms-10 sm:flex items-center">
                    <a href="{{ url('/') }}" class="px-5 py-2.5 rounded-xl text-white font-semibold hover:bg-white hover:bg-opacity-20 transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Ke Beranda
                    </a>

                    <a href="{{ route('seller.check') }}" class="px-5 py-2.5 rounded-xl {{ request()->routeIs('seller.*') ? 'bg-white text-green-700 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20' }} font-semibold transition-all duration-300 transform hover:scale-105 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                        {{ Auth::user()->seller ? __('Dashboard Toko') : __('Buka Toko') }}
                    </a>
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:gap-4">
                <x-dropdown align="right" width="56">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center gap-3 px-5 py-2.5 bg-white bg-opacity-20 backdrop-blur-sm hover:bg-opacity-30 rounded-xl text-white font-bold transition-all duration-300 transform hover:scale-105 shadow-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-9 h-9 rounded-full bg-white bg-opacity-30 flex items-center justify-center font-bold text-white">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </div>

                            <svg class="fill-current h-5 w-5 transition-transform duration-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-xl shadow-2xl overflow-hidden">
                            <div class="px-4 py-3 bg-gradient-to-r from-green-600 to-emerald-600">
                                <div class="font-bold text-white text-sm">{{ Auth::user()->name }}</div>
                                <div class="text-green-100 text-xs">{{ Auth::user()->email }}</div>
                            </div>
                            
                            <div class="py-2">
                                <x-dropdown-link :href="route('profile.edit')" class="flex items-center gap-2 text-gray-700 hover:bg-green-100 font-medium">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();"
                                            class="flex items-center gap-2 text-red-600 hover:bg-red-50 font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </div>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-3 rounded-xl text-white hover:bg-white hover:bg-opacity-20 transition-all duration-300">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white bg-opacity-10 backdrop-blur-lg">
        <div class="pt-3 pb-3 space-y-2 px-4">
            <a href="{{ url('/') }}" class="px-4 py-3 rounded-xl text-white font-semibold hover:bg-white hover:bg-opacity-20 transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                {{ __('Ke Beranda') }}
            </a>

            <a href="{{ route('seller.check') }}" class="px-4 py-3 rounded-xl {{ request()->routeIs('seller.*') ? 'bg-white text-green-700 shadow-lg' : 'text-white hover:bg-white hover:bg-opacity-20' }} font-semibold transition-all duration-300 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                {{ Auth::user()->seller ? __('Dashboard Toko') : __('Buka Toko') }}
            </a>
        </div>

        <div class="pt-4 pb-4 border-t border-white border-opacity-20 px-4">
            <div class="px-4 mb-3 flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-white bg-opacity-30 flex items-center justify-center font-black text-white text-lg">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-white">{{ Auth::user()->name }}</div>
                    <div class="text-green-100 text-sm">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="space-y-2">
                <a href="{{ route('profile.edit') }}" class="px-4 py-3 rounded-xl text-white font-semibold hover:bg-white hover:bg-opacity-20 transition-all duration-300 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    {{ __('Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-white font-semibold hover:bg-red-500 hover:bg-opacity-30 transition-all duration-300 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>