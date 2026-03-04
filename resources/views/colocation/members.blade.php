@extends('layouts.app')

@section('title', 'Infrastructure | EasyColoc')

@section('content')
    @php
        $is_owner = auth()->user()->id == $colocation->owner->user_id;
    @endphp
    <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-12 flex flex-col gap-12">
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-3 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">
            <a class="hover:text-white transition-colors" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <a class="hover:text-white transition-colors" href="{{ route('colocation.show', $colocation->id) }}">Unit Portal</a>
            <span class="material-symbols-outlined text-xs">chevron_right</span>
            <span class="text-white">Entities</span>
        </nav>

        @if (!$is_active)
            <div class="p-6 rounded-2xl glass modern-border border-red-500/20 bg-red-500/5">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-[0.2em] flex items-center gap-2">
                    <span class="material-symbols-outlined text-sm">terminal</span>
                    System Integration Severed / Unit Inactive
                </p>
            </div>
        @endif

        <!-- Hero Section -->
        <section class="flex flex-col md:flex-row md:items-end justify-between gap-12">
            <div class="max-w-3xl space-y-6">
                <h1 class="text-5xl md:text-7xl font-display font-black text-white tracking-tighter leading-none">
                    Infrastructure <span class="text-neutral-500">Nodes</span>
                </h1>
                <p class="text-lg text-neutral-400 font-body leading-relaxed max-w-xl">
                    Manage entity synchronization, monitor reputation metrics, and calibrate node permissions within this workspace framework.
                </p>
            </div>
            @if ($is_owner)
                <button @disabled(!$is_active) onclick="showAddInvitationModal()"
                    class="btn-modern px-10 py-5 flex items-center gap-3 group">
                    <span class="material-symbols-outlined text-xl group-hover:rotate-90 transition-transform">add</span>
                    <span>Synchronize New Entity</span>
                </button>
            @endif
        </section>

        <!-- Members Grid -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
            @foreach ($members as $member)
                <div class="group glass modern-border rounded-3xl p-8 relative overflow-hidden flex flex-col">
                    <!-- Status Header -->
                    <div class="flex justify-between items-start mb-10">
                        <div class="w-16 h-16 rounded-2xl border border-white/5 bg-neutral-900 flex items-center justify-center text-white italic text-xl">
                            {{ substr($member->user->name, 0, 1) }}
                        </div>
                        @if ($member->role == 'Owner')
                            <span class="px-3 py-1 rounded-full bg-white text-black text-[8px] font-bold uppercase tracking-widest">Administrator</span>
                        @else
                            <span class="px-3 py-1 rounded-full border border-white/10 text-neutral-400 text-[8px] font-bold uppercase tracking-widest">Verified Node</span>
                        @endif
                    </div>

                    <!-- Entity Info -->
                    <div class="space-y-2 mb-10">
                        <h3 class="text-2xl font-display font-bold text-white tracking-tight group-hover:text-neutral-300 transition-colors">
                            {{ $member->user->name }}
                        </h3>
                        <p class="text-[10px] text-neutral-500 uppercase tracking-[0.2em] font-bold">
                            {{ $member->user->email }}
                        </p>
                    </div>

                    <!-- Metrics -->
                    <div class="grid grid-cols-2 gap-4 pt-10 border-t border-white/5">
                        <div class="space-y-1">
                            <p class="text-[8px] text-neutral-600 uppercase font-black tracking-widest">Trust Metric</p>
                            <div class="flex items-center gap-2 text-white font-display font-bold">
                                <span class="material-symbols-outlined text-sm text-neutral-500">terminal</span>
                                {{ $member->user->reputation }}
                            </div>
                        </div>
                        <div class="space-y-1">
                            <p class="text-[8px] text-neutral-600 uppercase font-black tracking-widest">Sync Balance</p>
                            <p class="font-display font-bold text-lg @if ($member->sold >= 0) text-emerald-500 @else text-white @endif">
                                {{ number_format($member->sold, 2) }}€
                            </p>
                        </div>
                    </div>

                    <!-- Actions -->
                    @if ($member->role == 'Member' && $is_owner)
                        <div class="mt-8 pt-8 border-t border-white/[0.03]">
                            <button @disabled(!$is_active) onclick="showRemoveMemberModal({{ $colocation->id }}, {{ $member->id }})"
                                class="w-full btn-outline py-4 text-[10px] text-red-500 hover:bg-red-500 hover:text-white border-red-500/20">
                                Excise Entity
                            </button>
                        </div>
                    @endif

                    <!-- Subtle background logo -->
                    <div class="absolute -bottom-10 -right-10 opacity-[0.02] group-hover:opacity-[0.05] transition-opacity">
                        <span class="material-symbols-outlined text-[120px]">hub</span>
                    </div>
                </div>
            @endforeach
        </section>
    </main>
@endsection

@section('modals')
    @php
        $is_there_add_invitation_errors = $errors->addInvitation->any();
    @endphp
    <!-- Invitation Modal -->
    <div id="invite-member-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 @if (!$is_there_add_invitation_errors) hidden @endif">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="{{ route('invite.invite', $colocation->id) }}" method="POST" class="p-10 space-y-10">
                @csrf
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Access Provisioning</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Initialize synchronization protocol for new entity.</p>
                    </div>
                    <button onclick="closeAddInvitationModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Infrastructure Email</label>
                        <input name="email" value="{{ old('email') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="node@protocol.io" type="email" />
                        @error('email', 'addInvitation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Synchronization Log</label>
                        <textarea name="message"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors resize-none"
                            placeholder="Initializing workspace integration..." rows="4">{{ old('message') }}</textarea>
                        @error('message', 'addInvitation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeAddInvitationModal()" type="button" class="btn-outline flex-1 py-4">Abort</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Grant Access</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Exclusion Modal -->
    <div id="remove-member-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
                    <span class="material-symbols-outlined text-4xl">block</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Sever Integration?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        You are about to excise this entity from the local network. Historical ledger entries will remain archived for audit purposes.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <form class="w-full" action="" method="post">
                        @csrf
                        <button class="btn-modern w-full py-4 bg-red-500 text-white hover:bg-red-600 border-none">Confirm Exclusion</button>
                    </form>
                    <button onclick="closeRemoveMemberModal()" class="btn-outline w-full py-4">Maintain Node</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showAddInvitationModal() {
            const modal = document.getElementById('invite-member-modal');
            modal.classList.remove('hidden');
        }

        function closeAddInvitationModal() {
            const modal = document.getElementById('invite-member-modal');
            const form = modal.querySelector('form');
            form.reset();
            modal.classList.add('hidden');
        }

        function showRemoveMemberModal(id, memberId) {
            const modal = document.getElementById('remove-member-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('colocation.removeMember', [':id', ':memberId']) }}".replace(':id', id).replace(':memberId', memberId);
            modal.classList.remove('hidden');
        }

        function closeRemoveMemberModal() {
            const modal = document.getElementById('remove-member-modal');
            const form = modal.querySelector('form');
            form.action = "";
            modal.classList.add('hidden');
        }
    </script>
@endsection
