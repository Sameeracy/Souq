<x-app-layout>
    <x-slot name="title">Dashboard</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="rounded-2xl border border-gray-200 bg-white p-8 dark:border-gray-800 dark:bg-gray-dark shadow-theme-xs text-center">
            <div class="w-16 h-16 rounded-2xl bg-brand-50 dark:bg-brand-500/10 text-brand-500 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            </div>
            <h2 class="text-xl font-bold text-gray-900 dark:text-white">You're logged in!</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Welcome to Souq Marketplace.</p>

            <div class="mt-6 flex items-center justify-center gap-3">
                <a href="{{ route('home') }}" class="px-5 py-2.5 bg-brand-500 hover:bg-brand-600 text-white font-medium text-sm rounded-lg shadow-theme-xs transition">
                    Go to Storefront
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
