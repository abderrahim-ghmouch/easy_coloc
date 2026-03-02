<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['password' => '']);

rules(['password' => ['required', 'string']]);

$confirmPassword = function () {
    $this->validate();

    if (! Auth::guard('web')->validate([
        'email' => Auth::user()->email,
        'password' => $this->password,
    ])) {
        throw ValidationException::withMessages([
            'password' => __('auth.password'),
        ]);
    }

    session(['auth.password_confirmed_at' => time()]);

    $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
};

?>

<div>
    <div class="px-8 pt-10 pb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-2">Secure Area</h1>
        <p class="text-slate-400">Please confirm your password to continue</p>
    </div>

    <form wire:submit="confirmPassword" class="px-8 pb-10 space-y-6">
        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                <span>{{ __('Confirm Password') }}</span>
                <span class="material-symbols-outlined text-xl">lock_open</span>
            </x-primary-button>
        </div>
    </form>
</div>
