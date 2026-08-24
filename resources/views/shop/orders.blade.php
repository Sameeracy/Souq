<x-app-layout>
    <x-slot name="title">My Purchase Orders</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <!-- Header -->
        <div class="border-b border-slate-200/80 pb-6 mb-8 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">My Purchase Orders</h1>
                <p class="text-sm text-slate-500 mt-1">Track delivery statuses and confirm when your orders arrive safely</p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-bold text-indigo-600 hover:text-indigo-700 bg-indigo-50 px-4 py-2.5 rounded-xl transition self-start sm:self-auto">
                &larr; Continue Shopping
            </a>
        </div>

        @if(request('payment') === 'success')
            <div class="mb-8 p-4 sm:p-5 rounded-2xl bg-emerald-50 border border-emerald-200 flex items-start space-x-3.5 text-emerald-900 shadow-sm animate-fade-in">
                <div class="p-2 rounded-xl bg-emerald-100 text-emerald-700 shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-base text-emerald-950">Payment Successful!</h3>
                    <p class="text-sm text-emerald-800 mt-0.5">
                        Your payment via Stripe was processed successfully. Your order has been placed and dispatched to the seller's dashboard.
                    </p>
                </div>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200/80 p-12 text-center max-w-lg mx-auto shadow-sm">
                <div class="w-16 h-16 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900 mb-2">No orders placed yet</h2>
                <p class="text-sm text-slate-500 mb-6">Explore our curated marketplace catalog and place your first order!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-lg shadow-indigo-600/30 transition">
                    Browse Products
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white rounded-3xl border border-slate-200/80 shadow-sm overflow-hidden transition hover:border-slate-300">
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

                            <div class="flex items-center flex-wrap gap-4">
                                <div>
                                    <div class="text-xs text-slate-400">Total Amount</div>
                                    <div class="font-black text-indigo-600 text-base">Rs. {{ number_format($order->total_amount, 2) }}</div>
                                </div>

                                <!-- Status Badge -->
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold capitalize
                                        @if($order->status === 'completed' || $order->status === 'received') bg-emerald-100 text-emerald-800
                                        @elseif($order->status === 'processing') bg-blue-100 text-blue-800
                                        @elseif($order->status === 'cancelled') bg-rose-100 text-rose-800
                                        @else bg-amber-100 text-amber-800 @endif">
                                        <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                            @if($order->status === 'completed' || $order->status === 'received') bg-emerald-500
                                            @elseif($order->status === 'processing') bg-blue-500
                                            @elseif($order->status === 'cancelled') bg-rose-500
                                            @else bg-amber-500 @endif"></span>
                                        @if($order->status === 'completed')
                                            Received & Completed
                                        @else
                                            {{ ucfirst($order->status) }}
                                        @endif
                                    </span>
                                </div>

                                <!-- Mark Whole Order as Received Action -->
                                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                    <form action="{{ route('orders.markReceived', $order) }}" method="POST"
                                          onsubmit="return confirm('Confirm that you have received this entire order? This will mark it completed and clear the delivery note from the seller dashboard.');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-xl shadow-sm shadow-emerald-600/30 transition">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Order Received
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs font-semibold text-emerald-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Delivered
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Content: Items & Delivery Details -->
                        <div class="p-4 sm:p-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
                            <!-- Items List -->
                            <div class="lg:col-span-2 space-y-3 divide-y divide-slate-100">
                                <h3 class="text-xs font-bold uppercase tracking-wider text-slate-400">Purchased Items</h3>
                                @foreach($order->items as $item)
                                    <div class="pt-3 flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                                        <div class="flex items-center space-x-3">
                                            <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden shrink-0 border border-slate-200/60 flex items-center justify-center">
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
                                                    Seller: <strong class="text-slate-600">{{ $item->seller->name ?? 'Verified Seller' }}</strong>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="flex items-center justify-between sm:justify-end space-x-4">
                                            <div class="text-right">
                                                <div class="text-xs text-slate-500">Qty: {{ $item->quantity }} &times; Rs. {{ number_format($item->price, 2) }}</div>
                                                <div class="text-sm font-bold text-slate-900">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                            </div>

                                            <!-- Item-level received status / action -->
                                            <div>
                                                @if($item->status === 'received' || $order->status === 'completed')
                                                    <span class="inline-flex items-center px-2 py-1 bg-emerald-50 text-emerald-700 text-[11px] font-bold rounded-lg border border-emerald-200">
                                                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                        Received
                                                    </span>
                                                @else
                                                    <form action="{{ route('orderItems.markReceived', $item) }}" method="POST"
                                                          onsubmit="return confirm('Confirm that you have received this item? This will remove the delivery note from {{ addslashes($item->seller->name ?? 'the seller') }}\'s dashboard.');">
                                                        @csrf
                                                        <button type="submit" class="px-2.5 py-1 bg-slate-100 hover:bg-emerald-50 text-slate-600 hover:text-emerald-700 text-xs font-semibold rounded-lg border border-slate-200 hover:border-emerald-200 transition" title="Mark this single item as received">
                                                            Mark Received
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Delivery Note Box -->
                            <div class="bg-slate-50 rounded-2xl p-4 border border-slate-200/60 flex flex-col justify-between">
                                <div>
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

                                <div class="mt-4 pt-3 border-t border-slate-200/60 text-[11px] text-slate-400">
                                    @if($order->status === 'completed')
                                        <span class="text-emerald-600 font-medium">✓ Delivery finalized & archived</span>
                                    @else
                                        <span>Click <strong>Order Received</strong> once delivered to clear from seller's dispatch feed.</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
