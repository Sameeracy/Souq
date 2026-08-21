<x-app-layout>
    <x-slot name="title">Admin Control Panel</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-10">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-purple-100 text-purple-800 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-purple-600"></span>
                    <span>Admin Master Control</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Souq Platform Administration</h1>
                <p class="text-sm text-slate-500 mt-0.5">Platform overview, seller sales analytics, product moderation, and user management</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl shadow-sm transition">
                <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                View Public Storefront
            </a>
        </div>

        <!-- KPI Metrics -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Platform Sales</span>
                <h3 class="text-2xl font-black text-indigo-600 mt-1">Rs. {{ number_format($totalPlatformRevenue, 2) }}</h3>
                <span class="text-[11px] text-slate-500 mt-1 block">Gross merchandise value</span>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Active Products</span>
                <h3 class="text-2xl font-black text-slate-900 mt-1">{{ $totalProductsCount }}</h3>
                <span class="text-[11px] text-slate-500 mt-1 block">Across all sellers</span>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Total Orders</span>
                <h3 class="text-2xl font-black text-emerald-600 mt-1">{{ $totalOrdersCount }}</h3>
                <span class="text-[11px] text-slate-500 mt-1 block">Placed by customers</span>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Registered Sellers</span>
                <h3 class="text-2xl font-black text-amber-600 mt-1">{{ $totalSellersCount }}</h3>
                <span class="text-[11px] text-slate-500 mt-1 block">Active merchant accounts</span>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 p-5 shadow-sm">
                <span class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Customer Accounts</span>
                <h3 class="text-2xl font-black text-blue-600 mt-1">{{ $totalBuyersCount }}</h3>
                <span class="text-[11px] text-slate-500 mt-1 block">Registered buyers</span>
            </div>
        </div>

        <!-- Section 1: Total Sales by Seller Breakdown -->
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-lg">Seller Sales Performance Analytics</h2>
                    <p class="text-xs text-slate-500">Summary of total orders and sales volume per seller</p>
                </div>
                <span class="px-2.5 py-1 text-xs font-bold rounded-lg bg-indigo-50 text-indigo-700">
                    {{ $sellerSales->count() }} Active Merchants
                </span>
            </div>

            @if($sellerSales->isEmpty())
                <div class="p-8 text-center text-slate-500 text-sm">
                    No sales recorded yet on the platform.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3.5">Seller Name</th>
                                <th class="px-6 py-3.5">Email</th>
                                <th class="px-6 py-3.5">Orders Processed</th>
                                <th class="px-6 py-3.5">Units Sold</th>
                                <th class="px-6 py-3.5 text-right">Total Revenue</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($sellerSales as $sale)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4 font-bold text-slate-900">
                                        {{ $sale->seller->name ?? 'Deleted Seller (ID #' . $sale->seller_id . ')' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-600 text-xs">
                                        {{ $sale->seller->email ?? 'N/A' }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-700 font-semibold">
                                        {{ $sale->total_orders }}
                                    </td>
                                    <td class="px-6 py-4 text-slate-700">
                                        {{ $sale->total_items_sold }} items
                                    </td>
                                    <td class="px-6 py-4 text-right font-black text-indigo-600">
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
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-lg">Marketplace Products Catalog</h2>
                    <p class="text-xs text-slate-500">Admin can review, edit, or delete any product listed by sellers</p>
                </div>
                <span class="text-xs font-semibold text-slate-500">{{ $products->count() }} Total Products</span>
            </div>

            @if($products->isEmpty())
                <div class="p-8 text-center text-slate-500 text-sm">
                    No products listed on the platform yet.
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                            <tr>
                                <th class="px-6 py-3.5">Product</th>
                                <th class="px-6 py-3.5">Seller</th>
                                <th class="px-6 py-3.5">Price</th>
                                <th class="px-6 py-3.5">Variants</th>
                                <th class="px-6 py-3.5">Created</th>
                                <th class="px-6 py-3.5 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($products as $product)
                                <tr class="hover:bg-slate-50/60 transition">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-10 h-10 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-200 flex items-center justify-center">
                                                @if($product->image_path)
                                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <div class="font-bold text-slate-900 max-w-[200px] truncate">
                                                {{ $product->title }}
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-semibold text-slate-700">
                                        {{ $product->seller->name ?? 'Unknown Seller' }}
                                    </td>
                                    <td class="px-6 py-4 font-black text-indigo-600">
                                        Rs. {{ number_format($product->price, 2) }}
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-600">
                                        @if($product->options->count() > 0)
                                            <span class="px-2 py-0.5 rounded bg-indigo-50 text-indigo-700 font-semibold">
                                                {{ $product->options->count() }} Variants
                                            </span>
                                        @else
                                            <span class="text-slate-400">None</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs text-slate-500">
                                        {{ $product->created_at->format('M d, Y') }}
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2 whitespace-nowrap">
                                        <a href="{{ route('product.show', $product) }}" target="_blank" class="px-2.5 py-1 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition">
                                            View
                                        </a>

                                        <a href="{{ route('admin.products.edit', $product) }}" class="px-2.5 py-1 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline" onsubmit="return confirm('Delete this product permanently?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
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
        <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h2 class="font-bold text-slate-900 text-lg">User & Seller Account Directory</h2>
                    <p class="text-xs text-slate-500">Admin can manage users, sellers, and delete accounts (cascading deletes will remove associated products and orders)</p>
                </div>
                <span class="text-xs font-semibold text-slate-500">{{ $users->count() }} Registered Accounts</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="bg-slate-50 text-[11px] uppercase tracking-wider text-slate-400 font-bold border-b border-slate-100">
                        <tr>
                            <th class="px-6 py-3.5">User</th>
                            <th class="px-6 py-3.5">Email</th>
                            <th class="px-6 py-3.5">Assigned Roles</th>
                            <th class="px-6 py-3.5">Joined Date</th>
                            <th class="px-6 py-3.5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($users as $user)
                            <tr class="hover:bg-slate-50/60 transition">
                                <td class="px-6 py-4 font-bold text-slate-900">
                                    <div class="flex items-center space-x-2.5">
                                        <div class="w-7 h-7 rounded-full bg-slate-100 text-slate-700 flex items-center justify-center font-bold text-xs">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-600">
                                    {{ $user->email }}
                                </td>
                                <td class="px-6 py-4">
                                    @foreach($user->roles as $role)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold capitalize mr-1
                                            @if($role->name === 'admin') bg-purple-100 text-purple-800
                                            @elseif($role->name === 'seller') bg-amber-100 text-amber-800
                                            @else bg-blue-100 text-blue-800 @endif">
                                            {{ $role->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="px-6 py-4 text-xs text-slate-500">
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this user ({{ $user->name }})? All their listings and orders will be removed.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-3 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                                Delete Account
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Current Admin</span>
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