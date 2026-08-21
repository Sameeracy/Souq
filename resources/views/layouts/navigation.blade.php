
<nav x-data="{ open: false }" class="bg-white border-b border-slate-200 sticky top-0 z-50 shadow-sm">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center space-x-8">
                <!-- Logo / Brand -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-violet-600 flex items-center justify-center text-white font-black text-xl shadow-md shadow-indigo-200">
                            S
                        </div>
                        <div class="flex flex-col">
                            <span class="font-black text-xl tracking-tight text-slate-900 leading-none">Souq</span>
                            <span class="text-[10px] font-semibold text-indigo-600 tracking-wider uppercase">Marketplace</span>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:-my-px sm:flex sm:space-x-4">
                    <x-nav-link :href="route('home')" :active="request()->routeIs('home') || request()->routeIs('product.show')">
                        {{ __('Explore Products') }}
                    </x-nav-link>

                    @auth
                        @if(Auth::user()->hasRole('seller'))
                            <x-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
                                {{ __('Seller Dashboard') }}
                            </x-nav-link>
                            <x-nav-link :href="route('seller.products.create')" :active="request()->routeIs('seller.products.create')">
                                {{ __('+ Add Product') }}
                            </x-nav-link>
                            <x-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.index')">
                                {{ __('Order Inbox') }}
                            </x-nav-link>
                        @elseif(Auth::user()->hasRole('admin'))
                            <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                                {{ __('Admin Control Panel') }}
                            </x-nav-link>
                        @else
                            <x-nav-link :href="route('orders.my')" :active="request()->routeIs('orders.my')">
                                {{ __('My Orders') }}
                            </x-nav-link>
                        @endif
                    @endauth
                </div>
            </div>

            <!-- Right Nav Actions (Cart & Profile or Auth buttons) -->
            <div class="hidden sm:flex sm:items-center sm:space-x-4">
                @auth
                    <!-- Cart Button (for all users/buyers) -->
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2.5 rounded-xl text-slate-600 hover:text-indigo-600 hover:bg-slate-100 transition focus:outline-none" title="Shopping Cart">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute top-1 right-1 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-indigo-600 rounded-full shadow-sm">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    <!-- User Role Badge & Dropdown -->
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center space-x-2 px-3 py-2 border border-slate-200 text-sm font-medium rounded-xl text-slate-700 bg-white hover:bg-slate-50 focus:outline-none transition">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <div class="text-left">
                                    <div class="font-semibold text-xs leading-none">{{ Auth::user()->name }}</div>
                                    <div class="mt-1">
                                        @if(Auth::user()->hasRole('admin'))
                                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-purple-100 text-purple-800">Admin</span>
                                        @elseif(Auth::user()->hasRole('seller'))
                                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-amber-100 text-amber-800">Seller</span>
                                        @else
                                            <span class="inline-flex items-center px-1.5 py-0.2 rounded text-[10px] font-bold bg-blue-100 text-blue-800">Buyer</span>
                                        @endif
                                    </div>
                                </div>

                                <svg class="w-4 h-4 text-slate-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            <div class="px-4 py-2 border-b border-slate-100">
                                <p class="text-xs text-slate-500">Signed in as</p>
                                <p class="text-sm font-bold text-slate-800 truncate">{{ Auth::user()->email }}</p>
                            </div>

                            @if(Auth::user()->hasRole('admin'))
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('Admin Dashboard') }}
                                </x-dropdown-link>
                            @elseif(Auth::user()->hasRole('seller'))
                                <x-dropdown-link :href="route('seller.dashboard')">
                                    {{ __('Seller Dashboard') }}
                                </x-dropdown-link>
                                <x-dropdown-link :href="route('seller.orders.index')">
                                    {{ __('Orders & Delivery Inbox') }}
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link :href="route('orders.my')">
                                    {{ __('My Orders') }}
                                </x-dropdown-link>
                            @endif

                            <x-dropdown-link :href="route('cart.index')">
                                {{ __('Shopping Cart') }}
                            </x-dropdown-link>

                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile Settings') }}
                            </x-dropdown-link>

                            <div class="border-t border-slate-100"></div>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600 hover:text-rose-700">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="flex items-center space-x-3">
                        <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-700 hover:text-indigo-600 transition px-3 py-2">
                            Log in
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-xl shadow-sm transition">
                            Register
                        </a>
                    </div>
                @endauth
            </div>

            <!-- Hamburger (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                @auth
                    @php
                        $cartCount = \App\Models\Cart::where('user_id', Auth::id())->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-600 mr-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        @if($cartCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-0.5 text-xs font-bold leading-none text-white bg-indigo-600 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>
                @endauth

                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-xl text-slate-400 hover:text-slate-500 hover:bg-slate-100 focus:outline-none">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden bg-white border-b border-slate-200">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('home')" :active="request()->routeIs('home')">
                {{ __('Explore Products') }}
            </x-responsive-nav-link>

            @auth
                @if(Auth::user()->hasRole('seller'))
                    <x-responsive-nav-link :href="route('seller.dashboard')" :active="request()->routeIs('seller.dashboard')">
                        {{ __('Seller Dashboard') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('seller.products.create')" :active="request()->routeIs('seller.products.create')">
                        {{ __('+ Add New Product') }}
                    </x-responsive-nav-link>
                    <x-responsive-nav-link :href="route('seller.orders.index')" :active="request()->routeIs('seller.orders.index')">
                        {{ __('Orders & Delivery Inbox') }}
                    </x-responsive-nav-link>
                @elseif(Auth::user()->hasRole('admin'))
                    <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                        {{ __('Admin Control Panel') }}
                    </x-responsive-nav-link>
                @else
                    <x-responsive-nav-link :href="route('orders.my')" :active="request()->routeIs('orders.my')">
                        {{ __('My Orders') }}
                    </x-responsive-nav-link>
                @endif
                <x-responsive-nav-link :href="route('cart.index')" :active="request()->routeIs('cart.index')">
                    {{ __('Shopping Cart') }}
                </x-responsive-nav-link>
            @endauth
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-slate-200">
            @auth
                <div class="px-4 flex items-center justify-between">
                    <div>
                        <div class="font-semibold text-base text-slate-800">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-slate-500">{{ Auth::user()->email }}</div>
                    </div>
                    @if(Auth::user()->hasRole('admin'))
                        <span class="px-2 py-0.5 text-xs font-bold rounded bg-purple-100 text-purple-800">Admin</span>
                    @elseif(Auth::user()->hasRole('seller'))
                        <span class="px-2 py-0.5 text-xs font-bold rounded bg-amber-100 text-amber-800">Seller</span>
                    @else
                        <span class="px-2 py-0.5 text-xs font-bold rounded bg-blue-100 text-blue-800">Buyer</span>
                    @endif
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile.edit')">
                        {{ __('Profile Settings') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();" class="text-rose-600">
                            {{ __('Log Out') }}
                        </x-responsive-nav-link>
                    </form>
                </div>
            @else
                <div class="p-4 space-y-2">
                    <a href="{{ route('login') }}" class="block w-full text-center px-4 py-2 text-sm font-semibold text-slate-700 bg-slate-100 rounded-xl">
                        Log in
                    </a>
                    <a href="{{ route('register') }}" class="block w-full text-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl">
                        Register
                    </a>
                </div>
            @endauth
        </div>
    </div>
</nav>
