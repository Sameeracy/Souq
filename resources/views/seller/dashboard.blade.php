<x-app-layout>
    <x-slot name="title">Seller Dashboard</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        
        <!-- Header Banner -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Seller Portal</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Seller Management Hub</h1>
                <p class="text-sm text-slate-500 mt-0.5">Manage your marketplace inventory and view buyer delivery requests</p>
            </div>

            <div class="flex items-center space-x-3">
                <a href="{{ route('seller.orders.index') }}" class="inline-flex items-center px-4 py-2.5 bg-white border border-slate-300 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-xl shadow-sm transition">
                    <svg class="w-4 h-4 mr-2 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                    Full Order Inbox
                </a>
                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-200 transition">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add New Product
                </a>
            </div>
        </div>

        <!-- Metrics Overview Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Products</span>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $totalProducts }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Active on marketplace</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Items Sold</span>
                    <h3 class="text-3xl font-black text-slate-900 mt-1">{{ $totalSold }}</h3>
                    <span class="text-xs text-emerald-600 font-semibold mt-1 block">Units fulfilled</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
            </div>

            <div class="bg-white rounded-2xl border border-slate-200/80 p-6 shadow-sm flex items-center justify-between">
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-slate-400">Total Earnings</span>
                    <h3 class="text-3xl font-black text-indigo-600 mt-1">Rs. {{ number_format($totalRevenue, 2) }}</h3>
                    <span class="text-xs text-slate-500 mt-1 block">Gross sales volume</span>
                </div>
                <div class="w-12 h-12 rounded-xl bg-violet-50 text-violet-600 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- 2-Column Main Workspace -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Column: My Listed Products (col-span-7) -->
            <div class="lg:col-span-7 space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-5 border-b border-slate-100 flex items-center justify-between">
                        <div>
                            <h2 class="font-bold text-slate-900 text-lg">My Listed Products</h2>
                            <p class="text-xs text-slate-500">Products currently visible to shoppers</p>
                        </div>
                        <a href="{{ route('seller.products.create') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700 underline">
                            + Add New
                        </a>
                    </div>

                    @if($products->isEmpty())
                        <div class="p-10 text-center">
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-3">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                            </div>
                            <h3 class="font-bold text-slate-800 text-base">No products listed yet</h3>
                            <p class="text-xs text-slate-500 mt-1 max-w-sm mx-auto">Start by adding your first product with optional variants (sizes, colors) and pricing.</p>
                            <div class="mt-4">
                                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white font-bold text-xs rounded-xl hover:bg-indigo-700 transition">
                                    Create First Product
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100">
                            @foreach($products as $product)
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-slate-50/60 transition">
                                    <div class="flex items-center space-x-3.5">
                                        <!-- Thumbnail -->
                                        <div class="w-14 h-14 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 flex items-center justify-center">
                                            @if($product->image_path)
                                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            @endif
                                        </div>

                                        <div>
                                            <h3 class="font-bold text-slate-900 text-sm">
                                                <a href="{{ route('product.show', $product) }}" class="hover:text-indigo-600 transition">
                                                    {{ $product->title }}
                                                </a>
                                            </h3>
                                            <div class="flex items-center space-x-2 mt-1">
                                                <span class="font-black text-indigo-600 text-sm">Rs. {{ number_format($product->price, 2) }}</span>
                                                <span class="text-slate-300">•</span>
                                                <span class="text-xs text-slate-500 font-medium">
                                                    {{ $product->options->count() }} {{ \Illuminate\Support\Str::plural('variant', $product->options->count()) }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Actions -->
                                    <div class="flex items-center space-x-2 sm:self-center">
                                        <a href="{{ route('product.show', $product) }}" class="px-2.5 py-1.5 text-xs font-semibold text-slate-600 bg-slate-100 hover:bg-slate-200 rounded-lg transition" title="Preview in Store">
                                            View
                                        </a>

                                        <a href="{{ route('seller.products.edit', $product) }}" class="px-2.5 py-1.5 text-xs font-semibold text-indigo-600 bg-indigo-50 hover:bg-indigo-100 rounded-lg transition">
                                            Edit
                                        </a>

                                        <form action="{{ route('seller.products.destroy', $product) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this product?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="px-2.5 py-1.5 text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 rounded-lg transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            <!-- Right Column: Buyer Contact & Delivery Messages Side Box (col-span-5) -->
            <div class="lg:col-span-5 space-y-4">
                <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                    <div class="p-5 bg-gradient-to-r from-indigo-900 to-slate-900 text-white flex items-center justify-between">
                        <div class="flex items-center space-x-2.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-500/30 flex items-center justify-center text-indigo-300">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <div>
                                <h2 class="font-bold text-sm leading-tight">Buyer Delivery & Contact Box</h2>
                                <p class="text-[11px] text-indigo-200">Active dispatch details (auto-cleared once received)</p>
                            </div>
                        </div>
                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-indigo-500/40 text-indigo-100 border border-indigo-400/30">
                            Active Feed
                        </span>
                    </div>

                    @if($recentOrders->isEmpty())
                        <div class="p-8 text-center text-slate-500">
                            <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center mx-auto mb-2">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            </div>
                            <p class="font-bold text-slate-700 text-sm">All deliveries completed!</p>
                            <p class="text-xs text-slate-400 mt-1 max-w-xs mx-auto">
                                There are no pending shipments. When a buyer places an order, their delivery info appears here until they mark it as received.
                            </p>
                        </div>
                    @else
                        <div class="divide-y divide-slate-100 max-h-[600px] overflow-y-auto">
                            @foreach($recentOrders as $item)
                                <div class="p-4 sm:p-5 hover:bg-slate-50 transition space-y-3">
                                    <!-- Order Header & Buyer info -->
                                    <div class="flex items-start justify-between">
                                        <div class="flex items-center space-x-2.5">
                                            <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold text-xs">
                                                {{ strtoupper(substr($item->order->user->name ?? 'B', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-bold text-xs text-slate-900">{{ $item->order->user->name ?? 'Customer' }}</div>
                                                <div class="text-[10px] text-slate-400">{{ $item->created_at->diffForHumans() }}</div>
                                            </div>
                                        </div>
                                        <span class="text-xs font-black text-slate-800">Rs. {{ number_format($item->price * $item->quantity, 2) }}</span>
                                    </div>

                                    <!-- Ordered Product & Selected Variant -->
                                    <div class="bg-indigo-50/70 rounded-xl p-2.5 border border-indigo-100/80 text-xs">
                                        <div class="font-semibold text-indigo-950 truncate">
                                            {{ $item->product->title ?? 'Deleted Product' }}
                                        </div>
                                        <div class="flex items-center justify-between text-[11px] text-indigo-700 mt-1">
                                            <span>Qty: <strong>{{ $item->quantity }}</strong></span>
                                            @if($item->option)
                                                <span class="bg-white/80 px-1.5 py-0.5 rounded border border-indigo-200/50">
                                                    {{ $item->option->name }}: {{ $item->option->value }}
                                                </span>
                                            @else
                                                <span class="text-slate-400 italic">Standard</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Delivery Details & Contact Note (Not a chat, only dispatch information) -->
                                    <div class="bg-slate-50 rounded-xl p-3 border border-slate-200/70 text-xs space-y-1.5">
                                        <div>
                                            <span class="text-slate-400 font-semibold text-[10px] uppercase block tracking-wider">Contact Info:</span>
                                            <span class="font-medium text-slate-900 select-all">{{ $item->order->contact_details }}</span>
                                        </div>
                                        <div>
                                            <span class="text-slate-400 font-semibold text-[10px] uppercase block tracking-wider">Delivery Destination:</span>
                                            <span class="text-slate-800 leading-snug block select-all">{{ $item->order->delivery_address }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <div class="p-3 bg-slate-50 border-t border-slate-100 text-center">
                            <a href="{{ route('seller.orders.index') }}" class="text-xs font-bold text-indigo-600 hover:text-indigo-700">
                                View All {{ $sellerOrderItems->count() }} Orders in Dedicated Inbox &rarr;
                            </a>
                        </div>
                    @endif
                </div>
            </div>

        </div>

    </div>
</x-app-layout>