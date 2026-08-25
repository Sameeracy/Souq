<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Forgot Password</h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ __('Forgot your password? Enter your email address and we will send you a password reset link.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="mb-1.5 block text-sm font-medium text-gray-700 dark:text-gray-400">
                Email Address <span class="text-error-500">*</span>
            </label>
            <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                   placeholder="name@example.com"
                   class="dark:bg-dark-900 shadow-theme-xs focus:border-brand-300 focus:ring-brand-500/10 dark:focus:border-brand-800 h-11 w-full rounded-lg border border-gray-300 bg-transparent px-4 py-2.5 text-sm text-gray-800 placeholder:text-gray-400 focus:ring-3 focus:outline-hidden dark:border-gray-700 dark:bg-gray-900 dark:text-white/90 dark:placeholder:text-white/30" />
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div class="pt-2">
            <button type="submit" class="w-full flex items-center justify-center h-11 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                Email Password Reset Link
            </button>
        </div>

        <div class="text-center pt-2 text-xs text-gray-500 dark:text-gray-400">
            Remember your password?
            <a class="font-semibold text-brand-500 hover:text-brand-600 dark:text-brand-400 underline ml-1" href="{{ route('login') }}">
                Back to login
            </a>
        </div>
    </form>
</x-guest-layout>
