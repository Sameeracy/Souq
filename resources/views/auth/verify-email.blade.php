<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white tracking-tight">Verify Your Email</h2>
        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">
            {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you?') }}
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 p-3 rounded-lg text-xs font-medium text-emerald-700 bg-emerald-50 dark:bg-emerald-950/40 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="space-y-4">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center h-11 bg-brand-500 hover:bg-brand-600 text-white font-semibold text-sm rounded-lg shadow-theme-xs transition cursor-pointer">
                Resend Verification Email
            </button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white underline cursor-pointer">
                Log Out
            </button>
        </form>
    </div>
</x-guest-layout>
