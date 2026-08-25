<div class="relative" x-data="{
    dropdownOpen: false,
    toggleDropdown() {
        this.dropdownOpen = !this.dropdownOpen;
    },
    closeDropdown() {
        this.dropdownOpen = false;
    }
}" @click.away="closeDropdown()">

    @auth
        <!-- User Button -->
        <button
            class="flex items-center text-gray-700 dark:text-gray-400 hover:opacity-90 transition"
            @click.prevent="toggleDropdown()"
            type="button"
        >
            <span class="mr-2.5 flex items-center justify-center rounded-full h-10 w-10 bg-brand-50 text-brand-600 dark:bg-brand-500/20 dark:text-brand-400 font-bold text-sm border border-brand-200 dark:border-brand-800">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </span>

            <div class="hidden sm:block text-left mr-1">
                <span class="block font-medium text-theme-sm text-gray-800 dark:text-white leading-tight">
                    {{ Auth::user()->name }}
                </span>
                <span class="block text-[11px] font-semibold uppercase tracking-wider
                    @if(Auth::user()->hasRole('admin')) text-purple-600 dark:text-purple-400
                    @elseif(Auth::user()->hasRole('seller')) text-amber-600 dark:text-amber-400
                    @else text-brand-500 dark:text-brand-400 @endif">
                    @if(Auth::user()->hasRole('admin')) Admin
                    @elseif(Auth::user()->hasRole('seller')) Seller
                    @else Buyer @endif
                </span>
            </div>

            <!-- Chevron Icon -->
            <svg
                class="w-4 h-4 text-gray-400 transition-transform duration-200"
                :class="{ 'rotate-180': dropdownOpen }"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>

        <!-- Dropdown Start -->
        <div
            x-show="dropdownOpen"
            x-transition:enter="transition ease-out duration-100"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            class="absolute right-0 mt-2 flex w-[260px] flex-col rounded-2xl border border-gray-200 bg-white p-3 shadow-theme-lg dark:border-gray-800 dark:bg-gray-dark z-50"
            style="display: none;"
        >
            <!-- User Info -->
            <div class="p-2 border-b border-gray-100 dark:border-gray-800">
                <span class="block font-semibold text-gray-800 text-theme-sm dark:text-white">{{ Auth::user()->name }}</span>
                <span class="mt-0.5 block text-theme-xs text-gray-500 dark:text-gray-400 truncate">{{ Auth::user()->email }}</span>
            </div>

            <!-- Menu Items -->
            <ul class="flex flex-col gap-1 pt-2 pb-2 border-b border-gray-100 dark:border-gray-800">
                @if(Auth::user()->hasRole('admin'))
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-2.5 px-3 py-2 font-medium text-gray-700 rounded-lg text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Admin Dashboard
                        </a>
                    </li>
                @elseif(Auth::user()->hasRole('seller'))
                    <li>
                        <a href="{{ route('seller.dashboard') }}"
                            class="flex items-center gap-2.5 px-3 py-2 font-medium text-gray-700 rounded-lg text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                            Seller Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('seller.orders.index') }}"
                            class="flex items-center gap-2.5 px-3 py-2 font-medium text-gray-700 rounded-lg text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            Orders & Delivery Inbox
                        </a>
                    </li>
                @else
                    <li>
                        <a href="{{ route('orders.my') }}"
                            class="flex items-center gap-2.5 px-3 py-2 font-medium text-gray-700 rounded-lg text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                            My Purchase Orders
                        </a>
                    </li>
                @endif

                <li>
                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center gap-2.5 px-3 py-2 font-medium text-gray-700 rounded-lg text-theme-sm hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-white/5">
                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        Profile Settings
                    </a>
                </li>
            </ul>

            <!-- Sign Out -->
            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button
                    type="submit"
                    class="flex items-center w-full gap-2.5 px-3 py-2 font-medium text-rose-600 rounded-lg text-theme-sm hover:bg-rose-50 dark:text-rose-400 dark:hover:bg-rose-950/30 transition"
                    @click="closeDropdown()"
                >
                    <svg class="w-4 h-4 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                    </svg>
                    Sign out
                </button>
            </form>
        </div>
    @else
        <!-- Guest Actions -->
        <div class="flex items-center space-x-2 sm:space-x-3">
            <a href="{{ route('login') }}"
                class="px-3.5 py-2 text-sm font-semibold text-gray-700 hover:text-brand-500 dark:text-gray-300 dark:hover:text-white transition rounded-lg hover:bg-gray-100 dark:hover:bg-gray-800">
                Log in
            </a>
            <a href="{{ route('register') }}"
                class="px-4 py-2 text-sm font-semibold text-white bg-brand-500 hover:bg-brand-600 rounded-lg shadow-theme-xs transition">
                Register
            </a>
        </div>
    @endauth
</div>
