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
            <h1 class="text-3xl font-black tracking-tight text-slate-900 dark:text-slate-100">Create account</h1>
            <p class="mt-2 text-slate-500 dark:text-slate-400 font-normal">Join EasyColoc to manage your flatshare effortlessly</p>
        </div>


        <form wire:submit="register" class="px-8 pb-10 space-y-5">

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Name</label>
                <input wire:model="name" class="w-full bg-background-light dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg h-12 px-4 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="Enter your name" type="text"/>
                @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Email Address</label>
                <input wire:model="email" class="w-full bg-background-light dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg h-12 px-4 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" placeholder="alex@example.com" type="email"/>
                @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Password</label>
                <input wire:model="password" class="w-full bg-background-light dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg h-12 px-4 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" type="password"/>
                @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-slate-700 dark:text-slate-300 mb-1.5">Confirm Password</label>
                <input wire:model="password_confirmation" class="w-full bg-background-light dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-lg h-12 px-4 text-sm focus:ring-2 focus:ring-primary outline-none transition-all" type="password"/>
            </div>

            <button class="w-full bg-primary hover:bg-opacity-90 text-background-dark h-12 rounded-lg font-bold text-base shadow-lg shadow-primary/20 transition-all" type="submit">
                Create Account
            </button>

            <div class="pt-4 text-center">
                <p class="text-sm text-slate-600 dark:text-slate-400">
                    Already have an account?
                    <a href="{{ route('login') }}" wire:navigate class="text-primary font-bold hover:underline ml-1 inline-flex items-center gap-1">
                        Back to login
                    </a>
                </p>
            </div>
        </form>
    </div>

