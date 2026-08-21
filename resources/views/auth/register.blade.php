<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Create your Souq account</h2>
        <p class="text-sm text-slate-500 mt-1">Join as a shopper or start selling your products today</p>
    </div>

    <form method="POST" action="{{ route('register') }}" x-data="{ selectedRole: '{{ old('role', 'user') }}' }">
        @csrf

        <!-- Account Type / Role Selection -->
        <div class="mb-5">
            <x-input-label :value="__('Account Type')" class="mb-2 font-semibold text-slate-700" />
            <div class="grid grid-cols-2 gap-3">
                <label :class="selectedRole === 'user' ? 'border-indigo-600 bg-indigo-50/60 ring-2 ring-indigo-600/20' : 'border-slate-200 bg-white hover:bg-slate-50'" 
                       class="relative flex flex-col p-3.5 border rounded-xl cursor-pointer transition">
                    <input type="radio" name="role" value="user" x-model="selectedRole" class="sr-only" />
                    <div class="flex items-center space-x-2">
                        <div class="w-7 h-7 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        </div>
                        <span class="font-bold text-sm text-slate-900">Buyer</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1.5 leading-tight">Browse products, add to cart & place orders</p>
                </label>

                <label :class="selectedRole === 'seller' ? 'border-indigo-600 bg-indigo-50/60 ring-2 ring-indigo-600/20' : 'border-slate-200 bg-white hover:bg-slate-50'" 
                       class="relative flex flex-col p-3.5 border rounded-xl cursor-pointer transition">
                    <input type="radio" name="role" value="seller" x-model="selectedRole" class="sr-only" />
                    <div class="flex items-center space-x-2">
                        <div class="w-7 h-7 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        </div>
                        <span class="font-bold text-sm text-slate-900">Seller</span>
                    </div>
                    <p class="text-[11px] text-slate-500 mt-1.5 leading-tight">List products, manage variants & receive order details</p>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </div>

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input id="name" class="block mt-1 w-full rounded-xl" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="e.g. Sameer Khan" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full rounded-xl"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 underline focus:outline-none" href="{{ route('login') }}">
                {{ __('Already have an account? Log in') }}
            </a>

            <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-md shadow-indigo-200 transition focus:outline-none">
                {{ __('Create Account') }}
            </button>
        </div>
    </form>
</x-guest-layout>
