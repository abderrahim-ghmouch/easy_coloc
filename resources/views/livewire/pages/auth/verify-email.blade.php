<?php

use App\Livewire\Actions\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

use function Livewire\Volt\layout;

layout('layouts.guest');

$sendVerification = function () {
    if (Auth::user()->hasVerifiedEmail()) {
        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);

        return;
    }

    Auth::user()->sendEmailVerificationNotification();

    Session::flash('status', 'verification-link-sent');
};

$logout = function (Logout $logout) {
    $logout();

    $this->redirect('/', navigate: true);
};

?>

<div>
    <div class="px-8 pt-10 pb-6 text-center">
        <h1 class="text-3xl font-extrabold tracking-tight text-white mb-2">Verify email</h1>
        <p class="text-slate-400">Please check your inbox to continue</p>
    </div>

    <div class="px-8 pb-4 text-sm text-slate-400 text-center">
        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mx-8 mb-4 p-4 bg-primary/10 border border-primary/20 rounded-xl text-primary text-sm font-medium text-center">
            {{ __('A new verification link has been sent to the email address you provided during registration.') }}
        </div>
    @endif

    <div class="px-8 pb-10 flex flex-col gap-4 items-center">
        <x-primary-button wire:click="sendVerification">
            <span>{{ __('Resend Email') }}</span>
            <span class="material-symbols-outlined text-xl">forward_to_inbox</span>
        </x-primary-button>

        <button wire:click="logout" type="submit" class="text-sm text-slate-500 hover:text-primary transition-colors font-medium">
            {{ __('Log Out') }}
        </button>
    </div>
</div>
