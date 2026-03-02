<x-app-layout>
    <div class="flex flex-col gap-8">
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight">Profile Settings</h1>
            <p class="text-slate-500 dark:text-primary/60 mt-1">Manage your account information and security</p>
        </div>

        <div class="space-y-8">
            <div class="bg-white/5 border border-primary/20 rounded-2xl shadow-xl overflow-hidden p-8">
                <div class="max-w-2xl">
                    <livewire:profile.update-profile-information-form />
                </div>
            </div>

            <div class="bg-white/5 border border-primary/20 rounded-2xl shadow-xl overflow-hidden p-8">
                <div class="max-w-2xl">
                    <livewire:profile.update-password-form />
                </div>
            </div>

            <div class="bg-white/5 border border-primary/20 rounded-2xl shadow-xl overflow-hidden p-8">
                <div class="max-w-2xl">
                    <livewire:profile.delete-user-form />
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
