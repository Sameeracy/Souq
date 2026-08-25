<x-app-layout>
    <x-slot name="title">My Purchase Orders</x-slot>

    <div class="space-y-6">
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-800 pb-5">
            <div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">
                    My Purchase Orders
                </h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">
                    Track delivery progress and confirm when your orders arrive safely
                </p>
            </div>
            <a href="{{ route('home') }}" class="inline-flex items-center text-xs font-semibold text-brand-500 bg-brand-50 dark:bg-brand-500/10 hover:bg-brand-100 px-3.5 py-2 rounded-lg transition self-start sm:self-auto">
                &larr; Continue Shopping
            </a>
        </div>

        @if(request('payment') === 'success')
            <div class="p-4 rounded-xl bg-emerald-50 border border-emerald-200 dark:bg-emerald-950/40 dark:border-emerald-800/60 flex items-start space-x-3 text-emerald-900 dark:text-emerald-300 shadow-theme-xs">
                <div class="p-1.5 rounded-lg bg-emerald-100 dark:bg-emerald-900/50 text-emerald-700 dark:text-emerald-300 shrink-0">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <h3 class="font-bold text-sm text-emerald-950 dark:text-emerald-200">Payment Successful!</h3>
                    <p class="text-xs text-emerald-800 dark:text-emerald-300 mt-0.5">
                        Your payment via Stripe was processed successfully. Your order has been placed and dispatched to the seller's delivery inbox.
                    </p>
                </div>
            </div>
        @endif

        @if($orders->isEmpty())
            <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 p-12 text-center max-w-md mx-auto shadow-theme-xs">
                <div class="w-16 h-16 rounded-2xl bg-brand-50 dark:bg-brand-500/10 text-brand-500 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white mb-1">No orders placed yet</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-6">Explore our curated marketplace catalog and place your first order!</p>
                <a href="{{ route('home') }}" class="inline-flex items-center px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm rounded-lg shadow-theme-xs transition">
                    Browse Products
                </a>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orders as $order)
                    <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 shadow-theme-xs overflow-hidden">
                        <!-- Order Header -->
                        <div class="p-4 sm:p-5 bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-xl bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs border border-brand-200/60 dark:border-brand-800/60">
                                    #{{ $order->id }}
                                </div>
                                <div>
                                    <div class="text-[11px] text-gray-400 uppercase tracking-wider">Order Placed</div>
                                    <div class="font-bold text-gray-800 dark:text-white text-sm">{{ $order->created_at->format('M d, Y h:i A') }}</div>
                                </div>
                            </div>

                            <div class="flex items-center flex-wrap gap-4">
                                <div>
                                    <div class="text-[11px] text-gray-400 uppercase tracking-wider">Total</div>
                                    <div class="font-black text-brand-500 text-base">Rs. {{ number_format($order->total_amount, 2) }}</div>
                                </div>

                                <!-- Status Badge -->
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold capitalize
                                        @if($order->status === 'completed' || $order->status === 'received') bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800/60
                                        @elseif($order->status === 'processing') bg-blue-50 text-blue-700 dark:bg-blue-950/40 dark:text-blue-400 border border-blue-200 dark:border-blue-800/60
                                        @elseif($order->status === 'cancelled') bg-rose-50 text-rose-700 dark:bg-rose-950/40 dark:text-rose-400 border border-rose-200 dark:border-rose-800/60
                                        @else bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60 @endif">
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

                                <!-- Mark Order Received Action -->
                                @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                    <form action="{{ route('orders.markReceived', $order) }}" method="POST"
                                          onsubmit="return confirm('Confirm that you have received this entire order? This will mark it completed and clear the delivery note from the seller dashboard.');">
                                        @csrf
                                        <button type="submit" class="inline-flex items-center px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-xs rounded-lg shadow-theme-xs transition cursor-pointer">
                                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            Order Received
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400 flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Delivered
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- Order Items List -->
                        <div class="p-4 sm:p-5 divide-y divide-gray-100 dark:divide-gray-800">
                            @foreach($order->items as $item)
                                <div class="py-3.5 first:pt-0 last:pb-0 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                                    <div class="flex items-center space-x-3.5">
                                        <div class="w-14 h-14 rounded-xl bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0 border border-gray-200/60 dark:border-gray-700/60 flex items-center justify-center">
                                            @if($item->product && $item->product->image_path)
                                                <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                            @else
                                                <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                            @endif
                                        </div>

                                        <div>
                                            <h4 class="font-bold text-gray-800 dark:text-white text-sm">
                                                @if($item->product)
                                                    <a href="{{ route('product.show', $item->product) }}" class="hover:text-brand-500 transition">
                                                        {{ $item->product->title }}
                                                    </a>
                                                @else
                                                    Deleted Product
                                                @endif
                                            </h4>

                                            <div class="flex items-center space-x-2 text-xs text-gray-400 mt-0.5">
                                                <span>Sold by: <strong class="text-gray-600 dark:text-gray-300 font-medium">{{ $item->seller->name ?? 'Verified Seller' }}</strong></span>
                                                @if($item->option)
                                                    <span>•</span>
                                                    <span class="inline-flex items-center px-2 py-0.2 rounded text-[11px] font-semibold bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400">
                                                        {{ $item->option->name }}: {{ $item->option->value }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="flex items-center justify-between sm:justify-end space-x-6 w-full sm:w-auto">
                                        <div class="text-right">
                                            <div class="text-xs text-gray-400">Qty: {{ $item->quantity }} &times; Rs. {{ number_format($item->price, 2) }}</div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                        </div>

                                        @if($order->status !== 'completed' && $order->status !== 'cancelled')
                                            @if($item->status === 'received')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-bold bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400">
                                                    Item Received
                                                </span>
                                            @else
                                                <form action="{{ route('orderItems.markReceived', $item) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1 text-xs font-semibold text-emerald-700 bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/40 dark:text-emerald-400 rounded-lg transition border border-emerald-200 dark:border-emerald-800/60">
                                                        Mark Item Received
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Delivery Address Footer Note -->
                        <div class="p-4 bg-gray-50 dark:bg-white/[0.02] border-t border-gray-100 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Delivery Address:</span>
                                <span>{{ $order->delivery_address }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Contact:</span>
                                <span>{{ $order->contact_details }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
