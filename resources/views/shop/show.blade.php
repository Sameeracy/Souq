<x-app-layout>
    <x-slot name="title">{{ $product->title }}</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="flex items-center space-x-2 text-sm text-slate-500 mb-6">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Storefront</a>
            <svg class="w-4 h-4 text-slate-300" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path></svg>
            <span class="text-slate-800 font-semibold truncate">{{ $product->title }}</span>
        </nav>

        <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden p-6 sm:p-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-14 items-start">
                
                <!-- Product Image / Showcase -->
                <div class="relative bg-slate-100 rounded-2xl overflow-hidden aspect-square flex items-center justify-center border border-slate-200/60 shadow-inner">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="flex flex-col items-center justify-center text-slate-400 p-8 text-center">
                            <div class="w-20 h-20 rounded-2xl bg-white shadow-sm flex items-center justify-center mb-3 text-indigo-400">
                                <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="text-sm font-semibold text-slate-600">Souq Authentic Product</span>
                            <span class="text-xs text-slate-400 mt-1">High quality crafted item</span>
                        </div>
                    @endif

                    <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1.5 rounded-full text-xs font-semibold text-slate-700 shadow-sm border border-slate-200/60 flex items-center space-x-1.5">
                        <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                        <span>Sold by <strong class="text-slate-900">{{ $product->seller->name ?? 'Verified Seller' }}</strong></span>
                    </div>
                </div>

                <!-- Product Details & Add to Cart -->
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
                    <div class="border-b border-slate-100 pb-6">
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight leading-tight">
                            {{ $product->title }}
                        </h1>

                        <div class="mt-4 flex items-baseline space-x-3">
                            <span class="text-3xl sm:text-4xl font-black text-indigo-600">
                                Rs. <span x-text="parseFloat(currentPrice).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                            </span>
                            <span class="text-xs font-semibold text-emerald-600 bg-emerald-50 border border-emerald-200 px-2 py-0.5 rounded-md">
                                In Stock
                            </span>
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="py-6 border-b border-slate-100">
                        <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-2">Description</h3>
                        <div class="text-slate-600 text-sm sm:text-base leading-relaxed whitespace-pre-line">
                            {{ $product->description }}
                        </div>
                    </div>

                    <!-- Add to Cart Form -->
                    <form action="{{ route('cart.add', $product) }}" method="POST" class="pt-6 space-y-6">
                        @csrf

                        <!-- Variant / Option Selector -->
                        @if($product->options->count() > 0)
                            <div>
                                <label for="product_option_id" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">
                                    Choose Variant / Option <span class="text-rose-500">*</span>
                                </label>
                                <div class="relative">
                                    <select name="product_option_id" id="product_option_id" required 
                                            @change="updatePrice($event.target.value)"
                                            class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 pr-8 transition">
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
                                <p class="text-[11px] text-slate-500 mt-1.5">Selecting a variant will automatically update the product price if customized.</p>
                            </div>
                        @endif

                        <!-- Quantity Selector -->
                        <div>
                            <label for="quantity" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-2">Quantity</label>
                            <div class="flex items-center space-x-3 max-w-[160px]">
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="50" 
                                       class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3 text-center font-bold">
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="pt-2 flex flex-col sm:flex-row gap-3">
                            <button type="submit" class="flex-1 inline-flex items-center justify-center px-6 py-3.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-base rounded-xl shadow-lg shadow-indigo-600/30 transition focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Add to Cart
                            </button>

                            <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-5 py-3.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition">
                                Continue Shopping
                            </a>
                        </div>
                    </form>

                    <!-- Trust Banner -->
                    <div class="mt-8 p-4 rounded-2xl bg-indigo-50/50 border border-indigo-100 flex items-start space-x-3">
                        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="text-xs text-slate-600">
                            <p class="font-bold text-slate-800">Direct Seller Fulfillment</p>
                            <p class="mt-0.5">Upon checkout, your delivery address and contact details are routed directly to <strong class="text-slate-800">{{ $product->seller->name }}</strong> for fulfillment.</p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>