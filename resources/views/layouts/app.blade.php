<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ isset($title) ? $title . ' | Souq Marketplace' : config('app.name', 'Souq') . ' | Authentic Marketplace' }}</title>

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Theme Store -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('theme', {
                init() {
                    const savedTheme = localStorage.getItem('theme');
                    const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                    this.theme = savedTheme || systemTheme;
                    this.updateTheme();
                },
                theme: 'light',
                toggle() {
                    this.theme = this.theme === 'light' ? 'dark' : 'light';
                    localStorage.setItem('theme', this.theme);
                    this.updateTheme();
                },
                updateTheme() {
                    const html = document.documentElement;
                    const body = document.body;
                    if (this.theme === 'dark') {
                        html.classList.add('dark');
                        body.classList.add('dark', 'bg-gray-900');
                    } else {
                        html.classList.remove('dark');
                        body.classList.remove('dark', 'bg-gray-900');
                    }
                }
            });

            Alpine.store('sidebar', {
                isExpanded: window.innerWidth >= 1280,
                isMobileOpen: false,
                isHovered: false,

                toggleExpanded() {
                    this.isExpanded = !this.isExpanded;
                    this.isMobileOpen = false;
                },

                toggleMobileOpen() {
                    this.isMobileOpen = !this.isMobileOpen;
                },

                setMobileOpen(val) {
                    this.isMobileOpen = val;
                },

                setHovered(val) {
                    if (window.innerWidth >= 1280 && !this.isExpanded) {
                        this.isHovered = val;
                    }
                }
            });
        });
    </script>

    <!-- Prevent Dark Mode Flash -->
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme');
            const systemTheme = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            const theme = savedTheme || systemTheme;
            if (theme === 'dark') {
                document.documentElement.classList.add('dark');
                document.body.classList.add('dark', 'bg-gray-900');
            } else {
                document.documentElement.classList.remove('dark');
                document.body.classList.remove('dark', 'bg-gray-900');
            }
        })();
    </script>
</head>

<body
    class="font-sans antialiased text-gray-800 bg-gray-50 dark:bg-gray-900 dark:text-gray-200"
    x-data="{ 'loaded': true }"
    x-init="$store.sidebar.isExpanded = window.innerWidth >= 1280;
    const checkMobile = () => {
        if (window.innerWidth < 1280) {
            $store.sidebar.setMobileOpen(false);
            $store.sidebar.isExpanded = false;
        } else {
            $store.sidebar.isMobileOpen = false;
            $store.sidebar.isExpanded = true;
        }
    };
    window.addEventListener('resize', checkMobile);">

    <!-- Preloader -->
    <x-common.preloader/>

    <div class="min-h-screen xl:flex">
        @include('layouts.backdrop')
        @include('layouts.sidebar')

        <div class="flex-1 transition-all duration-300 ease-in-out flex flex-col min-h-screen"
            :class="{
                'xl:ml-[290px]': $store.sidebar.isExpanded || $store.sidebar.isHovered,
                'xl:ml-[90px]': !$store.sidebar.isExpanded && !$store.sidebar.isHovered,
                'ml-0': $store.sidebar.isMobileOpen
            }">
            
            <!-- App Header -->
            @include('layouts.app-header')

            <!-- Global Flash Messages -->
            <div class="p-4 mx-auto w-full max-w-(--breakpoint-2xl) md:px-6 md:pt-6 md:pb-0">
                @if (session('success'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-center justify-between p-4 text-emerald-800 bg-emerald-50/90 border border-emerald-200 rounded-xl dark:bg-emerald-950/40 dark:border-emerald-800/60 dark:text-emerald-300 shadow-theme-xs">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-emerald-600 dark:text-emerald-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-emerald-500 hover:text-emerald-700 dark:hover:text-emerald-300 p-1 rounded-lg focus:outline-hidden">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 flex items-center justify-between p-4 text-rose-800 bg-rose-50/90 border border-rose-200 rounded-xl dark:bg-rose-950/40 dark:border-rose-800/60 dark:text-rose-300 shadow-theme-xs">
                        <div class="flex items-center space-x-3">
                            <svg class="w-5 h-5 text-rose-600 dark:text-rose-400 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                            </svg>
                            <p class="text-sm font-medium">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-rose-500 hover:text-rose-700 dark:hover:text-rose-300 p-1 rounded-lg focus:outline-hidden">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </button>
                    </div>
                @endif

                @if (isset($errors) && $errors->any())
                    <div x-data="{ show: true }" x-show="show" x-transition class="mb-4 p-4 text-rose-800 bg-rose-50/90 border border-rose-200 rounded-xl dark:bg-rose-950/40 dark:border-rose-800/60 dark:text-rose-300 shadow-theme-xs">
                        <div class="flex items-center justify-between mb-1">
                            <p class="text-sm font-semibold">Please resolve the following errors:</p>
                            <button @click="show = false" class="text-rose-500 hover:text-rose-700 dark:hover:text-rose-300 p-1 rounded-lg focus:outline-hidden">
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

            <!-- Page Heading (if provided) -->
            @isset($header)
                <header class="bg-white dark:bg-gray-900 border-b border-gray-200 dark:border-gray-800">
                    <div class="p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Main Workspace / Slot Content -->
            <main class="flex-1 p-4 mx-auto max-w-(--breakpoint-2xl) md:p-6 w-full">
                {{ $slot ?? '' }}
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="mt-auto border-t border-gray-200 bg-white py-5 dark:border-gray-800 dark:bg-gray-900">
                <div class="mx-auto flex max-w-(--breakpoint-2xl) flex-col items-center justify-between gap-4 px-4 sm:flex-row md:px-6 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-brand-500 text-base">Souq</span>
                        <span>&copy; {{ date('Y') }} Marketplace. All rights reserved.</span>
                    </div>
                    <div class="flex items-center space-x-6">
                        <a href="{{ route('home') }}" class="hover:text-brand-500 transition">Storefront</a>
                        @auth
                            @if(auth()->user()->hasRole('seller'))
                                <a href="{{ route('seller.dashboard') }}" class="hover:text-brand-500 transition">Seller Portal</a>
                            @elseif(auth()->user()->hasRole('admin'))
                                <a href="{{ route('admin.dashboard') }}" class="hover:text-brand-500 transition">Admin Panel</a>
                            @else
                                <a href="{{ route('orders.my') }}" class="hover:text-brand-500 transition">My Orders</a>
                            @endif
                        @endauth
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
