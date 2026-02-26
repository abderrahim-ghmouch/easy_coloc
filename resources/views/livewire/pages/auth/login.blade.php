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



<div >

        <div class="px-8 pt-10 pb-6 text-center">
            <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">Welcome back</h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400">Log in to your EasyColoc account</p>
        </div>

        <x-auth-session-status class="mb-4 px-8" :status="session('status')" />

        <form wire:submit="login" class="px-8 pb-10 space-y-5">
            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                <input wire:model="form.email" class="w-full bg-background-light dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg h-12 px-4 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" type="email" placeholder="alex@example.com" required autofocus />
                <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
            </div>

            <div>
                <div class="flex items-center justify-between mb-1.5">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300">Password</label>
                    @if (Route::has('password.request'))
                        <a class="text-xs font-bold text-primary hover:underline" href="{{ route('password.request') }}" wire:navigate>Forgot?</a>
                    @endif
                </div>
                <input wire:model="form.password" class="w-full bg-background-light dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg h-12 px-4 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" type="password" placeholder="••••••••" required />
                <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
                </div>
                
            <button class="w-full bg-primary hover:bg-opacity-90 text-background-dark h-12 rounded-lg font-bold text-base shadow-lg shadow-primary/20 transition-all" type="submit">
                Log in
            </button>

            <div class="pt-4 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    New to EasyColoc?
                    <a href="{{ route('register') }}" wire:navigate class="text-primary font-bold hover:underline ml-1">Create account →</a>
                </p>
            </div>
        </form>
    </div>

