<?php
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state([
    'name' => '',
    'email' => '',
    'password' => '',
    'password_confirmation' => ''
]);

rules([
    'name' => ['required', 'string', 'max:255'],
    'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
    'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
]);

$register = function () {
    $validated = $this->validate();
    $validated['password'] = Hash::make($validated['password']);
    event(new Registered($user = User::create($validated)));
    Auth::login($user);
    $this->redirect(route('dashboard', absolute: false), navigate: true);
};
?>
<div>
    <div class="px-8 pt-10 pb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-2">Create account</h1>
        <p class="text-slate-400">Join EasyColoc today</p>
    </div>

    <form wire:submit="register" class="px-8 pb-10 space-y-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Full Name')" />
            <x-text-input wire:model="name" id="name" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="John Doe" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input wire:model="password" id="password" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                <span>{{ __('Create Account') }}</span>
                <span class="material-symbols-outlined text-xl">person_add</span>
            </x-primary-button>
        </div>

        <div class="pt-6 text-center border-t border-white/5">
            <p class="text-sm text-slate-500">
                Already have an account?
                <a href="{{ route('login') }}" wire:navigate class="text-primary font-bold hover:text-primary/80 transition-colors ml-1">
                    Sign in here
                </a>
            </p>
        </div>
    </form>
</div>

