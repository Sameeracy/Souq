<x-app-layout>
    <x-slot name="title">Your Shopping Cart</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="mb-8">
            <h1 class="text-3xl font-black text-slate-900 tracking-tight">Shopping Cart</h1>
            <p class="text-sm text-slate-500 mt-1">Review your selected items and specify your delivery destination</p>
        </div>

        @if($cartItems->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm max-w-2xl mx-auto">
                <div class="w-20 h-20 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900">Your cart is empty</h2>
                <p class="text-sm text-slate-500 mt-2 max-w-md mx-auto">
                    You haven't added any products to your cart yet. Browse our marketplace catalog to discover authentic items!
                </p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md shadow-indigo-200 transition">
                        Start Shopping
                    </a>
                </div>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
                
                <!-- Left: Cart Items List -->
                <div class="lg:col-span-7 space-y-4">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <div class="p-4 sm:p-6 border-b border-slate-100 flex items-center justify-between">
                            <h2 class="font-bold text-slate-800 text-lg">Cart Items ({{ $cartItems->count() }})</h2>
                            <a href="{{ route('home') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 underline">
                                + Add more products
                            </a>
                        </div>

                        <div class="divide-y divide-slate-100">
                            @foreach($cartItems as $item)
                                <div class="p-4 sm:p-6 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-4">
                                        <!-- Thumbnail -->
                                        <div class="w-16 h-16 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 flex items-center justify-center">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            @endif
                                        </div>

                                        <!-- Item info -->
                                        <div>
                                            <h3 class="font-bold text-slate-900 text-sm hover:text-indigo-600 transition">
                                                @if($item->product)
                                                    <a href="{{ route('product.show', $item->product) }}">
                                                        {{ $item->product->title }}
                                                    </a>
                                                @else
                                                    Product Unavailable
                                                @endif
                                            </h3>

                                            @if($item->option)
                                                <div class="mt-1 inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                                    {{ $item->option->name }}: {{ $item->option->value }}
                                                </div>
                                            @endif

                                            <div class="text-xs text-slate-400 mt-1">
                                                Sold by: <span class="text-slate-600 font-medium">{{ $item->product->seller->name ?? 'Verified Seller' }}</span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price, Qty & Remove -->
                                    <div class="flex items-center justify-between sm:justify-end space-x-6 w-full sm:w-auto mt-2 sm:mt-0">
                                        <div class="text-right">
                                            <div class="text-xs text-slate-400">Qty: <strong class="text-slate-700">{{ $item->quantity }}</strong> &times; Rs. {{ number_format($item->effective_price, 2) }}</div>
                                            <div class="text-base font-black text-slate-900">Rs. {{ number_format($item->effective_price * $item->quantity, 2) }}</div>
                                        </div>

                                        <form action="{{ route('cart.remove', $item) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="p-2 text-slate-400 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition" title="Remove item">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right: Delivery Details & Order Summary Checkout -->
                <div class="lg:col-span-5">
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm p-6 space-y-6">
                        <div class="border-b border-slate-100 pb-4">
                            <h2 class="font-bold text-slate-900 text-lg">Order Summary & Delivery</h2>
                            <p class="text-xs text-slate-500 mt-0.5">Please provide where you want the order delivered</p>
                        </div>

                        <!-- Price Breakdown -->
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between text-slate-600">
                                <span>Subtotal</span>
                                <span class="font-semibold text-slate-900">Rs. {{ number_format($total, 2) }}</span>
                            </div>
                            <div class="flex justify-between text-slate-600">
                                <span>Direct Seller Shipping</span>
                                <span class="font-semibold text-emerald-600">Included</span>
                            </div>
                            <div class="border-t border-slate-100 pt-3 flex justify-between items-baseline">
                                <span class="text-base font-bold text-slate-900">Grand Total</span>
                                <span class="text-2xl font-black text-indigo-600">Rs. {{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <!-- Checkout Form -->
                        <form action="{{ route('checkout') }}" method="POST" class="space-y-4 pt-2">
                            @csrf

                            <!-- Contact Details -->
                            <div>
                                <label for="contact_details" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Contact Details (Phone / Email) <span class="text-rose-500">*</span>
                                </label>
                                <input type="text" name="contact_details" id="contact_details" required 
                                       value="{{ old('contact_details', auth()->user()->email) }}"
                                       placeholder="e.g. +92 300 1234567 or contact@email.com"
                                       class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3">
                                <p class="text-[11px] text-slate-400 mt-1">Used by sellers to coordinate delivery.</p>
                            </div>

                            <!-- Delivery Address -->
                            <div>
                                <label for="delivery_address" class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                    Delivery Address <span class="text-rose-500">*</span>
                                </label>
                                <textarea name="delivery_address" id="delivery_address" rows="3" required
                                          placeholder="e.g. House 12, Street 4, Sector F-7/2, Islamabad, Pakistan"
                                          class="w-full bg-slate-50 border border-slate-300 text-slate-900 text-sm rounded-xl focus:ring-indigo-500 focus:border-indigo-500 block p-3">{{ old('delivery_address') }}</textarea>
                                <p class="text-[11px] text-slate-400 mt-1">This will appear in the seller's dashboard inbox.</p>
                            </div>

                            <!-- Submit Checkout -->
                            <div class="pt-2">
                                <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-base rounded-xl shadow-lg shadow-emerald-600/30 transition focus:outline-none focus:ring-2 focus:ring-emerald-500">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Confirm & Place Order (Rs. {{ number_format($total, 2) }})
                                </button>
                            </div>
                        </form>

                        <div class="p-3.5 bg-slate-50 rounded-xl border border-slate-100 flex items-center space-x-2.5 text-xs text-slate-500">
                            <svg class="w-4 h-4 text-indigo-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <span>Upon ordering, the specific seller(s) will receive your delivery details to dispatch your items.</span>
                        </div>
                    </div>
                </div>

            </div>
        @endif
    </div>
</x-app-layout>