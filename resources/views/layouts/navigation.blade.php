<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('assets.index') }}" class="font-bold text-xl text-indigo-600">
                        Aset IT MITSERI
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    <x-nav-link :href="route('assets.index')" :active="request()->routeIs('assets.index')">
                        {{ __('Dashboard Aset') }}
                    </x-nav-link>

                    {{-- MENU KHUSUS ADMIN SAJA (STAFF TIDAK BISA LIHAT) --}}
                    @if(auth()->user()->role === 'admin')
                        <x-nav-link :href="route('kategori.index')" :active="request()->routeIs('kategori.*')">
                            {{ __('Kategori') }}
                        </x-nav-link>

                        <x-nav-link :href="route('maintenances.index')" :active="request()->routeIs('maintenances.*')">
                            {{ __('Maintenances') }}
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <!-- Settings Dropdown & Badge Role -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <!-- BADGE ROLE (ADMIN / STAFF) -->
                <div class="me-3">
                    @if(auth()->user()->role === 'admin')
                        <span class="bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">ADMIN</span>
                    @else
                        <span class="bg-blue-500 text-white text-xs font-bold px-2.5 py-1 rounded-full shadow-sm">STAFF</span>
                    @endif
                </div>

                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>
        </div>
    </div>
</nav>