<x-app-layout>
    <!-- Hero Banner -->
    <div class="relative bg-gradient-to-br from-slate-900 via-indigo-950 to-slate-900 text-white overflow-hidden py-14 px-4 sm:px-6 lg:px-8 border-b border-indigo-900/40">
        <div class="absolute inset-0 opacity-10 bg-[radial-gradient(#6366f1_1px,transparent_1px)] [background-size:16px_16px]"></div>
        <div class="relative max-w-7xl mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
            <div class="max-w-2xl text-center md:text-left">
                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight text-white leading-tight">
                 <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 via-violet-300 to-purple-400">Souq</span>
                </h1>
                <p class="mt-3 text-base sm:text-lg text-slate-300">
                    Connect directly with independent sellers, explore customizable product variants, and enjoy straightforward order delivery.
                </p>

                <!-- Search Bar -->
                <form action="{{ route('home') }}" method="GET" class="mt-6 flex items-center max-w-lg mx-auto md:mx-0">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search products, descriptions, or sellers..." 
                               class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 text-white placeholder-slate-400 rounded-xl focus:outline-none focus:ring-2 focus:ring-indigo-400 focus:bg-white/20 transition text-sm">
                    </div>
                    <button type="submit" class="ml-2 px-5 py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-bold text-sm rounded-xl transition shadow-lg shadow-indigo-600/30 shrink-0">
                        Search
                    </button>
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="ml-2 text-xs text-slate-300 hover:text-white underline shrink-0">Clear</a>
                    @endif
                </form>
            </div>

            <!-- Hero Highlights / Badges -->
            <div class="grid grid-cols-2 gap-4 w-full md:w-auto">
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="w-8 h-8 rounded-lg bg-indigo-500/20 text-indigo-300 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-white text-sm">Custom Variants</p>
                    <p class="text-xs text-slate-400">Choose sizes, colors, & finishes</p>
                </div>
                <div class="p-4 rounded-2xl bg-white/5 border border-white/10 backdrop-blur-sm">
                    <div class="w-8 h-8 rounded-lg bg-emerald-500/20 text-emerald-300 flex items-center justify-center mb-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <p class="font-bold text-white text-sm">Direct Fulfillment</p>
                    <p class="text-xs text-slate-400">Seller receives delivery notes directly</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Product Catalog Section -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h2 class="text-2xl font-bold text-slate-900">
                    @if(request('search'))
                        Search results for "<span class="text-indigo-600">{{ request('search') }}</span>"
                    @else
                        Explore Listed Products
                    @endif
                </h2>
                <p class="text-sm text-slate-500 mt-0.5">Showing {{ $products->total() }} items available from registered sellers</p>
            </div>

            @auth
                @if(auth()->user()->hasRole('seller'))
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-sm transition">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        List New Product
                    </a>
                @endif
            @endauth
        </div>

        @if($products->isEmpty())
            <div class="text-center py-16 bg-white border border-slate-200 rounded-2xl shadow-sm">
                <div class="w-16 h-16 rounded-full bg-indigo-50 text-indigo-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h3 class="text-lg font-bold text-slate-900">No products found</h3>
                <p class="text-sm text-slate-500 max-w-md mx-auto mt-1">
                    @if(request('search'))
                        We couldn't find any products matching your search term. Try searching with different keywords.
                    @else
                        No products are currently listed in the marketplace.
                    @endif
                </p>
                <div class="mt-6">
                    @if(request('search'))
                        <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-indigo-600 bg-indigo-50 rounded-xl hover:bg-indigo-100 transition">
                            View All Products
                        </a>
                    @else
                        @auth
                            @if(auth()->user()->hasRole('seller'))
                                <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 text-sm font-semibold text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition">
                                    Add the First Product
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        @else
            <!-- Grid of Products -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach($products as $product)
                    <div class="group bg-white rounded-2xl border border-slate-200/80 shadow-sm hover:shadow-md hover:border-indigo-300 transition-all flex flex-col overflow-hidden">
                        <!-- Product Image Thumbnail -->
                        <div class="relative h-52 bg-slate-100 overflow-hidden flex items-center justify-center">
                            @if($product->image_path)
                                <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                            @else
                                <div class="flex flex-col items-center justify-center text-slate-400 p-4 text-center">
                                    <div class="w-12 h-12 rounded-xl bg-slate-200/70 flex items-center justify-center mb-2 text-slate-400">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                    <span class="text-xs font-medium text-slate-500">Souq Authentic</span>
                                </div>
                            @endif

                            <!-- Seller Badge -->
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-md px-2.5 py-1 rounded-full text-[11px] font-semibold text-slate-700 shadow-sm border border-slate-200/60 flex items-center space-x-1">
                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                <span class="truncate max-w-[120px]">{{ $product->seller->name ?? 'Verified Seller' }}</span>
                            </div>

                            <!-- Variants Tag -->
                            @if($product->options->count() > 0)
                                <div class="absolute bottom-3 right-3 bg-indigo-900/80 backdrop-blur-md text-white text-[10px] font-bold px-2 py-0.5 rounded-md shadow-sm">
                                    {{ $product->options->count() }} Variants
                                </div>
                            @endif
                        </div>

                        <!-- Product Info -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div>
                                <h3 class="font-bold text-slate-900 group-hover:text-indigo-600 transition line-clamp-1 text-base">
                                    <a href="{{ route('product.show', $product) }}">
                                        {{ $product->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-slate-500 mt-1 line-clamp-2 leading-relaxed">
                                    {{ $product->description }}
                                </p>
                            </div>

                            <div class="mt-4 pt-4 border-t border-slate-100 flex items-center justify-between">
                                <div>
                                    <span class="text-xs text-slate-400 block font-medium">Price</span>
                                    <span class="text-lg font-black text-slate-900">Rs. {{ number_format($product->price, 2) }}</span>
                                </div>

                                <a href="{{ route('product.show', $product) }}" class="inline-flex items-center justify-center px-3.5 py-2 text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-600 hover:text-white rounded-xl transition duration-150">
                                    <span>View Options</span>
                                    <svg class="w-3.5 h-3.5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-10">
                {{ $products->links() }}
            </div>
        @endif
    </div>
</x-app-layout>