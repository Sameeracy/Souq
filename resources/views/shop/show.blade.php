<x-app-layout>
    <x-slot name="title">{{ $product->title }}</x-slot>

    <!-- Breadcrumb -->
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
            <a href="{{ route('home') }}" class="hover:text-brand-500 transition">Storefront</a>
            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-gray-800 dark:text-white font-medium truncate max-w-xs">{{ $product->title }}</span>
        </nav>

        <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-brand-500 hover:text-brand-600 transition">
            &larr; Back to Catalog
        </a>
    </div>

    <!-- Product Showcase Container -->
    <div class="rounded-2xl border border-gray-200 bg-white p-6 sm:p-8 dark:border-gray-800 dark:bg-gray-dark shadow-theme-md">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
            
            <!-- Left: Product Image Showcase -->
            <div class="relative bg-gray-100 dark:bg-gray-800/80 rounded-2xl overflow-hidden aspect-square flex items-center justify-center border border-gray-200 dark:border-gray-700 shadow-theme-xs">
                @if($product->image_path)
                    <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                @else
                    <div class="flex flex-col items-center justify-center text-gray-400 dark:text-gray-500 p-8 text-center">
                        <div class="w-20 h-20 rounded-2xl bg-white dark:bg-gray-900 shadow-theme-xs flex items-center justify-center mb-3 text-brand-500">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                        <span class="text-sm font-semibold text-gray-700 dark:text-gray-300">Souq Authentic Product</span>
                        <span class="text-xs text-gray-400 mt-1">Verified handcrafted item</span>
                    </div>
                @endif

                <div class="absolute top-4 left-4 bg-white/95 dark:bg-gray-900/95 backdrop-blur-xs px-3 py-1.5 rounded-lg text-xs font-medium text-gray-700 dark:text-gray-300 shadow-theme-xs border border-gray-200 dark:border-gray-700 flex items-center space-x-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    <span>Sold by <strong class="text-gray-900 dark:text-white">{{ $product->seller->name ?? 'Verified Seller' }}</strong></span>
                </div>
            </div>

            <!-- Right: Product Details & Dynamic Variant Add-to-Cart -->
            <div class="flex flex-col" x-data="{
                basePrice: {{ (float)$product->price }},
                currentPrice: {{ (float)$product->price }},
                optionsMap: {{ Js::from($product->options->mapWithKeys(fn($o) => [$o->id => $o->price ? (float)$o->price : null])) }},
                updatePrice(optionId) {
                    if (optionId && this.optionsMap[optionId]) {
                        this.currentPrice = this.optionsMap[optionId];
                    } else {
                        this.currentPrice = this.basePrice;
                    }
                }
            }">
                <!-- Title & Price Header -->
                <div class="border-b border-gray-100 dark:border-gray-800 pb-6">
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight leading-tight">
                        {{ $product->title }}
                    </h1>

                    <div class="mt-4 flex items-baseline space-x-4">
                        <span class="text-3xl sm:text-4xl font-black text-brand-500">
                            Rs. <span x-text="parseFloat(currentPrice).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                        </span>
                        <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60 px-2.5 py-1 rounded-md">
                            In Stock
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="py-6 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 mb-2">Description</h3>
                    <div class="text-gray-600 dark:text-gray-300 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                        {{ $product->description }}
                    </div>
                </div>

                <!-- Add to Cart Form -->
                <form action="{{ route('cart.add', $product) }}" method="POST" class="pt-6 space-y-6">
                    @csrf

                    <!-- Variant / Option Selector -->
                    @if($product->options->count() > 0)
                        <div>
                            <label for="product_option_id" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Select Variant / Option <span class="text-error-500">*</span>
                            </label>
                            <div class="relative">
                                <select name="product_option_id" id="product_option_id" required 
                                        @change="updatePrice($event.target.value)"
                                        class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                                    <option value="" disabled selected>-- Select an option (e.g. Size, Color) --</option>
                                    @foreach($product->options as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->name }}: {{ $option->value }}
                                            @if($option->price)
                                                (Rs. {{ number_format($option->price, 2) }})
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <p class="text-xs text-gray-400 dark:text-gray-500 mt-1.5">Selecting a variant will automatically adjust the product pricing.</p>
                        </div>
                    @endif

                    <!-- Quantity & Submit Button Row -->
                    <div class="flex items-center gap-4">
                        <div class="w-28 shrink-0">
                            <label for="quantity" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                Quantity
                            </label>
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="99" required
                                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 font-semibold focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90">
                        </div>

                        <div class="flex-1 pt-6">
                            <button type="submit" class="w-full flex items-center justify-center gap-2 h-11 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Add to Shopping Cart</span>
                            </button>
                        </div>
                    </div>
                </form>

                <!-- Information Highlight Card -->
                <div class="mt-8 rounded-xl bg-gray-50 dark:bg-white/[0.02] border border-gray-200 dark:border-gray-800 p-4 space-y-2 text-xs text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        <span>Direct delivery dispatch note to merchant upon checkout.</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <svg class="w-4 h-4 text-brand-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>Standard currency in PKR (Rs.) with optional Stripe checkout.</span>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>