<x-app-layout>
    @section('title', 'Profile Configuration | EasyColoc')

    <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-12">
        <div class="mb-12">
            <h1 class="text-4xl font-display font-bold text-white tracking-tight">Configuration</h1>
            <p class="text-neutral-500 font-body mt-2">Manage your entity credentials and session security.</p>
        </div>

        <div class="space-y-12">
            <section class="glass modern-border rounded-[2rem] p-10 overflow-hidden relative">
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-profile-information-form')
                </div>
                <!-- Subtle background icon -->
                <div class="absolute -right-10 -bottom-10 opacity-[0.03]">
                    <span class="material-symbols-outlined text-[200px]">fingerprint</span>
                </div>
            </section>

            <section class="glass modern-border rounded-[2rem] p-10 overflow-hidden relative">
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.update-password-form')
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-[0.03]">
                    <span class="material-symbols-outlined text-[200px]">lock</span>
                </div>
            </section>

            <section class="glass modern-border rounded-[2rem] p-10 border-red-500/10 overflow-hidden relative">
                <div class="max-w-xl relative z-10">
                    @include('profile.partials.delete-user-form')
                </div>
                <div class="absolute -right-10 -bottom-10 opacity-[0.03] text-red-500">
                    <span class="material-symbols-outlined text-[200px]">dangerous</span>
                </div>
            </section>
        </div>
    </main>
</x-app-layout>
