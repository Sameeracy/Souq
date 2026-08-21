<x-guest-layout>
    <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Welcome back to Souq</h2>
        <p class="text-sm text-slate-500 mt-1">Sign in to your account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" x-data="{
        fillCredentials(email) {
            document.getElementById('email').value = email;
            document.getElementById('password').value = 'password';
        }
    }">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input id="email" class="block mt-1 w-full rounded-xl" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Password')" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-indigo-600 hover:text-indigo-700 underline" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full rounded-xl"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-lg border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-slate-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-6">
            <a class="text-xs font-semibold text-indigo-600 hover:text-indigo-700 underline" href="{{ route('register') }}">
                {{ __('Need an account? Register') }}
            </a>

            <button type="submit" class="inline-flex items-center px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold text-sm rounded-xl shadow-md shadow-indigo-200 transition">
                {{ __('Log in') }}
            </button>
        </div>

        <!-- Demo Accounts Quick Fill Pill Buttons -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400 text-center mb-3">Quick Demo Login (Password: password)</p>
            <div class="grid grid-cols-3 gap-2">
                <button type="button" @click="fillCredentials('admin@souq.com')" class="px-2.5 py-1.5 bg-purple-50 hover:bg-purple-100 text-purple-700 rounded-lg text-xs font-bold transition">
                    Admin
                </button>
                <button type="button" @click="fillCredentials('seller@souq.com')" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 rounded-lg text-xs font-bold transition">
                    Seller
                </button>
                <button type="button" @click="fillCredentials('buyer@souq.com')" class="px-2.5 py-1.5 bg-blue-50 hover:bg-blue-100 text-blue-700 rounded-lg text-xs font-bold transition">
                    Buyer
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
