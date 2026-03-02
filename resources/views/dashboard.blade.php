<x-app-layout>
    <div class="flex flex-col gap-8">
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div class="flex flex-col gap-1">
                <h1 class="text-3xl font-extrabold tracking-tight">My Flatshares</h1>
                <p class="text-slate-500 dark:text-primary/60">Manage your current and past residential histories</p>
            </div>
            <button type="button" onclick="toggleModal('colocationModal')"
                class="bg-primary hover:bg-primary/90 text-background-dark font-bold px-6 py-3 rounded-xl transition-all flex items-center justify-center gap-2 shadow-lg shadow-primary/20 active:scale-95">
                <span class="material-symbols-outlined">add_circle</span>
                Create New Flatshare
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($colocations as $colocation)
                <div
                    class="bg-white/5 border border-primary/20 rounded-2xl p-6 shadow-xl flex flex-col gap-5 hover:border-primary/40 transition-all relative overflow-hidden group">
                    <div class="absolute top-0 right-0 p-4">
                        <span
                            class="bg-primary/20 text-primary text-[10px] font-bold px-2.5 py-1 rounded-full uppercase tracking-wider flex items-center gap-1">
                            <span class="w-1.5 h-1.5 rounded-full bg-primary @if($colocation->status === 'active') animate-pulse @endif"></span>
                            {{ ucfirst($colocation->status) }}
                        </span>
                    </div>
                    <div class="flex flex-col gap-1 mt-2">
                        <h3 class="text-xl font-bold group-hover:text-primary transition-colors">{{ $colocation->name }}</h3>
                        <p class="text-sm text-slate-500 dark:text-primary/60 flex items-center gap-1">
                            <span class="material-symbols-outlined text-sm">calendar_today</span>
                            {{ $colocation->created_at->format('M Y') }} - Present
                        </p>
                    </div>
                    <div class="grid grid-cols-2 gap-4 py-4 border-y border-white/10">
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Members</span>
                            <div class="flex items-center gap-1 font-semibold">
                                <span class="material-symbols-outlined text-base">group</span>
                                {{ $colocation->members->count() }} Members
                            </div>
                        </div>
                        <div class="flex flex-col gap-1">
                            <span class="text-[10px] uppercase font-bold text-slate-400 dark:text-primary/40">Final Balance</span>
                            <div class="flex items-center gap-1 font-bold text-primary">
                                <span class="material-symbols-outlined text-base">check_circle</span>
                                Settled
                            </div>
                        </div>
                    </div>
                    <button
                        class="w-full bg-primary hover:bg-primary/90 text-background-dark font-bold py-3 rounded-xl transition-all flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">dashboard</span>
                        Enter Dashboard
                    </button>
                </div>
            @empty
                <div class="col-span-full py-20 text-center flex flex-col items-center gap-4">
                    <div class="w-20 h-20 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-4xl">holiday_village</span>
                    </div>
                    <h3 class="text-2xl font-bold text-white">No Flatshares Yet</h3>
                    <p class="text-slate-400 max-w-xs">Start your first adventure by creating a new flatshare!</p>
                    <button onclick="toggleModal('colocationModal')" class="mt-4 text-primary font-bold hover:underline flex items-center gap-2">
                        <span class="material-symbols-outlined">add</span>
                        Create one now
                    </button>
                </div>
            @endforelse
        </div>

    </div>

    <!-- Modal for creating colocation -->
    <div id="colocationModal"
        class="fixed inset-0 z-[60] hidden flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-sidebar-dark w-full max-w-md p-8 rounded-2xl border border-primary/20 shadow-2xl">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-2xl font-bold text-primary">New Flatshare</h3>
                <button onclick="toggleModal('colocationModal')" class="text-slate-400 hover:text-white">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <form method="POST" action="{{ route('colocation.store') }}" class="flex flex-col gap-4">
                @csrf
                <div>
                    <label class="block text-sm font-bold text-primary/60 mb-2 uppercase tracking-wider">Flatshare Name</label>
                    <input type="text" name="title" required placeholder="e.g. The Green Villa"
                        class="w-full px-4 py-3 bg-background-dark border border-primary/20 rounded-xl text-white focus:ring-2 focus:ring-primary outline-none transition-all">
                </div>

                <div class="flex gap-3 mt-4">
                    <button type="button" onclick="toggleModal('colocationModal')"
                        class="flex-1 px-4 py-3 text-slate-400 font-bold hover:text-white transition-all">Cancel</button>
                    <button type="submit"
                        class="flex-1 px-4 py-3 bg-primary text-background-dark font-bold rounded-xl hover:bg-primary/90 transition-all">
                        Create Now
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleModal(modalId) {
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.toggle('hidden');
                document.body.classList.toggle('overflow-hidden');
            }
        }

        window.addEventListener('click', function(event) {
            const modal = document.getElementById('colocationModal');
            if (event.target === modal) {
                toggleModal('colocationModal');
            }
        });
    </script>
</x-app-layout>
