<x-app-layout>
    <div class="flex flex-col gap-8">
        <div class="flex flex-col gap-2">
            <h1 class="text-4xl text-primary font-display mb-2">Admin Command Centre</h1>
            <p class="text-slate-400">Manage the EasyColoc community and Oversee all activities.</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            {{-- Users list --}}
            <div class="bg-sidebar-dark border border-primary/20 rounded-2xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-white/10 flex justify-between items-center">
                    <h3 class="text-xl font-display text-accent flex items-center gap-2">
                        <span class="material-symbols-outlined">group</span>
                        Community Members
                    </h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-primary/5 text-[10px] uppercase font-bold text-primary/60 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4">User</th>
                                <th class="px-6 py-4">Email</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($users as $user)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-bold">{{ $user->name }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $user->email }}</td>
                                <td class="px-6 py-4">
                                    @if($user->is_banned)
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-red-500/20 text-red-500">BANNED</span>
                                    @else
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-primary/20 text-primary">ACTIVE</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    @if(!$user->is_admin)
                                        <form action="{{ $user->is_banned ? route('admin.users.unban', $user) : route('admin.users.ban', $user) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="text-[10px] font-bold underline {{ $user->is_banned ? 'text-primary' : 'text-red-500' }}">
                                                {{ $user->is_banned ? 'UNBAN' : 'BAN USER' }}
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Colocations list --}}
            <div class="bg-sidebar-dark border border-primary/20 rounded-2xl overflow-hidden shadow-xl">
                <div class="p-6 border-b border-white/10 flex justify-between items-center">
                    <h3 class="text-xl font-display text-accent flex items-center gap-2">
                        <span class="material-symbols-outlined">home_work</span>
                        Active Flatshares
                    </h3>
                    <button onclick="toggleModal('colocationModal')" class="bg-primary/10 border border-primary/20 text-primary px-3 py-1.5 rounded-lg text-xs font-bold hover:bg-primary hover:text-background-dark transition-all flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">add</span>
                        NEW FLATSHARE
                    </button>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-primary/5 text-[10px] uppercase font-bold text-primary/60 border-b border-white/10">
                            <tr>
                                <th class="px-6 py-4">Flatshare</th>
                                <th class="px-6 py-4">Owner</th>
                                <th class="px-6 py-4">Members</th>
                                <th class="px-6 py-4">Established</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/5">
                            @foreach($colocations as $colocation)
                            <tr class="hover:bg-white/5 transition-colors">
                                <td class="px-6 py-4 font-bold">{{ $colocation->name }}</td>
                                <td class="px-6 py-4 text-slate-400">{{ $colocation->owner?->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4">{{ $colocation->members->count() }}</td>
                                <td class="px-6 py-4 text-slate-500 text-sm">{{ $colocation->created_at->format('M d, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
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
