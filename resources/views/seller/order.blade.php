<x-app-layout>
    <x-slot name="title">Seller Order & Delivery Inbox</x-slot>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
            <div>
                <div class="inline-flex items-center space-x-2 px-2.5 py-0.5 rounded-full bg-amber-100 text-amber-800 text-xs font-bold uppercase tracking-wider mb-2">
                    <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                    <span>Seller Dispatch Center</span>
                </div>
                <h1 class="text-3xl font-black text-slate-900 tracking-tight">Orders & Delivery Details Inbox</h1>
                <p class="text-sm text-slate-500 mt-0.5">Contact info and shipping destinations for products purchased from your store</p>
            </div>
            <a href="{{ route('seller.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-sm rounded-xl transition">
                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Back to Dashboard
            </a>
        </div>

        @if($orderItems->isEmpty())
            <div class="bg-white rounded-3xl border border-slate-200 p-12 text-center shadow-sm max-w-xl mx-auto">
                <div class="w-16 h-16 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                </div>
                <h2 class="text-xl font-bold text-slate-900">Your order inbox is clear</h2>
                <p class="text-sm text-slate-500 mt-1">When buyers order products from your catalog, the delivery address and contact note will appear here.</p>
                <div class="mt-6">
                    <a href="{{ route('seller.products.create') }}" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-bold text-sm rounded-xl shadow-md transition">
                        List More Products
                    </a>
                </div>
            </div>
        @else
            <div class="space-y-6">
                @foreach($orderItems as $item)
                    <div class="bg-white rounded-2xl border border-slate-200/80 shadow-sm overflow-hidden">
                        <!-- Top Order Info Bar -->
                        <div class="p-4 sm:p-5 bg-slate-50 border-b border-slate-200/70 flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-9 h-9 rounded-xl bg-indigo-100 text-indigo-700 flex items-center justify-center font-black text-xs">
                                    #{{ $item->order->id }}
                                </div>
                                <div>
                                    <div class="font-bold text-slate-900 text-sm">
                                        Buyer: <span class="text-indigo-600">{{ $item->order->user->name ?? 'Customer' }}</span>
                                    </div>
                                    <div class="text-xs text-slate-400">
                                        Received on {{ $item->created_at->format('M d, Y h:i A') }} ({{ $item->created_at->diffForHumans() }})
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center space-x-4">
                                <div class="text-right">
                                    <div class="text-xs text-slate-400">Item Revenue</div>
                                    <div class="text-base font-black text-indigo-600">Rs. {{ number_format($item->price * $item->quantity, 2) }}</div>
                                </div>
                                <span class="px-2.5 py-1 text-xs font-bold rounded-full bg-emerald-100 text-emerald-800">
                                    Paid
                                </span>
                            </div>
                        </div>

                        <!-- 2-Column Content: Item Info & Buyer Delivery Info -->
                        <div class="p-5 sm:p-6 grid grid-cols-1 md:grid-cols-12 gap-6 items-start">
                            
                            <!-- Ordered Product Info (md:col-span-6) -->
                            <div class="md:col-span-6 flex items-start space-x-4 bg-slate-50/50 p-4 rounded-xl border border-slate-100">
                                <div class="w-16 h-16 rounded-xl bg-white overflow-hidden shrink-0 border border-slate-200 flex items-center justify-center">
                                    @if($item->product && $item->product->image_path)
                                        <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->title }}" class="w-full h-full object-cover">
                                    @else
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    @endif
                                </div>

                                <div class="space-y-1">
                                    <h3 class="font-bold text-slate-900 text-sm">
                                        {{ $item->product->title ?? 'Product Removed' }}
                                    </h3>
                                    @if($item->option)
                                        <div class="inline-flex items-center px-2 py-0.5 rounded text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-200">
                                            Variant: {{ $item->option->name }} - {{ $item->option->value }}
                                        </div>
                                    @endif
                                    <div class="text-xs text-slate-600 font-medium">
                                        Quantity ordered: <strong class="text-slate-900 font-bold">{{ $item->quantity }}</strong> &times; Rs. {{ number_format($item->price, 2) }}
                                    </div>
                                </div>
                            </div>

                            <!-- Delivery and Contact Information (md:col-span-6) -->
                            <div class="md:col-span-6 bg-amber-50/40 p-4 rounded-xl border border-amber-200/60 space-y-3 text-xs">
                                <div class="flex items-center space-x-1.5 text-amber-900 font-bold text-xs uppercase tracking-wider">
                                    <svg class="w-4 h-4 text-amber-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                    <span>Dispatch & Delivery Information</span>
                                </div>

                                <div>
                                    <span class="text-slate-500 font-semibold block text-[11px]">Buyer Contact (Phone/Email):</span>
                                    <span class="font-bold text-slate-900 text-sm select-all">{{ $item->order->contact_details }}</span>
                                </div>

                                <div>
                                    <span class="text-slate-500 font-semibold block text-[11px]">Delivery Address:</span>
                                    <span class="font-medium text-slate-900 leading-relaxed block select-all bg-white p-2.5 rounded-lg border border-amber-200/50 mt-1">
                                        {{ $item->order->delivery_address }}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $orderItems->links() }}
            </div>
        @endif
    </div>
</x-app-layout>