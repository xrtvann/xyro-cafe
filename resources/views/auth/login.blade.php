<x-guest-layout>
    <!-- Heading -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-heading font-bold text-on-surface mb-2">Welcome Back</h2>
        <p class="text-secondary text-sm">Sign in to continue to Xyro Cafe</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-secondary">{{ __('Email') }}</label>
            <input id="email" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Enter your email" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-error" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <label for="password" class="block font-medium text-sm text-secondary">{{ __('Password') }}</label>
            <input id="password" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-error" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-5">
            <label for="remember_me" class="inline-flex items-center group cursor-pointer">
                <input id="remember_me" type="checkbox" class="rounded border-white/20 bg-white/[0.04] text-primary shadow-sm focus:ring-primary/50 focus:ring-offset-background" name="remember">
                <span class="ms-2 text-sm text-secondary group-hover:text-on-surface transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex flex-col mt-8 gap-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-primary to-primary-container border border-transparent rounded-full font-heading font-semibold text-on-primary uppercase tracking-widest shadow-[0_0_15px_rgba(255,184,118,0.3)] hover:shadow-[0_0_25px_rgba(255,184,118,0.5)] focus:bg-primary-container active:bg-primary-container focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background transition ease-in-out duration-150">
                {{ __('Log in') }}
            </button>

            @if (Route::has('password.request'))
                <a class="text-center underline text-sm text-secondary hover:text-on-surface rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-background transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            @if (Route::has('register'))
                <a class="text-center underline text-sm text-secondary hover:text-on-surface rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-background transition-colors" href="{{ route('register') }}">
                    {{ __('Don\'t have an account? Register here') }}
                </a>
            @endif
        </div>
    </form>
</x-guest-layout>
