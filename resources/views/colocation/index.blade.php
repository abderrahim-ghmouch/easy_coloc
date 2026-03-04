@extends('layouts.app')

@section('title', 'Workspaces | EasyColoc')

@section('content')
    <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-12">
        <div class="flex flex-col gap-12">
            <!-- Session Messages -->
            @if (session()->has('addColocationError'))
                <div class="flex flex-col gap-4 bg-red-500/10 border border-red-500/20 p-6 rounded-2xl">
                    <div class="flex items-center gap-3 text-red-500">
                        <span class="material-symbols-outlined">error</span>
                        <h2 class="text-lg font-display font-bold">Execution Error</h2>
                    </div>
                    <p class="text-neutral-400 text-sm font-body">
                        {{ session()->get('addColocationError') }}
                    </p>
                </div>
            @endif

            <!-- Header Section -->
            <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
                <div>
                    <h1 class="text-4xl font-display font-bold text-white tracking-tight">Workspaces</h1>
                    <div class="flex items-center gap-2 mt-2">
                        <div class="h-1.5 w-1.5 rounded-full bg-white opacity-40"></div>
                        <p class="text-neutral-500 text-[10px] font-bold uppercase tracking-[0.2em]">
                            Total Units: {{ $count }}</p>
                    </div>
                </div>
                <div>
                    <button onclick="showCreateModal()" class="btn-modern text-xs">
                        Create Workspace
                    </button>
                </div>
            </div>

            @if ($count > 0)
                <!-- Active Units -->
                <section class="space-y-6">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">bolt</span>
                        Active Subscription
                    </h3>
                    
                    @if ($active)
                        <div class="group relative rounded-2xl glass modern-border overflow-hidden p-8 hover-card">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                                <div class="flex flex-col gap-4">
                                    <div class="flex items-center gap-3">
                                        @if ($active->owner->user_id === auth()->user()->id)
                                            <span class="text-[10px] font-bold bg-white text-black px-2.5 py-1 rounded uppercase tracking-widest">Administrator</span>
                                        @else
                                            <span class="text-[10px] font-bold bg-neutral-800 text-neutral-400 px-2.5 py-1 rounded border border-border-dark uppercase tracking-widest">Member</span>
                                        @endif
                                        <span class="text-[10px] font-bold text-emerald-500 border border-emerald-500/20 px-2.5 py-1 rounded uppercase tracking-widest">Verified</span>
                                    </div>
                                    <div>
                                        <h4 class="text-2xl font-display font-bold text-white">{{ $active->name }}</h4>
                                        <p class="text-neutral-500 font-body text-sm mt-2 max-w-md">{{ $active->description }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4 w-full md:w-auto">
                                    @if ($active->owner->user_id === auth()->user()->id)
                                        <button onclick="showDisactivateModal({{ $active->id }})" class="btn-outline px-4 py-2 text-xs border-red-500/20 text-red-500 hover:bg-red-500 hover:text-white">
                                            Close Unit
                                        </button>
                                    @endif
                                    <a href="{{ route('colocation.show', $active->id) }}" class="btn-modern px-8 py-2.5 text-xs flex-1 md:flex-none">
                                        Access Portal
                                    </a>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-2xl border border-dashed border-border-dark p-12 text-center">
                            <p class="text-neutral-500 font-body italic">No active workspace assigned.</p>
                        </div>
                    @endif
                </section>

                <!-- History Section -->
                <section class="space-y-6 mt-12">
                    <h3 class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">history</span>
                        Archive
                    </h3>
                    <div class="grid grid-cols-1 gap-4">
                        @forelse ($inactives as $inactive)
                            <div class="flex items-center justify-between p-6 rounded-xl modern-border bg-surface-dark/30 group">
                                <div class="flex items-center gap-4 text-neutral-500">
                                    <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-neutral-900 border border-border-dark group-hover:text-white transition-colors">
                                        <span class="material-symbols-outlined">folder_off</span>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="font-bold font-display group-hover:text-white transition-colors">{{ $inactive->name }}</p>
                                            <span class="text-[8px] font-bold px-2 py-0.5 rounded border border-neutral-800 uppercase tracking-widest">Terminated</span>
                                        </div>
                                        <p class="text-[10px] uppercase tracking-wider font-medium opacity-60">Created {{ $inactive->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('colocation.show', $inactive->id) }}" class="h-10 w-10 flex items-center justify-center rounded-full modern-border text-neutral-500 hover:text-white hover:bg-neutral-800 transition-all">
                                    <span class="material-symbols-outlined text-sm">arrow_forward</span>
                                </a>
                            </div>
                        @empty
                            <p class="text-neutral-600 font-body text-sm italic">Archive empty.</p>
                        @endforelse
                    </div>
                </section>
            @else
                <!-- Empty State -->
                <div class="flex flex-col items-center justify-center py-24 text-center">
                    <div class="h-24 w-24 rounded-full bg-surface-dark border border-border-dark flex items-center justify-center mb-8">
                        <span class="material-symbols-outlined text-4xl text-neutral-700">inventory_2</span>
                    </div>
                    <h2 class="text-3xl font-display font-medium text-white mb-4">No workspaces found</h2>
                    <p class="text-neutral-500 max-w-sm mb-12 font-body">Complete your first unit integration to begin managing your shared finances.</p>
                    <div class="flex gap-4">
                        <button onclick="showCreateModal()" class="btn-modern px-8 py-4">
                            Establish Workspace
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </main>
@endsection

@section('modals')
    <!-- Create Modal -->
    <div id="add-colocation-modal" class="fixed inset-0 bg-black/95 flex items-center justify-center z-50 p-6 hidden">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10">
                <div class="flex justify-between items-start mb-10">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">New Workspace</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Initialize your colocation environment.</p>
                    </div>
                    <button onclick="closeCreateModal()" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <form action="{{ route('colocation.store') }}" method="POST" class="space-y-8">
                    @csrf
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Unit Name</label>
                        <input name="name" value="{{ old('name') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="Ex: District 12 / Modern Apartment" type="text" />
                        @error('name', 'addColocation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Internal Directives</label>
                        <textarea name="description"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors resize-none"
                            placeholder="Workspace goals and house rules..." rows="4">{{ old('description') }}</textarea>
                        @error('description', 'addColocation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-4 pt-4">
                        <button onclick="closeCreateModal()" type="button" class="btn-outline flex-1">
                            Cancel
                        </button>
                        <button type="submit" class="btn-modern flex-1">
                            Deploy Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Terminate Modal -->
    <div id="desactivate-colocation-modal" class="fixed inset-0 bg-black/95 flex items-center justify-center z-50 p-6 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl p-10 text-center animate-in fade-in zoom-in duration-300">
            <div class="h-16 w-16 rounded-2xl bg-red-500/10 text-red-500 flex items-center justify-center mx-auto mb-8">
                <span class="material-symbols-outlined text-3xl">warning</span>
            </div>
            <h3 class="text-2xl font-display font-bold text-white mb-4">Terminate Workspace?</h3>
            <p class="text-neutral-500 font-body text-sm mb-10 leading-relaxed">This action will archive all financial data and remove all assigned members. This operation is permanent.</p>
            
            <form method="POST" class="space-y-3">
                @csrf
                @method('DELETE')
                <button class="w-full bg-red-500 text-white rounded-xl py-4 font-bold hover:bg-red-600 transition-colors">
                    Confirm Termination
                </button>
            </form>
            <button onclick="closeDisactivateModal()" class="w-full btn-outline py-4 mt-3 bg-white/5">
                Maintain Workspace
            </button>
        </div>
    </div>

    <script>
        function showCreateModal() {
            document.getElementById('add-colocation-modal').classList.remove('hidden');
        }

        function closeCreateModal() {
            document.getElementById('add-colocation-modal').classList.add('hidden');
        }

        function showDisactivateModal(id) {
            const modal = document.getElementById('desactivate-colocation-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('colocation.destroy', ':id') }}".replace(':id', id);
            modal.classList.remove('hidden');
        }

        function closeDisactivateModal() {
            document.getElementById('desactivate-colocation-modal').classList.add('hidden');
        }
    </script>
@endsection
