<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <input id="remember_me" type="checkbox" class="rounded border-border-dark bg-background-dark text-white focus:ring-0 focus:ring-offset-0" name="remember">
                <span class="ms-3 text-[10px] font-bold uppercase tracking-widest text-neutral-500 group-hover:text-white transition-colors">{{ __('Remember credentials') }}</span>
            </label>
        </div>

        <div class="mt-10 space-y-6">
            <x-primary-button>
                {{ __('Login') }}
            </x-primary-button>

            <div class="flex items-center justify-between gap-4">
                <a class="text-xs font-semibold text-neutral-500 hover:text-white transition-colors" href="{{ route('register') }}">
                    {{ __('Create an account') }}
                </a>

                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-neutral-500 hover:text-white transition-colors" href="{{ route('password.request') }}">
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
        </div>
    </form>
</x-guest-layout>
