@extends('layouts.app')

@section('title', 'Group Dashboard | EasyColoc')

@section('content')
    @php
        $is_owner = auth()->user()->id == $colocation->owner->user_id;
        $member = $currentMember;
    @endphp
    <main class="mx-auto w-full max-w-7xl flex-1 px-6 py-12 flex flex-col gap-12">
        @if (!$is_active)
            <div class="p-4 rounded-xl border border-red-500/20 bg-red-500/5 text-xs font-bold text-red-500 uppercase tracking-widest flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
                Group inactive
            </div>
        @endif

        <!-- Group Header -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-8">
            <div class="space-y-4">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded bg-white/10 text-white text-[10px] font-bold uppercase tracking-widest border border-white/10">Group #{{ $colocation->id }}</span>
                    @if($is_active)
                        <span class="px-3 py-1 rounded bg-emerald-500/10 text-emerald-500 text-[10px] font-bold uppercase tracking-widest border border-emerald-500/20">Active</span>
                    @endif
                </div>
                <h1 class="text-5xl md:text-7xl font-display font-black text-white tracking-tighter">{{ $colocation->name }}</h1>
                <p class="text-lg text-neutral-400 font-body max-w-2xl leading-relaxed">{{ $colocation->description }}</p>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                @if ($member->role === 'Owner')
                    <button onclick="showInviteModal()" class="btn-outline px-6 py-3 text-xs bg-white text-black hover:bg-neutral-200 border-none">
                        <span class="material-symbols-outlined text-sm">person_add</span>
                        <span>Invite Roommate</span>
                    </button>
                    <a href="{{ route('colocation.category.index', $colocation->id) }}" class="btn-outline px-6 py-3 text-xs">
                        <span class="material-symbols-outlined text-sm">category</span>
                        <span>Categories</span>
                    </a>
                @endif
                <button onclick="showAddExpenseModal()" class="btn-modern px-8 py-3 text-xs">
                    <span class="material-symbols-outlined text-sm">add</span>
                    <span>Add Expense</span>
                </button>
            </div>
        </div>

        <!-- Quick Stats -->
        <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="p-8 rounded-3xl glass modern-border border-white/5 space-y-2">
                <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest">Total Spent</p>
                <p class="text-4xl font-display font-bold text-white tracking-tighter">{{ number_format($total_amount, 2) }}€</p>
            </div>
            <div class="p-8 rounded-3xl glass modern-border border-white/5 space-y-2">
                <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest">My Balance</p>
                <p class="text-4xl font-display font-bold tracking-tighter @if ($sold >= 0) text-emerald-500 @else text-red-500 @endif">
                    {{ number_format($sold, 2) }}€
                </p>
            </div>
            <div class="p-8 rounded-3xl glass modern-border border-white/5 space-y-2">
                <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest">My Spending</p>
                <p class="text-4xl font-display font-bold text-white tracking-tighter">{{ number_format($member->createdExpenses->sum('amount'), 2) }}€</p>
            </div>
            <div class="p-8 rounded-3xl glass modern-border border-white/5 space-y-2">
                <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-widest">Roommates</p>
                <p class="text-4xl font-display font-bold text-white tracking-tighter">{{ $colocation->activeMembers->count() }}</p>
            </div>
        </section>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            <!-- Left Side: Roommates & Governance -->
            <div class="lg:col-span-4 space-y-12">
                <!-- Roommates Section -->
                <section class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-500">Roommates</h3>
                        <a href="{{ route('colocation.members', $colocation->id) }}" class="text-[10px] font-bold text-neutral-400 hover:text-white transition-colors underline underline-offset-4">Manage All</a>
                    </div>
                    
                    <div class="grid gap-3">
                        @foreach ($colocation->activeMembers as $m)
                            <div class="flex items-center justify-between p-4 glass modern-border rounded-2xl group transition-all hover:bg-white/[0.02]">
                                <div class="flex items-center gap-4">
                                    <div class="size-10 rounded-xl bg-neutral-900 border border-white/5 flex items-center justify-center text-xs font-bold text-neutral-400">
                                        {{ substr($m->user->name, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <p class="text-sm font-bold text-white">{{ $m->user->name }}</p>
                                            @if($m->role === 'Owner')
                                                <span class="material-symbols-outlined text-[12px] text-white" title="Group Owner">verified</span>
                                            @endif
                                        </div>
                                        <p class="text-[10px] text-neutral-500 font-medium">{{ $m->role }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="text-xs font-bold @if($m->owed >= 0) text-emerald-500 @else text-red-500 @endif">
                                        {{ number_format($m->owed ?? 0, 2) }}€
                                    </p>
                                    <p class="text-[8px] uppercase tracking-widest text-neutral-600 font-bold">Balance</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>

                <!-- Governance Section -->
                <section class="space-y-6">
                    <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-500 flex items-center gap-2">
                        <span class="material-symbols-outlined text-sm">shield</span>
                        Group Settings
                    </h3>
                    <div class="p-8 rounded-3xl glass modern-border border-white/5 space-y-6">
                        @if ($is_owner)
                            <p class="text-sm text-neutral-400 leading-relaxed font-body">
                                As the owner, you can delete this group. This will permanently remove all data and expenses.
                            </p>
                            <button @disabled(!$is_active) onclick="showDisactivateModal({{ $colocation->id }})"
                                class="btn-outline w-full py-4 text-xs font-bold text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white transition-all uppercase tracking-widest">
                                Delete Group
                            </button>
                        @else
                            <p class="text-sm text-neutral-400 leading-relaxed font-body">
                                You can leave this group at any time. Please ensure all your debts are settled before leaving.
                            </p>
                            <button @disabled(!$is_active) onclick="showLeaveModal({{ $colocation->id }})"
                                class="btn-outline w-full py-4 text-xs font-bold text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white transition-all uppercase tracking-widest">
                                Leave Group
                            </button>
                        @endif
                    </div>
                </section>
            </div>

            <!-- Right Side: Money to Settle -->
            <div class="lg:col-span-8 space-y-12">
                <section class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-xs font-bold uppercase tracking-widest text-neutral-500">Money to Settle</h3>
                        <div class="h-px flex-1 bg-white/5 mx-6"></div>
                    </div>

                    <div class="grid gap-4">
                        @php
                            $has_pending = false;
                        @endphp
                        @foreach ($expenses as $expense)
                            @foreach ($expense->details as $detail)
                                @if($detail->debtor_member_id == $member->id || $expense->creator_member_id == $member->id)
                                    @php $has_pending = true; @endphp
                                    <div class="group flex flex-col sm:flex-row sm:items-center justify-between p-6 glass modern-border rounded-3xl transition-all hover:bg-white/[0.03]">
                                        <div class="flex items-center gap-5">
                                            <div class="size-12 rounded-2xl bg-neutral-900 flex items-center justify-center border border-white/5">
                                                <span class="material-symbols-outlined text-neutral-500 group-hover:text-white transition-colors">
                                                    @if($detail->status === 'PAID') check_circle @else pending @endif
                                                </span>
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-3">
                                                    <h4 class="text-lg font-bold text-white">{{ $expense->title }}</h4>
                                                    <span class="text-[10px] px-2 py-0.5 rounded border border-white/10 text-neutral-400">{{ $expense->category->name }}</span>
                                                </div>
                                                <p class="text-xs text-neutral-500 mt-1">
                                                    @if($expense->creator_member_id == $member->id)
                                                        @if($detail->status === 'PAID')
                                                            <span class="text-emerald-500 font-bold">{{ $detail->debtor->user->name }} paid you</span>
                                                        @else
                                                            <span class="text-emerald-500 font-bold">You are owed</span> by {{ $detail->debtor->user->name }}
                                                        @endif
                                                    @else
                                                        @if($detail->status === 'PAID')
                                                            <span class="text-neutral-500 font-bold">You paid</span> {{ $expense->creator->user->name }}
                                                        @else
                                                            <span class="text-red-500 font-bold">You owe</span> {{ $expense->creator->user->name }}
                                                        @endif
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                        
                                        <div class="mt-6 sm:mt-0 flex items-center gap-8 justify-between sm:justify-end">
                                            <div class="text-right">
                                                <p class="text-xl font-display font-black text-white">{{ number_format($detail->amount, 2) }}€</p>
                                                <p class="text-[8px] uppercase tracking-widest font-bold {{ $detail->status === 'PAID' ? 'text-emerald-500' : 'text-neutral-600' }}">
                                                    {{ $detail->status }}
                                                </p>
                                            </div>

                                            @if($expense->creator_member_id == $member->id && $detail->status === 'PENDING')
                                                <form action="{{ route('colocation.detail.mark-paid', [$colocation->id, $detail->id]) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button class="px-5 py-2.5 bg-white text-black text-[10px] font-bold uppercase tracking-widest rounded-xl hover:bg-neutral-200 transition-all">
                                                        Accept Payment
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        @endforeach

                        @if(!$has_pending)
                            <div class="py-12 border-2 border-dashed border-neutral-900 rounded-3xl text-center">
                                <p class="text-neutral-600 italic">No settleable amounts found for this period.</p>
                            </div>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </main>
@endsection

@section('modals')
    <!-- Invitation Modal -->
    <div id="invite-member-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="{{ route('invite.invite', $colocation->id) }}" method="POST" class="p-10 space-y-10">
                @csrf
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Invite Roommate</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Send an email invitation to a new group member.</p>
                    </div>
                    <button onclick="closeInviteModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-xs font-semibold text-neutral-500">Email Address</label>
                        <input name="email" value="{{ old('email') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="roommate@example.com" type="email" />
                        @error('email', 'addInvitation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-xs font-semibold text-neutral-500">Personal Note</label>
                        <textarea name="message"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors resize-none"
                            placeholder="Hey! Join our colocation group..." rows="4">{{ old('message') }}</textarea>
                        @error('message', 'addInvitation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeInviteModal()" type="button" class="btn-outline flex-1 py-4">Cancel</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Send Invitation</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Expense Modal -->
    <div id="add-expense-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="{{ route('expense.store') }}" method="POST" class="p-10 space-y-10">
                @csrf
                <input type="hidden" name="colocation_id" value="{{ $colocation->id }}">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Add Expense</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Log a new purchase for the group.</p>
                    </div>
                    <button onclick="closeAddExpenseModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-xs font-semibold text-neutral-500">What was it for?</label>
                        <input name="title" value="{{ old('title') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="Groceries, Internet, Pizza night..." type="text" />
                        @error('title', 'addExpense')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-xs font-semibold text-neutral-500">Category</label>
                            <select name="category_id"
                                class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white focus:border-white focus:ring-0 transition-colors">
                                <option disabled="" selected="" value="">Selection...</option>
                                @foreach ($colocation->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="text-xs font-semibold text-neutral-500">Amount (€)</label>
                            <input name="amount" value="{{ old('amount') }}"
                                class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                                placeholder="0.00" step="0.01" type="number" />
                            @error('amount', 'addExpense')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeAddExpenseModal()" type="button" class="btn-outline flex-1 py-4">Cancel</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Save Expense</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Group Modal -->
    <div id="desactivate-colocation-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
                    <span class="material-symbols-outlined text-4xl">warning</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Delete Group?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        This will permanently delete the group and all its records. This action cannot be undone.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <form action="{{ route('colocation.destroy', $colocation->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern w-full py-4 bg-red-500 text-white hover:bg-red-600 border-none">Confirm Delete</button>
                    </form>
                    <button onclick="closeDisactivateModal()" class="btn-outline w-full py-4">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Leave Group Modal -->
    <div id="left-colocation-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mx-auto text-white">
                    <span class="material-symbols-outlined text-4xl">logout</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Leave Group?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        You are about to leave this group. Please make sure you have settled all your pending debts.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <form action="{{ route('colocation.leave', $colocation->id) }}" method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern w-full py-4">Confirm Leave</button>
                    </form>
                    <button onclick="closeLeaveModal()" class="btn-outline w-full py-4">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showInviteModal() {
            document.getElementById('invite-member-modal').classList.remove('hidden');
        }
        function closeInviteModal() {
            document.getElementById('invite-member-modal').classList.add('hidden');
        }
        function showAddExpenseModal() {
            document.getElementById('add-expense-modal').classList.remove('hidden');
        }
        function closeAddExpenseModal() {
            document.getElementById('add-expense-modal').classList.add('hidden');
        }
        function showDisactivateModal() {
            document.getElementById('desactivate-colocation-modal').classList.remove('hidden');
        }
        function closeDisactivateModal() {
            document.getElementById('desactivate-colocation-modal').classList.add('hidden');
        }
        function showLeaveModal() {
            document.getElementById('left-colocation-modal').classList.remove('hidden');
        }
        function closeLeaveModal() {
            document.getElementById('left-colocation-modal').classList.add('hidden');
        }
    </script>
@endsection
