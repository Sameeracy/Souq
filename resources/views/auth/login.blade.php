<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Welcome Back</h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">Sign in to your Souq account to continue</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{
        showPassword: false,
        fillCredentials(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    }" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Email Address <span class="text-error-500">*</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   placeholder="name@example.com"
                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-400">
                    Password <span class="text-error-500">*</span>
                </label>
                @if (Route::has('password.request'))
                    <a class="text-xs text-brand-500 hover:text-brand-600 dark:text-brand-400 font-medium" href="{{ route('password.request') }}">
                        Forgot password?
                    </a>
                @endif
            </div>

            <div class="relative">
                <input :type="showPassword ? 'text' : 'password'" id="password" name="password" required autocomplete="current-password"
                       placeholder="••••••••"
                       class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent py-2.5 pr-11 pl-4 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
                <button type="button" @click="showPassword = !showPassword"
                      class="absolute top-1/2 right-3.5 -translate-y-1/2 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 cursor-pointer">
                    <svg x-show="!showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    <svg x-show="showPassword" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l18 18"/></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between pt-1">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 rounded border-gray-300 text-brand-500 focus:ring-brand-500/20 dark:border-gray-700 dark:bg-gray-900 dark:checked:bg-brand-500">
                <span class="ms-2 text-xs sm:text-sm text-gray-600 dark:text-gray-400">Remember me</span>
            </label>
        </div>

        <!-- Sign In Button -->
        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center h-11 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                Sign In
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center pt-2 text-xs text-gray-500 dark:text-gray-400">
            Don't have an account?
            <a class="font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400 underline ml-1" href="{{ route('register') }}">
                Create an account
            </a>
        </div>

        <!-- Demo Accounts Quick Fill Pill Buttons -->
        <div class="mt-6 pt-5 border-t border-gray-100 dark:border-gray-800">
            <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500 text-center mb-2.5">Quick Demo Login (Password: password)</p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" @click="fillCredentials('admin@souq.com')" class="px-2.5 py-2 bg-purple-50 hover:bg-purple-100 dark:bg-purple-950/40 dark:hover:bg-purple-900/50 text-purple-700 dark:text-purple-300 rounded-lg text-xs font-bold transition border border-purple-200/60 dark:border-purple-800/60 cursor-pointer">
                    Admin
                </button>
                <button type="button" @click="fillCredentials('seller@souq.com')" class="px-2.5 py-2 bg-amber-50 hover:bg-amber-100 dark:bg-amber-950/40 dark:hover:bg-amber-900/50 text-amber-700 dark:text-amber-300 rounded-lg text-xs font-bold transition border border-amber-200/60 dark:border-amber-800/60 cursor-pointer">
                    Seller
                </button>
                <button type="button" @click="fillCredentials('buyer@souq.com')" class="px-2.5 py-2 bg-brand-50 hover:bg-brand-100 dark:bg-brand-500/10 dark:hover:bg-brand-500/20 text-brand-600 dark:text-brand-300 rounded-lg text-xs font-bold transition border border-brand-200/60 dark:border-brand-800/60 cursor-pointer">
                    Buyer
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
