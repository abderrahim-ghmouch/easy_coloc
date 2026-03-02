<?php

use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\layout;
use function Livewire\Volt\rules;
use function Livewire\Volt\state;

layout('layouts.guest');

state(['email' => '']);

rules(['email' => ['required', 'string', 'email']]);

$sendPasswordResetLink = function () {
    $this->validate();

    // We will send the password reset link to this user. Once we have attempted
    // to send the link, we will examine the response then see the message we
    // need to show to the user. Finally, we'll send out a proper response.
    $status = Password::sendResetLink(
        $this->only('email')
    );

    if ($status != Password::RESET_LINK_SENT) {
        $this->addError('email', __($status));

        return;
    }

    $this->reset('email');

    Session::flash('status', __($status));
};

?>

<div>
    <div class="px-8 pt-10 pb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-2">Forgot password?</h1>
        <p class="text-slate-400">Enter your email and we'll send you a reset link</p>
    </div>

    @if (session('status'))
        <div class="mx-8 mb-4 p-4 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm font-medium">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="sendPasswordResetLink" class="px-8 pb-10 space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email Address')" />
            <x-text-input wire:model="email" id="email" class="block mt-1 w-full h-12 bg-white/5 border-primary/20 focus:border-primary focus:ring-primary/20" type="email" name="email" required autofocus placeholder="name@example.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="pt-2">
            <x-primary-button>
                <span>{{ __('Send Reset Link') }}</span>
                <span class="material-symbols-outlined text-xl">send</span>
            </x-primary-button>
        </div>

        <div class="pt-6 text-center border-t border-white/5">
            <a href="{{ route('login') }}" wire:navigate class="text-sm text-slate-500 hover:text-primary transition-colors font-medium">
                Back to Sign In
            </a>
        </div>
    </form>
</div>
