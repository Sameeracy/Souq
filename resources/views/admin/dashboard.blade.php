<x-app-layout>
    <x-slot name="title">Admin Control Panel</x-slot>

    <div class="space-y-8">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-700 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-800/60 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                    <span>Admin Master Control</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Souq Platform Administration</h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Platform overview, seller sales analytics, product moderation, and user management</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 font-medium text-sm rounded-lg shadow-theme-xs transition self-start sm:self-auto">
                <svg class="w-4 h-4 mr-2 text-brand-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                View Public Storefront
            </a>
        </div>

        <!-- Platform KPI Metrics Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 sm:gap-6">
            <!-- Platform Sales -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Platform Sales</span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-brand-500 mt-1">Rs. {{ number_format($totalPlatformRevenue, 2) }}</h3>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 block">Gross merchandise value</span>
            </div>

            <!-- Active Products -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Active Products</span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-gray-900 dark:text-white mt-1">{{ $totalProductsCount }}</h3>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 block">Across all merchants</span>
            </div>

            <!-- Total Orders -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Total Orders</span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-emerald-600 dark:text-emerald-400 mt-1">{{ $totalOrdersCount }}</h3>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 block">Customer checkouts</span>
            </div>

            <!-- Registered Sellers -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Sellers</span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-amber-600 dark:text-amber-400 mt-1">{{ $totalSellersCount }}</h3>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 block">Active merchant portals</span>
            </div>

            <!-- Customer Accounts -->
            <div class="rounded-2xl border border-gray-200 bg-white p-5 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs">
                <span class="text-[11px] font-semibold uppercase tracking-wider text-gray-400 dark:text-gray-500">Buyers</span>
                <h3 class="text-xl sm:text-2xl font-extrabold text-blue-600 dark:text-blue-400 mt-1">{{ $totalBuyersCount }}</h3>
                <span class="text-[11px] text-gray-500 dark:text-gray-400 mt-1 block">Registered customers</span>
            </div>
        </div>

        <!-- Section 1: Total Sales by Seller Breakdown -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900 dark:text-white text-base sm:text-lg">Seller Sales Performance Analytics</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Summary of total orders and sales volume per seller</p>
                </div>
                <span class="px-2.5 py-1 text-xs font-semibold rounded-lg bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-200 dark:border-brand-800">
                    {{ $sellerSales->count() }} Merchants
                </span>
            </div>

            @if($sellerSales->isEmpty())
                <div class="p-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                    No sales recorded yet on the platform.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-white/[0.02] text-[11px] uppercase tracking-wider text-gray-400 font-semibold border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-3.5 whitespace-nowrap">Seller Name</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Email</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Orders</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Units Sold</th>
                                <th class="px-6 py-3.5 text-right whitespace-nowrap">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($sellerSales as $sale)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition">
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $sale->seller->name ?? 'Deleted Seller (ID #' . $sale->seller_id . ')' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-500 dark:text-gray-400 text-xs whitespace-nowrap">
                                        {{ $sale->seller->email ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 font-medium whitespace-nowrap">
                                        {{ $sale->total_orders }}
                                    </td>
                                    <td class="px-6 py-4 text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                        {{ $sale->total_items_sold }} units
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-brand-500 whitespace-nowrap">
                                        Rs. {{ number_format($sale->total_sales, 2) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Section 2: All Listed Products (Admin can Edit & Delete any product) -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900 dark:text-white text-base sm:text-lg">Marketplace Products Catalog</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Review, moderate, edit, or delete any product listed by sellers</p>
                </div>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ $products->count() }} Total Products</span>
            </div>

            @if($products->isEmpty())
                <div class="p-8 text-center text-gray-500 dark:text-gray-400 text-sm">
                    No products listed on the platform yet.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-gray-50 dark:bg-white/[0.02] text-[11px] uppercase tracking-wider text-gray-400 font-semibold border-b border-gray-100 dark:border-gray-800">
                            <tr>
                                <th class="px-6 py-3.5 whitespace-nowrap">Product</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Seller</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Price</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Variants</th>
                                <th class="px-6 py-3.5 whitespace-nowrap">Listed Date</th>
                                <th class="px-6 py-3.5 text-right whitespace-nowrap">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($products as $product)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-lg bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0 border border-gray-200 dark:border-gray-700 flex items-center justify-center">
                                                @if($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <div class="font-bold text-gray-900 dark:text-white max-w-[220px] truncate">
                                                {{ $product->title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-300 whitespace-nowrap">
                                        {{ $product->seller->name ?? 'Unknown Seller' }}
                                    </td>
                                    <td class="px-6 py-4 font-black text-brand-500 whitespace-nowrap">
                                        Rs. {{ number_format($product->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        @if($product->options->count() > 0)
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 font-semibold border border-brand-200 dark:border-brand-800 whitespace-nowrap">
                                                {{ $product->options->count() }} Variants
                                            </span>
                                        @else
                                            <span class="text-gray-400">None</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('product.show', $product) }}" target="_blank" class="px-2.5 py-1 text-xs font-semibold text-gray-600 bg-gray-100 hover:bg-gray-200 dark:bg-white/5 dark:text-gray-300 dark:hover:bg-white/10 rounded-lg transition">
                                            View
                                        </a>

                                        <a href="{{ route('admin.products.edit', $product) }}" class="px-2.5 py-1 text-xs font-semibold text-brand-600 bg-brand-50 hover:bg-brand-100 dark:bg-brand-500/10 dark:text-brand-400 rounded-lg transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 rounded-lg transition">
                                                Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        <!-- Section 3: Users & Sellers Accounts Management -->
        <div class="rounded-2xl border border-gray-200 bg-white dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-gray-900 dark:text-white text-base sm:text-lg">User & Seller Account Directory</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400">Admin can manage users, sellers, and delete accounts (cascading deletes will remove associated products and orders)</p>
                </div>
                <span class="text-xs font-semibold text-gray-500 dark:text-gray-400">{{ $users->count() }} Registered Accounts</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-gray-50 dark:bg-white/[0.02] text-[11px] uppercase tracking-wider text-gray-400 font-semibold border-b border-gray-100 dark:border-gray-800">
                        <tr>
                            <th class="px-6 py-3.5 whitespace-nowrap">User</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Email</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Assigned Roles</th>
                            <th class="px-6 py-3.5 whitespace-nowrap">Joined Date</th>
                            <th class="px-6 py-3.5 text-right whitespace-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 dark:hover:bg-white/[0.01] transition">
                                <td class="px-6 py-4 font-bold text-gray-900 dark:text-white whitespace-nowrap">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-7 h-7 rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold capitalize mr-1 whitespace-nowrap
                                            @if($role->name === 'admin') bg-purple-50 text-purple-700 dark:bg-purple-950/40 dark:text-purple-400 border border-purple-200 dark:border-purple-800
                                            @elseif($role->name === 'seller') bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800
                                            @else bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-800 @endif">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user ({{ $user->name }})? All their listings and orders will be removed.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 dark:bg-rose-950/40 dark:text-rose-400 rounded-lg transition">
                                                Delete Account
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-gray-400 italic">Current Admin</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>