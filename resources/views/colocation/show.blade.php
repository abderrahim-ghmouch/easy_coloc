@extends('layouts.app')

@section('title', 'Unit Portal | EasyColoc')

@section('content')
    @php
        $is_owner = auth()->user()->id == $colocation->owner->user_id;
    @endphp
    <main class="mx-auto w-full max-w-5xl flex-1 px-6 py-12 flex flex-col gap-12">
        @if (!$is_active)
            <div class="p-4 rounded-xl modern-border bg-surface-dark/50 border-red-500/20">
                <p class="text-[10px] font-bold text-red-500 uppercase tracking-[0.2em]">
                    Unit Terminated / Inactive</p>
            </div>
        @endif

        <!-- Portal Header -->
        <section class="flex flex-col md:flex-row justify-between items-start md:items-end gap-8">
            <div class="space-y-2">
                <h1 class="text-5xl font-display font-black tracking-tighter text-white uppercase italic">
                    {{ $colocation->name }}</h1>
                <p class="text-neutral-500 font-body">Centralized Unit Management & Ledger</p>
            </div>
            <div class="flex gap-4 w-full md:w-auto">
                <div class="flex-1 md:min-w-[200px] p-6 rounded-2xl modern-border bg-surface-dark/30 backdrop-blur-sm">
                    <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-[0.2em] mb-2">
                        Cycle Expenditure</p>
                    <p class="text-3xl font-display font-bold text-white tracking-tighter">{{ number_format($total_amount, 2) }}€</p>
                </div>
                <div class="flex-1 md:min-w-[200px] p-6 rounded-2xl glass modern-border border-white/10">
                    <p class="text-[10px] font-bold text-neutral-400 uppercase tracking-[0.2em] mb-2">My Balance</p>
                    <p class="text-3xl font-display font-bold tracking-tighter @if ($sold >= 0) text-emerald-500 @else text-white @endif">
                        {{ number_format($sold, 2) }}€</p>
                </div>
            </div>
        </section>

        <!-- Command Bar -->
        <section class="flex flex-wrap items-center justify-between gap-6 p-6 rounded-2xl modern-border bg-surface-dark/20">
            <div class="flex gap-4 flex-wrap">
                <button @disabled(!$is_active) onclick="showAddExpenseModal()"
                    class="btn-modern px-6 py-3 text-xs">
                    <span class="material-symbols-outlined text-sm">add</span>
                    Append Entry
                </button>
                @if ($is_owner)
                    <button @disabled(!$is_active) onclick="showAddInvitationModal()"
                        class="btn-outline px-6 py-3 text-xs">
                        <span class="material-symbols-outlined text-sm">person_add</span>
                        Grant Access
                    </button>
                    <a href="{{ route('colocation.category.index', $colocation->id) }}"
                        class="btn-outline px-6 py-3 text-xs">
                        <span class="material-symbols-outlined text-sm">category</span>
                        Schema Categories
                    </a>
                @endif
            </div>
            <a href="{{ route('colocation.members', $colocation->id) }}"
                class="text-[10px] font-bold text-neutral-400 hover:text-white transition-colors uppercase tracking-[0.2em] flex items-center gap-2">
                View Infrastructure <span class="material-symbols-outlined text-xs">arrow_forward</span>
            </a>
        </section>

        <!-- Dynamic Ledger -->
        <section class="space-y-6">
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-display font-bold text-white flex items-center gap-3">
                    <span class="material-symbols-outlined text-neutral-500">receipt_long</span>
                    Unit Ledger
                </h3>
                <div class="relative">
                    <form action="" method="get" onchange="this.submit()">
                        <input type="month" name="month-year" value="{{ request('month-year') }}"
                            class="rounded-lg border border-border-dark bg-background-dark px-4 py-2 text-xs font-medium focus:border-white focus:ring-0 transition-colors"
                            id="month-select" />
                    </form>
                </div>
            </div>

            <div class="overflow-hidden rounded-2xl modern-border bg-surface-dark/30 backdrop-blur-sm">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-dark/50 border-b border-border-dark">
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Entry</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Category</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Amount</th>
                            <th class="px-8 py-5 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Operator</th>
                            <th class="px-8 py-5 text-right text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border-dark font-body">
                        @forelse ($expenses as $expense)
                            <tr class="group hover:bg-white/[0.02] transition-colors">
                                <td class="px-8 py-6 font-medium text-white">{{ $expense->title }}</td>
                                <td class="px-8 py-6">
                                    <span class="px-2 py-0.5 rounded border border-neutral-800 text-[8px] font-bold uppercase tracking-widest text-neutral-400 group-hover:border-neutral-700 transition-colors">
                                        {{ $expense->category->name }}
                                    </span>
                                </td>
                                <td class="px-8 py-6 font-display font-medium text-lg text-white">
                                    {{ number_format($expense->amount, 2) }}€
                                </td>
                                <td class="px-8 py-6">
                                    <div class="flex items-center gap-3 text-neutral-500 group-hover:text-neutral-300 transition-colors">
                                        <div class="w-2 h-2 rounded-full border border-current"></div>
                                        <span class="text-xs uppercase tracking-wider">{{ $expense->creator->user->name }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-6 text-right">
                                    <div class="flex justify-end gap-2">
                                        <button onclick='showExpenseDetailsModal({{ $colocation->id }}, {{ auth()->id() }}, @json($expense->details), {{ $expense->details->count() }}, "{{ $expense->title }}", "{{ $expense->amount }}", "{{ $expense->category->name }}")'
                                            class="p-2 hover:bg-white/5 rounded-lg text-neutral-500 hover:text-white transition-all">
                                            <span class="material-symbols-outlined text-sm">visibility</span>
                                        </button>
                                        @if ($expense->creator->user_id == auth()->id())
                                            <button @disabled(!$is_active)
                                                onclick="showEditExpenseModal({{ $expense->id }}, '{{ $expense->title }}', {{ $expense->category_id }}, {{ $expense->amount }})"
                                                class="p-2 hover:bg-white/5 rounded-lg text-neutral-500 hover:text-white transition-all">
                                                <span class="material-symbols-outlined text-sm">edit</span>
                                            </button>
                                            <button @disabled(!$is_active)
                                                onclick="showDeleteExpenseModal({{ $expense->id }}, '{{ $expense->title }}', '{{ $expense->amount }}', '{{ $expense->category->name }}')"
                                                class="p-2 hover:bg-white/5 rounded-lg text-neutral-500 hover:text-red-500 transition-all">
                                                <span class="material-symbols-outlined text-sm">delete</span>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-8 py-16 text-center text-neutral-600 italic font-body">No ledger records found for this cycle.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <!-- Analytics & Controls -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-12">
            <div class="space-y-6">
                <h3 class="text-xl font-display font-bold text-white flex items-center gap-3">
                    <span class="material-symbols-outlined text-neutral-500">analytics</span>
                    Balance Architecture
                </h3>
                <div class="space-y-3 font-body">
                    @forelse ($colocation->members as $member)
                        <div class="flex items-center justify-between p-6 rounded-2xl modern-border bg-surface-dark/20">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-xl bg-neutral-900 border border-border-dark flex items-center justify-center text-neutral-500 italic">
                                    {{ substr($member->user->name, 0, 1) }}
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-sm font-bold text-white">{{ $member->user->name }}</p>
                                    <p class="text-[10px] text-neutral-500 uppercase tracking-widest mt-1">
                                        @if ($member->owed > 0) Debit Expected @elseif($member->owed < 0) Credit Pending @else Neutral Status @endif
                                    </p>
                                </div>
                            </div>
                            <span class="font-display font-medium tracking-tighter text-lg @if ($member->owed > 0) text-emerald-500 @elseif($member->owed < 0) text-white/40 @else text-neutral-700 @endif">
                                {{ number_format($member->owed, 2) }}€
                            </span>
                        </div>
                    @empty
                        <p class="text-neutral-600 italic text-sm">No members assigned.</p>
                    @endforelse
                </div>
            </div>

            <!-- Unit Governance -->
            <div class="space-y-6">
                <h3 class="text-xl font-display font-bold text-white flex items-center gap-3">
                    <span class="material-symbols-outlined text-neutral-500">shield</span>
                    Governance
                </h3>
                <div class="p-8 rounded-2xl modern-border bg-surface-dark/10 flex flex-col gap-6">
                    @if ($is_owner)
                        <p class="text-sm text-neutral-400 leading-relaxed font-body">
                            As the <span class="text-white font-bold">System Administrator</span>, you hold ultimate authority over this workspace. Termination will permanently archive all internal logs.
                        </p>
                        <button @disabled(!$is_active) onclick="showDisactivateModal({{ $colocation->id }})"
                            class="btn-outline w-full py-4 text-[10px] font-bold text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white tracking-[0.2em] uppercase">
                            Terminate Unit Integration
                        </button>
                    @else
                        <p class="text-sm text-neutral-400 leading-relaxed font-body">
                            As a <span class="text-white font-bold">Verified Member</span>, you can decouple from this workspace integration at any cycle point. Ensure all pending credits are settled.
                        </p>
                        <button @disabled(!$is_active) onclick="showLeaveModal({{ $colocation->id }})"
                            class="btn-outline w-full py-4 text-[10px] font-bold text-red-500 border-red-500/20 hover:bg-red-500 hover:text-white tracking-[0.2em] uppercase">
                            Decouple Integration
                        </button>
                    @endif
                </div>
            </div>
        </section>
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
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Grant Access</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Initialize new member synchronization.</p>
                    </div>
                    <button onclick="closeAddInvitationModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Protocol Email</label>
                        <input name="email" value="{{ old('email') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="operator@system.io" type="email" />
                        @error('email', 'addInvitation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Transmission Log</label>
                        <textarea name="message"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors resize-none"
                            placeholder="Welcome to the collective grid..." rows="4">{{ old('message') }}</textarea>
                        @error('message', 'addInvitation')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeAddInvitationModal()" type="button" class="btn-outline flex-1 py-4">Cancel</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Execute Invite</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Expense Modal -->
    <div id="add-expense-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="{{ route('expense.store') }}" method="POST" class="p-10 space-y-10">
                @csrf
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Append Entry</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Log a new financial transaction into unit ledger.</p>
                    </div>
                    <button onclick="closeAddExpenseModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Entry Description</label>
                        <input name="title" value="{{ old('title') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="Component acquisition / Resource maintenance" type="text" />
                        @error('title', 'addExpense')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Schema Category</label>
                            <select name="category_id"
                                class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white focus:border-white focus:ring-0 transition-colors">
                                <option disabled="" selected="" value="">Selection...</option>
                                @foreach ($colocation->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Fiat Amount</label>
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
                    <button onclick="closeAddExpenseModal()" type="button" class="btn-outline flex-1 py-4">Abort</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Commit Entry</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showAddExpenseModal() {
            const modal = document.getElementById('add-expense-modal');
            modal.classList.remove('hidden');
        }

        function closeAddExpenseModal() {
            const modal = document.getElementById('add-expense-modal');
            const form = modal.querySelector('form');
            form.reset();
            modal.classList.add('hidden');
        }
    </script>

    @php
        $is_there_edit_expense_errors = $errors->editExpense->any();
    @endphp
    <div id="edit-expense-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 @if (!$is_there_edit_expense_errors) hidden @endif">
        <div class="w-full max-w-xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <form action="" method="POST" class="p-10 space-y-10">
                @csrf
                @method('PUT')
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-display font-bold text-white tracking-tight">Review Entry</h2>
                        <p class="text-neutral-500 font-body text-sm mt-2">Modify existing ledger record parameters.</p>
                    </div>
                    <button onclick="closeEditExpenseModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="space-y-8">
                    <div class="space-y-3">
                        <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Entry Description</label>
                        <input name="title" value="{{ old('title') }}"
                            class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                            placeholder="Component acquisition" type="text" />
                        @error('title', 'editExpense')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Schema Category</label>
                            <select name="category_id"
                                class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white focus:border-white focus:ring-0 transition-colors">
                                <option disabled="" selected="" value="">Selection...</option>
                                @foreach ($colocation->categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="space-y-3">
                            <label class="text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500">Fiat Amount</label>
                            <input name="amount" value="{{ old('amount') }}"
                                class="w-full rounded-xl border border-border-dark bg-background-dark py-4 px-5 text-white placeholder:text-neutral-700 focus:border-white focus:ring-0 transition-colors"
                                placeholder="0.00" step="0.01" type="number" />
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeEditExpenseModal()" type="button" class="btn-outline flex-1 py-4">Abort</button>
                    <button type="submit" class="btn-modern flex-1 py-4">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function showEditExpenseModal(id, title, category_id, amount) {
            const modal = document.getElementById('edit-expense-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('expense.update', ':id') }}".replace(':id', id);
            form.querySelector('input[name="title"]').value = title;
            form.querySelector('select[name="category_id"]').value = category_id;
            form.querySelector('input[name="amount"]').value = amount;
            modal.classList.remove('hidden');
        }

        function closeEditExpenseModal() {
            const modal = document.getElementById('edit-expense-modal');
            const form = modal.querySelector('form');
            form.reset();
            form.action = "";
            modal.classList.add('hidden');
        }
    </script>

    <div id="delete-expense-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
                    <span class="material-symbols-outlined text-4xl">delete_forever</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Purge Entry?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        This action will permanently excise the entry from the unit ledger. Total cycle calculations will be recalibrated.
                    </p>
                </div>

                <div class="p-6 rounded-2xl bg-surface-dark border border-border-dark flex items-center justify-between text-left">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-neutral-900 border border-border-dark flex items-center justify-center text-neutral-500">
                            <span class="material-symbols-outlined text-sm">receipt_long</span>
                        </div>
                        <div>
                            <p class="text-xs font-bold text-white title"></p>
                            <p class="text-[10px] text-neutral-500 uppercase tracking-widest category"></p>
                        </div>
                    </div>
                    <p class="font-display font-bold text-white amount"></p>
                </div>

                <div class="flex gap-4">
                    <button onclick="closeDeleteExpenseModal()" class="btn-outline flex-1 py-4">Abort</button>
                    <form action="" method="post" class="flex-1">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern w-full py-4 bg-red-500 text-white hover:bg-red-600 border-none">Purge</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDeleteExpenseModal(id, title, amount, category) {
            const modal = document.getElementById('delete-expense-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('expense.destroy', ':id') }}".replace(':id', id);
            modal.querySelector('.title').textContent = title;
            modal.querySelector('.amount').textContent = amount + "€";
            modal.querySelector('.category').textContent = category;
            modal.classList.remove('hidden');
        }

        function closeDeleteExpenseModal() {
            const modal = document.getElementById('delete-expense-modal');
            const form = modal.querySelector('form');
            form.action = "";
            modal.querySelector('.title').textContent = "";
            modal.querySelector('.amount').textContent = "";
            modal.querySelector('.category').textContent = "";
            modal.classList.add('hidden');
        }
    </script>

    <div id="desactivate-colocation-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-red-500/10 border border-red-500/20 rounded-full flex items-center justify-center mx-auto text-red-500">
                    <span class="material-symbols-outlined text-4xl">warning</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Terminate Integration?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        As Administrator, you are initiating a full unit shutdown. All active member synchronizations will be severed.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <form method="POST" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern w-full py-4 bg-red-500 text-white hover:bg-red-600 border-none">Confirm Shutdown</button>
                    </form>
                    <button onclick="closeDisactivateModal()" class="btn-outline w-full py-4">Maintain Integration</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showDisactivateModal(id) {
            const modal = document.getElementById('desactivate-colocation-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('colocation.destroy', ':id') }}".replace(':id', id);
            modal.classList.remove('hidden');
        }

        function closeDisactivateModal() {
            const modal = document.getElementById('desactivate-colocation-modal');
            const form = modal.querySelector('form');
            form.action = "";
            modal.classList.add('hidden');
        }
    </script>

    <div id="left-colocation-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-md glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-8 text-center">
                <div class="w-20 h-20 bg-white/5 border border-white/10 rounded-full flex items-center justify-center mx-auto text-white">
                    <span class="material-symbols-outlined text-4xl">logout</span>
                </div>
                
                <div>
                    <h2 class="text-2xl font-display font-bold text-white tracking-tight">Decouple Integration?</h2>
                    <p class="text-neutral-500 font-body text-sm mt-3 leading-relaxed">
                        You are about to disconnect your access protocol from this unit. Pending ledger credits should be resolved prior to termination.
                    </p>
                </div>

                <div class="flex flex-col gap-3">
                    <form action="" method="post" class="w-full">
                        @csrf
                        @method('DELETE')
                        <button class="btn-modern w-full py-4">Confirm Decoupling</button>
                    </form>
                    <button onclick="closeLeaveModal()" class="btn-outline w-full py-4">Resume Synchronization</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showLeaveModal(id) {
            const modal = document.getElementById('left-colocation-modal');
            const form = modal.querySelector('form');
            form.action = "{{ route('colocation.leave', ':id') }}".replace(':id', id);
            modal.classList.remove('hidden');
        }

        function closeLeaveModal() {
            const modal = document.getElementById('left-colocation-modal');
            const form = modal.querySelector('form');
            form.action = "";
            modal.classList.add('hidden');
        }
    </script>

    <div id="expense-details-modal" class="fixed inset-0 z-50 flex items-center justify-center p-6 bg-black/95 hidden">
        <div class="w-full max-w-2xl glass modern-border rounded-3xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-10 space-y-10">
                <div class="flex justify-between items-start">
                    <div>
                        <div class="flex items-center gap-2 text-[10px] font-bold uppercase tracking-[0.2em] text-neutral-500 mb-2">
                            <span class="material-symbols-outlined text-xs">analytics</span>
                            Ledger Transmission Details
                        </div>
                        <h2 class="text-3xl font-display font-bold text-white tracking-tight">
                            Entry: <span class="expense-name"></span>
                        </h2>
                    </div>
                    <button onclick="closeExpenseDetailsModal()" type="button" class="text-neutral-500 hover:text-white transition-colors">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <div class="p-6 rounded-2xl bg-surface-dark border border-border-dark">
                        <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-[0.2em] mb-2">Schema Category</p>
                        <p class="text-white font-medium expense-category"></p>
                    </div>
                    <div class="p-6 rounded-2xl bg-surface-dark border border-border-dark">
                        <p class="text-[10px] font-bold text-neutral-500 uppercase tracking-[0.2em] mb-2">Fiat Aggregate</p>
                        <p class="text-white font-display font-bold text-xl"><span class="expense-amount"></span>€</p>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-bold text-white flex items-center gap-2 uppercase tracking-widest">
                            Member Distribution
                        </h3>
                        <span class="text-[10px] text-neutral-500 uppercase tracking-widest"><span class="members-count"></span> Entities Syncing</span>
                    </div>
                    
                    <div id="details" class="space-y-3">
                        <!-- Dynamic content -->
                    </div>
                </div>

                <div class="pt-6 border-t border-border-dark">
                    <button onclick="closeExpenseDetailsModal()" class="btn-outline w-full py-4 uppercase tracking-[0.2em] text-[10px] font-bold">Close Transmission</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function showExpenseDetailsModal(colocation_id, user_id, details, member_count, expense_name, expense_amount, expense_category) {
            const modal = document.getElementById('expense-details-modal');
            const detailsContainer = document.getElementById('details');

            modal.querySelector('.expense-name').textContent = expense_name;
            modal.querySelector('.expense-amount').textContent = expense_amount;
            modal.querySelector('.expense-category').textContent = expense_category;
            modal.querySelector('.members-count').textContent = member_count;

            let html = ``;
            if(details.length > 0) {
                details.filter((detail) => detail.debtor.left_at == null)
                .forEach((detail) => {
                    const isPaid = detail.status == 'PAID';
                    html += `
                        <div class="flex items-center justify-between p-5 rounded-2xl modern-border bg-surface-dark/40 border-white/5">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full border border-neutral-800 flex items-center justify-center text-neutral-500 text-xs italic">
                                    ${detail.debtor.user.name.charAt(0)}
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-white">${detail.debtor.user.name}</p>
                                    <p class="text-[10px] uppercase tracking-widest mt-1 ${isPaid ? 'text-emerald-500' : 'text-neutral-500'}">
                                        ${isPaid ? 'Sync Complete' : 'Pending ' + detail.amount + '€'}
                                    </p>
                                </div>
                            </div>
                            <div class="flex items-center gap-3">
                                ${!isPaid && user_id == detail.expense.creator.user_id ? `
                                    <form action="${"{{ route('colocation.detail.mark-paid', [':colocation_id', ':id']) }}".replace(':colocation_id', colocation_id).replace(':id', detail.id)}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn-modern px-4 py-2 text-[8px] uppercase tracking-[0.1em] font-bold">Resolve</button>
                                    </form>
                                ` : isPaid ? `
                                    <span class="flex items-center gap-1.5 px-3 py-1 rounded-full bg-emerald-500/10 text-emerald-500 text-[8px] font-bold uppercase tracking-widest border border-emerald-500/20">
                                        <span class="material-symbols-outlined text-[10px]">check</span> Resolved
                                    </span>
                                ` : `
                                    <span class="text-[8px] uppercase tracking-widest text-neutral-600 font-bold">Unresolved</span>
                                `}
                            </div>
                        </div>
                    `;
                });
            } else {
                html = `<p class="text-neutral-600 italic text-center py-4">No distribution data found.</p>`;
            }
            detailsContainer.innerHTML = html;
            modal.classList.remove('hidden');
        }

        function closeExpenseDetailsModal() {
            const modal = document.getElementById('expense-details-modal');
            modal.classList.add('hidden');
        }
    </script>
@endsection
