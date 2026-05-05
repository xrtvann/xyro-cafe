<x-guest-layout>
    <!-- Heading -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-heading font-bold text-on-surface mb-2">Reset Password</h2>
        <p class="text-secondary text-sm">We'll help you get back to your account</p>
    </div>

    <div class="mb-6 text-sm text-secondary leading-relaxed">
        {{ __('Forgot your password? No problem. Just let us know your email address and we will email you a password reset link that will allow you to choose a new one.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email" class="block font-medium text-sm text-secondary">{{ __('Email') }}</label>
            <input id="email" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm" type="email" name="email" :value="old('email')" required autofocus placeholder="Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-error" />
        </div>

        <div class="flex flex-col mt-8 gap-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-primary to-primary-container border border-transparent rounded-full font-heading font-semibold text-on-primary uppercase tracking-widest shadow-[0_0_15px_rgba(255,184,118,0.3)] hover:shadow-[0_0_25px_rgba(255,184,118,0.5)] focus:bg-primary-container active:bg-primary-container focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background transition ease-in-out duration-150">
                {{ __('Email Password Reset Link') }}
            </button>

            <a class="text-center underline text-sm text-secondary hover:text-on-surface rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-background transition-colors" href="{{ route('login') }}">
                {{ __('Back to login') }}
            </a>
        </div>
    </form>
</x-guest-layout>
