<?php
use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use function Livewire\Volt\form;
use function Livewire\Volt\layout;

layout('layouts.guest');
form(LoginForm::class);

$login = function () {
    $this->validate();
    $this->form->authenticate();
    Session::regenerate();
    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};
?>



<div>
    <div class="px-8 pt-10 pb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-2">Welcome back</h1>
        <p class="text-slate-400">Log in to your EasyColoc account</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4 px-8" :status="session('status')" />

    <form wire:submit="login" class="px-8 pb-10 space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="form.email" id="email" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-2">
                <x-input-label for="password" :value="__('Password')" class="mb-0" />
                @if (Route::has('password.request'))
                    <a class="text-xs font-bold text-primary hover:text-primary/80 transition-colors" href="{{ route('password.request') }}" wire:navigate>
                        {{ __('Forgot password?') }}
                    </a>
                @endif
            </div>
            <x-text-input wire:model="form.password" id="password" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center">
                    <input wire:model="form.remember" id="remember" type="checkbox" class="rounded bg-white/5 border-primary/20 text-primary focus:ring-primary/20 focus:ring-offset-0" name="remember">
                </div>
                <span class="ms-3 text-sm text-slate-400 group-hover:text-slate-300 transition-colors">{{ __('Keep me logged in') }}</span>
            </label>
        </div>

        <div class="pt-2">
            <x-primary-button>
                <span>{{ __('Sign In') }}</span>
                <span class="material-symbols-outlined text-xl">login</span>
            </x-primary-button>
        </div>

        <div class="pt-6 text-center border-t border-white/5">
            <p class="text-sm text-slate-500">
                New to EasyColoc?
                <a href="{{ route('register') }}" wire:navigate class="text-primary font-bold hover:text-primary/80 transition-colors ml-1">
                    Create an account
                </a>
            </p>
        </div>
    </form>
</div>

