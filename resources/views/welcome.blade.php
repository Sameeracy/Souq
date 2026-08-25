<x-app-layout>
    <x-slot name="title">Explore Products</x-slot>

    <!-- Hero Banner -->
    <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-gray-900 via-brand-950 to-gray-900 text-white p-6 sm:p-10 mb-8 border border-gray-800 shadow-theme-md">
        <div class="relative z-10 max-w-2xl">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-500/20 border border-brand-500/30 text-brand-300 text-xs font-semibold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-brand-400"></span>
                <span>Authentic Multi-Vendor Marketplace</span>
            </div>
            <h1 class="text-2xl sm:text-4xl font-extrabold tracking-tight text-white leading-tight">
                Discover Handcrafted & Verified Products on <span class="text-brand-400">Souq</span>
            </h1>
            <p class="mt-2.5 text-sm sm:text-base text-gray-300">
                Connect directly with independent sellers, explore customizable product variants, and enjoy straightforward order delivery.
            </p>

            <!-- Search Form -->
            <form action="{{ route('home') }}" method="GET" class="mt-6 flex items-center max-w-lg gap-2">
                <div class="relative w-full">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search products, descriptions, or sellers..."
                           class="w-full pl-10 pr-4 py-2.5 bg-white/10 border border-white/20 text-white placeholder-gray-400 rounded-lg focus:outline-hidden focus:ring-2 focus:ring-brand-400 focus:bg-white/15 transition text-sm">
                </div>
                <button type="submit" class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg transition shadow-theme-xs shrink-0 cursor-pointer">
                    Search
                </button>
                @if(request('search'))
                    <a href="{{ route('home') }}" class="text-xs text-gray-300 hover:text-white underline shrink-0">Clear</a>
                @endif
            </form>
        </div>

        <!-- Background Graphic Elements -->
        <div class="absolute -right-12 -bottom-12 w-64 h-64 rounded-full bg-brand-500/10 blur-3xl pointer-events-none"></div>
    </div>

    <!-- Product Catalog Section -->
    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-800 dark:text-white/90">
                    @if(request('search'))
                        Search results for "<span class="text-brand-500">{{ request('search') }}</span>"
                    @else
                        Listed Products
                    @endif
                </h2>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Showing {{ $products->total() }} items available from registered sellers
                </p>
            </div>

            @auth
                @if(auth()->user()->hasRole('seller'))
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm rounded-lg shadow-theme-xs transition self-start sm:self-auto">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        List New Product
                    </a>
                @endif
            @endauth
        </div>

        @if($products->isEmpty())
            <div class="text-center py-16 bg-white dark:bg-gray-dark border border-gray-200 dark:border-gray-800 rounded-2xl shadow-theme-xs">
                <div class="w-16 h-16 rounded-full bg-brand-50 dark:bg-brand-500/10 text-brand-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-gray-800 dark:text-white">No products found</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400 max-w-md mx-auto mt-1">
                    @if(request('search'))
                        We couldn't find any products matching your search query. Try searching with other keywords.
                    @else
                        No products are currently listed in the marketplace.
                    @endif
                </p>
                <div class="mt-6">
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-brand-500 bg-brand-50 dark:bg-brand-500/10 rounded-lg hover:bg-brand-100 transition">
                            View All Products
                        </a>
                    @else
                        @auth
                            @if(auth()->user()->hasRole('seller'))
                                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-brand-500 rounded-lg hover:bg-brand-600 transition">
                                    Add the First Product
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        @else
            <!-- Products Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 sm:gap-6">
                @foreach($products as $product)
                    <div class="group rounded-2xl border border-gray-200 bg-white p-4 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs hover:shadow-theme-md transition-all duration-200 flex flex-col justify-between">
                        <div>
                            <!-- Product Image / Thumbnail -->
                            <a href="{{ route('product.show', $product) }}" class="block aspect-square w-full rounded-xl overflow-hidden bg-gray-100 dark:bg-gray-800 relative border border-gray-200/60 dark:border-gray-700/60">
                                @if($product->image_path)
                                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 p-4">
                                        <svg class="w-10 h-10 mb-1 opacity-60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-[11px] font-medium uppercase tracking-wider">Souq Item</span>
                                    </div>
                                @endif

                                @if($product->options->count() > 0)
                                    <span class="absolute top-2.5 right-2.5 bg-white/90 dark:bg-gray-900/90 backdrop-blur-xs px-2 py-0.5 rounded-md text-[10px] font-bold text-brand-600 dark:text-brand-400 border border-gray-200/60 dark:border-gray-700/60 shadow-theme-xs">
                                        {{ $product->options->count() }} Variants
                                    </span>
                                @endif
                            </a>

                            <!-- Product Info -->
                            <div class="mt-3.5 space-y-1.5">
                                <div class="flex items-center space-x-1.5 text-gray-500 dark:text-gray-400 text-xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 shrink-0"></span>
                                    <span class="truncate font-medium">{{ $product->seller->name ?? 'Verified Seller' }}</span>
                                </div>

                                <h3 class="font-bold text-gray-800 dark:text-white/90 text-sm line-clamp-1 group-hover:text-brand-500 transition">
                                    <a href="{{ route('product.show', $product) }}">
                                        {{ $product->title }}
                                    </a>
                                </h3>

                                <p class="text-xs text-gray-500 dark:text-gray-400 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>
                        </div>

                        <!-- Price & Action Button -->
                        <div class="mt-4 pt-3 border-t border-gray-100 dark:border-gray-800 flex items-center justify-between">
                            <div>
                                <span class="text-[10px] font-semibold text-gray-400 uppercase tracking-wider block">Price</span>
                                <span class="font-black text-brand-500 text-base">
                                    Rs. {{ number_format($product->price, 2) }}
                                </span>
                            </div>

                            <a href="{{ route('product.show', $product) }}"
                               class="inline-flex items-center justify-center p-2 rounded-lg bg-gray-100 hover:bg-brand-500 hover:text-white text-gray-700 dark:bg-white/5 dark:text-gray-300 dark:hover:bg-brand-500 dark:hover:text-white transition shadow-theme-xs"
                               title="View Product">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-app-layout>