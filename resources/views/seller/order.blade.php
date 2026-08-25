<x-app-layout>
    <x-slot name="title">Seller Order & Delivery Inbox</x-slot>

    <div class="space-y-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 border-b border-gray-200 dark:border-gray-800 pb-5">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800/60 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Seller Dispatch Center</span>
                </div>
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight">Orders & Delivery Details Inbox</h1>
                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-0.5">Contact info and shipping destinations for products purchased from your store</p>
            </div>
            <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 dark:bg-gray-800 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-200 font-medium text-sm rounded-lg transition self-start sm:self-auto">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
        </div>

        @if($orderItems->isEmpty())
            <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 p-12 text-center shadow-theme-xs max-w-md mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h2 class="text-lg font-bold text-gray-800 dark:text-white">Your order inbox is clear</h2>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">When buyers order products from your store, the delivery destination and contact note will appear here.</p>
                <div class="mt-6">
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-4 py-2 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm rounded-lg shadow-theme-xs transition">
                        List More Products
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orderItems as $item)
                    <div class="bg-white dark:bg-gray-dark rounded-2xl border border-gray-200 dark:border-gray-800 shadow-theme-xs overflow-hidden">
                        <!-- Top Order Info Bar -->
                        <div class="p-4 sm:p-5 bg-gray-50 dark:bg-white/[0.02] border-b border-gray-200 dark:border-gray-800 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-brand-50 dark:bg-brand-500/10 text-brand-600 dark:text-brand-400 flex items-center justify-center font-bold text-xs border border-brand-200/60 dark:border-brand-800/60">
                                    #{{ $item->order->id }}
                                </div>
                                <div>
                                    <div class="font-bold text-gray-900 dark:text-white text-sm">
                                        Buyer: <span class="text-brand-500">{{ $item->order->user->name ?? 'Customer' }}</span>
                                    </div>
                                    <div class="text-xs text-gray-400">
                                        Ordered on {{ $item->created_at->format('M d, Y h:i A') }} ({{ $item->created_at->diffForHumans() }})
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <div class="text-xs text-gray-400">Item Revenue</div>
                                    <div class="text-base font-black text-brand-500">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                </div>
                                
                                @if($item->order && $item->order->payment_status === 'paid')
                                    <span class="px-2.5 py-1 text-[11px] font-semibold rounded-full bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-200 dark:border-brand-800">
                                        Paid (Stripe)
                                    </span>
                                @endif

                                @if($item->status === 'received' || ($item->order && $item->order->status === 'completed'))
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-emerald-50 text-emerald-700 dark:bg-emerald-950/40 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800 flex items-center">
                                        <svg class="w-3.5 h-3.5 mr-1 text-emerald-600 dark:text-emerald-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Received by Customer
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-50 text-amber-700 dark:bg-amber-950/40 dark:text-amber-400 border border-amber-200 dark:border-amber-800 flex items-center">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 mr-1.5 animate-pulse"></span>
                                        Pending Delivery
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!-- 2-Column Content: Item Info & Buyer Delivery Info -->
                        <div class="p-5 sm:p-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                            
                            <!-- Ordered Product Info (md:col-span-6) -->
                            <div class="md:col-span-6 flex items-start space-x-4 bg-gray-50 dark:bg-white/[0.02] p-4 rounded-xl border border-gray-200/60 dark:border-gray-800">
                                <div class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-gray-800 overflow-hidden shrink-0 border border-gray-200/60 dark:border-gray-700/60 flex items-center justify-center">
                                    @if($item->product && $item->product->image_path)
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>

                                <div class="space-y-1">
                                    <h3 class="font-bold text-gray-800 dark:text-white text-sm">
                                        {{ $item->product->title ?? 'Product Removed' }}
                                    </h3>
                                    @if($item->option)
                                        <div class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-brand-50 text-brand-600 dark:bg-brand-500/10 dark:text-brand-400 border border-brand-200 dark:border-brand-800">
                                            Variant: {{ $item->option->name }} - {{ $item->option->value }}
                                        </div>
                                    @endif
                                    <div class="text-xs text-gray-400">
                                        Quantity: <strong class="text-gray-700 dark:text-gray-300">{{ $item->quantity }}</strong> &times; Rs. {{ number_format($item->price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Buyer Delivery & Contact Note (md:col-span-6) -->
                            <div class="md:col-span-6 bg-gray-50 dark:bg-white/[0.02] p-4 rounded-xl border border-gray-200/60 dark:border-gray-800 space-y-3">
                                <div>
                                    <span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider block">Buyer Contact Note:</span>
                                    <span class="font-bold text-gray-900 dark:text-white text-sm select-all">{{ $item->order->contact_details }}</span>
                                </div>
                                <div class="border-t border-gray-200 dark:border-gray-700 pt-2.5">
                                    <span class="text-gray-400 font-semibold text-[11px] uppercase tracking-wider block">Shipping Destination:</span>
                                    <span class="text-gray-800 dark:text-gray-200 text-sm leading-relaxed block select-all">{{ $item->order->delivery_address }}</span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>