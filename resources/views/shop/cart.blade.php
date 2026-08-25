<x-app-layout>
    <x-slot name="title">Shopping Cart & Checkout</x-slot>

    <div class="space-y-6">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                Shopping Cart & Checkout
            </h1>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
                Review your selected items and specify your delivery destination
            </p>
        </div>

        @if(request('payment') === 'cancelled')
            <div class="p-4 rounded-xl bg-amber-50 border border-amber-200 dark:bg-amber-950/40 dark:border-amber-800/60 flex items-start space-x-3 text-amber-900 dark:text-amber-300 shadow-theme-xs">
                <div class="p-1.5 rounded-lg bg-amber-100 dark:bg-amber-900/50 text-amber-700 dark:text-amber-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-amber-950 dark:text-amber-200">Checkout Cancelled</h3>
                    <p class="text-xs text-amber-800 dark:text-amber-300 mt-0.5">
                        Your checkout session on Stripe was cancelled. You can review your details and proceed with checkout when ready.
                    </p>
                </div>
            </div>
        @endif

        @if($cartItems->isEmpty())
            <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 p-12 text-center shadow-theme-xs max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-brand-50 dark:bg-brand-500/10 text-brand-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Your cart is empty</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 max-w-md mx-auto">
                    You haven't added any products to your cart yet. Explore our marketplace catalog to discover items!
                </p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm rounded-lg shadow-theme-xs transition">
                        Start Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-start">
                
                <!-- Left: Cart Items List (col-span-7) -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 shadow-theme-xs overflow-hidden">
                        <div class="p-5 border-b border-gray-100 dark:border-gray-800 flex items-center justify-between">
                            <h2 class="font-bold text-gray-800 dark:text-white text-base">Cart Items ({{ $cartItems->count() }})</h2>
                            <a href="{{ route('home') }}" class="text-xs font-semibold text-brand-500 hover:text-brand-600 transition">
                                + Add more products
                            </a>
                        </div>

                        <div class="divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($cartItems as $item)
                                <div class="p-4 sm:p-5 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-3.5">
                                        <!-- Thumbnail -->
                                        <div class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0 border border-gray-200/60 dark:border-gray-700/60 flex items-center justify-center">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            @endif
                                        </div>

                                        <!-- Item Details -->
                                        <div>
                                            <h3 class="font-bold text-gray-800 dark:text-white text-sm hover:text-brand-500 transition">
                                                @if($item->product)
                                                    <a href="{{ route('product.show', $item->product) }}">
                                                        {{ $item->product->title }}
                                                    </a>
                                                @else
                                                    Product Unavailable
                                                @endif
                                            </h3>

                                            @if($item->option)
                                                <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-200/60 dark:border-brand-800/60">
                                                    {{ $item->option->name }}: {{ $item->option->value }}
                                                </div>
                                            @endif

                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-1">
                                                Sold by: <span class="text-gray-600 dark:text-gray-300 font-medium">{{ $item->product->seller->name ?? 'Verified Seller' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price & Remove -->
                                    <div class="flex items-center justify-between sm:justify-end space-x-6 w-full sm:w-auto mt-2 sm:mt-0">
                                        <div class="text-right">
                                            <div class="text-xs text-gray-400">Qty: <strong class="text-gray-700 dark:text-gray-300">{{ $item->quantity }}</strong> &times; Rs. {{ number_format($item->effective_price, 2) }}</div>
                                            <div class="text-base font-black text-brand-500">Rs. {{ number_format($item->effective_price * $item->quantity, 2) }}</div>
                                        </div>

                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 text-gray-400 hover:text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/30 rounded-lg transition" title="Remove item">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Checkout & Destination Form (col-span-5) -->
                <div class="lg:col-span-5">
                    <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 p-6 shadow-theme-xs space-y-6">
                        <div class="border-b border-gray-100 dark:border-gray-800 pb-4">
                            <h2 class="font-bold text-gray-800 dark:text-white text-base">Checkout & Delivery Details</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Dispatched directly to each merchant's dashboard</p>
                        </div>

                        <form action="{{ route('checkout') }}" method="POST" class="space-y-4">
                            @csrf

                            <!-- Delivery Address -->
                            <div>
                                <label for="delivery_address" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Delivery Address <span class="text-error-500">*</span>
                                </label>
                                <textarea name="delivery_address" id="delivery_address" rows="3" required
                                          placeholder="Full street address, house/flat #, city, postal code..."
                                          class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">{{ old('delivery_address') }}</textarea>
                            </div>

                            <!-- Contact Details -->
                            <div>
                                <label for="contact_details" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                                    Contact Details / Phone <span class="text-error-500">*</span>
                                </label>
                                <input type="text" name="contact_details" id="contact_details" required value="{{ old('contact_details') }}"
                                       placeholder="e.g. +92 300 1234567 (WhatsApp / Mobile)"
                                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30">
                            </div>

                            <!-- Price Breakdown Summary -->
                            <div class="rounded-xl bg-gray-50 dark:bg-white/[0.02] p-4 border border-gray-200 dark:border-gray-800 space-y-2.5 pt-4 mt-6">
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Subtotal ({{ $cartItems->sum('quantity') }} items)</span>
                                    <span class="font-semibold text-gray-800 dark:text-white">Rs. {{ number_format($total, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Shipping Fulfillment</span>
                                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Calculated by Merchant</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-2.5 flex justify-between items-baseline">
                                    <span class="font-bold text-gray-800 dark:text-white text-sm">Total Amount</span>
                                    <span class="text-xl font-black text-brand-500">Rs. {{ number_format($total, 2) }}</span>
                                </div>
                            </div>

                            <!-- Checkout Action Button -->
                            <button type="submit" class="w-full flex items-center justify-center gap-2 h-11 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                <span>Proceed to Stripe Checkout</span>
                            </button>
                        </form>

                        <div class="text-[11px] text-gray-400 dark:text-gray-500 text-center flex items-center justify-center space-x-1.5">
                            <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            <span>Encrypted & secure checkout via Stripe</span>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>