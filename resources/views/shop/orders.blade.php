<x-app-layout>
    <x-slot name="title">My Orders</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">My Order History</h1>
                <p class="text-sm text-slate-500 mt-1">Track the status of your purchases and delivery requests</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center px-4 py-2 bg-indigo-50 hover:bg-indigo-100 text-indigo-700 font-semibold text-sm rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Continue Shopping
            </a>
        </div>

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900">No orders placed yet</h2>
                <p class="text-sm text-slate-500 mt-1">When you checkout items, your order history and delivery tracking will appear here.</p>
                <div class="mt-6">
                    <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md transition">
                        Explore Marketplace
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <!-- Order Header -->
                        <div class="p-4 sm:p-6 bg-slate-50 border-b border-slate-200/80 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-4">
                                <div class="w-10 h-10 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-sm">
                                    #{{ $order->id }}
                                </div>
                                <div>
                                    <div class="text-xs text-slate-400">Order Placed</div>
                                    <div class="font-bold text-slate-800 text-sm">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-6">
                                <div>
                                    <div class="text-xs text-slate-400">Total Amount</div>
                                    <div class="font-black text-indigo-600 text-base">Rs. {{ number_format($order->total_amount, 2) }}</div>
                                </div>

                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold capitalize
                                        @if($order->status === 'completed') bg-emerald-100 text-emerald-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'cancelled') bg-rose-100 text-rose-800
                                        @else bg-amber-100 text-amber-800 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                            @if($order->status === 'completed') bg-emerald-500
                                            @elseif($order->status === 'processing') bg-blue-500
                                            @elseif($order->status === 'cancelled') bg-rose-500
                                            @else bg-amber-500 @endif"></span>
                                        {{ $order->status }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Order Content: Items & Delivery Details -->
                        <div class="p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Items List -->
                            <div class="lg:col-span-2 space-y-3 divide-y divide-slate-100">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Purchased Items</h3>
                                @foreach($order->items as $item)
                                    <div class="pt-3 flex items-center justify-between">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 rounded-lg bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 flex items-center justify-center">
                                                @if($item->product && $item->product->image_path)
                                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                                @else
                                                    <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-sm text-slate-900">
                                                    @if($item->product)
                                                        <a href="{{ route('product.show', $item->product) }}" class="hover:text-indigo-600">
                                                            {{ $item->product->title }}
                                                        </a>
                                                    @else
                                                        Product No Longer Available
                                                    @endif
                                                </h4>
                                                @if($item->option)
                                                    <span class="inline-block text-[11px] font-semibold text-indigo-600">
                                                        Variant: {{ $item->option->name }} ({{ $item->option->value }})
                                                    </span>
                                                @endif
                                                <div class="text-[11px] text-slate-400">
                                                    Seller: {{ $item->seller->name ?? 'Verified Seller' }}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-right">
                                            <div class="text-xs text-slate-500">Qty: {{ $item->quantity }} &times; Rs. {{ number_format($item->price, 2) }}</div>
                                            <div class="text-sm font-bold text-slate-900">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Delivery Note Box -->
                            <div class="bg-slate-50 rounded-xl p-4 border border-slate-200/60">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center space-x-1.5">
                                    <svg class="w-4 h-4 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span>Delivery Destination</span>
                                </h3>
                                <div class="space-y-2 text-xs text-slate-700">
                                    <div>
                                        <span class="text-slate-400 block font-medium">Contact:</span>
                                        <span class="font-semibold text-slate-800">{{ $order->contact_details }}</span>
                                    </div>
                                    <div>
                                        <span class="text-slate-400 block font-medium">Address:</span>
                                        <span class="font-medium text-slate-800 leading-relaxed">{{ $order->delivery_address }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
