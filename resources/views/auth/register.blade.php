<x-guest-layout>
    <!-- Heading -->
    <div class="mb-8 text-center">
        <h2 class="text-3xl font-heading font-bold text-on-surface mb-2">Join Aura Brew</h2>
        <p class="text-secondary text-sm">Create an account to start your journey</p>
    </div>

    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="full_name" class="block font-medium text-sm text-secondary">{{ __('Name') }}</label>
            <input id="full_name" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm" type="text" name="full_name" :value="old('full_name')" required autofocus autocomplete="name" placeholder="Full Name" />
            <x-input-error :messages="$errors->get('full_name')" class="mt-2 text-error" />
        </div>

        <!-- Email Address -->
        <div class="mt-5">
            <label for="email" class="block font-medium text-sm text-secondary">{{ __('Email') }}</label>
            <input id="email" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Email Address" />
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-error" />
        </div>

        <!-- Password -->
        <div class="mt-5">
            <label for="password" class="block font-medium text-sm text-secondary">{{ __('Password') }}</label>
            <input id="password" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm"
                            type="password"
                            name="password"
                            required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-error" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-5">
            <label for="password_confirmation" class="block font-medium text-sm text-secondary">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" class="block mt-2 w-full bg-white/[0.04] border border-white/10 rounded-lg text-on-surface placeholder-secondary/50 focus:border-primary focus:ring focus:ring-primary/30 focus:bg-white/[0.08] transition-colors shadow-sm"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-error" />
        </div>

        <div class="flex flex-col mt-8 gap-4">
            <button type="submit" class="w-full inline-flex justify-center items-center px-6 py-3 bg-gradient-to-r from-primary to-primary-container border border-transparent rounded-full font-heading font-semibold text-on-primary uppercase tracking-widest shadow-[0_0_15px_rgba(255,184,118,0.3)] hover:shadow-[0_0_25px_rgba(255,184,118,0.5)] focus:bg-primary-container active:bg-primary-container focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 focus:ring-offset-background transition ease-in-out duration-150">
                {{ __('Register') }}
            </button>

            <a class="text-center underline text-sm text-secondary hover:text-on-surface rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary focus:ring-offset-background transition-colors" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
