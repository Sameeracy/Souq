<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ isset($title) ? $title . ' - Souq Marketplace' : config('app.name', 'Souq') . ' - Authentic Marketplace' }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-slate-900 min-h-full flex flex-col bg-slate-50">
        <div class="min-h-screen flex flex-col">
            @include('layouts.navigation')

            <!-- Global Flash Messages -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-center justify-between p-4 text-emerald-800 bg-emerald-50 border border-emerald-200 rounded-xl shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 p-1 rounded-lg focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-center justify-between p-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-600 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg focus:outline-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 p-4 text-rose-800 bg-rose-50 border border-rose-200 rounded-xl shadow-sm">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-semibold">Please resolve the following errors:</p>
                            <button @click="show = false" class="text-rose-500 hover:text-rose-700 p-1 rounded-lg focus:outline-none">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </button>
                        </div>
                        <ul class="list-disc list-inside text-sm space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-b border-slate-200">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Footer -->
            <footer class="bg-white border-t border-slate-200 mt-auto py-6">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between text-sm text-slate-500 gap-4">
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-indigo-600 text-lg">Souq</span>
                        <span>&copy; {{ date('Y') }} Marketplace. All rights reserved.</span>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="hover:text-indigo-600 transition">Storefront</a>
                        @auth
                            @if(auth()->user()->hasRole('seller'))
                                <a href="{{ route('seller.dashboard') }}" class="hover:text-indigo-600 transition">Seller Portal</a>
                            @elseif(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-indigo-600 transition">Admin Panel</a>
                            @else
                                <a href="{{ route('orders.my') }}" class="hover:text-indigo-600 transition">My Orders</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
