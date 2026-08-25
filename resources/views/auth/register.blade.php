<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Create an Account</h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Join Souq as a buyer or start selling your items today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ selectedRole: '{{ old('role', 'user') }}' }" class="space-y-4">
        @csrf

        <!-- Account Type / Role Selection -->
        <div>
            <label class="mb-2 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Choose Account Type <span class="text-error-500">*</span>
            </label>
            <div class="grid grid-cols-2 gap-3">
                <!-- Buyer Option -->
                <label :class="selectedRole === 'user' ? 'border-brand-500 bg-brand-50/50 dark:bg-brand-500/10 ring-2 ring-brand-500/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/60'" 
                       class="relative flex flex-col p-3 border rounded-xl cursor-pointer transition">
                    <input type="radio" name="role" value="user" x-model="selectedRole" class="sr-only" />
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-lg bg-blue-100 dark:bg-blue-950 text-blue-600 dark:text-blue-400 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <span class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white">Buyer</span>
                    </div>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-tight">Browse products, add to cart & checkout</p>
                </label>

                <!-- Seller Option -->
                <label :class="selectedRole === 'seller' ? 'border-brand-500 bg-brand-50/50 dark:bg-brand-500/10 ring-2 ring-brand-500/20' : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900 hover:bg-gray-50 dark:hover:bg-gray-800/60'" 
                       class="relative flex flex-col p-3 border rounded-xl cursor-pointer transition">
                    <input type="radio" name="role" value="seller" x-model="selectedRole" class="sr-only" />
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-lg bg-amber-100 dark:bg-amber-950 text-amber-600 dark:text-amber-400 flex items-center justify-center">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="font-bold text-xs sm:text-sm text-gray-900 dark:text-white">Seller</span>
                    </div>
                    <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-tight">List products & receive delivery requests</p>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
        </div>

        <!-- Full Name -->
        <div>
            <label for="name" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Full Name <span class="text-error-500">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name"
                   placeholder="e.g. Sameer Khan"
                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <x-input-error :messages="$errors->get('name')" class="mt-1.5" />
        </div>

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Email Address <span class="text-error-500">*</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autocomplete="username"
                   placeholder="name@example.com"
                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Password <span class="text-error-500">*</span>
            </label>
            <input type="password" id="password" name="password" required autocomplete="new-password"
                   placeholder="••••••••"
                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Confirm Password <span class="text-error-500">*</span>
            </label>
            <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                   placeholder="••••••••"
                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1.5" />
        </div>

        <!-- Submit Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center h-11 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                Create Account
            </button>
        </div>

        <!-- Login Link -->
        <div class="text-center pt-2 text-xs text-gray-500 dark:text-gray-400">
            Already have an account?
            <a class="font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400 underline ml-1" href="{{ route('login') }}">
                Log in
            </a>
        </div>
    </form>
</x-guest-layout>
